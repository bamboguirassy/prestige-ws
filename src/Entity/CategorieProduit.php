<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CategorieProduit
 *
 * @ORM\Table(name="categorie_produit", indexes={@ORM\Index(name="fk_categorie_categorie1_idx", columns={"categorie_parent"}), @ORM\Index(name="fk_categorie_modele1_idx", columns={"modele"})})
 * @ORM\Entity
 */
class CategorieProduit
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
     * @var string|null
     *
     * @ORM\Column(name="photo", type="string", length=245, nullable=true)
     */
    private $photo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var \CategorieProduit
     *
     * @ORM\ManyToOne(targetEntity="CategorieProduit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categorie_parent", referencedColumnName="id")
     * })
     */
    private $categorieParent;

    /**
     * @var \Modele
     *
     * @ORM\ManyToOne(targetEntity="Modele")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="modele", referencedColumnName="id")
     * })
     */
    private $modele;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CategorieProduit", mappedBy="categorieParent")
     */
    private $sousCategories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CaracteristiqueCategorie", mappedBy="categorie", orphanRemoval=true)
     */
    private $caracteristiques;

    /**
     * @ORM\Column(type="string", length=15, name="type")
     */
    private $type;


    public function __construct()
    {
        $this->categorieProduits = new ArrayCollection();
        $this->caracteristiques = new ArrayCollection();
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

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

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

    public function getCategorieParent()
    {
        return $this->categorieParent;
    }

    public function setCategorieParent($categorieParent): self
    {
        $this->categorieParent = $categorieParent;

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

    public function getSousCategories()
    {
        return $this->sousCategories;
    }

    public function setSousCategories($sousCategories): self
    {
        $this->sousCategories = $sousCategories;

        return $this;
    }

    /**
     * @return Collection|CaracteristiqueCategorie[]
     */
    public function getCaracteristiques(): Collection
    {
        return $this->caracteristiques;
    }

    public function addCaracteristique(CaracteristiqueCategorie $caracteristique): self
    {
        if (!$this->caracteristiques->contains($caracteristique)) {
            $this->caracteristiques[] = $caracteristique;
            $caracteristique->setCategorieProduit($this);
        }

        return $this;
    }

    public function removeCaracteristique(CaracteristiqueCategorie $caracteristique): self
    {
        if ($this->caracteristiques->contains($caracteristique)) {
            $this->caracteristiques->removeElement($caracteristique);
            // set the owning side to null (unless already changed)
            if ($caracteristique->getCategorieProduit() === $this) {
                $caracteristique->setCategorieProduit(null);
            }
        }

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


}
