<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"trans:read"}},
 *      denormalizationContext={"groups"={"trans:write"}},
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
     *      "trans:read"
     * })
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({
     *      "trans:read", "trans:write",
     * })
     */
    private $code;

    /**
     * @ORM\Column(type="float")
     *
     * @Groups({
     *      "trans:read", "trans:write",
     * })
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Groups({"trans:read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Groups({
     *      "trans:read", "trans:write",
     * })
     */
    private $isDepot;

    /**
     * @ORM\Column(type="float", nullable=true)
     *
     * @Groups({
     *      "trans:read", "trans:write",
     * })
     */
    private $partEtat;

    /**
     * @ORM\Column(type="float")
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
     * @ORM\OneToOne(targetEntity=Clients::class, cascade={"persist", "remove"})
     *
     *
     * @Groups({
     *      "trans:read", "trans:write",
     * })
     */
    private $client;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Groups({"trans:read"})
     */
    private $statut;

    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Comptes::class, inversedBy="transactions", cascade={"persist"})
     *
     * @Groups({
     *      "trans:read", "trans:write",
     * })
     */
    private $compte;

    /**
     * @ORM\Column(type="integer")
     */
    private $frais;

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

    public function getClient(): ?Clients
    {
        return $this->client;
    }

    public function setClient(?Clients $client): self
    {
        $this->client = $client;

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

}
