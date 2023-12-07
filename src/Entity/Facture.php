<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\FactureRepository;

#[ORM\Table(name: "facture")]
#[ORM\Entity(repositoryClass: FactureRepository::class)]

class Facture
{
    #[ORM\Column(name: "num_passport", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private int $numPassport;

    #[ORM\Column(name: "nom", type: "string", length: 255, nullable: false)]
    private string $nom;

    #[ORM\Column(name: "prenom", type: "string", length: 255, nullable: false)]
    private string $prenom;

    #[ORM\Column(name: "destination", type: "string", length: 255, nullable: false)]
    private string $destination;

    #[ORM\Column(name: "nom_hotel", type: "string", length: 255, nullable: false)]
    private string $nomHotel;

    #[ORM\Column(name: "nom_compagnie", type: "string", length: 255, nullable: false)]
    private string $nomCompagnie;

    #[ORM\Column(name: "montant", type: "float", precision: 10, scale: 0, nullable: false)]
    private float $montant;

    public function getNumPassport(): ?int
    {
        return $this->numPassport;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    public function getNomHotel(): ?string
    {
        return $this->nomHotel;
    }

    public function setNomHotel(string $nomHotel): static
    {
        $this->nomHotel = $nomHotel;

        return $this;
    }

    public function getNomCompagnie(): ?string
    {
        return $this->nomCompagnie;
    }

    public function setNomCompagnie(string $nomCompagnie): static
    {
        $this->nomCompagnie = $nomCompagnie;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }
}

