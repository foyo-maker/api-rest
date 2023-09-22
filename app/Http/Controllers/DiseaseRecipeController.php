<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiseaseRecipe;

class DiseaseRecipeController extends Controller
{
    public function index()
    {
        $diseases = DiseaseRecipe::all();
   
        $diseaseArr = [];

        foreach ($diseases as $disease) {
            $diseaseArr[] = [
                'id' => $disease->id,
                'disease_id' => $disease->disease_id,
                'recipe_id' => $disease->recipe_id,
            ];
        }

        return $diseaseArr;
    
    }
}
