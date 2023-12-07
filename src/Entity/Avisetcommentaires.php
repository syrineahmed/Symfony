<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Avisetcommentaires
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idAvis = null;


    #[ORM\Column(length: 255)]
    private ?string $nomService = null;

    #[ORM\Column]
    private ?int $idPatient = null;

    #[ORM\Column]
    private ?int $note = null;

    #[ORM\Column(length: 255)]
    private ?string $commentaire = null;

    #[ORM\Column(length: 255)]
    private ?string $dateAvis = null;




    public function getIdAvis(): ?int
    {
        return $this->idAvis;
    }

    public function setIdAvis(?int $idAvis): void
    {
        $this->idAvis = $idAvis;
    }

    public function getNomService(): ?string
    {
        return $this->nomService;
    }

    public function setNomService(?string $nomService): void
    {
        $this->nomService = $nomService;
    }

    public function getIdPatient(): ?int
    {
        return $this->idPatient;
    }

    public function setIdPatient(?int $idPatient): void
    {
        $this->idPatient = $idPatient;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): void
    {
        $this->note = $note;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): void
    {
        $this->commentaire = $commentaire;
    }

    public function getDateAvis(): ?string
    {
        return $this->dateAvis;
    }

    public function setDateAvis(?string $dateAvis): void
    {
        $this->dateAvis = $dateAvis;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
    }


}
