<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Modele
 *
 * @ORM\Table(name="modele")
 * @ORM\Entity
 */
class Modele
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
     * @ORM\Column(name="nom", type="string", length=45, nullable=false)
     */
    private $nom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="photo", type="string", length=45, nullable=true)
     */
    private $photo;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Fonctionnalite", inversedBy="modeles")
     * @ORM\JoinTable(name="fonctionnalite_modele",
     *      joinColumns={@ORM\JoinColumn(name="modele", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="fonctionnalite", referencedColumnName="id")}
     * )
     */
    private $fonctionnalites;

    /**
     * @ORM\Column(name="deploye", type="boolean", nullable=true)
     */
    private $deploye;

    public function __construct()
    {
        $this->fonctionnalites = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection|Fonctionnalite[]
     */
    public function getFonctionnalites(): Collection
    {
        return $this->fonctionnalites;
    }

    public function addFonctionnalite(Fonctionnalite $fonctionnalite): self
    {
        if (!$this->fonctionnalites->contains($fonctionnalite)) {
            $this->fonctionnalites[] = $fonctionnalite;
        }

        return $this;
    }

    public function removeFonctionnalite(Fonctionnalite $fonctionnalite): self
    {
        if ($this->fonctionnalites->contains($fonctionnalite)) {
            $this->fonctionnalites->removeElement($fonctionnalite);
        }

        return $this;
    }

    public function getDeploye()
    {
        return $this->deploye;
    }

    public function setDeploye($deploye): self
    {
        $this->deploye = $deploye;

        return $this;
    }


}
