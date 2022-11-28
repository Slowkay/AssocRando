<?php

namespace App\Entity;

use App\Repository\HikingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * hiking class with an id, a name and a nbPlace
 */
#[ORM\Entity(repositoryClass: HikingRepository::class)]
class Hiking
{
    // ===== Attributes =====

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $nameHiking = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\Column]
    private ?int $maxPlaces = null;

    #[ORM\OneToMany(mappedBy: 'hike', targetEntity: Session::class)]
    protected Collection $session;

    public function __construct()
    {
        $this->session = new ArrayCollection();
    }

    // ===== Accessors =====

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameHiking(): ?string
    {
        return $this->nameHiking;
    }

    public function setNameHiking(string $nameHiking): self
    {
        $this->nameHiking = $nameHiking;

        return $this;
    }

    public function getdescription(): ?string
    {
        return $this->description;
    }

    public function setdescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getMaxPlaces(): ?int
    {
        return $this->maxPlaces;
    }

    public function setMaxPlaces(int $maxPlaces): self
    {
        $this->maxPlaces = $maxPlaces;

        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSession(): Collection
    {
        return $this->session;
    }

    public function addSession(Session $session): self
    {
        if (!$this->session->contains($session)) {
            $this->session->add($session);
            $session->setHike($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->session->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getHike() === $this) {
                $session->setHike(null);
            }
        }

        return $this;
    }
}
