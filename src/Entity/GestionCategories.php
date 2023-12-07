<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class GestionCategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[ORM\Column(length: 255)]
    private ?string $nomcategorie = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;
    #[ORM\Column]
    private ?int $tarification = null;
    #[ORM\Column(length: 255)]
    private ?string $refServices = null;

    #[ORM\Column(length: 255)]
    private ?string $disponibilite = null;

    #[ORM\Column(length: 255)]
    private ?string $date = null;



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getNomcategorie(): ?string
    {
        return $this->nomcategorie;
    }

    public function setNomcategorie(?string $nomcategorie): void
    {
        $this->nomcategorie = $nomcategorie;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getTarification(): ?int
    {
        return $this->tarification;
    }

    public function setTarification(?int $tarification): void
    {
        $this->tarification = $tarification;
    }

    public function getRefServices(): ?string
    {
        return $this->refServices;
    }

    public function setRefServices(?string $refServices): void
    {
        $this->refServices = $refServices;
    }

    public function getDisponibilite(): ?string
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(?string $disponibilite): void
    {
        $this->disponibilite = $disponibilite;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): void
    {
        $this->date = $date;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
    }


}
