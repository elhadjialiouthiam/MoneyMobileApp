<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AdminSystemeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *      attributes={
 *      "security" = "is_granted('ROLE_ADMINSYSTEME')",
 *      "security_message" = "tu n'as pas le droit d'acces à ce ressource",
 *   },
 * )
 * @ORM\Entity(repositoryClass=AdminSystemeRepository::class)
 */
class AdminSysteme extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
