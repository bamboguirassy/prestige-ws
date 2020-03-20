<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/client")
 */
class ClientController extends AbstractController {

    /**
     * @Rest\Get(path="/", name="client_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_CLIENT_INDEX")
     */
    public function index(): array {
        /* $faker = \Faker\Factory::create('fr_FR');
          $em= $this->getDoctrine()->getManager();
          $populator = new \Faker\ORM\Doctrine\Populator($faker, $em);
          $populator->addEntity(\App\Entity\Client::class, 2000);
          $insertedPKs = $populator->execute(); */
        $clients = $this->getDoctrine()
                ->getRepository(Client::class)
                ->findAll();

        return count($clients) ? $clients : [];
    }
    
    /**
     * @Rest\Get(path="/dette-client/{id}", name="dette_client_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_CLIENT_SHOW")
     */
    public function detteClient(Client $client) {
        $em = $this->getDoctrine()
                ->getManager();
        $dette=$em->createQuery('select sum(v.montantRestant) from App\Entity\Vente v '
                . 'where v.client=?1 and v.entreprise=?2 and v.regle<>?3')
                ->setParameter(1,$client)
                ->setParameter(2, $this->getUser()->getEntreprise())
                ->setParameter(3,1)
                ->getSingleScalarResult();
        return $dette;
    }

    /**
     * @Rest\Get(path="/search/{tel}", name="client_search")
     * @IsGranted("ROLE_CLIENT_INDEX")
     * @Rest\View(StatusCode = 200)
     */
    public function searchClient($tel): array {

        $clients = $this->getDoctrine()->getManager()
                ->createQuery('select c from App\Entity\Client c where c.telephone like ?1')
                ->setParameter(1, '%'.$tel.'%')
                ->getResult();

        return count($clients) ? $clients : [];
    }

    /**
     * @Rest\Post(Path="/create", name="client_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CLIENT_CREATE")
     */
    public function create(Request $request): Client {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($client);
        $entityManager->flush();

        return $client;
    }

    /**
     * @Rest\Get(path="/{id}", name="client_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CLIENT_SHOW")
     */
    public function show(Client $client): Client {
        return $client;
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="client_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CLIENT_EDIT")
     */
    public function edit(Request $request, Client $client): Client {
        $form = $this->createForm(ClientType::class, $client);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $client;
    }

    /**
     * @Rest\Delete("/{id}", name="client_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CLIENT_DELETE")
     */
    public function delete(Client $client): Client {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($client);
        $entityManager->flush();

        return $client;
    }

    /**
     * @Rest\Post("/delete-selection/", name="client_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CLIENT_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $clients = Utils::getObjectFromRequest($request);
        if (!count($clients)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($clients as $client) {
            $client = $entityManager->getRepository(Client::class)->find($client->id);
            $entityManager->remove($client);
        }
        $entityManager->flush();

        return $clients;
    }

}
