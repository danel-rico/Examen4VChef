<?php

namespace App\Entity;

use App\Repository\NutrientTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NutrientTypeRepository::class)]
class NutrientType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $unit = null;

    /**
     * @var Collection<int, Nutrient>
     */
    #[ORM\OneToMany(targetEntity: Nutrient::class, mappedBy: 'nutrient_type')]
    private Collection $nutrients;

    public function __construct()
    {
        $this->nutrients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * @return Collection<int, Nutrient>
     */
    public function getNutrients(): Collection
    {
        return $this->nutrients;
    }

    public function addNutrient(Nutrient $nutrient): static
    {
        if (!$this->nutrients->contains($nutrient)) {
            $this->nutrients->add($nutrient);
            $nutrient->setNutrientType($this);
        }

        return $this;
    }

    public function removeNutrient(Nutrient $nutrient): static
    {
        if ($this->nutrients->removeElement($nutrient)) {
            // set the owning side to null (unless already changed)
            if ($nutrient->getNutrientType() === $this) {
                $nutrient->setNutrientType(null);
            }
        }

        return $this;
    }
}
