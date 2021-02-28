<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ComptesRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"compte:read"}},
 *      denormalizationContext={"groups"={"compte:write"}},
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
 * @ORM\Entity(repositoryClass=ComptesRepository::class)
 */
class Comptes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({
     *      "compte:read", "agence:read", "agence:write",
     * })
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({
     *      "compte:read", "compte:write",
     *      "agence:read", "agence:write",
     * })
     */
    private $solde;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({
     *      "compte:read", 
     *      "agence:read", 
     * })
     */
    private $statut= false;

    /**
     * @ORM\ManyToOne(targetEntity=Caisier::class, inversedBy="comptes")
     */
    private $caisier;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="comptes")
     */
    private $transaction;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({
     *      "compte:read", "compte:write",
     *      "agence:read", "agence:write",
     * })
     */
    private $numCompte;

    /**
     * @ORM\Column(type="date")
     * @Groups({
     *      "compte:read", "compte:write",
     *      "agence:read", "agence:write",
     * })
     */
    private $dateCreation;

    public function __construct()
    {
        $this->transaction = new ArrayCollection();
        $this->setDateCreation(new \DateTime());
        // $this->setSolde(700000);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

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

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setCompte($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getCompte() === $this) {
                $transaction->setCompte(null);
            }
        }

        return $this;
    }

    public function getCaisier(): ?Caisier
    {
        return $this->caisier;
    }

    public function setCaisier(?Caisier $caisier): self
    {
        $this->caisier = $caisier;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransaction(): Collection
    {
        return $this->transaction;
    }

    public function getNumCompte(): ?string
    {
        return $this->numCompte;
    }

    public function setNumCompte(string $numCompte): self
    {
        $this->numCompte = $numCompte;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }
}
