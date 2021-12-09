<?php

namespace App\Entity;

use App\Repository\SpeciesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpeciesRepository::class)]
class Species
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'date', nullable: true)]
    private $discoveredSince;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDiscoveredSince(): ?\DateTimeInterface
    {
        return $this->discoveredSince;
    }

    public function setDiscoveredSince(?\DateTimeInterface $discoveredSince): self
    {
        $this->discoveredSince = $discoveredSince;

        return $this;
    }
}
