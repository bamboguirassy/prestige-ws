<?php

namespace App\Controller;

use App\Entity\VenteProduit;
use App\Form\VenteProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/vente/produit")
 */
class VenteProduitController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="vente_produit_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_VENTEPRODUIT_INDEX")
     */
    public function index(): array
    {
        $venteProduits = $this->getDoctrine()
            ->getRepository(VenteProduit::class)
            ->findAll();

        return count($venteProduits)?$venteProduits:[];
    }

    /**
     * @Rest\Post(Path="/create", name="vente_produit_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VENTEPRODUIT_CREATE")
     */
    public function create(Request $request): VenteProduit    {
        $venteProduit = new VenteProduit();
        $form = $this->createForm(VenteProduitType::class, $venteProduit);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($venteProduit);
        $entityManager->flush();

        return $venteProduit;
    }

    /**
     * @Rest\Get(path="/{id}", name="vente_produit_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VENTEPRODUIT_SHOW")
     */
    public function show(VenteProduit $venteProduit): VenteProduit    {
        return $venteProduit;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="vente_produit_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VENTEPRODUIT_EDIT")
     */
    public function edit(Request $request, VenteProduit $venteProduit): VenteProduit    {
        $form = $this->createForm(VenteProduitType::class, $venteProduit);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $venteProduit;
    }

    /**
     * @Rest\Delete("/{id}", name="vente_produit_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VENTEPRODUIT_DELETE")
     */
    public function delete(VenteProduit $venteProduit): VenteProduit    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($venteProduit);
        $entityManager->flush();

        return $venteProduit;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="vente_produit_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VENTEPRODUIT_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $venteProduits = Utils::getObjectFromRequest($request);
        if (!count($venteProduits)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($venteProduits as $venteProduit) {
            $venteProduit = $entityManager->getRepository(VenteProduit::class)->find($venteProduit->id);
            $entityManager->remove($venteProduit);
        }
        $entityManager->flush();

        return $venteProduits;
    }
}
