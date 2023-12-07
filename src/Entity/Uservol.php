<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\UserVolRepository;

#[ORM\Table(name: "uservol")]
#[ORM\Entity(repositoryClass: UserVolRepository::class)]
class Uservol
{
    #[ORM\Column(name: "num_passport", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    private int $numPassport;

    #[ORM\Column(name: "usernom", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Le nom de l'utilisateur ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "Le nom de l'utilisateur ne peut pas dépasser 255 caractères.")]
    private string $usernom;

    #[ORM\Column(name: "userprenom", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Le prénom de l'utilisateur ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "Le prénom de l'utilisateur ne peut pas dépasser 255 caractères.")]
    private string $userprenom;

    #[ORM\Column(name: "nom_compagnie", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Le nom de la compagnie ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "Le nom de la compagnie ne peut pas dépasser 255 caractères.")]
    private string $nomCompagnie;

    #[ORM\Column(name: "billet_reservee", type: "integer", nullable: false)]
    #[Assert\NotBlank(message: "Le nombre de billets réservés ne peut pas être vide.")]
    #[Assert\Range(min: 0, minMessage: "Le nombre de billets réservés doit être positif ou nul.")]
    private int $billetReservee;

    #[ORM\Column(name: "destination", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "La destination ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "La destination ne peut pas dépasser 255 caractères.")]
    private string $destination;

    #[ORM\Column(name: "date_depart",type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "La date de départ ne peut pas être vide.")]
    private string $dateDepart;

    #[ORM\Column(name: "facture_vol", type: "float", precision: 10, scale: 0, nullable: false)]
    #[Assert\NotBlank(message: "La facture du vol ne peut pas être vide.")]
    #[Assert\Range(min: 0, minMessage: "La facture du vol doit être positive ou nulle.")]
    private float $factureVol;

  
    private ?Vols $vol;
    
    public function getNumPassport(): ?int
    {
        return $this->numPassport;
    }

    public function setNumPassport(int $numpass): static
{
    $this->numPassport = $numpass;

    return $this;
}

    public function getUsernom(): ?string
    {
        return $this->usernom;
    }

    public function setUsernom(string $usernom): static
    {
        $this->usernom = $usernom;

        return $this;
    }

    public function getUserprenom(): ?string
    {
        return $this->userprenom;
    }

    public function setUserprenom(string $userprenom): static
    {
        $this->userprenom = $userprenom;

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

    public function getBilletReservee(): ?int
    {
        return $this->billetReservee;
    }

    public function setBilletReservee(int $billetReservee): static
    {
        $this->billetReservee = $billetReservee;

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

    public function getDateDepart(): ?string
    {
        return $this->dateDepart;
    }

    public function setDateDepart(string $dateDepart): static
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getFactureVol(): ?float
    {
        return $this->factureVol;
    }

    public function setFactureVol(float $factureVol): static
    {
        $this->factureVol = $factureVol;

        return $this;
    }
    public function getVol(): ?Vols
    {
        return $this->vol;
    }

    public function setVol(?Vols $vol): static
    {
        $this->vol = $vol;

        return $this;
    }
}

