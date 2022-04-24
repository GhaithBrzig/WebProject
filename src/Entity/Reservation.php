<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="fk_idevenement", columns={"id_evenement"})})
 * @ORM\Entity
 */
class Reservation
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
     * @ORM\Column(name="nomClient", type="string", length=255)
     * @Assert\Length(
     * min=3,
     * max=50,
     * minMessage = "le nom de client doit comporter au moins {{ limit }}caractéres",
     * maxMessage = "le nom de client doit comporter au plus {{ limit }} caractéres"
     * )
     */
    private $nomclient;

    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="integer")
     * @Assert\NotBlank(message="Number is required")
     *
     *
     */
    private $numero;

    /**
     * @var int
     *
     * @ORM\Column(name="nbpersonne", type="integer")
     * @Assert\NotBlank(message="nombre personnel is required")
     */
    private $nbpersonne;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     *  @Assert\Date()
     * @Assert\GreaterThan("today")
     *
     */
    private $date;


    /**
     * @var bool|null
     *
     * @ORM\Column(name="archived", type="boolean")
     */
    private $archived = '0';

    /**
     * @ORM\ManyToOne(targetEntity=Evenement::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false, name="id_evenement", referencedColumnName="id")
     */
    private $idEvenement;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomclient(): ?string
    {
        return $this->nomclient;
    }

    public function setNomclient(string $nomclient): self
    {
        $this->nomclient = $nomclient;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

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



    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(?bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

    public function getIdEvenement(): ?evenement
    {
        return $this->idEvenement;
    }

    public function setIdEvenement(?evenement $idEvenement): self
    {
        $this->idEvenement = $idEvenement;

        return $this;
    }


}
