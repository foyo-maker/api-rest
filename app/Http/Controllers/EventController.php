<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
class EventController extends Controller
{

    // public function index()
    // {
    //     $events = Event::with('user')->get();
    
    //     $eventData = $events->map(function ($event) {
    //         return [
    //             'id' => $event->id,
    //             'title' => $event->title,
    //             'details' => $event->details,
    //             'image' => $event->image_url,
    //             'date' => $event->date, 
    //             'address' => $event->address,
    //             'user' => [
    //                 'id' => $event->user->id,
    //                 'name' => $event->user->name,
    //                 'email' => $event->user->email,
    //             ],
    //         ];
    //     });
    
    //     return $eventData;
    // }

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
                "status"=>$Event->status,
                'user_id'=>$Event->user_id
            ];
        }
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $output->writeln($Event);
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
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $output->writeln($Event);
        return $Event;
    }


    // public function show($id)
    // {
    //     $event = Event::with('user')->find($id);
    
    //     if ($event->image != null) {
    //         $event->image_url = asset('storage/images/' . $event->image);
    //     }
    
    //     return $event;
    // }
    
    
    public function show($id)
    {
        $event = Event::find($id);
    
        if ($event->image != null) {
            $event->image_url = asset('storage/images/' . $event->image);
            $eventData = [
                'id' => $event->id,
                'title' => $event->title,
                'details' => $event->details,
                'image' => $event->image_url,
                'date' => $event->date,
                'address' => $event->address,
                'status' => $event->status,
                'user_id' => $event->user_id
            ];
    
            return $eventData;
        } else {
            return $event;
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

