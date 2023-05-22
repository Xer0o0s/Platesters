<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 66)]
    private ?string $designation = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column]
    private ?int $nbfavoris = null;

    #[ORM\Column(length: 255)]
    private ?string $minia = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Ajouter::class, orphanRemoval: true)]
    private Collection $ajouters;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'Favoris')]
    private Collection $users;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Collections $collection = null;

    public function __construct()
    {
        $this->ajouters = new ArrayCollection();
        $this->users = new ArrayCollection();
    
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getNbfavoris(): ?int
    {
        return $this->nbfavoris;
    }

    public function setNbfavoris(int $nbfavoris): self
    {
        $this->nbfavoris = $nbfavoris;

        return $this;
    }

    public function getMinia(): ?string
    {
        return $this->minia;
    }

    public function setMinia(string $minia): self
    {
        $this->minia = $minia;

        return $this;
    }

    /**
     * @return Collection<int, Ajouter>
     */
    public function getAjouters(): Collection
    {
        return $this->ajouters;
    }

    public function addAjouter(Ajouter $ajouter): self
    {
        if (!$this->ajouters->contains($ajouter)) {
            $this->ajouters->add($ajouter);
            $ajouter->setProduit($this);
        }

        return $this;
    }

    public function removeAjouter(Ajouter $ajouter): self
    {
        if ($this->ajouters->removeElement($ajouter)) {
            // set the owning side to null (unless already changed)
            if ($ajouter->getProduit() === $this) {
                $ajouter->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addFavori($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeFavori($this);
        }

        return $this;
    }

    public function getCollection(): ?Collections
    {
        return $this->collection;
    }

    public function setCollection(?Collections $collection): self
    {
        $this->collection = $collection;

        return $this;
    }
}
