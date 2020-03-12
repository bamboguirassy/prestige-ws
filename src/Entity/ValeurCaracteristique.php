<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ValeurCaracteristique
 *
 * @ORM\Table(name="valeur_caracteristique", indexes={@ORM\Index(name="fk_valeur_caracteristique_caracteristique_categorie1_idx", columns={"caracteristique_categorie"})})
 * @ORM\Entity
 */
class ValeurCaracteristique
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
     * @ORM\Column(name="valeur", type="string", length=145, nullable=false)
     */
    private $valeur;

    /**
     * @var string|null
     *
     * @ORM\Column(name="color", type="string", length=15, nullable=true)
     */
    private $color;

    /**
     * @var \CaracteristiqueCategorie
     *
     * @ORM\ManyToOne(targetEntity="CaracteristiqueCategorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="caracteristique_categorie", referencedColumnName="id")
     * })
     */
    private $caracteristiqueCategorie;

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

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color): self
    {
        $this->color = $color;

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


}
