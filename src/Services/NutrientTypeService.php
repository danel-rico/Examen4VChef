<?php
namespace App\Services;

use App\Entity\NutrientType;
use Doctrine\ORM\EntityManagerInterface;

class NutrientTypeService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllNutrientTypes(): array
    {
        $nutrientTypes = $this->entityManager->getRepository(NutrientType::class)->findAll();

        $data = [];
        foreach ($nutrientTypes as $nutrientType) {
            $data[] = [
                'id' => $nutrientType->getId(),
                'name' => $nutrientType->getName(),
                'unit' => $nutrientType->getUnit(),
            ];
        }

        return $data;
    }
}
