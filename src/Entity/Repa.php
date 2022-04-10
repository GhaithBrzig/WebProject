<?php

namespace App\Entity;

use App\Repository\RepaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RepaRepository::class)
 * @UniqueEntity("lib_prod")
 */
class Repa
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank(message="Repa's Name is required" )
     * @Assert\NotNull
     */
    private $lib_prod;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Description is required")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive
     * @Assert\Type(
     *     type="float",
     *     message="Price value should be a number"
     * )
     * @Assert\NotBlank(message="Price is required")
     * @Assert\NotNull
     */
    private $prix_prod;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive
     * @Assert\Type(
     *     type="integer",
     *     message="Quantity value should be a number"
     * )
     * @Assert\NotBlank(message="Quantity is required")
     * @Assert\NotNull
     */
    private $quantite_dispo;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotNull
     */
    private $remise;

    /**
     * @ORM\Column(type="string", length=60)
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categorie", referencedColumnName="categorie")
     * })
     * @Assert\NotNull
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     * @Assert\NotBlank(message="You must select an image")
     * @Assert\NotNull
     */
    private $path;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibProd(): ?string
    {
        return $this->lib_prod;
    }

    public function setLibProd(?string $lib_prod): self
    {
        $this->lib_prod = $lib_prod;

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

    public function getPrixProd(): ?float
    {
        return $this->prix_prod;
    }

    public function setPrixProd(?float $prix_prod): self
    {
        $this->prix_prod = $prix_prod;

        return $this;
    }

    public function getQuantiteDispo(): ?int
    {
        return $this->quantite_dispo;
    }

    public function setQuantiteDispo(?int $quantite_dispo): self
    {
        $this->quantite_dispo = $quantite_dispo;

        return $this;
    }

    public function getRemise(): ?string
    {
        return $this->remise;
    }

    public function setRemise(?string $remise): self
    {
        $this->remise = $remise;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }
}
