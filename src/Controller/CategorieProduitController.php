<?php

namespace App\Controller;

use App\Entity\CategorieProduit;
use App\Form\CategorieProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/categorieproduit")
 */
class CategorieProduitController extends AbstractController
{
    public static $photoDirectory = '/uploads/categorieproduits';
    
    /**
     * @Rest\Get(path="/categorie-produit/", name="categorie_produit_index")
     * @Rest\View(StatusCode = 200)
     */
    public function findCategoryProduit(): array
    {
        $categorieProduits = $this->getDoctrine()
            ->getRepository(CategorieProduit::class)
            ->finByType('produit',['nom'=>'asc']);

        return count($categorieProduits)?$categorieProduits:[];
    }
    
    /**
     * @Rest\Get(path="/categorie-service/", name="categorie_service_index")
     * @Rest\View(StatusCode = 200)
     */
    public function findCategoryService(): array
    {
        $categorieProduits = $this->getDoctrine()
            ->getRepository(CategorieProduit::class)
            ->finByType('service',['nom'=>'asc']);

        return count($categorieProduits)?$categorieProduits:[];
    }
    
    /**
     * @Rest\Get(path="/cp/{id}/modele", name="categorie_produit_by_modele")
     * @Rest\View(StatusCode = 200)
     */
    public function findCPByModele(\App\Entity\Modele $modele): array
    {
        $categorieProduits = $this->getDoctrine()
            ->getRepository(CategorieProduit::class)
            ->findBy(['modele'=>$modele,'categorieParent'=>NULL,'type'=>'produit'],['nom'=>'asc']);

        return count($categorieProduits)?$categorieProduits:[];
    }
    
    /**
     * @Rest\Get(path="/cmp/{id}/modele", name="categorie_produit_by_matierepremiere")
     * @Rest\View(StatusCode = 200)
     */
    public function findCMPByModele(\App\Entity\Modele $modele): array
    {
        $categorieProduits = $this->getDoctrine()
            ->getRepository(CategorieProduit::class)
            ->findBy(['modele'=>$modele,'categorieParent'=>NULL,'type'=>'matierepremiere'],['nom'=>'asc']);

        return count($categorieProduits)?$categorieProduits:[];
    }
    
    /**
     * @Rest\Get(path="/cs/{id}/modele", name="categorie_service_by_modele")
     * @Rest\View(StatusCode = 200)
     */
    public function findCSByModele(\App\Entity\Modele $modele): array
    {
        $categorieProduits = $this->getDoctrine()
            ->getRepository(CategorieProduit::class)
            ->findBy(['modele'=>$modele,'categorieParent'=>NULL,'type'=>'service'],['nom'=>'asc']);

        return count($categorieProduits)?$categorieProduits:[];
    }
    
    /**
     * @Rest\Get(path="/{id}/categorie", name="sous_categorie_produit_by_categorie")
     * @Rest\View(StatusCode = 200)
     */
    public function findSousCategorieByCategorie(CategorieProduit $categorie): array
    {
        $categorieProduits = $this->getDoctrine()
            ->getRepository(CategorieProduit::class)
            ->findByCategorieParent($categorie,['nom'=>'asc']);

        return count($categorieProduits)?$categorieProduits:[];
    }

    /**
     * @Rest\Post(Path="/create", name="categorie_produit_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CATEGORIEPRODUIT_CREATE")
     */
    public function create(Request $request): CategorieProduit    {
        $categorieProduit = new CategorieProduit();
        $form = $this->createForm(CategorieProduitType::class, $categorieProduit);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($categorieProduit);
        $entityManager->flush();

        return $categorieProduit;
    }
    
    /**
     * @Rest\Post(path="/{id}/photo-upload", name="categorieproduit_photo_upload",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CATEGORIEPRODUIT_CREATE")
     */
    public function uploadPhoto(Request $request, CategorieProduit $categorie, \Symfony\Component\DependencyInjection\ContainerInterface $container): CategorieProduit {
        $em = $this->getDoctrine()->getManager();
        $fullPath = Utils::$serveurUrl . CategorieProduitController::$photoDirectory . '/';
        //find old photo and delete it if exists
        $fileSystem = new \Symfony\Component\Filesystem\Filesystem();
        if ($categorie->getPhoto()) {
            $path = $container->getParameter('categorieproduit_photo_directory') . $categorie->getPhoto();
            try {
                if ($fileSystem->exists($path)) {
                    $fileSystem->remove($path);
                }
            } catch (IOExceptionInterface $exception) {
                echo "An error occurred while deleting the file at " . $exception->getPath();
            }
        }
        //manage new file upload
        $file = NULL;
        if ($request->files->get('file')) {
            $file = $request->files->get('file');
        }
        if ($file) {
            $fileName = $categorie->getNom() . '.' . $file->guessExtension();
            // moves the file to the directory where brochures are stored
            $file->move(
                    $container->getParameter('categorieproduit_photo_directory'), $fileName
            );
            $categorie->setPhoto($fileName);
            $categorie->setPhotoUrl($fullPath . $fileName);
            $em->flush();
        }
        return $categorie;
    }

    /**
     * @Rest\Get(path="/{id}", name="categorie_produit_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CATEGORIEPRODUIT_SHOW")
     */
    public function show(CategorieProduit $categorieProduit): CategorieProduit    {
        return $categorieProduit;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="categorie_produit_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CATEGORIEPRODUIT_EDIT")
     */
    public function edit(Request $request, CategorieProduit $categorieProduit): CategorieProduit    {
        $form = $this->createForm(CategorieProduitType::class, $categorieProduit);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $categorieProduit;
    }

    /**
     * @Rest\Delete("/{id}", name="categorie_produit_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CATEGORIEPRODUIT_DELETE")
     */
    public function delete(CategorieProduit $categorieProduit): CategorieProduit    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($categorieProduit);
        $entityManager->flush();

        return $categorieProduit;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="categorie_produit_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CATEGORIEPRODUIT_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $categorieProduits = Utils::getObjectFromRequest($request);
        if (!count($categorieProduits)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($categorieProduits as $categorieProduit) {
            $categorieProduit = $entityManager->getRepository(CategorieProduit::class)->find($categorieProduit->id);
            $entityManager->remove($categorieProduit);
        }
        $entityManager->flush();

        return $categorieProduits;
    }
}
