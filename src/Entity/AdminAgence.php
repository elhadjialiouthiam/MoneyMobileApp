<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AdminAgenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=AdminAgenceRepository::class)
 */
class AdminAgence extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity=Agences::class, inversedBy="adminAgences")
     */
    private $agence;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgence(): ?Agences
    {
        return $this->agence;
    }

    public function setAgence(?Agences $agence): self
    {
        $this->agence = $agence;

        return $this;
    }
}
