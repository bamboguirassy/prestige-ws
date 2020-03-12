<?php

namespace App\Controller;

use App\Entity\Vente;
use App\Form\VenteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/vente")
 */
class VenteController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="vente_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_VENTE_INDEX")
     */
    public function index(): array
    {
        $ventes = $this->getDoctrine()
            ->getRepository(Vente::class)
            ->findAll();

        return count($ventes)?$ventes:[];
    }

    /**
     * @Rest\Post(Path="/create", name="vente_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VENTE_CREATE")
     */
    public function create(Request $request): Vente    {
        $vente = new Vente();
        $form = $this->createForm(VenteType::class, $vente);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($vente);
        $entityManager->flush();

        return $vente;
    }

    /**
     * @Rest\Get(path="/{id}", name="vente_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VENTE_SHOW")
     */
    public function show(Vente $vente): Vente    {
        return $vente;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="vente_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VENTE_EDIT")
     */
    public function edit(Request $request, Vente $vente): Vente    {
        $form = $this->createForm(VenteType::class, $vente);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $vente;
    }

    /**
     * @Rest\Delete("/{id}", name="vente_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VENTE_DELETE")
     */
    public function delete(Vente $vente): Vente    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($vente);
        $entityManager->flush();

        return $vente;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="vente_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VENTE_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $ventes = Utils::getObjectFromRequest($request);
        if (!count($ventes)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($ventes as $vente) {
            $vente = $entityManager->getRepository(Vente::class)->find($vente->id);
            $entityManager->remove($vente);
        }
        $entityManager->flush();

        return $ventes;
    }
}
