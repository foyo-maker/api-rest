<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Support\Facades\Storage;

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

      
    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->has('recipe_image')) {
            $imageData = $request->input('recipe_image');
            $imageData = base64_decode($imageData);

        // Generat a unique filename for the image
            $imageName = uniqid() . '.jpg';

            // Store the image file in a designated directory (e.g., storage/app/public/images)
            Storage::disk('public')->put('images/' . $imageName, $imageData);

            // Store the image filename in the database
            $data['recipe_image'] = $imageName;
        }
        $recipe = Recipe::create($data);

        return $recipe;
    }

    public function show($id)
    {
        $recipe = Recipe::find($id);
        if ($recipe->recipe_image != null){
            $recipe->imageUrl = asset('storage/images/' . $recipe->recipe_image);
            $recipeData = [
                'id' => $recipe->id,
                'recipe_name' => $recipe->recipe_name,
                'recipe_image' => $recipe->imageUrl,
                'recipe_description' => $recipe->recipe_description,
                'recipe_servings' => $recipe->recipe_servings,
            ];

            return $recipeData;
        } else {
           
            return $recipe;
        }
    }

    public function update(Request $request, $id)
    {

        $data = $request->all();
        $recipe = Recipe::find($id);

        if (!$recipe) {
            return response()->json(['message' => 'Recipe not found'], 404);
        }

        if ($request->has('recipe_image')) {
            $imageData = $request->input('recipe_image');
            $imageData = base64_decode($imageData);

        // Generat a unique filename for the image
            $imageName = uniqid() . '.jpg';

            // Store the image file in a designated directory (e.g., storage/app/public/images)
            Storage::disk('public')->put('images/' . $imageName, $imageData);

            // Store the image filename in the database
            $data['recipe_image'] = $imageName;
        }

        $recipe->fill($data);
        $recipe->save();

        return $recipe; 
    }

    public function destroy($id)
    {
        $recipe = Recipe::find($id);

        if ($recipe) {
            
            $recipe->delete();
            return $recipe;
        } else {
            return response()->json(['message' => 'Recipe not found'], 404);
        }
    }
}
