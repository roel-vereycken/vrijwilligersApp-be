<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EventTaakRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;


/**
 * @ApiResource(
 *     normalizationContext={"groups"={"eventTaak:read"}},
 *     denormalizationContext={"groups"={"eventTaak:write"}}
 * )
 * @ApiFilter(SearchFilter::class, properties={"eventId.id": "exact"})

 * @ORM\Entity(repositoryClass=EventTaakRepository::class)
 */
class EventTaak
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"event:read", "eventTaak:read", "user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups({"eventTaak:read", "user:read"})
     */
    private $datum;

    /**
     * @ORM\Column(type="time", nullable=true)
     * @Groups({"eventTaak:read"})
     */
    private $startUur;

    /**
     * @ORM\Column(type="time", nullable=true)
     * @Groups({"eventTaak:read"})
     */
    private $eindUur;

    /**
     * @ORM\ManyToOne(targetEntity=Taak::class, inversedBy="eventTaken", cascade={"persist", "remove"})
     * @Groups({"event:read", "eventTaak:read", "user:read"})
     */
    private $taakId;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="eventTaken")
     * @Groups({"user:read"})
     */
    private $eventId;

    /**
     * @var User[]
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="taakverdeling", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="user_event_taak")
     * @Groups({"event:read", "eventTaak:read", "eventTaak:write"})
     */
    protected $users;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"eventTaak:read"})
     */
    private $aantalVrijwilligers;

    public function __construct()
    {
        $this->users = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatum(): ?\DateTimeInterface
    {
        return $this->datum;
    }

    public function setDatum(\DateTimeInterface $datum): self
    {
        $this->datum = $datum;

        return $this;
    }

    public function getStartUur(): ?\DateTimeInterface
    {
        return $this->startUur;
    }

    public function setStartUur(?\DateTimeInterface $startUur): self
    {
        $this->startUur = $startUur;

        return $this;
    }

    public function getEindUur(): ?\DateTimeInterface
    {
        return $this->eindUur;
    }

    public function setEindUur(?\DateTimeInterface $eindUur): self
    {
        $this->eindUur = $eindUur;

        return $this;
    }

    public function getTaakId(): ?Taak
    {
        return $this->taakId;
    }

    public function setTaakId(?Taak $taakId): self
    {
        $this->taakId = $taakId;

        return $this;
    }

    public function getEventId(): ?Event
    {
        return $this->eventId;
    }

    public function setEventId(?Event $eventId): self
    {
        $this->eventId = $eventId;

        return $this;
    }

    /**
     * @return User[]
     */
    public function getUsers()
    {
        return $this->users;
    }
    /**
     * @param User[] $users
     */
    public function setUsers(array $users)
    {
        // This is the owning side, we have to call remove and add to have change in the category side too.
        foreach ($this->getUsers() as $user) {
            $this->removeUser($user);
        }
        foreach ($users as $user) {
            $this->addUser($user);
        }
    }
    /**
     * @param  $user User the user to associate
     */
    public function addUser(User $user)
    {
        if ($this->users->contains($user)) {
            return;
        }
        $this->users->add($user);
        $user->addTaakverdeling($this);
    }
    /**
     * @param $user User the user to associate
     */
    public function removeUser(User $user)
    {
        if (!$this->users->removeElement($user)) {
            return;
        }
        $this->users->removeElement($user);
        $user->removeTaakverdeling($this);
    }

    // toevoeging voor easyadmin: om de foreign key te herkennen
    public function __toString()
    {
        return strval($this->getTaakId());
    }

    public function getAantalVrijwilligers(): ?int
    {
        return $this->aantalVrijwilligers;
    }

    public function setAantalVrijwilligers(int $aantalVrijwilligers): self
    {
        $this->aantalVrijwilligers = $aantalVrijwilligers;

        return $this;
    }


}
