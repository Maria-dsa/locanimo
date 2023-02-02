<?php

namespace App\Entity;

use DateTimeInterface;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[Vich\Uploadable]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $breed = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $age = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $poster = null;

    #[Vich\UploadableField(mapping: 'poster_file', fileNameProperty: 'poster')]
    private ?File $posterFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DatetimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    private ?Species $species = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    private ?User $owner = null;

    #[ORM\OneToMany(mappedBy: 'animal', targetEntity: Availablity::class)]
    private Collection $availablities;

    #[ORM\OneToMany(mappedBy: 'animal', targetEntity: ScheduleRental::class)]
    private Collection $scheduleRentals;

    public function __construct()
    {
        $this->availablities = new ArrayCollection();
        $this->scheduleRentals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBreed(): ?string
    {
        return $this->breed;
    }

    public function setBreed(?string $breed): self
    {
        $this->breed = $breed;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(?string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getPosterFile(): ?File
    {
        return $this->posterFile;
    }

    public function setPosterFile(File $image = null): Animal
    {
        $this->posterFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    public function getUpdatedAt(): ?DatetimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DatetimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, Availablity>
     */
    public function getAvailablities(): Collection
    {
        return $this->availablities;
    }

    public function addAvailablity(Availablity $availablity): self
    {
        if (!$this->availablities->contains($availablity)) {
            $this->availablities->add($availablity);
            $availablity->setAnimal($this);
        }

        return $this;
    }

    public function removeAvailablity(Availablity $availablity): self
    {
        if ($this->availablities->removeElement($availablity)) {
            // set the owning side to null (unless already changed)
            if ($availablity->getAnimal() === $this) {
                $availablity->setAnimal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ScheduleRental>
     */
    public function getScheduleRentals(): Collection
    {
        return $this->scheduleRentals;
    }

    public function addScheduleRental(ScheduleRental $scheduleRental): self
    {
        if (!$this->scheduleRentals->contains($scheduleRental)) {
            $this->scheduleRentals->add($scheduleRental);
            $scheduleRental->setAnimal($this);
        }

        return $this;
    }

    public function removeScheduleRental(ScheduleRental $scheduleRental): self
    {
        if ($this->scheduleRentals->removeElement($scheduleRental)) {
            // set the owning side to null (unless already changed)
            if ($scheduleRental->getAnimal() === $this) {
                $scheduleRental->setAnimal(null);
            }
        }

        return $this;
    }
}