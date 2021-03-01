<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CaisierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *      attributes={
 *      "security" = "is_granted('ROLE_ADMINSYSTEME') or is_granted('ROLE_ADMINAGENCE')",
 *      "security_message" = "tu n'as pas le droit d'acces à ce ressource",
 *   },
 * )
 * @ORM\Entity(repositoryClass=CaisierRepository::class)
 */
class Caisier extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

   
}
