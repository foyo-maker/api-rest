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
}
