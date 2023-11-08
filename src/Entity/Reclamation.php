<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;




use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: ReclamationRepository::class )]
class Reclamation
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
   // private $idRec;
private ?int $idRec = null;

    #[ORM\Column(length: 255)]


    private ?string $username = null;
    #[ORM\Column(length: 255)]

    private ?string $email = null;
    #[ORM\Column(length: 255)]

    private ?string $description = null;
    #[ORM\Column(length: 255)]

    private ?string $etat = null;
    #[ORM\Column(name: 'date', type: 'date', nullable: false, options: ['default' => 'CURRENT_TIMESTAMP'])]

    private \DateTimeInterface $date;

    #[ORM\ManyToOne(inversedBy: 'Reclamation')]
    private ?Utilisateur $utilisateur = null;

    public function getIdRec(): ?int
    {
        return $this->idRec;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): static
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $idUtilisateur): static
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }


}
