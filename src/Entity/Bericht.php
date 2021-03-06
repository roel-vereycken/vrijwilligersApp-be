<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BerichtRepository;
use App\Services\TextAreaService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;


/**
 * @ApiResource(
 *
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put", "delete"},
 *
 *     normalizationContext={"groups"={"bericht:read"}},
 *     denormalizationContext={"groups"={"bericht:write"}}
 * )
 * @ApiFilter(SearchFilter::class, properties={"eventBericht.id": "exact"})

 * @ORM\Entity(repositoryClass=BerichtRepository::class)
 */
class Bericht
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
     * @Groups({"bericht:read", "bericht:write"})
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="berichten")
     * @Groups({"bericht:read", "bericht:write"})
     */
    private $userBericht;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="berichten")
     * @Groups({"bericht:write"})
     */
    private $eventBericht;

    /**
     * @ORM\OneToMany(targetEntity=Opmerking::class, mappedBy="opmerkingBericht", cascade={"persist", "remove"})
     * @Groups({"bericht:read"})
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
        $this->createdAt = new\DateTimeImmutable();
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

    public function getUserBericht(): ?User
    {
        return $this->userBericht;
    }

    public function setUserBericht(?User $userBericht): self
    {
        $this->userBericht = $userBericht;

        return $this;
    }

    public function getEventBericht(): ?Event
    {
        return $this->eventBericht;
    }

    public function setEventBericht(?Event $eventBericht): self
    {
        $this->eventBericht = $eventBericht;

        return $this;
    }

    /**
     * @return Collection|Opmerking[]
     */
    public function getOpmerkingen(): Collection
    {
        return $this->opmerkingen;
    }

    public function addOpmerkingen(Opmerking $opmerkingen): self
    {
        if (!$this->opmerkingen->contains($opmerkingen)) {
            $this->opmerkingen[] = $opmerkingen;
            $opmerkingen->setOpmerkingBericht($this);
        }

        return $this;
    }

    public function removeOpmerkingen(Opmerking $opmerkingen): self
    {
        if ($this->opmerkingen->removeElement($opmerkingen)) {
            // set the owning side to null (unless already changed)
            if ($opmerkingen->getOpmerkingBericht() === $this) {
                $opmerkingen->setOpmerkingBericht(null);
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
