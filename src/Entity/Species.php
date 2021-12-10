<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SpeciesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SpeciesRepository::class)]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
)]
class Species
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank, Assert\Length(max: 255)]
    private $name;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Assert\Type(\DateTimeInterface::class)]
    private $discoveredSince;

    #[ORM\OneToMany(targetEntity: Race::class, mappedBy: 'species')]
    #[ApiSubresource]
    private Collection $races;

    public function __construct()
    {
        $this->races = new ArrayCollection();
    }

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

    /**
     * @return Collection|Race[]
     */
    public function getRaces(): Collection
    {
        return $this->races;
    }

    public function addRace(Race $race): self
    {
        if (!$this->races->contains($race)) {
            $this->races[] = $race;
            $race->setSpecies($this);
        }

        return $this;
    }

    public function removeRace(Race $race): self
    {
        if ($this->races->removeElement($race)) {
            // set the owning side to null (unless already changed)
            if ($race->getSpecies() === $this) {
                $race->setSpecies(null);
            }
        }

        return $this;
    }
}
