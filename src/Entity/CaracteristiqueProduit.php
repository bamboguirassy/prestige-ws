<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CaracteristiqueProduit
 *
 * @ORM\Table(name="caracteristique_produit", indexes={@ORM\Index(name="fk_caracteristique_produit_caracteristique_categorie1_idx", columns={"caracteristique_categorie"}), @ORM\Index(name="fk_caracteristique_produit_produit1_idx", columns={"produit"})})
 * @ORM\Entity
 */
class CaracteristiqueProduit
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
     * @ORM\Column(name="valeur", type="string", length=45, nullable=false)
     */
    private $valeur;

    /**
     * @var \CaracteristiqueCategorie
     *
     * @ORM\ManyToOne(targetEntity="CaracteristiqueCategorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="caracteristique_categorie", referencedColumnName="id")
     * })
     */
    private $caracteristiqueCategorie;

    /**
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produit", referencedColumnName="id")
     * })
     */
    private $produit;

    public function getId()
    {
        return $this->id;
    }

    public function getValeur()
    {
        return $this->valeur;
    }

    public function setValeur(string $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getCaracteristiqueCategorie()
    {
        return $this->caracteristiqueCategorie;
    }

    public function setCaracteristiqueCategorie($caracteristiqueCategorie): self
    {
        $this->caracteristiqueCategorie = $caracteristiqueCategorie;

        return $this;
    }

    public function getProduit()
    {
        return $this->produit;
    }

    public function setProduit($produit): self
    {
        $this->produit = $produit;

        return $this;
    }


}
