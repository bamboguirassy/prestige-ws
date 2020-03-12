<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProduitCategorise
 *
 * @ORM\Table(name="produit_categorise", indexes={@ORM\Index(name="fk_categorie_produit_has_produit_categorie_produit1_idx", columns={"categorie_produit"}), @ORM\Index(name="fk_categorie_produit_has_produit_produit1_idx", columns={"produit"})})
 * @ORM\Entity
 */
class ProduitCategorise
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
     * @var \CategorieProduit
     *
     * @ORM\ManyToOne(targetEntity="CategorieProduit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categorie_produit", referencedColumnName="id")
     * })
     */
    private $categorieProduit;

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

    public function getCategorieProduit()
    {
        return $this->categorieProduit;
    }

    public function setCategorieProduit($categorieProduit): self
    {
        $this->categorieProduit = $categorieProduit;

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
