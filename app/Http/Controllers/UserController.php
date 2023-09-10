<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $users = User::all();

        // Append the image URL to each user record
        foreach ($users as $user) {
            if ($user->image == null) {
                $user->image_url = null;
            } else {
                $user->image_url = asset('storage/images/' . $user->image);
            }
        }

        // Create an array to store the modified user data
        $userData = [];

        // Iterate through the users and build the modified data array
        foreach ($users as $user) {
            $userData[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'gender' => $user->gender,
                'image' => $user->image_url, // Use the generated image URL
                'phone' => $user->phone,
                'birthdate' => $user->birthdate,
                'weight' => $user->weight,
                'height' => $user->height,
            ];
        }

        return $userData;
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
        $user = User::create($data);

        return $user;
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

        if ($user->image != null) {
            // User found, do something with $user
            $user->image_url = asset('storage/images/' . $user->image);
            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'gender' => $user->gender,
                'image' => $user->image_url, // Use the generated image URL
                'phone' => $user->phone,
                'birthdate' => $user->birthdate,
                'weight' => $user->weight,
                'height' => $user->height,
            ];

            return $userData;
        } else {
            // User not found, handle the error
            return $user;
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
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
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
        
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        // Update user data and save
        $user->fill($data);
        $user->save();

        return $user; // Use 200 for successful updates
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            // Delete the user
            $user->delete();

            // Respond with a success message or status code
            return $user;
        } else {
            // Handle the case where the user is not found
            return response()->json(['message' => 'User not found'], 404);
        }
    }
}
