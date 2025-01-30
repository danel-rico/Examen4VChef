<?php

namespace App\Services;

use App\Repository\RecipeRepository;
use App\Entity\Recipe;
use App\Entity\Step;
use App\Entity\Ingredient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RecipeService
{
    private RecipeRepository $recipeRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, RecipeRepository $recipeRepository)
    {
        $this->entityManager = $entityManager;
        $this->recipeRepository = $recipeRepository;
    }

    public function getRecipes(): JsonResponse
    {
        $recipes = $this->recipeRepository->findAll();

        if (!$recipes) {
            return new JsonResponse(['message' => 'No recipes found'], Response::HTTP_NOT_FOUND);
        }

        $data = array_map(fn($recipe) => $this->formatRecipe($recipe), $recipes);

        return new JsonResponse($data);
        
    }
    private function formatRecipe($recipe): array
    {
        return [
            'id' => $recipe->getId(),
            'title' => $recipe->getTitle(),
            'servings' => $recipe->getNComensales(),
            'steps' => array_map(fn($step) => [
                'id' => $step->getId(),
                'description' => $step->getDescription()
            ], $recipe->getSteps()->toArray()),
            'ingredients' => array_map(fn($ingredient) => [
                'id' => $ingredient->getId(),
                'name' => $ingredient->getName(),
                'quantity' => $ingredient->getQuantity()
            ], $recipe->getIngredients()->toArray()),
        ];
    }

    
    public function createRecipe(array $data): JsonResponse
    {
        if (!isset($data['title'], $data['number-diner'], $data['ingredients'], $data['steps'])) {
            return new JsonResponse(['message' => 'Invalid request data'], Response::HTTP_BAD_REQUEST);
        }

        $recipe = new Recipe();
        $recipe->setTitle($data['title']);
        $recipe->setNComensales($data['number-diner']);

        // Agregar ingredientes
        foreach ($data['ingredients'] as $ingredientData) {
            if (!isset($ingredientData['name'], $ingredientData['quantity'], $ingredientData['unit'])) {
                continue;
            }

            $ingredient = new Ingredient();
            $ingredient->setName($ingredientData['name']);
            $ingredient->setQuantity($ingredientData['quantity']);
            $ingredient->setUnit($ingredientData['unit']);
            $ingredient->setRecipe($recipe);

            $this->entityManager->persist($ingredient);
        }

        // Agregar pasos
        foreach ($data['steps'] as $stepData) {
            if (!isset($stepData['order'], $stepData['description'])) {
                continue;
            }

            $step = new Step();
            $step->setNStep($stepData['order']);
            $step->setDescription($stepData['description']);
            $step->setRecipe($recipe);

            $this->entityManager->persist($step);
        }

        // Guardar en la BD
        $this->entityManager->persist($recipe);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Recipe created successfully'], Response::HTTP_CREATED);
    }
}