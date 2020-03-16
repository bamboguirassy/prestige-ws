<?php

namespace App\Controller;

use App\Entity\MoyenPaiement;
use App\Form\MoyenPaiementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/moyenpaiement")
 */
class MoyenPaiementController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="moyen_paiement_index")
     * @Rest\View(StatusCode = 200)
     */
    public function index(): array
    {
        $moyenPaiements = $this->getDoctrine()
            ->getRepository(MoyenPaiement::class)
            ->findAll(['nom'=>'asc']);

        return count($moyenPaiements)?$moyenPaiements:[];
    }

    /**
     * @Rest\Post(Path="/create", name="moyen_paiement_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_MOYENPAIEMENT_CREATE")
     */
    public function create(Request $request): MoyenPaiement    {
        $moyenPaiement = new MoyenPaiement();
        $form = $this->createForm(MoyenPaiementType::class, $moyenPaiement);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($moyenPaiement);
        $entityManager->flush();

        return $moyenPaiement;
    }

    /**
     * @Rest\Get(path="/{id}", name="moyen_paiement_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function show(MoyenPaiement $moyenPaiement): MoyenPaiement    {
        return $moyenPaiement;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="moyen_paiement_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_MOYENPAIEMENT_EDIT")
     */
    public function edit(Request $request, MoyenPaiement $moyenPaiement): MoyenPaiement    {
        $form = $this->createForm(MoyenPaiementType::class, $moyenPaiement);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $moyenPaiement;
    }

    /**
     * @Rest\Delete("/{id}", name="moyen_paiement_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_MOYENPAIEMENT_DELETE")
     */
    public function delete(MoyenPaiement $moyenPaiement): MoyenPaiement    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($moyenPaiement);
        $entityManager->flush();

        return $moyenPaiement;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="moyen_paiement_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_MOYENPAIEMENT_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $moyenPaiements = Utils::getObjectFromRequest($request);
        if (!count($moyenPaiements)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($moyenPaiements as $moyenPaiement) {
            $moyenPaiement = $entityManager->getRepository(MoyenPaiement::class)->find($moyenPaiement->id);
            $entityManager->remove($moyenPaiement);
        }
        $entityManager->flush();

        return $moyenPaiements;
    }
}
