<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{

    public function index()
    {
        $Events = Event::all();

        foreach ($Events as $Event) {
            if ($Event->image == null) {
                $Event->image_url = null;
            } else {
                $Event->image_url = asset('storage/images/' . $Event->image);
            }
        }

        $EventData = [];

        foreach ($Events as $Event) {
            $EventData[] = [
                'id' => $Event->id,
                'title' => $Event->title,
                'details' => $Event->details,
                'image' => $Event->image_url,
                'date' => $Event->date, 
                'address' => $Event->address,
            ];
        }

        return $EventData;
    }


    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->has('image')) {
            $imageData = $request->input('image');
            $imageData = base64_decode($imageData);

            $imageName = uniqid() . '.jpg';

            Storage::disk('public')->put('images/' . $imageName, $imageData);

            $data['image'] = $imageName;
        }
        $Event = Event::create($data);

        return $Event;
    }


    public function show($id)
    {
        $Event = Event::find($id);

        if ($Event->image != null) {
            $Event->image_url = asset('storage/images/' . $Event->image);
            $EventData = [
                'id' => $Event->id,
                'title' => $Event->title,
                'details' => $Event->details,
                'image' => $Event->image,
                'date' => $Event->date, 
                'address' => $Event->address,
            ];

            return $EventData;
        } else {
            return $Event;
        }
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();
        $Event = Event::find($id);

        if (!$Event) {
            return response()->json(['message' => 'Event not found'], 404);
        }


        if ($request->has('image')) {
            $imageData = $request->input('image');
            $imageData = base64_decode($imageData);

            $imageName = uniqid() . '.jpg';

            Storage::disk('public')->put('images/' . $imageName, $imageData);

            $data['image'] = $imageName;
        }
        
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $Event->fill($data);
        $Event->save();

        return $Event; // Use 200 for successful updates
    }


    public function destroy($id)
    {
        $Event = Event::find($id);

        if ($Event) {
            $Event->delete();

            return $Event;
        } else {
            return response()->json(['message' => 'Event not found'], 404);
        }
    }
}

