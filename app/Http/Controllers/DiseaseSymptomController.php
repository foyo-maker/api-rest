<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\DiseaseSymptom;

class DiseaseSymptomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
   
    public function index()
    {
        $diseaseSymptoms = DiseaseSymptom::all();

        $diseaseSymptomArr = [];

        foreach ($diseaseSymptoms as $diseaseSymptom) {
            $diseaseSymptomArr[] = [
                'id' => $diseaseSymptom->id,
                'disease_id' => $diseaseSymptom->disease_id,
                'symptom_id' => $diseaseSymptom->symptom_id,
            ];
        }

        return $diseaseSymptomArr;
    
    }

   public function store(Request $request)
   {
       $data = $request->all();

       $diseaseSymptom = DiseaseSymptom::create($data);

       return $diseaseSymptom;
   }

   public function show($id)
   {
       $diseaseSymptom = DiseaseSymptom::find($id);
       if ($diseaseSymptom->disease_id != null){
           $diseaseSymptomData = [
               'id' => $diseaseSymptom->id,
               'disease_id' => $diseaseSymptom->disease_id,
               'symptom_id' => $diseaseSymptom->symptom_id,
           ];

           return $diseaseSymptomData;
       } else {
          
           return $diseaseSymptom;
       }
   }
   public function showDiseaseSymptom($diseaseId)
   {
        $diseaseSymptoms = DiseaseSymptom::where('disease_id', $diseaseId)->get();
  
        return $diseaseSymptoms;
   }

   public function showSymptomDisease($symptomId)
   {
        $symptomDiseases = DiseaseSymptom::where('symptom_id', $symptomId)->get();
  
        return $symptomDiseases;
   }


   public function update(Request $request, $id)
   {

       $data = $request->all();
       $diseaseSymptom = DiseaseSymptom::find($id);

       if (!$diseaseSymptom) {
           return response()->json(['message' => 'Disease Symptom not found'], 404);
       }

       $diseaseSymptom->fill($data);
       $diseaseSymptom->save();

       return $diseaseSymptom; 
   }

   public function destroy($id)
   {
       $diseaseSymptom = DiseaseSymptom::find($id);

       if ($diseaseSymptom) {
           
           $diseaseSymptom->delete();
           return $diseaseSymptom;
       } else {

           return response()->json(['message' => 'Disease Symptom not found'], 404);
       }
   }
}
