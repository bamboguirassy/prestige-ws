<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/user")
 */
class UserController extends AbstractController {

    /**
     * @Rest\Get(path="/", name="user_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_USER_INDEX")
     */
    public function index(): array {
        /* $faker = \Faker\Factory::create('fr_FR');
          $em= $this->getDoctrine()->getManager();
          $populator = new \Faker\ORM\Doctrine\Populator($faker, $em);
          $populator->addEntity(\App\Entity\Group::class, 30);
          $insertedPKs = $populator->execute();
          $populator->addEntity(User::class, 100);
          $insertedPKs = $populator->execute(); */

        $users = $this->getDoctrine()
                ->getRepository(User::class)
                ->findAll();

        return count($users) ? $users : [];
    }

    /**
     * @Rest\Post(Path="/create", name="user_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_USER_CREATE")
     */
    public function create(Request $request, \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $passwordEncoder): User {
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit(Utils::serializeRequestContent($request));
        //check if the email already exist
        $checkedUsers=$entityManager->getRepository('App\Entity\User')
                ->findByEmail($user->getEmail());
        if(count($checkedUsers)) {
            throw $this->createAccessDeniedException("Ce email est déja utilisé.");
        }
        $user->setUsername($user->getEmail());
        $user->setPassword($passwordEncoder->encodePassword($user, 'bienvenue'));

        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }

    /**
     * @Rest\Get(path="/{id}", name="user_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_USER_SHOW")
     */
    public function show(User $user): User {
        return $user;
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="user_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_USER_EDIT")
     */
    public function edit(Request $request, User $user): User {
        $form = $this->createForm(UserType::class, $user);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $user;
    }

    /**
     * @Rest\Delete("/{id}", name="user_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_USER_DELETE")
     */
    public function delete(User $user): User {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return $user;
    }

    /**
     * @Rest\Post("/delete-selection/", name="user_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_USER_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $users = Utils::getObjectFromRequest($request);
        if (!count($users)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($users as $user) {
            $user = $entityManager->getRepository(User::class)->find($user->id);
            $entityManager->remove($user);
        }
        $entityManager->flush();

        return $users;
    }
    
    public static function isSuperAdmin($controller) {
        foreach ($controller->getUser()->getGroups() as $group) {
            if($group->getCode()=='SA'){
                return true;
            }
        }
        return false;
    }

}
