<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdminAgenceRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      attributes={
 *      "security" = "is_granted('ROLE_ADMINSYSTEME')",
 *      "security_message" = "tu n'as pas le droit d'acces à ce ressource",
 *   },
 * )
 * @ORM\Entity(repositoryClass=AdminAgenceRepository::class)
 */
class AdminAgence extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({
     *      "agence:read", "agence:write",
     * })
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity=Agences::class, inversedBy="adminAgences")
     * @Groups({
     *      "user:read", "profil:read",
     * })
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
