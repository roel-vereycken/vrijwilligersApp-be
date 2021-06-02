<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TaakRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=TaakRepository::class)
 */
class Taak
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"event:read"})
     */
    private $naam;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"event:read"})
     */
    private $omschrijving;

    /**
     * @ORM\OneToMany(targetEntity=EventTaak::class, mappedBy="taakId", cascade={"persist"})
     */
    private $eventTaken;

    public function __construct()
    {
        $this->eventTaken = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNaam(): ?string
    {
        return $this->naam;
    }

    public function setNaam(string $naam): self
    {
        $this->naam = $naam;

        return $this;
    }

    public function getOmschrijving(): ?string
    {
        return $this->omschrijving;
    }

    public function setOmschrijving(?string $omschrijving): self
    {
        $this->omschrijving = $omschrijving;

        return $this;
    }

    /**
     * @return Collection|EventTaak[]
     */
    public function getEventTaken(): Collection
    {
        return $this->eventTaken;
    }

    public function addEventTaken(EventTaak $eventTaken): self
    {
        if (!$this->eventTaken->contains($eventTaken)) {
            $this->eventTaken[] = $eventTaken;
            $eventTaken->setTaakId($this);
        }

        return $this;
    }

    public function removeEventTaken(EventTaak $eventTaken): self
    {
        if ($this->eventTaken->removeElement($eventTaken)) {
            // set the owning side to null (unless already changed)
            if ($eventTaken->getTaakId() === $this) {
                $eventTaken->setTaakId(null);
            }
        }

        return $this;
    }

    // toevoeging voor easyadmin: om de foreign key te herkennen
    public function __toString()
    {
        return $this->getNaam();
    }
}
