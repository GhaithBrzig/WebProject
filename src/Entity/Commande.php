<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="fk_login_id", columns={"id_user"})})
 * @ORM\Entity
 */
class Commande
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
     * @var bool
     *
     * @ORM\Column(name="etat_cmd", type="boolean", nullable=false)
     */
    private $etatCmd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_cmd", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateCmd = 'CURRENT_TIMESTAMP';

    /**
     * @var \Login
     *
     * @ORM\ManyToOne(targetEntity="Login")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtatCmd(): ?bool
    {
        return $this->etatCmd;
    }

    public function setEtatCmd(bool $etatCmd): self
    {
        $this->etatCmd = $etatCmd;

        return $this;
    }

    public function getDateCmd(): ?\DateTimeInterface
    {
        return $this->dateCmd;
    }

    public function setDateCmd(\DateTimeInterface $dateCmd): self
    {
        $this->dateCmd = $dateCmd;

        return $this;
    }

    public function getIdUser(): ?Login
    {
        return $this->idUser;
    }

    public function setIdUser(?Login $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }


}
