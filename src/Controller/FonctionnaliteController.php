<?php

namespace App\Controller;

use App\Entity\Fonctionnalite;
use App\Form\FonctionnaliteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/fonctionnalite")
 */
class FonctionnaliteController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="fonctionnalite_index")
     * @Rest\View(StatusCode = 200)
     */
    public function index(): array
    {
        $fonctionnalites = $this->getDoctrine()
            ->getRepository(Fonctionnalite::class)
            ->findAll();

        return count($fonctionnalites)?$fonctionnalites:[];
    }

    /**
     * @Rest\Post(Path="/create", name="fonctionnalite_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FONCTIONNALITE_CREATE")
     */
    public function create(Request $request): Fonctionnalite    {
        $fonctionnalite = new Fonctionnalite();
        $form = $this->createForm(FonctionnaliteType::class, $fonctionnalite);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($fonctionnalite);
        $entityManager->flush();

        return $fonctionnalite;
    }

    /**
     * @Rest\Get(path="/{id}", name="fonctionnalite_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FONCTIONNALITE_SHOW")
     */
    public function show(Fonctionnalite $fonctionnalite): Fonctionnalite    {
        return $fonctionnalite;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="fonctionnalite_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FONCTIONNALITE_EDIT")
     */
    public function edit(Request $request, Fonctionnalite $fonctionnalite): Fonctionnalite    {
        $form = $this->createForm(FonctionnaliteType::class, $fonctionnalite);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $fonctionnalite;
    }

    /**
     * @Rest\Delete("/{id}", name="fonctionnalite_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FONCTIONNALITE_DELETE")
     */
    public function delete(Fonctionnalite $fonctionnalite): Fonctionnalite    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($fonctionnalite);
        $entityManager->flush();

        return $fonctionnalite;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="fonctionnalite_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FONCTIONNALITE_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $fonctionnalites = Utils::getObjectFromRequest($request);
        if (!count($fonctionnalites)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($fonctionnalites as $fonctionnalite) {
            $fonctionnalite = $entityManager->getRepository(Fonctionnalite::class)->find($fonctionnalite->id);
            $entityManager->remove($fonctionnalite);
        }
        $entityManager->flush();

        return $fonctionnalites;
    }
}
