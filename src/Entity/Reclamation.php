<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ReclamationRepository;



/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation")
 * @ORM\Entity(repositoryClass="App\Repository\ReclamationRepository")
 */
class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nomClient", type="string", length=100, nullable=false)
     * @Assert\NotBlank(message="name is required")
     */
    private $nomclient;

    /**
     * @var string
     *
     * @ORM\Column(name="emailClient", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Email is required")
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email ")
     */
    private $emailclient;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500, nullable=false)
     * @Assert\NotBlank(message="Description is required")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="isSolved", type="boolean", nullable=false)
     */
    private $issolved;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomclient(): ?string
    {
        return $this->nomclient;
    }

    public function setNomclient(?string $nomclient): self
    {
        $this->nomclient = $nomclient;

        return $this;
    }

    public function getEmailclient(): ?string
    {
        return $this->emailclient;
    }

    public function setEmailclient(?string $emailclient): self
    {
        $this->emailclient = $emailclient;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getIssolved(): ?bool
    {
        return $this->issolved;
    }

    public function setIssolved(?bool $issolved): self
    {
        $this->issolved = $issolved;

        return $this;
    }
}
