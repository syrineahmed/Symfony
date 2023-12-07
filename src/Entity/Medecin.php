<?php

namespace App\Entity;
use app\Repository\MedecinRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: MedecinRepository::class)]
class Medecin implements UserInterface

{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[ORM\Column(length: 255)]
    private $nom;

    #[ORM\Column(length: 255)]
    private $prenom;

    #[ORM\Column(length: 255)]
    private $specialite;

    #[ORM\Column(length: 255)]
    private $pays;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private $dategrad;

    #[ORM\Column]
    private $numbergrad;

    #[ORM\Column(length: 255)]
    private $email;

    #[ORM\Column(length: 255)]
    private $motdepasse;

 

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

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): static
    {
        $this->specialite = $specialite;

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

    public function getDategrad(): ?\DateTimeInterface
    {
        return $this->dategrad;
    }

    public function setDategrad(\DateTimeInterface $dategrad): static
    {
        $this->dategrad = $dategrad;

        return $this;
    }

    public function getNumbergrad(): ?int
    {
        return $this->numbergrad;
    }

    public function setNumbergrad(int $numbergrad): static
    {
        $this->numbergrad = $numbergrad;

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

    public function getMotdepasse(): ?string
    {
        return $this->motdepasse;
    }

    public function setMotdepasse(string $motdepasse): static
    {
        $this->motdepasse = $motdepasse;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        // Return an array of roles for the user (e.g., ['ROLE_MEDIC'])
        return ['ROLE_MEDIC'];
    }

    public function getPassword(): string
    {
        return $this->motdepasse;
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
        return $this->email;
    }
}

