<?php

namespace App\Controller;

use App\Entity\ValeurCaracteristique;
use App\Form\ValeurCaracteristiqueType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/valeurcaracteristique")
 */
class ValeurCaracteristiqueController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="valeur_caracteristique_index")
     * @Rest\View(StatusCode = 200)
     */
    public function index(): array
    {
        $valeurCaracteristiques = $this->getDoctrine()
            ->getRepository(ValeurCaracteristique::class)
            ->findAll();

        return count($valeurCaracteristiques)?$valeurCaracteristiques:[];
    }

    /**
     * @Rest\Post(Path="/create", name="valeur_caracteristique_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VALEURCARACTERISTIQUE_CREATE")
     */
    public function create(Request $request): ValeurCaracteristique    {
        $valeurCaracteristique = new ValeurCaracteristique();
        $form = $this->createForm(ValeurCaracteristiqueType::class, $valeurCaracteristique);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($valeurCaracteristique);
        $entityManager->flush();

        return $valeurCaracteristique;
    }

    /**
     * @Rest\Get(path="/{id}", name="valeur_caracteristique_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VALEURCARACTERISTIQUE_SHOW")
     */
    public function show(ValeurCaracteristique $valeurCaracteristique): ValeurCaracteristique    {
        return $valeurCaracteristique;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="valeur_caracteristique_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VALEURCARACTERISTIQUE_EDIT")
     */
    public function edit(Request $request, ValeurCaracteristique $valeurCaracteristique): ValeurCaracteristique    {
        $form = $this->createForm(ValeurCaracteristiqueType::class, $valeurCaracteristique);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $valeurCaracteristique;
    }

    /**
     * @Rest\Delete("/{id}", name="valeur_caracteristique_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VALEURCARACTERISTIQUE_DELETE")
     */
    public function delete(ValeurCaracteristique $valeurCaracteristique): ValeurCaracteristique    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($valeurCaracteristique);
        $entityManager->flush();

        return $valeurCaracteristique;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="valeur_caracteristique_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VALEURCARACTERISTIQUE_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $valeurCaracteristiques = Utils::getObjectFromRequest($request);
        if (!count($valeurCaracteristiques)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($valeurCaracteristiques as $valeurCaracteristique) {
            $valeurCaracteristique = $entityManager->getRepository(ValeurCaracteristique::class)->find($valeurCaracteristique->id);
            $entityManager->remove($valeurCaracteristique);
        }
        $entityManager->flush();

        return $valeurCaracteristiques;
    }
}
