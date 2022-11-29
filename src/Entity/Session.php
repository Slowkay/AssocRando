<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{


    // ===== Attributes =====

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\ManyToOne(inversedBy: 'session')]
    #[ORM\JoinColumn(nullable: false)]
    protected ?Hiking $hike = null;
    

    // ===== Accessors =====

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHike(): ?Hiking
    {
        return $this->hike;
    }

    public function setHike(?Hiking $hike): self
    {
        $this->hike = $hike;

        return $this;
    }
}
