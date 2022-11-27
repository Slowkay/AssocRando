<?php

namespace App\Entity;

use App\Repository\HikingRepository;
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
}
