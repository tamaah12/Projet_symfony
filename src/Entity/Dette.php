<?php

namespace App\Entity;

use App\Repository\DetteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetteRepository::class)]
class Dette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    private $montant;

    #[ORM\Column(type: 'float')]
    private $montantVerse;

    #[ORM\Column(type: 'datetime_immutable')]
    private $dateAt;  // Renommé pour suivre les conventions

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'dettes')]
    private $client;

    #[ORM\Column(type: 'string', nullable: true)] // Ajoute cette ligne pour le statut
    private $statut;

    public function __construct()
    {
        // Initialise montantVerse à 0 et dateAt à la date actuelle
        $this->montantVerse = 0;
        $this->dateAt = new \DateTimeImmutable(); 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getMontantVerse(): ?float
    {
        return $this->montantVerse;
    }

    public function setMontantVerse(float $montantVerse): self
    {
        $this->montantVerse = $montantVerse;

        return $this;
    }

    public function getDateAt(): ?\DateTimeImmutable
    {
        return $this->dateAt;  // Utilisez le nom mis à jour
    }

    public function setDateAt(\DateTimeImmutable $dateAt): self  // Utilisez le nom mis à jour
    {
        $this->dateAt = $dateAt;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    // Ajoute les méthodes pour le statut
    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }
}
