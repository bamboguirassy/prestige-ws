<?php

namespace App\Controller;

use App\Entity\CaracteristiqueCategorie;
use App\Form\CaracteristiqueCategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/caracteristiquecategorie")
 */
class CaracteristiqueCategorieController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="caracteristique_categorie_index")
     * @Rest\View(StatusCode = 200)
     */
    public function index(): array
    {
        $caracteristiqueCategories = $this->getDoctrine()
            ->getRepository(CaracteristiqueCategorie::class)
            ->findAll();

        return count($caracteristiqueCategories)?$caracteristiqueCategories:[];
    }
    
    /**
     * @Rest\Get(path="/{id}/categorie", name="caracteristique_categorie_by_categorie")
     * @Rest\View(StatusCode = 200)
     */
    public function findByCategorie(\App\Entity\CategorieProduit $categorie): array
    {
        $caracteristiqueCategories = $this->getDoctrine()
            ->getRepository(CaracteristiqueCategorie::class)
            ->findByCategorie($categorie);

        return count($caracteristiqueCategories)?$caracteristiqueCategories:[];
    }

    /**
     * @Rest\Post(Path="/create", name="caracteristique_categorie_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CARACTERISTIQUECATEGORIE_CREATE")
     */
    public function create(Request $request): CaracteristiqueCategorie    {
        $caracteristiqueCategorie = new CaracteristiqueCategorie();
        $form = $this->createForm(CaracteristiqueCategorieType::class, $caracteristiqueCategorie);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($caracteristiqueCategorie);
        $entityManager->flush();

        return $caracteristiqueCategorie;
    }

    /**
     * @Rest\Get(path="/{id}", name="caracteristique_categorie_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CARACTERISTIQUECATEGORIE_SHOW")
     */
    public function show(CaracteristiqueCategorie $caracteristiqueCategorie): CaracteristiqueCategorie    {
        return $caracteristiqueCategorie;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="caracteristique_categorie_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CARACTERISTIQUECATEGORIE_EDIT")
     */
    public function edit(Request $request, CaracteristiqueCategorie $caracteristiqueCategorie): CaracteristiqueCategorie    {
        $form = $this->createForm(CaracteristiqueCategorieType::class, $caracteristiqueCategorie);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $caracteristiqueCategorie;
    }

    /**
     * @Rest\Delete("/{id}", name="caracteristique_categorie_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CARACTERISTIQUECATEGORIE_DELETE")
     */
    public function delete(CaracteristiqueCategorie $caracteristiqueCategorie): CaracteristiqueCategorie    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($caracteristiqueCategorie);
        $entityManager->flush();

        return $caracteristiqueCategorie;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="caracteristique_categorie_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CARACTERISTIQUECATEGORIE_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $caracteristiqueCategories = Utils::getObjectFromRequest($request);
        if (!count($caracteristiqueCategories)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($caracteristiqueCategories as $caracteristiqueCategorie) {
            $caracteristiqueCategorie = $entityManager->getRepository(CaracteristiqueCategorie::class)->find($caracteristiqueCategorie->id);
            $entityManager->remove($caracteristiqueCategorie);
        }
        $entityManager->flush();

        return $caracteristiqueCategories;
    }
}
