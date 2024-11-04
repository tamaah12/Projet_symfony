<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[UniqueEntity(fields: ['surname'], message: 'Le surname existe déjà')]
#[UniqueEntity(fields: ['telephone'], message: 'Le téléphone existe déjà')]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50, unique: true)]
    #[Assert\NotBlank(message: 'Le surname est obligatoire')]
    private $surname;

    #[ORM\Column(type: 'string', length: 9, unique: true)]
    #[Assert\NotBlank(message: 'Le téléphone est obligatoire')]
    private $telephone;

    #[ORM\Column(type: 'text')]
    private $adresse;

    #[ORM\OneToOne(targetEntity: User::class, mappedBy: 'client', cascade: ['persist', 'remove'])]
    private $compte;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Dette::class)]
    private $dettes;

    public function __construct()
    {
        $this->dettes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCompte(): ?User
    {
        return $this->compte;
    }

    public function setCompte(?User $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    /**
     * @return Collection<int, Dette>
     */
    public function getDettes(): Collection
    {
        return $this->dettes;
    }

    public function addDette(Dette $dette): self
    {
        if (!$this->dettes->contains($dette)) {
            $this->dettes[] = $dette;
            $dette->setClient($this);
        }

        return $this;
    }

    public function removeDette(Dette $dette): self
    {
        if ($this->dettes->removeElement($dette)) {
            // set the owning side to null (unless already changed)
            if ($dette->getClient() === $this) {
                $dette->setClient(null);
            }
        }

        return $this;
    }
}
