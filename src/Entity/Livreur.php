<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Livreur
 *
 * @ORM\Table(name="livreur")
 * @ORM\Entity
 */
class Livreur
{
    /**
     * @var int
     *
     * @ORM\Column(name="IdLivreur", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idlivreur;

    /**
     * @var string
     *
     * @ORM\Column(name="NomLivreur", type="string", length=255, nullable=false)
     */
    private $nomlivreur;

    /**
     * @var string
     *
     * @ORM\Column(name="PrenomLivreur", type="string", length=255, nullable=false)
     */
    private $prenomlivreur;

    /**
     * @var string
     *
     * @ORM\Column(name="telLivreur", type="string", length=255, nullable=false)
     */
    private $tellivreur;

    public function getIdlivreur(): ?int
    {
        return $this->idlivreur;
    }

    public function getNomlivreur(): ?string
    {
        return $this->nomlivreur;
    }

    public function setNomlivreur(string $nomlivreur): self
    {
        $this->nomlivreur = $nomlivreur;

        return $this;
    }

    public function getPrenomlivreur(): ?string
    {
        return $this->prenomlivreur;
    }

    public function setPrenomlivreur(string $prenomlivreur): self
    {
        $this->prenomlivreur = $prenomlivreur;

        return $this;
    }

    public function getTellivreur(): ?string
    {
        return $this->tellivreur;
    }

    public function setTellivreur(string $tellivreur): self
    {
        $this->tellivreur = $tellivreur;

        return $this;
    }


}
