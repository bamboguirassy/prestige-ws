<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/produit")
 */
class ProduitController extends AbstractController {

    /**
     * @Rest\Get(path="/", name="produit_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_PRODUIT_INDEX")
     */
    public function index(): array {
        if (UserController::isSuperAdmin($this)) {
            $produits = $this->getDoctrine()
                    ->getRepository(Produit::class)
                    ->findByType('produit');
        } else {
            $produits = $this->getDoctrine()
                    ->getRepository(Produit::class)
                    ->findBy(
                    array('entreprise' => $this->getUser()->getEntreprise(),
                        'type' => 'produit'));
        }

        return count($produits) ? $produits : [];
    }

    /**
     * @Rest\Get(path="/search/{name}", name="produit_search")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_PRODUIT_INDEX")
     */
    public function searchProduit($name): array {
        if (UserController::isSuperAdmin($this)) {
            $produits = $this->getDoctrine()->getManager()
                    ->createQuery('select p from App\Entity\Produit p '
                            . 'where p.nom like ?1 and p.type=?2')
                    ->setParameter(1, '%'.$name.'%')
                    ->setParameter(2, 'produit')
                    ->getResult();
        } else {
            $produits = $this->getDoctrine()->getManager()
                    ->createQuery('select p from App\Entity\Produit p '
                            . 'where p.nom like ?1 and p.type=?2 and '
                            . 'p.entreprise = ?3')
                    ->setParameter(1, '%' . $name . '%')
                    ->setParameter(2, 'produit')
                    ->setParameter(3, $this->getUser()->getEntreprise())
                    ->getResult();
        }

        return count($produits) ? $produits : [];
    }

    /**
     * @Rest\Get(path="/service/{id}/modele", name="service_by_modele")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_PRODUIT_INDEX")
     */
    public function findServiceByModele(\App\Entity\Modele $modele): array {
        $produits = $this->getDoctrine()
                ->getRepository(Produit::class)
                ->findByModele($modele);

        return count($produits) ? $produits : [];
    }

    /**
     * @Rest\Post(Path="/create", name="produit_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PRODUIT_CREATE")
     */
    public function create(Request $request): Produit {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($produit);
        $entityManager->flush();

        return $produit;
    }

    /**
     * @Rest\Get(path="/{id}", name="produit_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PRODUIT_SHOW")
     */
    public function show(Produit $produit): Produit {
        return $produit;
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="produit_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PRODUIT_EDIT")
     */
    public function edit(Request $request, Produit $produit): Produit {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $produit;
    }

    /**
     * @Rest\Delete("/{id}", name="produit_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PRODUIT_DELETE")
     */
    public function delete(Produit $produit): Produit {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($produit);
        $entityManager->flush();

        return $produit;
    }

    /**
     * @Rest\Post("/delete-selection/", name="produit_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PRODUIT_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $produits = Utils::getObjectFromRequest($request);
        if (!count($produits)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($produits as $produit) {
            $produit = $entityManager->getRepository(Produit::class)->find($produit->id);
            $entityManager->remove($produit);
        }
        $entityManager->flush();

        return $produits;
    }

}
