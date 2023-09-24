<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiseaseHospital;

class DiseaseHospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
   
     public function index()
     {
         $diseaseHospitals = DiseaseHospital::all();
 
         $diseaseHospitalArr = [];
 
         foreach ($diseaseHospitals as $diseaseHospital) {
             $diseaseHospitalArr[] = [
                 'id' => $diseaseHospital->id,
                 'disease_id' => $diseaseHospital->disease_id,
                 'hospital_id' => $diseaseHospital->hospital_id,
             ];
         }
 
         return $diseaseHospitalArr;
     
     }
 
    public function store(Request $request)
    {
        $data = $request->all();
 
        $diseaseHosptial = DiseaseHospital::create($data);
 
        return $diseaseHospital;
    }
 
    public function show($id)
    {
        $diseaseHospital = DiseaseHospital::find($id);
        if ($diseaseHospital->disease_id != null){
            $diseaseHospitalData = [
                'id' => $diseaseHospital->id,
                'disease_id' => $diseaseHospital->disease_id,
                'hospital_id' => $diseaseHospital->hospital_id,
            ];
 
            return $diseaseHospitalData;
        } else {
           
            return $diseaseHospital;
        }
    }
    public function showDiseaseHospital($diseaseId)
    {
         $diseaseHospitals = DiseaseHospital::where('disease_id', $diseaseId)->get();
   
         return $diseaseHospitals;
    }
 
    public function update(Request $request, $id)
    {
 
        $data = $request->all();
        $diseaseHospital = DiseaseHospital::find($id);
 
        if (!$diseaseHospital) {
            return response()->json(['message' => 'Disease Hospital not found'], 404);
        }
 
        $diseaseHospital->fill($data);
        $diseaseHospital->save();
 
        return $diseaseHospital; 
    }
 
    public function destroy($id)
    {
        $diseaseHospital = DiseaseHospital::find($id);
 
        if ($diseaseHospital) {
            
            $diseaseHospital->delete();
            return $diseaseHospital;
        } else {
 
            return response()->json(['message' => 'Disease Hospital not found'], 404);
        }
    }
}
