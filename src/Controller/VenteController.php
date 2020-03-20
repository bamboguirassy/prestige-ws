<?php

namespace App\Controller;

use App\Entity\Vente;
use App\Form\VenteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/vente")
 */
class VenteController extends AbstractController {

    /**
     * @Rest\Get(path="/", name="vente_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_VENTE_INDEX")
     */
    public function index(): array {
        $ventes = $this->getDoctrine()
                ->getRepository(Vente::class)
                ->findBy(['entreprise' => $this->getUser()->getEntreprise(),
            'type' => 'vente'], ['date' => 'desc']);

        return count($ventes) ? $ventes : [];
    }

    /**
     * @Rest\Get(path="/commande/", name="commande_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_COMMANDE_INDEX")
     */
    public function findCommandes(): array {
        $ventes = $this->getDoctrine()
                ->getRepository(Vente::class)
                ->findBy(['entreprise' => $this->getUser()->getEntreprise(),
            'type' => 'commande'], ['date' => 'desc']);

        return count($ventes) ? $ventes : [];
    }

    /**
     * @Rest\Get(path="/service/", name="service_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_SERVICEDEMANDE_SHOW")
     */
    public function findServices(): array {
        $services = $this->getDoctrine()
                ->getRepository(Vente::class)
                ->findBy([
            'entreprise' => $this->getUser()->getEntreprise(),
            'type' => 'service'], ['date' => 'desc']);

        return count($services) ? $services : [];
    }

    /**
     * @Rest\Post(Path="/create", name="vente_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VENTE_CREATE")
     */
    public function create(Request $request): Vente {
        $venteData = json_decode($request->getContent());
        $entityManager = $this->getDoctrine()->getManager();
        $vente = new Vente();
        $form = $this->createForm(VenteType::class, $vente);
        $form->submit(Utils::serializeRequestContent($request));
        //generate random
        if ($vente->getType() == 'vente') {
            $numeroVente = 'V-' . $this->getUser()->getId() . '-' . time();
        } else if ($vente->getType() == 'commande') {
            $numeroVente = 'C-' . $this->getUser()->getId() . '-' . time();
        } else {
            throw $this->createNotFoundException("Type inconnu, vente ou commande attentdue...");
        }

        $vente->setNumeroVente($numeroVente);
        $vente->setEntreprise($this->getUser()->getEntreprise());
        $vente->setDate(new \DateTime());
        $vente->setAgentVente($this->getUser());
        //persist
        $entityManager->persist($vente);
        //manage produit lines
        $produits = $venteData->produits;
        foreach ($produits as $produit) {
            $venteProduit = new \App\Entity\VenteProduit();
            $formProd = $this->createForm(\App\Form\VenteProduitType::class, $venteProduit);
            $formProd->submit((array) $produit);
            $venteProduit->setVente($vente);
            if ($venteProduit->getProduit()->getQuantifiable()) {
                $quantiteDispo = $venteProduit->getProduit()->getQuantiteDisponible() - $venteProduit->getQuantite();
                $venteProduit->getProduit()->setQuantiteDisponible($quantiteDispo);
            }
            $entityManager->persist($venteProduit);
        }
        //manage reglement
        $reglements = $venteData->reglements;
        foreach ($reglements as $reglementLine) {
            $reglement = new \App\Entity\Reglement();
            $formReg = $this->createForm(\App\Form\ReglementType::class, $reglement);
            $formReg->submit((array) $reglementLine);
            if ($reglement->getMontant() > 0 || $reglement->getMontantRestant() < 0 || isset($venteData->avoirs)) {
                $reglement->setVente($vente);
                $reglement->setDate(new \DateTime());
                $entityManager->persist($reglement);
                // check for avoir
                if ($reglement->getMontantRestant() < 0) {
                    $avoir = new \App\Entity\Avoir();
                    $avoir->setDate(new \DateTime());
                    $avoir->setMontant(abs($reglement->getMontantRestant()));
                    $avoir->setReglementSource($reglement);
                    $avoir->setUtilise(false);
                    $entityManager->persist($avoir);
                }
            }
        }

        //check for selected avoirs
        if (isset($venteData->avoirs)) {
            $selectedAvoirs = $venteData->avoirs;
            foreach ($selectedAvoirs as $selectedAvoir) {
                $avoir = $entityManager->getRepository(\App\Entity\Avoir::class)
                        ->find($selectedAvoir->id);
                $form = $this->createForm(\App\Form\AvoirType::class, $avoir);
                $form->submit((array) $selectedAvoir);
                $avoir->setReglementDestination($reglement);
                $avoir->setUtilise(true);
            }
        }

        $entityManager->flush();

        return $vente;
    }

    /**
     * @Rest\Post(Path="/create/service/", name="service_vente_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_SERVICEDEMANDE_CREATE")
     */
    public function createService(Request $request): Vente {
        $serviceData = json_decode($request->getContent());
        $entityManager = $this->getDoctrine()->getManager();
        $vente = new Vente();
        $form = $this->createForm(VenteType::class, $vente);
        $form->submit(Utils::serializeRequestContent($request));
        //generate random
        $numeroVente = 'S-' . $this->getUser()->getId() . '-' . time();
        $vente->setNumeroVente($numeroVente);
        $vente->setEntreprise($this->getUser()->getEntreprise());
        $vente->setDate(new \DateTime());
        $vente->setAgentVente($this->getUser());
        $vente->setType('service');
        //persist
        $entityManager->persist($vente);
        //manage produit lines
        $produits = $serviceData->produits;
        foreach ($produits as $produitLine) {
            $produit = new \App\Entity\Produit();
            $formProd = $this->createForm(\App\Form\ProduitType::class, $produit);
            $formProd->submit((array) $produitLine);
            //get selected categorie
            $categorie = $entityManager->getRepository(\App\Entity\CategorieProduit::class)
                    ->find($produitLine->categorie);
            $produit->setNom($vente->getClient()->getPrenom() . '-' . $vente->getClient()->getNom() . '-' . $categorie->getNom() . '-' . $numeroVente);
            $produit->setVente($vente);
            $produit->setType('service');
            $produit->setEntreprise($this->getUser()->getEntreprise());
            $entityManager->persist($produit);
            //define caracteristics for product
            $caracteristiqueAndValeurs = (array) $produitLine->caracteristiqueAndValeurs;
            foreach ($caracteristiqueAndValeurs as $caracteristiqueAndValeur) {
                $caracteristique = $entityManager->getRepository(\App\Entity\CaracteristiqueCategorie::class)
                        ->find($caracteristiqueAndValeur->id);
                $caracteristiqueProduit = new \App\Entity\CaracteristiqueProduit();
                $caracteristiqueProduit->setProduit($produit);
                $caracteristiqueProduit->setCaracteristiqueCategorie($caracteristique);
                if (isset($caracteristiqueAndValeur->valeur)) {
                    $valeurCaracteristique = (string) $caracteristiqueAndValeur->valeur;
                    $caracteristiqueProduit->setValeur($valeurCaracteristique);
                    $entityManager->persist($caracteristiqueProduit);
                }
            }
        }
        //manage reglement
        $reglements = $serviceData->reglements;
        foreach ($reglements as $reglementLine) {
            $reglement = new \App\Entity\Reglement();
            $formReg = $this->createForm(\App\Form\ReglementType::class, $reglement);
            $formReg->submit((array) $reglementLine);
            if ($reglement->getMontant() > 0 || $reglement->getMontantRestant() < 0 || isset($serviceData->avoirs)) {
                $reglement->setVente($vente);
                $reglement->setDate(new \DateTime());
                $entityManager->persist($reglement);
                // check for avoir
                if ($reglement->getMontantRestant() < 0) {
                    $avoir = new \App\Entity\Avoir();
                    $avoir->setDate(new \DateTime());
                    $avoir->setMontant(abs($reglement->getMontantRestant()));
                    $avoir->setReglementSource($reglement);
                    $avoir->setUtilise(false);
                    $entityManager->persist($avoir);
                }
            }
        }

        //check for selected avoirs
        if (isset($serviceData->avoirs)) {
            $selectedAvoirs = $serviceData->avoirs;
            foreach ($selectedAvoirs as $selectedAvoir) {
                $avoir = $entityManager->getRepository(\App\Entity\Avoir::class)
                        ->find($selectedAvoir->id);
                $form = $this->createForm(\App\Form\AvoirType::class, $avoir);
                $form->submit((array) $selectedAvoir);
                $avoir->setReglementDestination($reglement);
                $avoir->setUtilise(true);
            }
        }

        $entityManager->flush();

        return $vente;
    }

    /**
     * @Rest\Get(path="/{id}", name="vente_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VENTE_SHOW")
     */
    public function show(Vente $vente): Vente {
        return $vente;
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="vente_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VENTE_EDIT")
     */
    public function edit(Request $request, Vente $vente): Vente {
        $etatLivraison = $vente->getLivree();
        $form = $this->createForm(VenteType::class, $vente);
        $form->submit(Utils::serializeRequestContent($request));
        if ($vente->getLivree() && !$etatLivraison) {
            $vente->setDateLivraison(new \DateTime());
        } else if ($etatLivraison && !$vente->getLivree()) {
            $vente->setDateLivraison(null);
        }

        $this->getDoctrine()->getManager()->flush();

        return $vente;
    }

    /**
     * @Rest\Delete("/{id}", name="vente_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VENTE_DELETE")
     */
    public function delete(Vente $vente): Vente {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($vente);
        $entityManager->flush();

        return $vente;
    }

    /**
     * @Rest\Post("/delete-selection/", name="vente_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VENTE_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $ventes = Utils::getObjectFromRequest($request);
        if (!count($ventes)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($ventes as $vente) {
            $vente = $entityManager->getRepository(Vente::class)->find($vente->id);
            $entityManager->remove($vente);
        }
        $entityManager->flush();

        return $ventes;
    }

}
