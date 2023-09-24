<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;

class HospitalController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
   
     public function index()
     {
         $hospitals = Hospital::all();
 
         $hospitalArr = [];
 
         foreach ($hospitals as $hospital) {
             $hospitalArr[] = [
                 'id' => $hospital->id,
                 'hospital_name' => $hospital->hospital_name,
                 'hospital_contact' => $hospital->hospital_contact,
                 'hospital_address' => $hospital->hospital_address,
             ];
         }
 
         return $hospitalArr;
     
     }

     
    public function store(Request $request)
    {
        $data = $request->all();

        $hospital = Hospital::create($data);

        return $hospital;
    }

    public function show($id)
    {
        $hospital = Hospital::find($id);
        if ($hospital->hospital_name != null){
            $hospitalData = [
                'id' => $hospital->id,
                'hospital_name' => $hospital->hospital_name,
                'hospital_contact' => $hospital->hospital_contact,
                'hospital_address' => $hospital->hospital_address,
            ];

            return $hospitalData;
        } else {
           
            return $hospital;
        }
    }

    public function update(Request $request, $id)
    {

        $data = $request->all();
        $hospital = Hospital::find($id);

        if (!$hospital) {
            return response()->json(['message' => 'Hospital not found'], 404);
        }

        $hospital->fill($data);
        $hospital->save();

        return $hospital; 
    }

    public function destroy($id)
    {
        $hospital = Hospital::find($id);

        if ($hospital) {
            
            $hospital->delete();
            return $hospital;
        } else {

            return response()->json(['message' => 'Hospital not found'], 404);
        }
    }
}
