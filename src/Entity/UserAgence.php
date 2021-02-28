<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserAgenceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"useragence:read"}},
 *      denormalizationContext={"groups"={"useragence:write"}},
 *      attributes={
 *      "security" = "is_granted('ROLE_ADMINSYSTEME') or is_granted('ROLE_CAISIER') or is_granted('ROLE_ADMINAGENCE')",
 *      "security_message" = "tu n'as pas le droit d'acces à ce ressource",
 *   },
 *       itemOperations={
 *          "GET",
 *          "PUT"={"deserialize"=false},
 *          "DELETE"
 *      }
 * )
 * @ORM\Entity(repositoryClass=UserAgenceRepository::class)
 */
class UserAgence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({
     *    "useragence:read","trans:read", "compteuser:read",
     * })
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({
     *      "useragence:read", "useragence:write",
     *      "compteuser:read",
     *      "trans:read", 
     * })
     */
    private $nomComplet;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({
     *      "useragence:read", "useragence:write",
     *      "compteuser:read",
     *      "trans:read", 
     * })
     */
    private $CNI;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({
     *      "useragence:read", "useragence:write",
     *      "compteuser:read",
     *      "trans:read",
     * })
     */
    private $telephone;

    /**
     * @ORM\OneToOne(targetEntity=CompteUserAgence::class, cascade={"persist", "remove"})
     * @Groups({
     *      "useragence:read", "useragence:write",
     *      "trans:read",
     * })
     */
    private $compteUserAgence;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(string $nomComplet): self
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }

    public function getCNI(): ?string
    {
        return $this->CNI;
    }

    public function setCNI(string $CNI): self
    {
        $this->CNI = $CNI;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getCompteUserAgence(): ?CompteUserAgence
    {
        return $this->compteUserAgence;
    }

    public function setCompteUserAgence(?CompteUserAgence $compteUserAgence): self
    {
        $this->compteUserAgence = $compteUserAgence;

        return $this;
    }
}
