<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipeController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
   
     public function index()
     {
         $recipes = Recipe::all();
 
         foreach ($recipes as $recipe) {
             if ($recipe->recipe_image == null) {
                 $recipe->imageUrl = null;
             } else {
                 $recipe->imageUrl = asset('storage/images/' . $recipe->recipe_image);
             }
         }
 
         $recipeArr = [];
 
         foreach ($recipes as $recipe) {
             $recipeArr[] = [
                 'id' => $recipe->id,
                 'recipe_name' => $recipe->recipe_name,
                 'recipe_image' => $recipe->imageUrl,
                 'recipe_description' => $recipe->recipe_description,
                 'recipe_servings' => $recipe->recipe_servings,
             ];
         }
 
         return $recipeArr;
     
     }
}
