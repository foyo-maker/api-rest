<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Disease;
use Illuminate\Support\Facades\Validator;

class DiseaseController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
   
     public function index()
     {
         $diseases = Disease::all();
 
         foreach ($diseases as $disease) {
             if ($disease->disease_image == null) {
                 $disease->imageUrl = null;
             } else {
                 $disease->imageUrl = asset('storage/images/' . $disease->disease_image);
             }
         }
    
         $diseaseArr = [];
 
         foreach ($diseases as $disease) {
             $diseaseArr[] = [
                 'id' => $disease->id,
                 'disease_name' => $disease->disease_name,
                 'disease_image' => $disease->imageUrl,
                 'disease_causes' => $disease->disease_causes,
                 'disease_description' => $disease->disease_description,
             ];
         }
 
         return $diseaseArr;
     
     }
     
 
}
