<?php

namespace App\Controller;

use App\Entity\Reglement;
use App\Form\ReglementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/reglement")
 */
class ReglementController extends AbstractController {

    /**
     * @Rest\Get(path="/", name="reglement_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_REGLEMENT_INDEX")
     */
    public function index(): array {
        $reglements = $this->getDoctrine()
                ->getRepository(Reglement::class)
                ->findAll();

        return count($reglements) ? $reglements : [];
    }
    
    /**
     * @Rest\Get(path="/{id}/vente", name="reglement_by_vente_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_VENTE_SHOW")
     */
    public function findByVente(\App\Entity\Vente $vente): array {
        $reglements = $this->getDoctrine()
                ->getRepository(Reglement::class)
                ->findByVente($vente);

        return count($reglements) ? $reglements : [];
    }

    /**
     * @Rest\Post(Path="/create", name="reglement_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_REGLEMENT_CREATE")
     */
    public function create(Request $request): Reglement {
        $reglement = new Reglement();
        $form = $this->createForm(ReglementType::class, $reglement);
        $form->submit(Utils::serializeRequestContent($request));
        $reglement->setDate(new \DateTime());

        //update vente
        $montantRestant = $reglement->getVente()->getMontantRestant() - $reglement->getMontant();
        $montantRegle = $reglement->getVente()->getMontantRegle() + $reglement->getMontant();
        $regle = $montantRestant <= 0;
        $reglement->getVente()->setMontantRestant($montantRestant);
        $reglement->getVente()->setMontantRegle($montantRegle);
        $reglement->getVente()->setRegle($regle);
        $reglement->setMontantRestant($montantRestant);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reglement);
        
        $entityManager->flush();

        return $reglement;
    }

    /**
     * @Rest\Get(path="/{id}", name="reglement_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_REGLEMENT_SHOW")
     */
    public function show(Reglement $reglement): Reglement {
        return $reglement;
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="reglement_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_REGLEMENT_EDIT")
     */
    public function edit(Request $request, Reglement $reglement): Reglement {
        $form = $this->createForm(ReglementType::class, $reglement);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $reglement;
    }

    /**
     * @Rest\Delete("/{id}", name="reglement_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_REGLEMENT_DELETE")
     */
    public function delete(Reglement $reglement): Reglement {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reglement);
        $entityManager->flush();

        return $reglement;
    }

    /**
     * @Rest\Post("/delete-selection/", name="reglement_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_REGLEMENT_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $reglements = Utils::getObjectFromRequest($request);
        if (!count($reglements)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($reglements as $reglement) {
            $reglement = $entityManager->getRepository(Reglement::class)->find($reglement->id);
            $entityManager->remove($reglement);
        }
        $entityManager->flush();

        return $reglements;
    }

}
