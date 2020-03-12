<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FonctionnaliteModele
 *
 * @ORM\Table(name="fonctionnalite_modele", uniqueConstraints={@ORM\UniqueConstraint(name="index4", columns={"modele", "fonctionnalite"})}, indexes={@ORM\Index(name="fk_fonctionnalite_modele_fonctionnalite1_idx", columns={"fonctionnalite"}), @ORM\Index(name="fk_fonctionnalite_modele_modele1_idx", columns={"modele"})})
 * @ORM\Entity
 */
class FonctionnaliteModele
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
     * @var \Fonctionnalite
     *
     * @ORM\ManyToOne(targetEntity="Fonctionnalite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fonctionnalite", referencedColumnName="id")
     * })
     */
    private $fonctionnalite;

    /**
     * @var \Modele
     *
     * @ORM\ManyToOne(targetEntity="Modele")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="modele", referencedColumnName="id")
     * })
     */
    private $modele;

    public function getId()
    {
        return $this->id;
    }

    public function getFonctionnalite()
    {
        return $this->fonctionnalite;
    }

    public function setFonctionnalite($fonctionnalite): self
    {
        $this->fonctionnalite = $fonctionnalite;

        return $this;
    }

    public function getModele()
    {
        return $this->modele;
    }

    public function setModele($modele): self
    {
        $this->modele = $modele;

        return $this;
    }


}
