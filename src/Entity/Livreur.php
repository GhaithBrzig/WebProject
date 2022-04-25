<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * Livreur
 *
 * @ORM\Table(name="livreur")
 * @ORM\Entity(repositoryClass="App\Repository\LivreurRepository")
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
     * @Assert\NotBlank(message=" veillez entrer le frais de livraison")
     */
     
    private $nomlivreur;

    /**
     * @var string
     *
     * @ORM\Column(name="PrenomLivreur", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message=" veillez entrer le frais de livraison")
     */
    private $prenomlivreur;

    /**
     * @var string
     *
     * @ORM\Column(name="telLivreur", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message=" veillez entrer le frais de livraison")
     */
    private $tellivreur;
    /**
     * @ORM\OneToMany(targetEntity=Livraison::class, mappedBy="idlivreur", orphanRemoval=true)
     */
    private $livraisons;

    public function __construct()
    {
        $this->livraisons = new ArrayCollection();
    }
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
public function __toString()
{
    return 
$this ->nomlivreur;
}
    /**
     * @return Collection|Livraison[]
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

   

}
