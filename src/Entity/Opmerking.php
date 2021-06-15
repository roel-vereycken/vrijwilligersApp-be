<?php

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OpmerkingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource(
 *     normalizationContext={"groups"={"opmerking:read"}},
 *     denormalizationContext={"groups"={"opmerking:write"}}
 * )

 * @ORM\Entity(repositoryClass=OpmerkingRepository::class)
 */
class Opmerking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"bericht:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"bericht:read", "opmerking:read", "opmerking:write"})
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity=Bericht::class, inversedBy="opmerkingen")
     * @Groups({"opmerking:write"})
     */
    private $opmerkingBericht;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="opmerkingen")
     * @Groups({"bericht:read", "opmerking:write"})
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

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"bericht:read"})
     */
    private $createdAt;

    public function __construct()
    {
        $this->opmerkingen = new ArrayCollection();
        $this->createdAt = new\DateTimeImmutable('+2 hours');

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
        return strval($this->getBody());
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

//    public function setCreatedAt(?\DateTimeInterface $createdAt): self
//    {
//        $this->createdAt = $createdAt;
//
//        return $this;
//    }
}
