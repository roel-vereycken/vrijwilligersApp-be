<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ApiResource(
 *     attributes={
 *          "pagination_items_per_page"=6
 *           },
 *      normalizationContext={"groups"={"event:read"}},
 *      denormalizationContext={"groups"={"event:write"}}
 * )
 * @ORM\Entity(repositoryClass=EventRepository::class)
 *
 * @Vich\Uploadable()
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"event:read"})
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
    private $beschrijving;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"event:read"})
     */
    private $startDatum;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"event:read"})
     */
    private $eindDatum;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups({"event:read"})
     */
    private $afbeelding;

    /**
     * @Vich\UploadableField(mapping="afbeeldingen", fileNameProperty="afbeelding")
     */
    private $afbeeldingFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Bericht::class, mappedBy="eventBericht")
     * @Groups({"event:read"})
     */
    private $berichten;

    /**
     * @ORM\OneToMany(targetEntity=EventTaak::class, mappedBy="eventId", cascade={"persist", "remove"})
     * @Groups({"event:read", "eventTaak:read"})
     */
    private $eventTaken;

    /**
     * @ORM\ManyToOne(targetEntity=Locatie::class, inversedBy="events")
     * @Groups({"event:read"})
     */
    private $eventLocatie;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="events")
     * @Groups({"event:read"})
     */
    private $eventCategorie;

    public function __construct()
    {
        $this->berichten = new ArrayCollection();
        $this->eventTaken = new ArrayCollection();
        $this->updatedAt = new \DateTime();
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

    public function getBeschrijving(): ?string
    {
        return $this->beschrijving;
    }

    public function setBeschrijving(?string $beschrijving): self
    {
        $this->beschrijving = $beschrijving;

        return $this;
    }

    public function getStartDatum(): ?\DateTimeInterface
    {
        return $this->startDatum;
    }

    public function setStartDatum(?\DateTimeInterface $startDatum): self
    {
        $this->startDatum = $startDatum;

        return $this;
    }

    public function getEindDatum(): ?\DateTimeInterface
    {
        return $this->eindDatum;
    }

    public function setEindDatum(?\DateTimeInterface $eindDatum): self
    {
        $this->eindDatum = $eindDatum;

        return $this;
    }

    public function getAfbeelding(): ?string
    {
        return $this->afbeelding;
    }

    public function setAfbeelding(?string $afbeelding): self
    {
        $this->afbeelding = $afbeelding;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAfbeeldingFile()
    {
        return $this->afbeeldingFile;
    }

    /**
     * @param mixed $afbeeldingFile
     */
    public function setAfbeeldingFile($afbeeldingFile): void
    {
        $this->afbeeldingFile = $afbeeldingFile;

        if ( $afbeeldingFile )
        {
            $this->updatedAt = new \DateTime();
        }
    }

    /**
     * @return Collection|Bericht[]
     */
    public function getBerichten(): Collection
    {
        return $this->berichten;
    }

    public function addBerichten(Bericht $berichten): self
    {
        if (!$this->berichten->contains($berichten)) {
            $this->berichten[] = $berichten;
            $berichten->setEventBericht($this);
        }

        return $this;
    }

    public function removeBerichten(Bericht $berichten): self
    {
        if ($this->berichten->removeElement($berichten)) {
            // set the owning side to null (unless already changed)
            if ($berichten->getEventBericht() === $this) {
                $berichten->setEventBericht(null);
            }
        }

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
            $eventTaken->setEventId($this);
        }

        return $this;
    }

    public function removeEventTaken(EventTaak $eventTaken): self
    {
        if ($this->eventTaken->removeElement($eventTaken)) {
            // set the owning side to null (unless already changed)
            if ($eventTaken->getEventId() === $this) {
                $eventTaken->setEventId(null);
            }
        }

        return $this;
    }

    public function getEventLocatie(): ?Locatie
    {
        return $this->eventLocatie;
    }

    public function setEventLocatie(?Locatie $eventLocatie): self
    {
        $this->eventLocatie = $eventLocatie;

        return $this;
    }

    public function getEventCategorie(): ?Categorie
    {
        return $this->eventCategorie;
    }

    public function setEventCategorie(?Categorie $eventCategorie): self
    {
        $this->eventCategorie = $eventCategorie;

        return $this;
    }

    // toevoeging voor easyadmin: om de foreign key te herkennen
    public function __toString()
    {
        return $this->getNaam();
    }
}
