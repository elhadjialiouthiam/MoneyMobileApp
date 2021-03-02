<?php

namespace App\Entity;

use App\Entity\Clients;
use App\Entity\Comptes;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TransactionRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiFilter( BooleanFilter::class, properties={"isDepot"}
 * )
 * @ApiResource(
 *      normalizationContext={"groups"={"trans:read"}},
 *      denormalizationContext={"groups"={"trans:write"}},
 *      attributes={
 *      "security" = "is_granted('ROLE_ADMINSYSTEME') or is_granted('ROLE_CAISIER') or is_granted('ROLE_ADMINAGENCE')",
 *      "security_message" = "tu n'as pas le droit d'acces à ce ressource",
 *   },
 *      itemOperations={
 *          "GET",
 *          "PUT"={"deserialize"=false},
 *          "DELETE"
 *      }
 * )
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     *  @Groups({
     *      "trans:read", "compte:read","compteuser:read","useragence:read",
     * })
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({
     *      "trans:read", "trans:write","compte:read","compteuser:read","useragence:read",
     * })
     */
    private $code;

    /**
     * @ORM\Column(type="float")
     *
     * @Groups({
     *      "trans:read", "trans:write","compte:read","compteuser:read","useragence:read",
     * })
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Groups({
     *      "trans:read", "trans:write","compte:read","compteuser:read","useragence:read",
     * })
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({
     *      "trans:read", "trans:write","compte:read","compteuser:read","useragence:read",
     * })
     */
    private $isDepot;

    /**
     * @ORM\Column(type="float", nullable=true)
     *
     *@Groups({
     *      "trans:read", "trans:write",
     * })
     */
    private $partEtat;

    /**
     * @ORM\Column(type="float", nullable=true)
     *
     * @Groups({
     *      "trans:read", "trans:write",
     * })
     */
    private $partAgenceRetrait;

    /**
     * @ORM\Column(type="float", nullable=true)
     *
     * @Groups({
     *      "trans:read", "trans:write",
     * })
     */
    private $partAgenceDepot;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Groups({
     *      "trans:read", "trans:write","compte:read","compteuser:read"
     * })
     */
    private $statut;

    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Comptes::class, inversedBy="transactions", cascade={"persist"})
     *
     *@Groups({
     *      "trans:read", "trans:write","compte:read"
     * })
     */
    private $compte;

    /**
     * @ORM\Column(type="integer")
     * @Groups({
     *      "trans:read","compte:read","compteuser:read","useragence:read",
     * })
     */
    private $frais;

    /**
     * @ORM\OneToOne(targetEntity=Clients::class, cascade={"persist", "remove"})
     * @Groups({
     *      "trans:read", "trans:write","compte:read"
     * })
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=CompteUserAgence::class, inversedBy="transaction")
     * @Groups({
     *      "trans:read", "trans:write"
     * })
     */
    private $compteUserAgence;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({
     *      "trans:read", "trans:write","compte:read","compteuser:read","useragence:read",
     * })
     */
    private $isClient;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({
     *      "trans:read", "trans:write",
     * })
     */
    private $partSysteme;

    public function __construct()
    {
        $this->setStatut(false);
        $this->setCreatedAt(new \DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getIsDepot(): ?bool
    {
        return $this->isDepot;
    }

    public function setIsDepot(bool $isDepot): self
    {
        $this->isDepot = $isDepot;

        return $this;
    }

    public function getPartEtat(): ?float
    {
        return $this->partEtat;
    }

    public function setPartEtat(?float $partEtat): self
    {
        $this->partEtat = $partEtat;

        return $this;
    }

    public function getPartAgenceRetrait(): ?float
    {
        return $this->partAgenceRetrait;
    }

    public function setPartAgenceRetrait(float $partAgenceRetrait): self
    {
        $this->partAgenceRetrait = $partAgenceRetrait;

        return $this;
    }

    public function getPartAgenceDepot(): ?float
    {
        return $this->partAgenceDepot;
    }

    public function setPartAgenceDepot(?float $partAgenceDepot): self
    {
        $this->partAgenceDepot = $partAgenceDepot;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCompte(): ?Comptes
    {
        return $this->compte;
    }

    public function setCompte(?Comptes $compte): self
    {
        $this->compte = $compte;

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

    public function getClient(): ?Clients
    {
        return $this->client;
    }

    public function setClient(?Clients $client): self
    {
        $this->client = $client;

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

    public function getIsClient(): ?bool
    {
        return $this->isClient;
    }

    public function setIsClient(bool $isClient): self
    {
        $this->isClient = $isClient;

        return $this;
    }

    public function getPartSysteme(): ?int
    {
        return $this->partSysteme;
    }

    public function setPartSysteme(int $partSysteme): self
    {
        $this->partSysteme = $partSysteme;

        return $this;
    }

}
