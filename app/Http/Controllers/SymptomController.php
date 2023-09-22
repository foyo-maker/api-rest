<?php

namespace App\Http\Controllers;
use App\Models\Symptom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SymptomController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
   
    public function index()
    {
        $symptoms = Symptom::all();

        foreach ($symptoms as $symptom) {
            if ($symptom->symptom_image == null) {
                $symptom->imageUrl = null;
            } else {
                $symptom->imageUrl = asset('storage/images/' . $symptom->symptom_image);
            }
        }

        $SymptomArr = [];

        foreach ($symptoms as $symptom) {
            $symptomArr[] = [
                'id' => $symptom->id,
                'symptom_name' => $symptom->symptom_name,
                'symptom_image' => $symptom->imageUrl,
                'symptom_description' => $symptom->symptom_description,
            ];
        }

        return $symptomArr;
    
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

        if ($request->has('image')) {
            $imageData = $request->input('image');
            $imageData = base64_decode($imageData);

        // Generat a unique filename for the image
            $imageName = uniqid() . '.jpg';

            // Store the image file in a designated directory (e.g., storage/app/public/images)
            Storage::disk('public')->put('images/' . $imageName, $imageData);

            // Store the image filename in the database
            $data['image'] = $imageName;
        }
        $symptom = Symptom::create($data);

        return $symptom;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $symptom = Symptom::find($id);

        if ($symptom->image != null) {
            // Symptom found, do something with $symptom
            $symptom->imageUrl = asset('storage/images/' . $symptom->symptom_image);
            $symptomData = [
                'id' => $symptom->id,
                'symptom_name' => $symptom->symptom_name,
                'symptom_image' => $symptom->imageUrl,
                'symptom_description' => $symptom->symptom_description,
            ];

            return $symptomData;
        } else {
            // User not found, handle the error
            return $symptom;
        }
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
        $data = $request->all();
        $symptom = Symptom::find($id);

        if (!$symptom) {
            return response()->json(['message' => 'Symptom not found'], 404);
        }

        if ($request->has('image')) {
            $imageData = $request->input('image');
            $imageData = base64_decode($imageData);

        // Generat a unique filename for the image
            $imageName = uniqid() . '.jpg';

            // Store the image file in a designated directory (e.g., storage/app/public/images)
            Storage::disk('public')->put('images/' . $imageName, $imageData);

            // Store the image filename in the database
            $data['image'] = $imageName;
        }

        // Update user data and save
        $symptom->fill($data);
        $symptom->save();

        return $symptom; // Use 200 for successful updates
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $symptom = Symptom::find($id);

        if ($symptom) {
            // Delete the symptom
            $symptom->delete();

            // Respond with a success message or status code
            return $symptom;
        } else {
            // Handle the case where the symptom is not found
            return response()->json(['message' => 'Symptom not found'], 404);
        }
    }

}
