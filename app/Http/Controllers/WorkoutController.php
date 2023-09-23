<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Support\Facades\Storage;
class WorkoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $workouts = Workout::all();
      
        $workoutData = [];
    
        // Iterate through the workouts and build the modified data array
        foreach ($workouts as $workout) {
            $gifUrl = null;
    
            // Check if the GIF image exists for the workout
            if ($workout->gifimage) {
                // Generate a URL to serve the GIF file
                $gifUrl = asset('storage/images/' . $workout->gifimage);
            }
    
            $workoutData[] = [
                'id' => $workout->id,
                'name' => $workout->name,
                'description' => $workout->description,
                'gifimage' => $gifUrl, // Use the generated GIF URL
                'calorie' => $workout->calorie,
                'link' => $workout->link,
                'bmi_status' => $workout->bmi_status,
                // Add any other fields you need for the Workout entity here
            ];
        }
    
        return $workoutData;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $workout = Workout::find($id);
      

            $gifUrl = null;
    
            // Check if the GIF image exists for the workout
            if ($workout->gifimage) {
                // Generate a URL to serve the GIF file
                $gifUrl = asset('storage/images/' . $workout->gifimage);
            }
    
            $workoutData = [
                'id' => $workout->id,
                'name' => $workout->name,
                'description' => $workout->description,
                'gifimage' => $gifUrl, // Use the generated GIF URL
                'calorie' => $workout->calorie,
                'link' => $workout->link,
                'bmi_status' => $workout->bmi_status,
                // Add any other fields you need for the Workout entity here
            ];
        
    
        return $workoutData;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $workout = Workout::find($id);
        $data = $request->all();

        if ($request->has('gifimage')) {
            $imageData = $request->input('gifimage');
            $imageData = base64_decode($imageData);

            // Generate a unique filename for the GIF
            $imageName = uniqid() . '.gif';

            // Store the GIF file in a designated directory (e.g., storage/app/public/images)
            Storage::disk('public')->put('images/' . $imageName, $imageData);

            // Store the GIF filename in the database
            $data['gifimage'] = $imageName;
        }

        // Create your Workout or User instance with the updated $data array
        // Replace 'Workout' with your actual model class name
      // Update user data and save
      $workout->fill($data);
      $workout->save();

      return $workout; // Use 200 for successful updates

     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
   
    $workout = Workout::find($id);

        if ($workout) {
            // Delete the user
            $workout->delete();

            // Respond with a success message or status code
            return $workout;
        } else {
            // Handle the case where the user is not found
            return response()->json(['message' => 'User not found'], 404);
        }
    }

}