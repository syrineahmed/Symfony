<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private $datenai;

    #[ORM\Column]
    private $numassu;

    #[ORM\Column(length: 255)]
    private ?string $maladie = null;

    #[ORM\Column(length: 255)]
    private ?string $emailp = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDatenai(): ?\DateTimeInterface
    {
        return $this->datenai;
    }

    public function setDatenai(\DateTimeInterface $datenai): static
    {
        $this->datenai = $datenai;

        return $this;
    }

    public function getNumassu(): ?int
    {
        return $this->numassu;
    }

    public function setNumassu(int $numassu): static
    {
        $this->numassu = $numassu;

        return $this;
    }

    public function getMaladie(): ?string
    {
        return $this->maladie;
    }

    public function setMaladie(string $maladie): static
    {
        $this->maladie = $maladie;

        return $this;
    }

    public function getEmailp(): ?string
    {
        return $this->emailp;
    }

    public function setEmailp(string $emailp): static
    {
        $this->emailp = $emailp;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    // UserInterface methods

    public function getUsername(): string
    {
        return $this->emailp;
    }

    public function getRoles(): array
    {
        // Return an array of roles for the user (e.g., ['ROLE_PATIENT'])
        return ['ROLE_PATIENT'];
    }

    public function getSalt()
    {
        // You can leave this method blank unless you're using advanced user features
    }

    public function eraseCredentials()
    {
        // You can leave this method blank unless you're using advanced user features
    }

    public function getUserIdentifier(): string
    {
        return $this->emailp;
    }
}