<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Disease;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
    
    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->has('disease_image')) {
            $imageData = $request->input('disease_image');
            $imageData = base64_decode($imageData);

      
            $imageName = uniqid() . '.jpg';

            Storage::disk('public')->put('images/' . $imageName, $imageData);

            $data['disease_image'] = $imageName;
        }
        $disease = Disease::create($data);

        return $disease;
    }

    public function show($id)
    {
        $disease = Disease::find($id);
        if ($disease->disease_image != null){
            $disease->imageUrl = asset('storage/images/' . $disease->disease_image);
            $diseaseData = [
                'id' => $disease->id,
                'disease_name' => $disease->disease_name,
                'disease_image' => $disease->imageUrl,
                'disease_causes' => $disease->disease_causes,
                'disease_description' => $disease->disease_description,
            ];

            return $diseaseData;
        } else {
           
            return $disease;
        }
    }

    public function update(Request $request, $id)
    {

        $data = $request->all();
        $disease = Disease::find($id);

        if (!$disease) {
            return response()->json(['message' => 'Disease not found'], 404);
        }

        if ($request->has('disease_image')) {
            $imageData = $request->input('disease_image');
            $imageData = base64_decode($imageData);

            $imageName = uniqid() . '.jpg';

            Storage::disk('public')->put('images/' . $imageName, $imageData);

            $data['disease_image'] = $imageName;
        }

        $disease->fill($data);
        $disease->save();

        return $disease; 
    }

    public function destroy($id)
    {
        $disease = Disease::find($id);

        if ($disease) {
            
            $disease->delete();
            return $disease;
        } else {
            return response()->json(['message' => 'Disease not found'], 404);
        }
    }
 
}
