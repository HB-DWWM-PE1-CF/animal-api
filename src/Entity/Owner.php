<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OwnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OwnerRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get',
        'post' => [
            'denormalization_context' => [
                'groups' => ['lite_owner'],
            ],
        ],
    ],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['full_owner'],
            ],
        ],
        'put',
        'delete',
        'patch',
    ],
    denormalizationContext: [
        'groups' => ['lite_owner'],
    ],
    normalizationContext: [
        'groups' => ['lite_owner'],
    ]
)]
class Owner
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: 'integer')]
    #[Groups(['full_owner', 'lite_owner'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank, Assert\Length(max: 255)]
    #[Groups(['full_owner', 'lite_owner'])]
    private $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank, Assert\Length(max: 255)]
    #[Groups(['full_owner', 'lite_owner'])]
    private $lastName;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Assert\Type(\DateTimeInterface::class)]
    #[Groups(['full_owner'])]
    private $birthAt;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Animal::class)]
    private $animals;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthAt(): ?\DateTimeInterface
    {
        return $this->birthAt;
    }

    public function setBirthAt(?\DateTimeInterface $birthAt): self
    {
        $this->birthAt = $birthAt;

        return $this;
    }

    /**
     * @return Collection|Animal[]
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): self
    {
        if (!$this->animals->contains($animal)) {
            $this->animals[] = $animal;
            $animal->setOwner($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): self
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getOwner() === $this) {
                $animal->setOwner(null);
            }
        }

        return $this;
    }
}
