<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PersonalizedWorkoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $workout = Workout::create($data);

        return $workout;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
    
        // Check if the user exists
        if (!$user) {
            return response(['message' => 'User not found'], 404);
        }
    
        $heightInMeters = $user->height / 100.0; // Calculate height in meters
        $bmi = $user->weight / ($heightInMeters * $heightInMeters); // Calculate BMI
    
        $workoutData = []; // Initialize the workout data array
    
        if ($bmi < 18.5) {
            $workouts = Workout::where('bmi_status', 'Underweight')->limit(5)->get();
        } elseif ($bmi < 25.0) {
            $workouts = Workout::where('bmi_status', 'Healthy')->limit(5)->get();
        } elseif ($bmi < 30.0) {
            $workouts = Workout::where('bmi_status', 'Overweight')->limit(5)->get();
        } else {
            $workouts = Workout::where('bmi_status', 'Obese')->limit(5)->get();
        }
    
        // Call the function to generate the modified workout data array
        $workoutData = $this->returnWorkoutData($workouts);
    
        return $workoutData;
    }
    
    public function returnWorkoutData($workouts)
    {
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
