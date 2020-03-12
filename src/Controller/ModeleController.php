<?php

namespace App\Controller;

use App\Entity\Modele;
use App\Form\ModeleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/modele")
 */
class ModeleController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="modele_index")
     * @Rest\View(StatusCode = 200)
     */
    public function index(): array
    {
        $modeles = $this->getDoctrine()
            ->getRepository(Modele::class)
            ->findAll();

        return count($modeles)?$modeles:[];
    }

    /**
     * @Rest\Post(Path="/create", name="modele_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_MODELE_CREATE")
     */
    public function create(Request $request, \Symfony\Component\DependencyInjection\ContainerInterface  $container): Modele    {
        $modele = new Modele();
        $form = $this->createForm(ModeleType::class, $modele);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($modele);
        $entityManager->flush();

        return $modele;
    }

    /**
     * @Rest\Get(path="/{id}", name="modele_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_MODELE_SHOW")
     */
    public function show(Modele $modele): Modele    {
        return $modele;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="modele_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_MODELE_EDIT")
     */
    public function edit(Request $request, Modele $modele): Modele    {
        $form = $this->createForm(ModeleType::class, $modele);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $modele;
    }

    /**
     * @Rest\Delete("/{id}", name="modele_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_MODELE_DELETE")
     */
    public function delete(Modele $modele): Modele    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($modele);
        $entityManager->flush();

        return $modele;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="modele_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_MODELE_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $modeles = Utils::getObjectFromRequest($request);
        if (!count($modeles)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($modeles as $modele) {
            $modele = $entityManager->getRepository(Modele::class)->find($modele->id);
            $entityManager->remove($modele);
        }
        $entityManager->flush();

        return $modeles;
    }
}
