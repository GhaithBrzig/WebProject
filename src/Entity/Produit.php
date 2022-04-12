<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit", uniqueConstraints={@ORM\UniqueConstraint(name="uq_produit", columns={"lib_prod"})})
 * @ORM\Entity
 */
class Produit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_prod", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProd;

    /**
     * @var string
     *
     * @ORM\Column(name="lib_prod", type="string", length=30, nullable=false)
     */
    private $libProd;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var int|null
     *
     * @ORM\Column(name="prix_prod", type="integer", nullable=true)
     */
    private $prixProd = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="quantiteDispo", type="integer", nullable=true)
     */
    private $quantitedispo = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="Remise", type="string", length=12, nullable=false)
     */
    private $remise = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=30, nullable=false, options={"default"="Autre"})
     */
    private $categorie = 'Autre';

    /**
     * @var string|null
     *
     * @ORM\Column(name="Image_prod", type="string", length=255, nullable=true)
     */
    private $imageProd;

    public function getIdProd(): ?int
    {
        return $this->idProd;
    }

    public function getLibProd(): ?string
    {
        return $this->libProd;
    }

    public function setLibProd(string $libProd): self
    {
        $this->libProd = $libProd;

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

    public function getPrixProd(): ?int
    {
        return $this->prixProd;
    }

    public function setPrixProd(?int $prixProd): self
    {
        $this->prixProd = $prixProd;

        return $this;
    }

    public function getQuantitedispo(): ?int
    {
        return $this->quantitedispo;
    }

    public function setQuantitedispo(?int $quantitedispo): self
    {
        $this->quantitedispo = $quantitedispo;

        return $this;
    }

    public function getRemise(): ?string
    {
        return $this->remise;
    }

    public function setRemise(string $remise): self
    {
        $this->remise = $remise;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getImageProd(): ?string
    {
        return $this->imageProd;
    }

    public function setImageProd(?string $imageProd): self
    {
        $this->imageProd = $imageProd;

        return $this;
    }


}
