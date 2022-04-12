<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PointsFidelite
 *
 * @ORM\Table(name="points_fidelite")
 * @ORM\Entity
 */
class PointsFidelite
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
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     */
    private $idUser;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_points", type="bigint", nullable=false)
     */
    private $nombrePoints = '0';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getNombrePoints(): ?string
    {
        return $this->nombrePoints;
    }

    public function setNombrePoints(string $nombrePoints): self
    {
        $this->nombrePoints = $nombrePoints;

        return $this;
    }


}
