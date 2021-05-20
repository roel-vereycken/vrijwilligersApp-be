<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OpmerkingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=OpmerkingRepository::class)
 */
class Opmerking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity=Bericht::class, inversedBy="opmerkingen")
     */
    private $opmerkingBericht;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="opmerkingen")
     */
    private $opmerkingUser;

    /**
     * @ORM\ManyToOne(targetEntity=Opmerking::class, inversedBy="opmerkingen")
     */
    private $opmerkingOpmerking;

    /**
     * @ORM\OneToMany(targetEntity=Opmerking::class, mappedBy="opmerkingOpmerking")
     */
    private $opmerkingen;

    public function __construct()
    {
        $this->opmerkingen = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getOpmerkingBericht(): ?Bericht
    {
        return $this->opmerkingBericht;
    }

    public function setOpmerkingBericht(?Bericht $opmerkingBericht): self
    {
        $this->opmerkingBericht = $opmerkingBericht;

        return $this;
    }

    public function getOpmerkingUser(): ?User
    {
        return $this->opmerkingUser;
    }

    public function setOpmerkingUser(?User $opmerkingUser): self
    {
        $this->opmerkingUser = $opmerkingUser;

        return $this;
    }

    public function getOpmerkingOpmerking(): ?self
    {
        return $this->opmerkingOpmerking;
    }

    public function setOpmerkingOpmerking(?self $opmerkingOpmerking): self
    {
        $this->opmerkingOpmerking = $opmerkingOpmerking;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getOpmerkingen(): Collection
    {
        return $this->opmerkingen;
    }

    public function addOpmerkingen(self $opmerkingen): self
    {
        if (!$this->opmerkingen->contains($opmerkingen)) {
            $this->opmerkingen[] = $opmerkingen;
            $opmerkingen->setOpmerkingOpmerking($this);
        }

        return $this;
    }

    public function removeOpmerkingen(self $opmerkingen): self
    {
        if ($this->opmerkingen->removeElement($opmerkingen)) {
            // set the owning side to null (unless already changed)
            if ($opmerkingen->getOpmerkingOpmerking() === $this) {
                $opmerkingen->setOpmerkingOpmerking(null);
            }
        }

        return $this;
    }

    // toevoeging voor easyadmin: om de foreign key te herkennen
    public function __toString()
    {
        return strval($this->getId());
    }
}