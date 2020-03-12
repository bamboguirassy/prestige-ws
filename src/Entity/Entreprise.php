<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entreprise
 *
 * @ORM\Table(name="entreprise", indexes={@ORM\Index(name="fk_entreprise_categorie_entreprise_idx", columns={"modele"})})
 * @ORM\Entity
 */
class Entreprise
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
     * @ORM\Column(name="nom", type="string", length=100, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=45, nullable=false)
     */
    private $telephone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ninea", type="string", length=245, nullable=true)
     */
    private $ninea;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=45, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="text", length=65535, nullable=false)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_prenom_patron", type="string", length=145, nullable=false)
     */
    private $nomPrenomPatron;

    /**
     * @var string|null
     *
     * @ORM\Column(name="gerant", type="string", length=45, nullable=true)
     */
    private $gerant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telephone_gerant", type="string", length=45, nullable=true)
     */
    private $telephoneGerant;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone_patron", type="string", length=45, nullable=false)
     */
    private $telephonePatron;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

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
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="entreprise")
     */
    private $users;

    /**
     * @ORM\Column(type="string", length=145, nullable=true)
     */
    private $logo;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getNinea()
    {
        return $this->ninea;
    }

    public function setNinea($ninea): self
    {
        $this->ninea = $ninea;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getNomPrenomPatron()
    {
        return $this->nomPrenomPatron;
    }

    public function setNomPrenomPatron(string $nomPrenomPatron): self
    {
        $this->nomPrenomPatron = $nomPrenomPatron;

        return $this;
    }

    public function getGerant()
    {
        return $this->gerant;
    }

    public function setGerant($gerant): self
    {
        $this->gerant = $gerant;

        return $this;
    }

    public function getTelephoneGerant()
    {
        return $this->telephoneGerant;
    }

    public function setTelephoneGerant($telephoneGerant): self
    {
        $this->telephoneGerant = $telephoneGerant;

        return $this;
    }

    public function getTelephonePatron()
    {
        return $this->telephonePatron;
    }

    public function setTelephonePatron(string $telephonePatron): self
    {
        $this->telephonePatron = $telephonePatron;

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

    public function getModele()
    {
        return $this->modele;
    }

    public function setModele($modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setEntreprise($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getEntreprise() === $this) {
                $user->setEntreprise(null);
            }
        }

        return $this;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function setLogo($logo): self
    {
        $this->logo = $logo;

        return $this;
    }


}
