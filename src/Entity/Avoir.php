<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Avoir
 *
 * @ORM\Table(name="avoir", indexes={@ORM\Index(name="fk_avoir_reglement1_idx", columns={"reglement_source"}), @ORM\Index(name="reglement_destination", columns={"reglement_destination"})})
 * @ORM\Entity
 */
class Avoir
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="montant", type="bigint", nullable=false)
     */
    private $montant;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="utilise", type="boolean", nullable=true)
     */
    private $utilise;

    /**
     * @var \Reglement
     *
     * @ORM\ManyToOne(targetEntity="Reglement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reglement_destination", referencedColumnName="id")
     * })
     */
    private $reglementDestination;

    /**
     * @var \Reglement
     *
     * @ORM\ManyToOne(targetEntity="Reglement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reglement_source", referencedColumnName="id")
     * })
     */
    private $reglementSource;

    public function getId()
    {
        return $this->id;
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

    public function getMontant()
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getUtilise()
    {
        return $this->utilise;
    }

    public function setUtilise($utilise): self
    {
        $this->utilise = $utilise;

        return $this;
    }

    public function getReglementDestination()
    {
        return $this->reglementDestination;
    }

    public function setReglementDestination($reglementDestination): self
    {
        $this->reglementDestination = $reglementDestination;

        return $this;
    }

    public function getReglementSource()
    {
        return $this->reglementSource;
    }

    public function setReglementSource($reglementSource): self
    {
        $this->reglementSource = $reglementSource;

        return $this;
    }


}
