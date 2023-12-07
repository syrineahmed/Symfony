<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\HotelsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Table(name: "hotels")]
#[ORM\Entity(repositoryClass: HotelsRepository::class)]
class Hotels
{
    #[ORM\Column(name: "id_hotel", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private int $idHotel;

    #[ORM\Column(name: "nom_hotel", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Le nom de l'hôtel ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "Le nom de l'hôtel ne peut pas dépasser 255 caractères.")]
    private string $nomHotel;

    #[ORM\Column(name: "nb_etoile", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Le nombre d'étoiles ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "Le nombre d'étoiles ne peut pas dépasser 255 caractères.")]
    private string $nbEtoile;

    #[ORM\Column(name: "pays", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Le pays ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "Le nom du pays ne peut pas dépasser 255 caractères.")]
    private string $pays;

    #[ORM\Column(name: "nb_chambre", type: "integer", nullable: false)]
    #[Assert\NotBlank(message: "Le nombre de chambres ne peut pas être vide.")]
    #[Assert\Range(min: 0, minMessage: "Le nombre de chambres doit être positif ou nul.")]
    private int $nbChambre;

    #[ORM\Column(name: "prix_nuit", type: "float", precision: 10, scale: 0, nullable: false)]
    #[Assert\NotBlank(message: "Le prix par nuit ne peut pas être vide.")]
    #[Assert\Range(min: 0, minMessage: "Le prix par nuit doit être positif ou nul.")]
    private float $prixNuit;



    
    public function getIdHotel(): ?int
    {
        return $this->idHotel;
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

    public function getNbEtoile(): ?string
    {
        return $this->nbEtoile;
    }

    public function setNbEtoile(string $nbEtoile): static
    {
        $this->nbEtoile = $nbEtoile;

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

    public function getNbChambre(): ?int
    {
        return $this->nbChambre;
    }

    public function setNbChambre(int $nbChambre): static
    {
        $this->nbChambre = $nbChambre;

        return $this;
    }

    public function getPrixNuit(): ?float
    {
        return $this->prixNuit;
    }

    public function setPrixNuit(float $prixNuit): static
    {
        $this->prixNuit = $prixNuit;

        return $this;
    }
  
}
