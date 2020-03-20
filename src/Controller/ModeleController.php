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
class ModeleController extends AbstractController {

    public static $photoDirectory = '/uploads/modeles';

    /**
     * @Rest\Get(path="/", name="modele_index")
     * @Rest\View(StatusCode = 200)
     */
    public function index(): array {
        $modeles = $this->getDoctrine()
                ->getRepository(Modele::class)
                ->findAll(['nom' => 'asc']);

        return count($modeles) ? $modeles : [];
    }

    /**
     * @Rest\Post(Path="/create", name="modele_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_MODELE_CREATE")
     */
    public function create(Request $request): Modele {
        $modele = new Modele();
        $form = $this->createForm(ModeleType::class, $modele);
        $form->submit(Utils::serializeRequestContent($request));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($modele);

        //set fonctionnalities
        $modeleData = json_decode($request->getContent());
        $fonctionnaliteIds = (array) $modeleData->fonctionnalites;
        foreach ($fonctionnaliteIds as $fonctionnaliteId) {
            $fonctionnalite = $entityManager->getRepository(\App\Entity\Fonctionnalite::class)
                    ->find($fonctionnaliteId);
            $fonctionnaliteModele = new \App\Entity\FonctionnaliteModele();
            $fonctionnaliteModele->setFonctionnalite($fonctionnalite);
            $fonctionnaliteModele->setModele($modele);
            $entityManager->persist($fonctionnaliteModele);
        }
        $entityManager->flush();

        return $modele;
    }

    /**
     * @Rest\Get(path="/{id}", name="modele_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_MODELE_SHOW")
     */
    public function show(Modele $modele): Modele {
        return $modele;
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="modele_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_MODELE_EDIT")
     */
    public function edit(Request $request, Modele $modele): Modele {
        $form = $this->createForm(ModeleType::class, $modele);
        $form->submit(Utils::serializeRequestContent($request));
        $entityManager = $this->getDoctrine()->getManager();

        //find and remove existing fonctionnalités
        $fonctionnaliteModeles = $entityManager->getRepository(\App\Entity\FonctionnaliteModele::class)
                ->findByModele($modele);
        foreach ($fonctionnaliteModeles as $fonctionnalite) {
            $entityManager->remove($fonctionnalite);
        }
        $entityManager->flush();
        //set fonctionnalities
        $modeleData = json_decode($request->getContent());
        $fonctionnaliteIds = (array) $modeleData->fonctionnalites;
        foreach ($fonctionnaliteIds as $fonctionnaliteId) {
            $fonctionnalite = $entityManager->getRepository(\App\Entity\Fonctionnalite::class)
                    ->find($fonctionnaliteId);
            $fonctionnaliteModele = new \App\Entity\FonctionnaliteModele();
            $fonctionnaliteModele->setFonctionnalite($fonctionnalite);
            $fonctionnaliteModele->setModele($modele);
            $entityManager->persist($fonctionnaliteModele);
        }

        $entityManager->flush();

        return $modele;
    }

    /**
     * @Rest\Post(path="/{id}/photo-upload", name="modele_photo_upload",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_MODELE_EDIT")
     */
    public function uploadPhoto(Request $request, Modele $modele, \Symfony\Component\DependencyInjection\ContainerInterface $container): Modele {
        $em = $this->getDoctrine()->getManager();
        $fullPath = Utils::$serveurUrl . ModeleController::$photoDirectory . '/';
        //find old photo and delete it if exists
        $fileSystem = new \Symfony\Component\Filesystem\Filesystem();
        if ($modele->getPhoto()) {
            $path = $container->getParameter('modele_photo_directory') . $modele->getPhoto();
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
            $fileName = $modele->getNom() . '.' . $file->guessExtension();
            // moves the file to the directory where brochures are stored
            $file->move(
                    $container->getParameter('modele_photo_directory'), $fileName
            );
            $modele->setPhoto($fileName);
            $modele->setPhotoUrl($fullPath . $fileName);
            $em->flush();
        }
        return $modele;
    }

    /**
     * @Rest\Delete("/{id}", name="modele_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_MODELE_DELETE")
     */
    public function delete(Modele $modele, \Symfony\Component\DependencyInjection\ContainerInterface $container): Modele {
        $entityManager = $this->getDoctrine()->getManager();

        //find and remove existing fonctionnalités
        $fonctionnaliteModeles = $entityManager->getRepository(\App\Entity\FonctionnaliteModele::class)
                ->findByModele($modele);
        foreach ($fonctionnaliteModeles as $fonctionnalite) {
            $entityManager->remove($fonctionnalite);
        }

        //find old photo and delete it if exists
        $fileSystem = new \Symfony\Component\Filesystem\Filesystem();
        if ($modele->getPhoto()) {
            $path = $container->getParameter('modele_photo_directory') . '/' . $modele->getPhoto();
            try {
                if ($fileSystem->exists($path)) {
                    $fileSystem->remove($path);
                }
            } catch (IOExceptionInterface $exception) {
                echo "An error occurred while deleting the file at " . $exception->getPath();
            }
        }
        $entityManager->remove($modele);

        $entityManager->flush();

        return $modele;
    }

    /**
     * @Rest\Post("/delete-selection/", name="modele_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_MODELE_DELETE")
     */
    public function deleteMultiple(Request $request, \Symfony\Component\DependencyInjection\ContainerInterface $container): array {
        $entityManager = $this->getDoctrine()->getManager();
        $modeles = Utils::getObjectFromRequest($request);
        if (!count($modeles)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        $fileSystem = new \Symfony\Component\Filesystem\Filesystem();
        foreach ($modeles as $modele) {
            $modele = $entityManager->getRepository(Modele::class)->find($modele->id);
            //find and remove existing fonctionnalités
            $fonctionnaliteModeles = $entityManager->getRepository(\App\Entity\FonctionnaliteModele::class)
                    ->findByModele($modele);
            foreach ($fonctionnaliteModeles as $fonctionnalite) {
                $entityManager->remove($fonctionnalite);
            }
            //find old photo and delete it if exists
            if ($modele->getPhoto()) {
                $path = $container->getParameter('modele_photo_directory') . $modele->getPhoto();
                try {
                    if ($fileSystem->exists($path)) {
                        $fileSystem->remove($path);
                    }
                } catch (IOExceptionInterface $exception) {
                    echo "An error occurred while deleting the file at " . $exception->getPath();
                }
            }
            $entityManager->remove($modele);
        }
        $entityManager->flush();

        return $modeles;
    }

}
