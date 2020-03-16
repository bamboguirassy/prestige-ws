<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Vente
 *
 * @ORM\Table(name="vente", indexes={@ORM\Index(name="fk_vente_entreprise1_idx", columns={"entreprise"}), @ORM\Index(name="fk_vente_fos_user1_idx", columns={"agent_vente"}), @ORM\Index(name="fk_vente_user1_idx", columns={"client"})})
 * @ORM\Entity
 */
class Vente
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="montant_initial", type="bigint", nullable=false)
     */
    private $montantInitial;

    /**
     * @var int|null
     *
     * @ORM\Column(name="montant_regle", type="bigint", nullable=true)
     */
    private $montantRegle;

    /**
     * @var int|null
     *
     * @ORM\Column(name="montant_restant", type="bigint", nullable=true)
     */
    private $montantRestant;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_livraison", type="date", nullable=true)
     */
    private $dateLivraison;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresse_livraison", type="text", length=65535, nullable=true)
     */
    private $adresseLivraison;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="livree", type="boolean", nullable=true)
     */
    private $livree;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="regle", type="boolean", nullable=true, options={"comment"="true si reglement total = montant commande"})
     */
    private $regle;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_livraison_prevue", type="datetime", nullable=true)
     */
    private $dateLivraisonPrevue;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_livraison_effective", type="datetime", nullable=true)
     */
    private $dateLivraisonEffective;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=45, nullable=false, options={"comment"="commande ou vente ou ondemand"})
     */
    private $type;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_vente", type="string", length=16, nullable=false)
     */
    private $numeroVente;

    /**
     * @var \Entreprise
     *
     * @ORM\ManyToOne(targetEntity="Entreprise")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="entreprise", referencedColumnName="id")
     * })
     */
    private $entreprise;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="agent_vente", referencedColumnName="id")
     * })
     */
    private $agentVente;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client", referencedColumnName="id")
     * })
     */
    private $client;


    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMontantInitial()
    {
        return $this->montantInitial;
    }

    public function setMontantInitial(string $montantInitial)
    {
        $this->montantInitial = $montantInitial;

        return $this;
    }

    public function getMontantRegle()
    {
        return $this->montantRegle;
    }

    public function setMontantRegle($montantRegle): self
    {
        $this->montantRegle = $montantRegle;

        return $this;
    }

    public function getMontantRestant()
    {
        return $this->montantRestant;
    }

    public function setMontantRestant($montantRestant): self
    {
        $this->montantRestant = $montantRestant;

        return $this;
    }

    public function getDateLivraison()
    {
        return $this->dateLivraison;
    }

    public function setDateLivraison($dateLivraison): self
    {
        $this->dateLivraison = $dateLivraison;

        return $this;
    }

    public function getAdresseLivraison()
    {
        return $this->adresseLivraison;
    }

    public function setAdresseLivraison($adresseLivraison): self
    {
        $this->adresseLivraison = $adresseLivraison;

        return $this;
    }

    public function getLivree()
    {
        return $this->livree;
    }

    public function setLivree($livree): self
    {
        $this->livree = $livree;

        return $this;
    }

    public function getRegle()
    {
        return $this->regle;
    }

    public function setRegle($regle): self
    {
        $this->regle = $regle;

        return $this;
    }

    public function getDateLivraisonPrevue()
    {
        return $this->dateLivraisonPrevue;
    }

    public function setDateLivraisonPrevue($dateLivraisonPrevue): self
    {
        $this->dateLivraisonPrevue = $dateLivraisonPrevue;

        return $this;
    }

    public function getDateLivraisonEffective()
    {
        return $this->dateLivraisonEffective;
    }

    public function setDateLivraisonEffective($dateLivraisonEffective): self
    {
        $this->dateLivraisonEffective = $dateLivraisonEffective;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNumeroVente()
    {
        return $this->numeroVente;
    }

    public function setNumeroVente(string $numeroVente): self
    {
        $this->numeroVente = $numeroVente;

        return $this;
    }

    public function getEntreprise()
    {
        return $this->entreprise;
    }

    public function setEntreprise($entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getAgentVente()
    {
        return $this->agentVente;
    }

    public function setAgentVente($agentVente): self
    {
        $this->agentVente = $agentVente;

        return $this;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient($client): self
    {
        $this->client = $client;

        return $this;
    }

}
