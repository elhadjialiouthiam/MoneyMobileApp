<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AgencesRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"agence:read"}},
 *      denormalizationContext={"groups"={"agence:write"}},
 *      attributes={
 *      "security" = "is_granted('ROLE_ADMINSYSTEME')",
 *      "security_message" = "tu n'as pas le droit d'acces à ce ressource",
 *   },
 *       itemOperations={
 *          "GET",
 *          "PUT"={"deserialize"=false},
 *          "DELETE"
 *      }
 * )
 * @ORM\Entity(repositoryClass=AgencesRepository::class)
 */
class Agences
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({
     *      "agence:read", "compte:read",
     *      "compte:write","user:read", "user:write",
     * })
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({
     *      "agence:read", "agence:write",
     *      "compte:read", "compte:write",
     *      "user:read", "user:write",
     * })
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({
     *      "agence:read", "agence:write",
     *      "compte:read", "compte:write",
     *      "user:read", "user:write",
     * })
     */
    private $adresse;

    /**
     * @ORM\Column(type="float")
     * @Groups({
     *      "agence:read", "agence:write",
     *      "compte:read", "compte:write",
     *      "user:read", "user:write",
     * })
     */
    private $lattitude;

    /**
     * @ORM\Column(type="float")
     * @Groups({
     *      "agence:read", "agence:write",
     *      "compte:read", "compte:write",
     *      "user:read", "user:write",
     * })
     */
    private $longitude;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"agence:read", "compte:read","user:read"})
     */
    private $statut = false;

    /**
     * @ORM\OneToOne(targetEntity=Comptes::class, cascade={"persist", "remove"})
     * @Groups({"agence:read", "agence:write","user:read"})
     */
    private $compte;

    /**
     * @ORM\OneToMany(targetEntity=AdminAgence::class, mappedBy="agence")
     * @Groups({
     *    "agence:read",
     *     "compte:read","user:read"
     * })
     */
    private $adminAgences;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({
     *      "agence:read", "agence:write",
     *      "compte:read", "compte:write",
     *      "user:read", "user:write",
     * })
     */
    private $nom;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"agence:read", "compte:read","user:read"})
     */
    private $createdAt;

    public function __construct()
    {
        $this->adminAgences = new ArrayCollection();
        $this->setCreatedAt(new \DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getLattitude(): ?float
    {
        return $this->lattitude;
    }

    public function setLattitude(float $lattitude): self
    {
        $this->lattitude = $lattitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

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

    public function getCompte(): ?Comptes
    {
        return $this->compte;
    }

    public function setCompte(?Comptes $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    /**
     * @return Collection|AdminAgence[]
     */
    public function getAdminAgences(): Collection
    {
        return $this->adminAgences;
    }

    public function addAdminAgence(AdminAgence $adminAgence): self
    {
        if (!$this->adminAgences->contains($adminAgence)) {
            $this->adminAgences[] = $adminAgence;
            $adminAgence->setAgence($this);
        }

        return $this;
    }

    public function removeAdminAgence(AdminAgence $adminAgence): self
    {
        if ($this->adminAgences->removeElement($adminAgence)) {
            // set the owning side to null (unless already changed)
            if ($adminAgence->getAgence() === $this) {
                $adminAgence->setAgence(null);
            }
        }

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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
}
