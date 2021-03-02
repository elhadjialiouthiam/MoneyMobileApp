<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TarifRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=TarifRepository::class)
 */
class Tarif
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $montantMIn;

    /**
     * @ORM\Column(type="integer")
     */
    private $montantMax;

    /**
     * @ORM\Column(type="integer")
     */
    private $frais;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantMIn(): ?int
    {
        return $this->montantMIn;
    }

    public function setMontantMIn(int $montantMIn): self
    {
        $this->montantMIn = $montantMIn;

        return $this;
    }

    public function getMontantMax(): ?int
    {
        return $this->montantMax;
    }

    public function setMontantMax(int $montantMax): self
    {
        $this->montantMax = $montantMax;

        return $this;
    }

    public function getFrais(): ?int
    {
        return $this->frais;
    }

    public function setFrais(int $frais): self
    {
        $this->frais = $frais;

        return $this;
    }
}
