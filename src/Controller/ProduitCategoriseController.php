<?php

namespace App\Controller;

use App\Entity\ProduitCategorise;
use App\Form\ProduitCategoriseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/produitcategorise")
 */
class ProduitCategoriseController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="produit_categorise_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_PRODUITCATEGORISE_INDEX")
     */
    public function index(): array
    {
        $produitCategorises = $this->getDoctrine()
            ->getRepository(ProduitCategorise::class)
            ->findAll();

        return count($produitCategorises)?$produitCategorises:[];
    }
    
    /**
     * @Rest\Get(path="/{id}/produit", name="produit_categorise_by_produit")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_PRODUIT_SHOW")
     */
    public function findByProduit(\App\Entity\Produit $produit): array
    {
        $produitCategorises = $this->getDoctrine()
            ->getRepository(ProduitCategorise::class)
            ->findByProduit($produit);

        return count($produitCategorises)?$produitCategorises:[];
    }

    /**
     * @Rest\Post(Path="/create", name="produit_categorise_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PRODUITCATEGORISE_CREATE")
     */
    public function create(Request $request): ProduitCategorise    {
        $produitCategorise = new ProduitCategorise();
        $form = $this->createForm(ProduitCategoriseType::class, $produitCategorise);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($produitCategorise);
        $entityManager->flush();

        return $produitCategorise;
    }

    /**
     * @Rest\Get(path="/{id}", name="produit_categorise_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PRODUITCATEGORISE_SHOW")
     */
    public function show(ProduitCategorise $produitCategorise): ProduitCategorise    {
        return $produitCategorise;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="produit_categorise_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PRODUITCATEGORISE_EDIT")
     */
    public function edit(Request $request, ProduitCategorise $produitCategorise): ProduitCategorise    {
        $form = $this->createForm(ProduitCategoriseType::class, $produitCategorise);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $produitCategorise;
    }

    /**
     * @Rest\Delete("/{id}", name="produit_categorise_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PRODUITCATEGORISE_DELETE")
     */
    public function delete(ProduitCategorise $produitCategorise): ProduitCategorise    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($produitCategorise);
        $entityManager->flush();

        return $produitCategorise;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="produit_categorise_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PRODUITCATEGORISE_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $produitCategorises = Utils::getObjectFromRequest($request);
        if (!count($produitCategorises)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($produitCategorises as $produitCategorise) {
            $produitCategorise = $entityManager->getRepository(ProduitCategorise::class)->find($produitCategorise->id);
            $entityManager->remove($produitCategorise);
        }
        $entityManager->flush();

        return $produitCategorises;
    }
}
