<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Maker;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Common\Inflector\Inflector;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Doctrine\DoctrineHelper;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Renderer\FormTypeRenderer;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Validator\Validation;

/**
 * @author Sadicov Vladimir <sadikoff@gmail.com>
 */
final class MakeCrud extends AbstractMaker {

    private $doctrineHelper;
    private $formTypeRenderer;

    public function __construct(DoctrineHelper $doctrineHelper, FormTypeRenderer $formTypeRenderer) {
        $this->doctrineHelper = $doctrineHelper;
        $this->formTypeRenderer = $formTypeRenderer;
    }

    public static function getCommandName(): string {
        return 'make:crud';
    }

    /**
     * {@inheritdoc}
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig) {
        $command
                ->setDescription('Creates CRUD for Doctrine entity class')
                ->addArgument('entity-class', InputArgument::OPTIONAL, sprintf('The class name of the entity to create CRUD (e.g. <fg=yellow>%s</>)', Str::asClassName(Str::getRandomTerm())))
                ->setHelp(file_get_contents(__DIR__ . '/../Resources/help/MakeCrud.txt'))
        ;

        $inputConfig->setArgumentAsNonInteractive('entity-class');
    }

    public function interact(InputInterface $input, ConsoleStyle $io, Command $command) {
        if (null === $input->getArgument('entity-class')) {
            $argument = $command->getDefinition()->getArgument('entity-class');

            $entities = $this->doctrineHelper->getEntitiesForAutocomplete();

            $question = new Question($argument->getDescription());
            $question->setAutocompleterValues($entities);

            $value = $io->askQuestion($question);

            $input->setArgument('entity-class', $value);
        }
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator) {
        $entityClassDetails = $generator->createClassNameDetails(
                Validator::entityExists($input->getArgument('entity-class'), $this->doctrineHelper->getEntitiesForAutocomplete()), 'Entity\\'
        );

        $entityDoctrineDetails = $this->doctrineHelper->createDoctrineDetails($entityClassDetails->getFullName());

        $repositoryVars = [];

        if (null !== $entityDoctrineDetails->getRepositoryClass()) {
            $repositoryClassDetails = $generator->createClassNameDetails(
                    '\\' . $entityDoctrineDetails->getRepositoryClass(), 'Repository\\', 'Repository'
            );

            $repositoryVars = [
                'repository_full_class_name' => $repositoryClassDetails->getFullName(),
                'repository_class_name' => $repositoryClassDetails->getShortName(),
                'repository_var' => lcfirst(Inflector::singularize($repositoryClassDetails->getShortName())),
            ];
        }

        $controllerClassDetails = $generator->createClassNameDetails(
                $entityClassDetails->getRelativeNameWithoutSuffix() . 'Controller', 'Controller\\', 'Controller'
        );

        $iter = 0;
        do {
            $formClassDetails = $generator->createClassNameDetails(
                    $entityClassDetails->getRelativeNameWithoutSuffix() . ($iter ?: '') . 'Type', 'Form\\', 'Type'
            );
            ++$iter;
        } while (class_exists($formClassDetails->getFullName()));

        $entityVarPlural = lcfirst(Inflector::pluralize($entityClassDetails->getShortName()));
        $entityVarSingular = lcfirst(Inflector::singularize($entityClassDetails->getShortName()));

        $entityTwigVarPlural = Str::asTwigVariable($entityVarPlural);
        $entityTwigVarSingular = Str::asTwigVariable($entityVarSingular);

        $routeName = Str::asRouteName($controllerClassDetails->getRelativeNameWithoutSuffix());
        $templatesPath = strtolower($entityClassDetails->getShortName()); //Str::asFilePath($controllerClassDetails->getRelativeNameWithoutSuffix());

        $generator->generateController(
                $controllerClassDetails->getFullName(), 'crud/controller/Controller.tpl.php', array_merge([
            'entity_full_class_name' => $entityClassDetails->getFullName(),
            'entity_class_name' => $entityClassDetails->getShortName(),
            'form_full_class_name' => $formClassDetails->getFullName(),
            'form_class_name' => $formClassDetails->getShortName(),
            'route_path' => Str::asRoutePath($controllerClassDetails->getRelativeNameWithoutSuffix()),
            'route_name' => $routeName,
            'templates_path' => $templatesPath,
            'entity_var_plural' => $entityVarPlural,
            'entity_twig_var_plural' => $entityTwigVarPlural,
            'entity_var_singular' => $entityVarSingular,
            'entity_twig_var_singular' => $entityTwigVarSingular,
            'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                        ], $repositoryVars
                )
        );

        $this->formTypeRenderer->render(
                $formClassDetails, $entityDoctrineDetails->getFormFields(), $entityClassDetails
        );

        $templates = [
            $templatesPath . '.ts' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
                'route_name' => $routeName,
                'destination_path' => $templatesPath . '/' . $templatesPath . '.ts',
                'template_path' => 'crud/templates/model.ts.tpl.php',
                'route_path' => Str::asRoutePath($controllerClassDetails->getRelativeNameWithoutSuffix()),
                'templatesPath' => $templatesPath,
                'entity_var_singular' => $entityVarSingular,
                'entity_var_plural' => $entityVarPlural,
            ],
            $templatesPath . '.service.ts' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
                'route_name' => $routeName,
                'destination_path' => $templatesPath . '/' . $templatesPath . '.service.ts',
                'template_path' => 'crud/templates/service.ts.tpl.php',
                'route_path' => Str::asRoutePath($controllerClassDetails->getRelativeNameWithoutSuffix()),
                'templatesPath' => $templatesPath,
                'entity_var_singular' => $entityVarSingular,
                'entity_var_plural' => $entityVarPlural,
            ],
            $templatesPath . '.routes.ts' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
                'route_name' => $routeName,
                'destination_path' => $templatesPath . '/' . $templatesPath . '.routes.ts',
                'template_path' => 'crud/templates/routes.ts.tpl.php',
                'route_path' => Str::asRoutePath($controllerClassDetails->getRelativeNameWithoutSuffix()),
                'templatesPath' => $templatesPath,
                'entity_var_singular' => $entityVarSingular,
                'entity_var_plural' => $entityVarPlural,
            ],
            $templatesPath . '.columns.ts' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
                'route_name' => $routeName,
                'destination_path' => $templatesPath . '/' . $templatesPath . '.columns.ts',
                'template_path' => 'crud/templates/columns.ts.tpl.php',
                'route_path' => Str::asRoutePath($controllerClassDetails->getRelativeNameWithoutSuffix()),
                'templatesPath' => $templatesPath,
                'entity_var_singular' => $entityVarSingular,
                'entity_var_plural' => $entityVarPlural,
            ],
//            'one-' . $templatesPath . '.resolver.ts' => [
//                'entity_class_name' => $entityClassDetails->getShortName(),
//                'entity_twig_var_plural' => $entityTwigVarPlural,
//                'entity_twig_var_singular' => $entityTwigVarSingular,
//                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
//                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
//                'route_name' => $routeName,
//                'destination_path' =>$templatesPath . '/one-' . $templatesPath.'.resolver.ts',
//                'template_path' => 'crud/templates/one-resolver.ts.tpl.php',
//                'route_path' => Str::asRoutePath($controllerClassDetails->getRelativeNameWithoutSuffix()),
//            ],
//            'multiple-' . $templatesPath . '.resolver.ts' => [
//                'entity_class_name' => $entityClassDetails->getShortName(),
//                'entity_twig_var_plural' => $entityTwigVarPlural,
//                'entity_twig_var_singular' => $entityTwigVarSingular,
//                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
//                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
//                'route_name' => $routeName,
//                'destination_path' =>$templatesPath . '/multiple-' . $templatesPath.'.resolver.ts',
//                'template_path' => 'crud/templates/multiple-resolver.ts.tpl.php',
//                'route_path' => Str::asRoutePath($controllerClassDetails->getRelativeNameWithoutSuffix()),
//            ],
            // show
            $templatesPath . '-show.component.html' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
                'route_name' => $routeName,
                'destination_path' => $templatesPath . '/' . $templatesPath . '-show/' . $templatesPath . '-show.component.html',
                'template_path' => 'crud/templates/show.component.html.tpl.php',
                'route_path' => Str::asRoutePath($controllerClassDetails->getRelativeNameWithoutSuffix()),
                'entity_var_singular' => $entityVarSingular,
                'entity_var_plural' => $entityVarPlural,
            ],
            $templatesPath . '-show.component.css' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_twig_var_plural' => $entityTwigVarPlural,
                'entity_twig_var_singular' => $entityTwigVarSingular,
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
                'route_name' => $routeName,
                'destination_path' =>$templatesPath . '/' . $templatesPath.'-show/'.$templatesPath.'-show.component.css',
                'template_path' => 'crud/templates/show.component.css.tpl.php',
            ],
            $templatesPath . '-show.component.ts' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
                'route_name' => $routeName,
                'destination_path' => $templatesPath . '/' . $templatesPath . '-show/' . $templatesPath . '-show.component.ts',
                'template_path' => 'crud/templates/show.component.ts.tpl.php',
                'route_path' => Str::asRoutePath($controllerClassDetails->getRelativeNameWithoutSuffix()),
                'templatesPath' => $templatesPath,
                'entity_var_singular' => $entityVarSingular,
                'entity_var_plural' => $entityVarPlural,
            ],
            // edit
            $templatesPath . '-edit.component.html' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
                'route_name' => $routeName,
                'destination_path' => $templatesPath . '/' . $templatesPath . '-edit/' . $templatesPath . '-edit.component.html',
                'template_path' => 'crud/templates/edit.component.html.tpl.php',
                'route_path' => Str::asRoutePath($controllerClassDetails->getRelativeNameWithoutSuffix()),
                'entity_var_singular' => $entityVarSingular,
                'entity_var_plural' => $entityVarPlural,
            ],
            $templatesPath . '-edit.component.css' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_twig_var_plural' => $entityTwigVarPlural,
                'entity_twig_var_singular' => $entityTwigVarSingular,
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
                'route_name' => $routeName,
                'destination_path' =>$templatesPath . '/' . $templatesPath.'-edit/'.$templatesPath.'-edit.component.css',
                'template_path' => 'crud/templates/edit.component.css.tpl.php',
            ],
            $templatesPath . '-edit.component.ts' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
                'route_name' => $routeName,
                'destination_path' => $templatesPath . '/' . $templatesPath . '-edit/' . $templatesPath . '-edit.component.ts',
                'template_path' => 'crud/templates/edit.component.ts.tpl.php',
                'route_path' => Str::asRoutePath($controllerClassDetails->getRelativeNameWithoutSuffix()),
                'templatesPath' => $templatesPath,
                'entity_var_singular' => $entityVarSingular,
                'entity_var_plural' => $entityVarPlural,
            ],
            // picklist
            $templatesPath . '-picklist.component.html' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
                'route_name' => $routeName,
                'destination_path' => $templatesPath . '/' . $templatesPath . '-picklist/' . $templatesPath . '-picklist.component.html',
                'template_path' => 'crud/templates/picklist.component.html.tpl.php',
                'route_path' => Str::asRoutePath($controllerClassDetails->getRelativeNameWithoutSuffix()),
                'entity_var_singular' => $entityVarSingular,
                'entity_var_plural' => $entityVarPlural,
            ],
            $templatesPath . '-picklist.component.css' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_twig_var_plural' => $entityTwigVarPlural,
                'entity_twig_var_singular' => $entityTwigVarSingular,
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
                'route_name' => $routeName,
                'destination_path' =>$templatesPath . '/' . $templatesPath.'-picklist/'.$templatesPath.'-picklist.component.css',
                'template_path' => 'crud/templates/picklist.component.css.tpl.php',
            ],
            $templatesPath . '-picklist.component.ts' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
                'route_name' => $routeName,
                'destination_path' => $templatesPath . '/' . $templatesPath . '-picklist/' . $templatesPath . '-picklist.component.ts',
                'template_path' => 'crud/templates/picklist.component.ts.tpl.php',
                'route_path' => Str::asRoutePath($controllerClassDetails->getRelativeNameWithoutSuffix()),
                'templatesPath' => $templatesPath,
                'entity_var_singular' => $entityVarSingular,
                'entity_var_plural' => $entityVarPlural,
            ],
            // list
            $templatesPath . '-list.component.html' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
                'route_name' => $routeName,
                'destination_path' => $templatesPath . '/' . $templatesPath . '-list/' . $templatesPath . '-list.component.html',
                'template_path' => 'crud/templates/list.component.html.tpl.php',
                'route_path' => Str::asRoutePath($controllerClassDetails->getRelativeNameWithoutSuffix()),
                'entity_var_singular' => $entityVarSingular,
                'entity_var_plural' => $entityVarPlural,
            ],
            $templatesPath . '-list.component.css' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_twig_var_plural' => $entityTwigVarPlural,
                'entity_twig_var_singular' => $entityTwigVarSingular,
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
                'route_name' => $routeName,
                'destination_path' =>$templatesPath . '/' . $templatesPath.'-list/'.$templatesPath.'-list.component.css',
                'template_path' => 'crud/templates/list.component.css.tpl.php',
            ],
            $templatesPath . '-list.component.ts' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
                'route_name' => $routeName,
                'destination_path' => $templatesPath . '/' . $templatesPath . '-list/' . $templatesPath . '-list.component.ts',
                'template_path' => 'crud/templates/list.component.ts.tpl.php',
                'route_path' => Str::asRoutePath($controllerClassDetails->getRelativeNameWithoutSuffix()),
                'templatesPath' => $templatesPath,
                'entity_var_singular' => $entityVarSingular,
                'entity_var_plural' => $entityVarPlural,
            ],
            // new
            $templatesPath . '-new.component.html' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
                'route_name' => $routeName,
                'destination_path' => $templatesPath . '/' . $templatesPath . '-new/' . $templatesPath . '-new.component.html',
                'template_path' => 'crud/templates/new.component.html.tpl.php',
                'route_path' => Str::asRoutePath($controllerClassDetails->getRelativeNameWithoutSuffix()),
                'entity_var_singular' => $entityVarSingular,
                'entity_var_plural' => $entityVarPlural,
            ],
            $templatesPath . '-new.component.css' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_twig_var_plural' => $entityTwigVarPlural,
                'entity_twig_var_singular' => $entityTwigVarSingular,
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
                'route_name' => $routeName,
                'destination_path' =>$templatesPath . '/' . $templatesPath.'-new/'.$templatesPath.'-new.component.css',
                'template_path' => 'crud/templates/new.component.css.tpl.php',
            ],
            $templatesPath . '-new.component.ts' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
                'route_name' => $routeName,
                'destination_path' => $templatesPath . '/' . $templatesPath . '-new/' . $templatesPath . '-new.component.ts',
                'template_path' => 'crud/templates/new.component.ts.tpl.php',
                'route_path' => Str::asRoutePath($controllerClassDetails->getRelativeNameWithoutSuffix()),
                'templatesPath' => $templatesPath,
                'entity_var_singular' => $entityVarSingular,
                'entity_var_plural' => $entityVarPlural,
            ],
        ];

        foreach ($templates as $template => $variables) {
            $generator->generateTemplate(
                    $variables['destination_path'], $variables['template_path'], $variables
            );
        }

        $generator->writeChanges();

        $this->writeSuccessMessage($io);

        $io->text(sprintf('Next: Check your new CRUD by going to <fg=yellow>%s/</>', Str::asRoutePath($controllerClassDetails->getRelativeNameWithoutSuffix())));
    }

    /**
     * {@inheritdoc}
     */
    public function configureDependencies(DependencyBuilder $dependencies) {
        $dependencies->addClassDependency(
                Route::class, 'router'
        );

        $dependencies->addClassDependency(
                AbstractType::class, 'form'
        );

        $dependencies->addClassDependency(
                Validation::class, 'validator'
        );

        $dependencies->addClassDependency(
                TwigBundle::class, 'twig-bundle'
        );

        $dependencies->addClassDependency(
                DoctrineBundle::class, 'orm-pack'
        );

        $dependencies->addClassDependency(
                CsrfTokenManager::class, 'security-csrf'
        );

        $dependencies->addClassDependency(
                ParamConverter::class, 'annotations'
        );
    }

}
