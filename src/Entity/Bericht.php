<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BerichtRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=BerichtRepository::class)
 */
class Bericht
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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="berichten")
     */
    private $userBericht;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="berichten")
     */
    private $eventBericht;

    /**
     * @ORM\OneToMany(targetEntity=Opmerking::class, mappedBy="opmerkingBericht")
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
        return strval($this->getId());
    }
}
