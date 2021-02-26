<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompteUserAgenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"compteuser:read"}},
 *      denormalizationContext={"groups"={"compteuser:write"}},
 *      itemOperations={
 *          "GET",
 *          "PUT"={"deserialize"=false},
 *          "DELETE"
 *      }
 * )
 * @ORM\Entity(repositoryClass=CompteUserAgenceRepository::class)
 */
class CompteUserAgence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({
     *      "compteuser:read", "trans:read","useragence:read","useragence:write",
     * })
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({
     *      "compteuser:read", "compteuser:write","trans:read","useragence:read","useragence:write",
     * })
     */
    private $solde;

    /**
     * @ORM\Column(type="date")
     * @Groups({
     *      "compteuser:read", "compteuser:write","trans:read","useragence:read","useragence:write",
     * })
     */
    private $date_creation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut= false;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="compteUserAgence")
     * @Groups({
     *      "compteuser:read","useragence:read",
     * })
     */
    private $transaction;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({
     *      "compteuser:read", "compteuser:write","trans:read","useragence:read","useragence:write",
     * })
     */
    private $numero_compte;

    public function __construct()
    {
        $this->transaction = new ArrayCollection();
        $this->setDateCreation(new \DateTime());
        $this->setSolde(0);
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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

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
    public function getTransaction(): Collection
    {
        return $this->transaction;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transaction->contains($transaction)) {
            $this->transaction[] = $transaction;
            $transaction->setCompteUserAgence($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transaction->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getCompteUserAgence() === $this) {
                $transaction->setCompteUserAgence(null);
            }
        }

        return $this;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->numero_compte;
    }

    public function setNumeroCompte(string $numero_compte): self
    {
        $this->numero_compte = $numero_compte;

        return $this;
    }
}
