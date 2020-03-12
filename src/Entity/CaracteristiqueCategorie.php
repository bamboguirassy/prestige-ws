<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CaracteristiqueCategorie
 *
 * @ORM\Table(name="caracteristique_categorie", indexes={@ORM\Index(name="fk_caracteristique_categorie_categorie1_idx", columns={"categorie"})})
 * @ORM\Entity
 */
class CaracteristiqueCategorie
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
     * @var bool|null
     *
     * @ORM\Column(name="is_color", type="boolean", nullable=true)
     */
    private $isColor;

    /**
     * @var \CategorieProduit
     *
     * @ORM\ManyToOne(targetEntity="CategorieProduit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categorie", referencedColumnName="id")
     * })
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ValeurCaracteristique", mappedBy="caracteristiqueCategorie", orphanRemoval=true)
     */
    private $valeurs;

    /**
     * @var bool|null
     * 
     * @ORM\Column(type="boolean", nullable=true, name="is_input")
     */
    private $isInput;

    public function __construct()
    {
        $this->valeurs = new ArrayCollection();
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

    public function getIsColor()
    {
        return $this->isColor;
    }

    public function setIsColor($isColor): self
    {
        $this->isColor = $isColor;

        return $this;
    }

    public function getCategorie()
    {
        return $this->categorie;
    }

    public function setCategorie($categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|ValeurCaracteristique[]
     */
    public function getValeurs(): Collection
    {
        return $this->valeurs;
    }

    public function addValeur(ValeurCaracteristique $valeur): self
    {
        if (!$this->valeurs->contains($valeur)) {
            $this->valeurs[] = $valeur;
            $valeur->setCaracteristique($this);
        }

        return $this;
    }

    public function removeValeur(ValeurCaracteristique $valeur): self
    {
        if ($this->valeurs->contains($valeur)) {
            $this->valeurs->removeElement($valeur);
            // set the owning side to null (unless already changed)
            if ($valeur->getCaracteristique() === $this) {
                $valeur->setCaracteristique(null);
            }
        }

        return $this;
    }

    public function getIsInput()
    {
        return $this->isInput;
    }

    public function setIsInput($isInput): self
    {
        $this->isInput = $isInput;

        return $this;
    }


}
