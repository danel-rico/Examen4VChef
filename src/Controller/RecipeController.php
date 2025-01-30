<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Services\RecipeService;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Attribute\Route;

final class RecipeController extends AbstractController
{
    private RecipeService $recipeService;

    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }

    #[Route('/recipes', methods: ['GET'])]
    public function searchRecipes(SerializerInterface $serializer): JsonResponse
    {
        return $this->recipeService->getRecipes();    
    }
    

    #[Route('/recipes', name: 'create', methods: ['POST'])]
    public function createRecipe(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        return $this->recipeService->createRecipe($data);
    }
}
