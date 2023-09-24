<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiseaseRecipe;

class DiseaseRecipeController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
   
     public function index()
     {
         $diseaseRecipes = DiseaseRecipe::all();
 
         $diseaseRecipeArr = [];
 
         foreach ($diseaseRecipes as $diseaseRecipe) {
             $diseaseRecipeArr[] = [
                 'id' => $diseaseRecipe->id,
                 'disease_id' => $diseaseRecipe->disease_id,
                 'recipe_id' => $diseaseRecipe->recipe_id,
             ];
         }
 
         return $diseaseRecipeArr;
     
     }
 
    public function store(Request $request)
    {
        $data = $request->all();
 
        $diseaseRecipe = DiseaseRecipe::create($data);
 
        return $diseaseRecipe;
    }
 
    public function show($id)
    {
        $diseaseRecipe = DiseaseRecipe::find($id);
        if ($diseaseRecipe->disease_id != null){
            $diseaseRecipeData = [
                'id' => $diseaseRecipe->id,
                'disease_id' => $diseaseRecipe->disease_id,
                'recipe_id' => $diseaseRecipe->recipe_id,
            ];
 
            return $diseaseRecipeData;
        } else {
           
            return $diseaseRecipe;
        }
    }
    public function showDiseaseRecipe($diseaseId)
    {
         $diseaseRecipes = DiseaseRecipe::where('disease_id', $diseaseId)->get();
   
         return $diseaseRecipes;
    }
 
    public function update(Request $request, $id)
    {
 
        $data = $request->all();
        $diseaseRecipe = DiseaseRecipe::find($id);
 
        if (!$diseaseRecipe) {
            return response()->json(['message' => 'Disease Recipe not found'], 404);
        }
 
        $diseaseRecipe->fill($data);
        $diseaseRecipe->save();
 
        return $diseaseRecipe; 
    }
 
    public function destroy($id)
    {
        $diseaseRecipe = DiseaseRecipe::find($id);
 
        if ($diseaseRecipe) {
            
            $diseaseRecipe->delete();
            return $diseaseRecipe;
        } else {
            return response()->json(['message' => 'Disease Recipe not found'], 404);
        }
    }
}
