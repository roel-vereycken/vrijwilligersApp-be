<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EventTaakRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=EventTaakRepository::class)
 */
class EventTaak
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $datum;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $startUur;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $eindUur;

    /**
     * @ORM\ManyToOne(targetEntity=Taak::class, inversedBy="eventTaken")
     */
    private $taakId;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="eventTaken")
     */
    private $eventId;

    /**
     * @var User[]
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="taakverdeling", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="user_event_taak")
     */
    protected $users;

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


}
