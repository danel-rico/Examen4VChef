<?php

namespace App\Entity;

use App\Repository\NutrientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NutrientRepository::class)]
class Nutrient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'nutrients')]
    private ?NutrientType $nutrient_type = null;

    #[ORM\Column]
    private ?float $quantity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNutrientType(): ?NutrientType
    {
        return $this->nutrient_type;
    }

    public function setNutrientType(?NutrientType $nutrient_type): static
    {
        $this->nutrient_type = $nutrient_type;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
}
