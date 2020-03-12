<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/entreprise")
 */
class EntrepriseController extends AbstractController {

    /**
     * @Rest\Get(path="/", name="entreprise_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_ENTREPRISE_INDEX")
     */
    public function index(): array {
        if (UserController::isSuperAdmin($this)) {
            $entreprises = $this->getDoctrine()
                    ->getRepository(Entreprise::class)
                    ->findAll();
        } else {
            $entreprises[] = $this->getUser()->getEntreprise();
        }

        return count($entreprises) ? $entreprises : [];
    }

    /**
     * @Rest\Post(Path="/create", name="entreprise_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ENTREPRISE_CREATE")
     */
    public function create(Request $request): Entreprise {
        $entreprise = new Entreprise();
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entreprise);
        $entityManager->flush();

        return $entreprise;
    }

    /**
     * @Rest\Get(path="/{id}", name="entreprise_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ENTREPRISE_SHOW")
     */
    public function show(Entreprise $entreprise): Entreprise {
        return $entreprise;
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="entreprise_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ENTREPRISE_EDIT")
     */
    public function edit(Request $request, Entreprise $entreprise): Entreprise {
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $entreprise;
    }

    /**
     * @Rest\Delete("/{id}", name="entreprise_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ENTREPRISE_DELETE")
     */
    public function delete(Entreprise $entreprise): Entreprise {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($entreprise);
        $entityManager->flush();

        return $entreprise;
    }

    /**
     * @Rest\Post("/delete-selection/", name="entreprise_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ENTREPRISE_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $entreprises = Utils::getObjectFromRequest($request);
        if (!count($entreprises)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($entreprises as $entreprise) {
            $entreprise = $entityManager->getRepository(Entreprise::class)->find($entreprise->id);
            $entityManager->remove($entreprise);
        }
        $entityManager->flush();

        return $entreprises;
    }

}
