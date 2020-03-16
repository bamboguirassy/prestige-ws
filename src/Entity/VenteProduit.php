<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VenteProduit
 *
 * @ORM\Table(name="vente_produit", indexes={@ORM\Index(name="fk_vente_produit_produit1_idx", columns={"produit"}), @ORM\Index(name="fk_vente_produit_vente1_idx", columns={"vente"})})
 * @ORM\Entity
 */
class VenteProduit
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
     * @ORM\Column(name="prix_unitaire", type="bigint", nullable=false)
     */
    private $prixUnitaire;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     */
    private $quantite;

    /**
     * @var int|null
     *
     * @ORM\Column(name="montant_total", type="bigint", nullable=true)
     */
    private $montantTotal;

    /**
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produit", referencedColumnName="id")
     * })
     */
    private $produit;

    /**
     * @var \Vente
     *
     * @ORM\ManyToOne(targetEntity="Vente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vente", referencedColumnName="id")
     * })
     */
    private $vente;

    public function getId()
    {
        return $this->id;
    }

    public function getPrixUnitaire()
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(string $prixUnitaire): self
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function getQuantite()
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getMontantTotal()
    {
        return $this->montantTotal;
    }

    public function setMontantTotal($montantTotal): self
    {
        $this->montantTotal = $montantTotal;

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
