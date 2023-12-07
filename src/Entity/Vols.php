<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\VolsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Table(name: "vols")]
#[ORM\Entity(repositoryClass: VolsRepository::class)]

class Vols
{
    #[ORM\Column(name: "id_vol", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private int $idVol;

    #[ORM\Column(name: "nom_airways", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Le nom de la compagnie aérienne ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "Le nom de la compagnie aérienne ne peut pas dépasser 255 caractères.")]
    private string $nomAirways;

    #[ORM\Column(name: "nb_billet", type: "integer", nullable: false)]
    #[Assert\NotBlank(message: "Le nombre de billets ne peut pas être vide.")]
    #[Assert\Range(min: 0, minMessage: "Le nombre de billets doit être positif ou nul.")]
    private int $nbBillet;

    #[ORM\Column(name: "prix_billet", type: "float", precision: 10, scale: 0, nullable: false)]
    #[Assert\NotBlank(message: "Le prix du billet ne peut pas être vide.")]
    #[Assert\Range(min: 0, minMessage: "Le prix du billet doit être positif ou nul.")]
    private float $prixBillet;

    #[ORM\Column(name: "date_depart", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "La date de départ ne peut pas être vide.")]
    #[Assert\Regex(
        pattern: '/^\d{4}\/\d{2}\/\d{2}$/',
        message: 'La date de départ doit être au format "aaaa/mm/jj".'
    )]
    private string $dateDepart;

    #[ORM\Column(name: "destination", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "La destination ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "La destination ne peut pas dépasser 255 caractères.")]
    private string $destination;


    private $uservols;

    public function __construct()
    {
        $this->uservols = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|Collection|Uservol[]
     */
    public function getUservols()
    {
        return $this->uservols;
    }

    public function addUservol(Uservol $uservol): self
    {
        if (!$this->uservols->contains($uservol)) {
            $this->uservols[] = $uservol;
            $uservol->setVol($this);
        }

        return $this;
    }

    public function removeUservol(Uservol $uservol): self
    {
        if ($this->uservols->removeElement($uservol)) {
            // set the owning side to null (unless already changed)
            if ($uservol->getVol() === $this) {
                $uservol->setVol(null);
            }
        }

        return $this;
    }

    public function getIdVol(): ?int
    {
        return $this->idVol;
    }

    public function getNomAirways(): ?string
    {
        return $this->nomAirways;
    }

    public function setNomAirways(string $nomAirways): static
    {
        $this->nomAirways = $nomAirways;

        return $this;
    }

    public function getNbBillet(): ?int
    {
        return $this->nbBillet;
    }

    public function setNbBillet(int $nbBillet): static
    {
        $this->nbBillet = $nbBillet;

        return $this;
    }

    public function getPrixBillet(): ?float
    {
        return $this->prixBillet;
    }

    public function setPrixBillet(float $prixBillet): static
    {
        $this->prixBillet = $prixBillet;

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

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    // Dans la classe Vols
public function __toString(): string
{
    return $this->nomAirways;
}
public function setVol(?Vols $vol): self
{
    $this->vol = $vol;

    return $this;
}

}
