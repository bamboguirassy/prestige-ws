<?php

namespace App\Controller;

use App\Entity\Avoir;
use App\Form\AvoirType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/avoir")
 */
class AvoirController extends AbstractController {

    /**
     * @Rest\Get(path="/", name="avoir_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_AVOIR_INDEX")
     */
    public function index(): array {
        $avoirs = $this->getDoctrine()
                ->getRepository(Avoir::class)
                ->findAll();

        return count($avoirs) ? $avoirs : [];
    }

    /**
     * @Rest\Get(path="/{id}/client", name="avoir_by_client")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_AVOIR_INDEX")
     */
    public function findByClient(\App\Entity\Client $client): array {
        $avoirs = $this->getDoctrine()->getManager()
                ->createQuery('select a from App\Entity\Avoir a,'
                        . 'App\Entity\Reglement r, App\Entity\vente v '
                        . 'where a.reglementSource=r and r.vente=v and v.entreprise=?1 '
                        . 'and v.client=?2 and a.utilise=?3')
                ->setParameter(1, $this->getUser()->getEntreprise())
                ->setParameter(2, $client)
                ->setParameter(3, 0)
                ->getResult();

        return count($avoirs) ? $avoirs : [];
    }

    /**
     * @Rest\Post(Path="/create", name="avoir_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_AVOIR_CREATE")
     */
    public function create(Request $request): Avoir {
        $avoir = new Avoir();
        $form = $this->createForm(AvoirType::class, $avoir);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($avoir);
        $entityManager->flush();

        return $avoir;
    }

    /**
     * @Rest\Get(path="/{id}", name="avoir_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_AVOIR_SHOW")
     */
    public function show(Avoir $avoir): Avoir {
        return $avoir;
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="avoir_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_AVOIR_EDIT")
     */
    public function edit(Request $request, Avoir $avoir): Avoir {
        $form = $this->createForm(AvoirType::class, $avoir);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $avoir;
    }

    /**
     * @Rest\Put(path="/update-multiple/", name="avoir_edit_multiple")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VENTE_CREATE")
     */
    public function updateMultiple(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $selectedAvoirs = Utils::serializeRequestContent($request);
        foreach ($selectedAvoirs as $selectedAvoir) {
            $avoir = $em->getRepository(Avoir::class)
                    ->find($selectedAvoir->id);
            $form = $this->createForm(AvoirType::class, $avoir);
            $form->submit($selectedAvoir);
        }

        $em->flush();

        return $avoir;
    }

    /**
     * @Rest\Delete("/{id}", name="avoir_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_AVOIR_DELETE")
     */
    public function delete(Avoir $avoir): Avoir {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($avoir);
        $entityManager->flush();

        return $avoir;
    }

    /**
     * @Rest\Post("/delete-selection/", name="avoir_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_AVOIR_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $avoirs = Utils::getObjectFromRequest($request);
        if (!count($avoirs)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($avoirs as $avoir) {
            $avoir = $entityManager->getRepository(Avoir::class)->find($avoir->id);
            $entityManager->remove($avoir);
        }
        $entityManager->flush();

        return $avoirs;
    }

}
