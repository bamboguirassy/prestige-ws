<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="fk_produit_entreprise1_idx", columns={"entreprise"})})
 * @ORM\Entity
 */
class Produit
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=145, nullable=false)
     */
    private $nom;

    /**
     * @var int|null
     *
     * @ORM\Column(name="prix_minimum", type="bigint", nullable=true)
     */
    private $prixMinimum;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="prix_variable", type="boolean", nullable=true)
     */
    private $prixVariable;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="quantifiable", type="boolean", nullable=true)
     */
    private $quantifiable;

    /**
     * @var int|null
     *
     * @ORM\Column(name="quantite_disponible", type="bigint", nullable=true)
     */
    private $quantiteDisponible;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="expose", type="boolean", nullable=true)
     */
    private $expose;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=45, nullable=false, options={"comment"="produit ou service"})
     */
    private $type;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Vente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vente", referencedColumnName="id")
     * })
     */
    private $vente;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom(string $nom)
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrixMinimum()
    {
        return $this->prixMinimum;
    }

    public function setPrixMinimum($prixMinimum): self
    {
        $this->prixMinimum = $prixMinimum;

        return $this;
    }

    public function getPrixVariable()
    {
        return $this->prixVariable;
    }

    public function setPrixVariable($prixVariable): self
    {
        $this->prixVariable = $prixVariable;

        return $this;
    }

    public function getQuantifiable()
    {
        return $this->quantifiable;
    }

    public function setQuantifiable($quantifiable): self
    {
        $this->quantifiable = $quantifiable;

        return $this;
    }

    public function getQuantiteDisponible()
    {
        return $this->quantiteDisponible;
    }

    public function setQuantiteDisponible($quantiteDisponible): self
    {
        $this->quantiteDisponible = $quantiteDisponible;

        return $this;
    }

    public function getExpose()
    {
        return $this->expose;
    }

    public function setExpose($expose): self
    {
        $this->expose = $expose;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        $this->description = $description;

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

    public function getEntreprise()
    {
        return $this->entreprise;
    }

    public function setEntreprise($entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getVente()
    {
        return $this->vente;
    }

    public function setVente($vente): self
    {
        $this->vente = $vente;

        return $this;
    }
}
