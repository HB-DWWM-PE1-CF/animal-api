<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get',
        'post' => [
            'security' => 'is_granted("ROLE_ADMIN_ANIMAL")',
        ],
    ],
    itemOperations: [
        'get',
        'put' => [
            'security' => 'is_granted("ROLE_ADMIN_ANIMAL")',
        ],
        'delete' => [
            'security' => 'is_granted("ROLE_ADMIN_ANIMAL")',
        ],
    ],
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'partial'])]
#[ApiFilter(OrderFilter::class, properties: ['name', 'id'])]
class Animal
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank, Assert\Length(max: 255)]
    private $name;

    #[ORM\ManyToOne(targetEntity: Species::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private $species;

    #[ORM\ManyToOne(targetEntity: Owner::class, inversedBy: 'animals')]
    private $owner;

    #[ORM\Column(type: 'string', length: 1)]
    #[Assert\NotBlank, Assert\Choice(['m', 'f', 'o'])]
    private $gender;

    #[ORM\OneToMany(targetEntity: AnimalRace::class, mappedBy: 'animal')]
    private $races;

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

    public function getSpecies(): ?Species
    {
        return $this->species;
    }

    public function setSpecies(?Species $species): self
    {
        $this->species = $species;

        return $this;
    }

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function setOwner(?Owner $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Collection|AnimalRace[]
     */
    public function getRaces(): Collection
    {
        return $this->races;
    }

    public function addRace(AnimalRace $race): self
    {
        if (!$this->races->contains($race)) {
            $this->races[] = $race;
        }

        return $this;
    }

    public function removeRace(AnimalRace $race): self
    {
        $this->races->removeElement($race);

        return $this;
    }
}
