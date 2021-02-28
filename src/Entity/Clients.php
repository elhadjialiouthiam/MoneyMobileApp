<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientsRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"client:read"}},
 *      denormalizationContext={"groups"={"client:write"}},
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
 * @ORM\Entity(repositoryClass=ClientsRepository::class)
 */
class Clients
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({
     *    "client:read","trans:read", "trans:write"
     * })
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({
     *      "client:read", "client:write",
     *      "trans:read", "trans:write"
     * })
     */
    private $nomComplet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({
     *      "client:read", "client:write",
     *      "trans:read", "trans:write"
     * })
     */
    private $telephone;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut= false;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({
     *      "client:read", "client:write",
     *      "trans:read", "trans:write"
     * })
     */
    private $cniBeneficiaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({
     *      "client:read", "client:write",
     *      "trans:read", "trans:write"
     * })
     */
    private $telephoneBeneficiaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({
     *      "client:read", "client:write",
     *      "trans:read", "trans:write"
     * })
     */
    private $nomCompletBeneficiaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({
     *      "client:read", "client:write",
     *      "trans:read", "trans:write"
     * })
     */
    private $numCNI;

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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }


    public function getCniBeneficiaire(): ?string
    {
        return $this->cniBeneficiaire;
    }

    public function setCniBeneficiaire(string $cniBeneficiaire): self
    {
        $this->cniBeneficiaire = $cniBeneficiaire;

        return $this;
    }

    public function getTelephoneBeneficiaire(): ?string
    {
        return $this->telephoneBeneficiaire;
    }

    public function setTelephoneBeneficiaire(string $telephoneBeneficiaire): self
    {
        $this->telephoneBeneficiaire = $telephoneBeneficiaire;

        return $this;
    }

    public function getNomCompletBeneficiaire(): ?string
    {
        return $this->nomCompletBeneficiaire;
    }

    public function setNomCompletBeneficiaire(string $nomCompletBeneficiaire): self
    {
        $this->nomCompletBeneficiaire = $nomCompletBeneficiaire;

        return $this;
    }

    public function getNumCNI(): ?string
    {
        return $this->numCNI;
    }

    public function setNumCNI(string $numCNI): self
    {
        $this->numCNI = $numCNI;

        return $this;
    }

}
