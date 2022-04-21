<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity
 */
class Evenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     *  @Assert\Length(
     * min=3,
     * max=50,
     * minMessage = "le type d'evenement doit comporter au moins {{ limit }}caractéres",
     * maxMessage = "le type d'evenement doit comporter au plus {{ limit }} caractéres"
     * )
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     * @Assert\Length(
     * min=3,
     * max=50,
     * minMessage = "la description de l'evenement doit comporter au moins {{ limit }}caractéres",
     * maxMessage = "la description de l'evenement doit comporter au plus {{ limit }} caractéres"
     * )
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="nbpersonne", type="integer", nullable=false)
     * @Assert\NotBlank(message="Number is required")
     */
    private $nbpersonne;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     *  @Assert\Date()
     * @Assert\GreaterThan("today")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="idEvenement", orphanRemoval=true)
     */
    private $reservations;


    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNbpersonne(): ?int
    {
        return $this->nbpersonne;
    }

    public function setNbpersonne(int $nbpersonne): self
    {
        $this->nbpersonne = $nbpersonne;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addYe(Reservation $ye): self
    {
        if (!$this->reservations->contains($ye)) {
            $this->reservations[] = $ye;
            $ye->setIdEvenement($this);
        }

        return $this;
    }

    public function removeYe(Reservation $ye): self
    {
        if ($this->reservations->removeElement($ye)) {
            // set the owning side to null (unless already changed)
            if ($ye->getIdEvenement() === $this) {
                $ye->setIdEvenement(null);
            }
        }

        return $this;
    }


}
