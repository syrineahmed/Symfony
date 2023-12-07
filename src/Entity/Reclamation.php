<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="fk7", columns={"id_utilisateur_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\ReclamationRepository")
 */

class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_rec", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRec;

    /**
     * @var string
     *
     * @ORM\Column(name="sujet", type="string", length=255, nullable=false)
     */
    private $sujet;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)

     */
    
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    private $etat='non traité';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false, options={"default"="current_timestamp()"})
     */
    private $date = 'current_timestamp()';

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_utilisateur_id", referencedColumnName="id")
     * })
     */
    private $idUtilisateur;

    /**
     * @ORM\OneToMany(targetEntity="ReponseReclamation", mappedBy="idReclamation", cascade={"remove"})
     */
    private $reponseReclamations;



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

    public function __construct()
    {
        // Set the default value for date to the current date and time
        $this->date = new \DateTime();
        $this->reponseReclamations = new ArrayCollection();
    }

    // ... (other methods)

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
    public function __toString()
    {
        return $this->getIdRec();
    }

    /**
     * @return Collection<int, ReponseReclamation>
     */
    public function getReponseReclamations(): Collection
    {
        return $this->reponseReclamations;
    }

    public function addReponseReclamation(ReponseReclamation $reponseReclamation): static
    {
        if (!$this->reponseReclamations->contains($reponseReclamation)) {
            $this->reponseReclamations->add($reponseReclamation);
            $reponseReclamation->setIdReclamation($this);
        }

        return $this;
    }

    public function removeReponseReclamation(ReponseReclamation $reponseReclamation): static
    {
        if ($this->reponseReclamations->removeElement($reponseReclamation)) {
            // set the owning side to null (unless already changed)
            if ($reponseReclamation->getIdReclamation() === $this) {
                $reponseReclamation->setIdReclamation(null);
            }
        }

        return $this;
    }
    public function containsInappropriateWords(): bool// void
    {
        $inappropriateWords = ['test', 'test2', 'test3'];
        //$description = $this->getDescription();
        $description =$this->getDescription();
        foreach ($inappropriateWords as $word) {
           // $replacement = str_repeat('*', strlen($word));
            //$description = str_ireplace($word, $replacement, $description);

            if (stripos($description, $word) !== false) {
                return true;
           // $replacement = str_repeat('*', strlen($word));
           // $description = str_ireplace($word, $replacement, $description);
            }
        }

       return false;
      //  $this->setDescription($description);

}









}
