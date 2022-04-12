<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Livraison
 *
 * @ORM\Table(name="livraison", indexes={@ORM\Index(name="fk_livreurId", columns={"IdLivreur"}), @ORM\Index(name="fk_commande_id_l", columns={"id_commande"})})
 * @ORM\Entity
 */
class Livraison
{
    /**
     * @var int
     *
     * @ORM\Column(name="IdLivraison", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idlivraison;

    /**
     * @var float
     *
     * @ORM\Column(name="FraisdeLivraison", type="float", precision=10, scale=0, nullable=false)
     */
    private $fraisdelivraison;

    /**
     * @var \Livreur
     *
     * @ORM\ManyToOne(targetEntity="Livreur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IdLivreur", referencedColumnName="IdLivreur")
     * })
     */
    private $idlivreur;

    /**
     * @var \Commande
     *
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_commande", referencedColumnName="id")
     * })
     */
    private $idCommande;

    public function getIdlivraison(): ?int
    {
        return $this->idlivraison;
    }

    public function getFraisdelivraison(): ?float
    {
        return $this->fraisdelivraison;
    }

    public function setFraisdelivraison(float $fraisdelivraison): self
    {
        $this->fraisdelivraison = $fraisdelivraison;

        return $this;
    }

    public function getIdlivreur(): ?Livreur
    {
        return $this->idlivreur;
    }

    public function setIdlivreur(?Livreur $idlivreur): self
    {
        $this->idlivreur = $idlivreur;

        return $this;
    }

    public function getIdCommande(): ?Commande
    {
        return $this->idCommande;
    }

    public function setIdCommande(?Commande $idCommande): self
    {
        $this->idCommande = $idCommande;

        return $this;
    }


}
