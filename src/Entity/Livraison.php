<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use app\Entity\Commande;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;



/**
 * Livraison
 *
 * @ORM\Table(name="livraison", indexes={@ORM\Index(name="fk_livreurId", columns={"IdLivreur"}), @ORM\Index(name="fk_commande_id_l", columns={"id_commande"})})
 * @ORM\Entity(repositoryClass="App\Repository\LivraisonRepository")
 */
class Livraison
{
    /**
     * @var int
     *
     * @ORM\Column(name="IdLivraison", type="integer", nullable=false)
     * @ORM\Id
     
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * 
     */
    private $idlivraison;

    /**
     * @var float
     *
     * @ORM\Column(name="FraisdeLivraison", type="float", precision=10, scale=0, nullable=false)
     * @Assert\NotBlank(message=" veillez entrer le frais de livraison")
    
     */
    private $fraisdelivraison;

    /**
     * @var \Livreur
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="IdLivreur", referencedColumnName="IdLivreur")
     * @ORM\ManyToOne(targetEntity=Livreur::class, inversedBy="Livraison")
     * @ORM\JoinColumn(nullable=false, name="id_livreur", referencedColumnName="id")
     * })
      * @Assert\NotBlank(message=" veillez selectionner un livreur")
     */
    private $idlivreur;

    /**  
     * @var \Commande
     *
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_commande", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message=" veillez selectionner une commande")
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
