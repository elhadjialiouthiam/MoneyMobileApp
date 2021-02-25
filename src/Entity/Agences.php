<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AgencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"agence:read"}},
 *      denormalizationContext={"groups"={"agence:write"}},
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
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="float")
     */
    private $lattitude;

    /**
     * @ORM\Column(type="float")
     */
    private $longitude;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut;

    /**
     * @ORM\OneToOne(targetEntity=Comptes::class, cascade={"persist", "remove"})
     */
    private $compte;

    /**
     * @ORM\OneToMany(targetEntity=AdminAgence::class, mappedBy="agence")
     */
    private $adminAgences;

    public function __construct()
    {
        $this->adminAgences = new ArrayCollection();
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
}
