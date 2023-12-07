<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\UserHotelRepository;

#[ORM\Table(name: "userhotel")]
#[ORM\Entity(repositoryClass: UserHotelRepository::class)]

class Userhotel
{
    #[ORM\Column(name: "numpassport", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    private int $numpassport;

    #[ORM\Column(name: "user_nom", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Le nom de l'utilisateur ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "Le nom de l'utilisateur ne peut pas dépasser 255 caractères.")]
    private string $userNom;

    #[ORM\Column(name: "user_prenom", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Le prénom de l'utilisateur ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "Le prénom de l'utilisateur ne peut pas dépasser 255 caractères.")]
    private string $userPrenom;

    #[ORM\Column(name: "nom_hotel", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Le nom de l'hôtel ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "Le nom de l'hôtel ne peut pas dépasser 255 caractères.")]
    private string $nomHotel;

    #[ORM\Column(name: "pays", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Le pays ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "Le nom du pays ne peut pas dépasser 255 caractères.")]
    private string $pays;

    #[ORM\Column(name: "chambre_reservee", type: "integer", nullable: false)]
    #[Assert\NotBlank(message: "Le nombre de chambres réservées ne peut pas être vide.")]
    #[Assert\Range(min: 0, minMessage: "Le nombre de chambres réservées doit être positif ou nul.")]
    private int $chambreReservee;

    #[ORM\Column(name: "facture_hotel", type: "float", precision: 10, scale: 0, nullable: false)]
    #[Assert\NotBlank(message: "La facture de l'hôtel ne peut pas être vide.")]
    #[Assert\Range(min: 0, minMessage: "La facture de l'hôtel doit être positif ou nulle.")]
    private float $factureHotel;

    


    public function getNumpassport(): ?int
    {
        return $this->numpassport;
    }
    public function setNumPassport(int $numpass): static
    {
        $this->numpassport = $numpass;

        return $this;
    }


    public function getUserNom(): ?string
    {
        return $this->userNom;
    }

    public function setUserNom(string $userNom): static
    {
        $this->userNom = $userNom;

        return $this;
    }

    public function getUserPrenom(): ?string
    {
        return $this->userPrenom;
    }

    public function setUserPrenom(string $userPrenom): static
    {
        $this->userPrenom = $userPrenom;

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

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    public function getChambreReservee(): ?int
    {
        return $this->chambreReservee;
    }

    public function setChambreReservee(int $chambreReservee): static
    {
        $this->chambreReservee = $chambreReservee;

        return $this;
    }

    public function getFactureHotel(): ?float
    {
        return $this->factureHotel;
    }

    public function setFactureHotel(float $factureHotel): static
    {
        $this->factureHotel = $factureHotel;

        return $this;
    }
 
}

