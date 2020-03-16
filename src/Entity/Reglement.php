<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reglement
 *
 * @ORM\Table(name="reglement", indexes={@ORM\Index(name="fk_reglement_moyen_payement1_idx", columns={"moyen_paiement"}), @ORM\Index(name="fk_reglement_vente1_idx", columns={"vente"})})
 * @ORM\Entity
 */
class Reglement
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
     * @ORM\Column(name="montant", type="bigint", nullable=true)
     */
    private $montant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var int|null
     *
     * @ORM\Column(name="montant_restant", type="bigint", nullable=true)
     */
    private $montantRestant;

    /**
     * @var int
     *
     * @ORM\Column(name="montant_donne", type="bigint", nullable=false)
     */
    private $montantDonne;

    /**
     * @var int|null
     *
     * @ORM\Column(name="montant_retourne", type="bigint", nullable=true)
     */
    private $montantRetourne;

    /**
     * @var \MoyenPaiement
     *
     * @ORM\ManyToOne(targetEntity="MoyenPaiement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="moyen_paiement", referencedColumnName="id")
     * })
     */
    private $moyenPaiement;

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

    public function getMontant()
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

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

    public function getMontantRestant()
    {
        return $this->montantRestant;
    }

    public function setMontantRestant($montantRestant): self
    {
        $this->montantRestant = $montantRestant;

        return $this;
    }

    public function getMontantDonne()
    {
        return $this->montantDonne;
    }

    public function setMontantDonne(string $montantDonne): self
    {
        $this->montantDonne = $montantDonne;

        return $this;
    }

    public function getMontantRetourne()
    {
        return $this->montantRetourne;
    }

    public function setMontantRetourne($montantRetourne): self
    {
        $this->montantRetourne = $montantRetourne;

        return $this;
    }

    public function getMoyenPaiement()
    {
        return $this->moyenPaiement;
    }

    public function setMoyenPaiement($moyenPaiement): self
    {
        $this->moyenPaiement = $moyenPaiement;

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
