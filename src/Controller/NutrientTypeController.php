<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\NutrientTypeService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NutrientTypeController extends AbstractController
{
    private NutrientTypeService $nutrientTypeService;

    public function __construct(NutrientTypeService $nutrientTypeService)
    {
        $this->nutrientTypeService = $nutrientTypeService;
    }
    #[Route('/nutrient-types', name: 'get_nutrient_types', methods: ['GET'])]
    public function getNutrientTypes(): JsonResponse
    {
        $data = $this->nutrientTypeService->getAllNutrientTypes();
        return $this->json($data);
    }
}
