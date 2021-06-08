<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}}
 * )
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ({"eventTaak:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups ({"user:read", "user:write"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"bericht:read", "opmerking:read", "user:read", "eventTaak:read", "user:write"})
     */
    private $voornaam;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"bericht:read", "opmerking:read", "user:read", "eventTaak:read", "user:write"})
     */
    private $naam;

    /**
     * @ORM\OneToMany(targetEntity=Bericht::class, mappedBy="userBericht")
     */
    private $berichten;

    /**
     * @ORM\OneToMany(targetEntity=Opmerking::class, mappedBy="opmerkingUser")
     */
    private $opmerkingen;

    /**
     * @var EventTaak[]
     * @ORM\ManyToMany(targetEntity=EventTaak::class, inversedBy="users")
     * @ORM\JoinTable(name="user_event_taak")
     * @Groups({"user:read"})
     */
    protected $taakverdeling;



    public function __construct()
    {
        $this->berichten = new ArrayCollection();
        $this->taakverdeling = new ArrayCollection();
        $this->opmerkingen = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = password_hash( $password, PASSWORD_ARGON2I );

        return $this;
    }


    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getVoornaam(): ?string
    {
        return $this->voornaam;
    }

    public function setVoornaam(string $voornaam): self
    {
        $this->voornaam = $voornaam;

        return $this;
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
            $berichten->setUserBericht($this);
        }

        return $this;
    }

    public function removeBerichten(Bericht $berichten): self
    {
        if ($this->berichten->removeElement($berichten)) {
            // set the owning side to null (unless already changed)
            if ($berichten->getUserBericht() === $this) {
                $berichten->setUserBericht(null);
            }
        }

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
            $opmerkingen->setOpmerkingUser($this);
        }

        return $this;
    }

    public function removeOpmerkingen(Opmerking $opmerkingen): self
    {
        if ($this->opmerkingen->removeElement($opmerkingen)) {
            // set the owning side to null (unless already changed)
            if ($opmerkingen->getOpmerkingUser() === $this) {
                $opmerkingen->setOpmerkingUser(null);
            }
        }

        return $this;
    }
    // toevoeging voor easyadmin: om de foreign key te herkennen
    public function __toString()
    {
        return $this->getVoornaam() . " " . $this->getNaam();
    }

    /**
     * @return EventTaak[]
     */
    public function getTaakverdeling()
    {
        return $this->taakverdeling;
    }
//
//    /**
//     *
//     * @param EventTaak[] $taakverdeling
//     */
//    public function setTaakverdeling(array $taakverdeling)
//    {
//        // This is the owning side, we have to call remove and add to have change in the category side too.
//        foreach ($this->getTaakverdeling() as $taak) {
//            $this->removeTaakverdeling($taak);
//        }
//        foreach ($taakverdeling as $taak) {
//            $this->addTaakverdeling($taak);
//        }
//    }
     /**
      * @param  $taak EventTaak the taak to associate
      */
    public function addTaakverdeling(EventTaak $taak)
    {
        if ($this->taakverdeling->contains($taak)) {
            return;
        }

        $this->taakverdeling->add($taak);
        $taak->addUser($this);
    }
    /**
     * @param  $taak EventTaak the taak to associate
     */
    public function removeTaakverdeling(EventTaak $taak)
    {
        if (!$this->taakverdeling->contains($taak)) {
            return;
        }
        $this->taakverdeling->removeElement($taak);
        $taak->removeUser($this);
    }

}
