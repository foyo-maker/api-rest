<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\User;
use App\Models\EventParticipants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventParticipantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     return EventParticipants::all();
    // }

    public function index(Request $request)
    {
        // Retrieve the user_id from the request query parameters.
        $userId = $request->input('user_id');
        
        $events = Event::join('event_participants', 'events.id', '=', 'event_participants.event_id')
            ->select('events.*')
            ->get();
        
        foreach ($events as $event) {
            if ($event->image == null) {
                $event->image_url = null;
            } else {
                $event->image_url = asset('storage/images/' . $event->image);
            }
        }
    
        $eventData = [];
    
        foreach ($events as $event) {
            $eventData[] = [
                'id' => $event->id,
                'title' => $event->title,
                'details' => $event->details,
                'image' => $event->image_url,
                'date' => $event->date,
                'address' => $event->address,
                'status' => $event->status,
                'user_id' => $event->user_id
            ];
        }
    
        return response()->json($eventData, 200);
    }

    public function displayUserHaventPart($user_id)
    {
        $events = Event::whereDoesntHave('participants', function ($query) use ($user_id) {
            $query->where('user_id', '=', $user_id);
        })->get();
    
        foreach ($events as $event) {
            if ($event->image == null) {
                $event->image_url = null;
            } else {
                $event->image_url = asset('storage/images/' . $event->image);
            }
        }
    
        $eventData = [];
    
        foreach ($events as $event) {
            $eventData[] = [
                'id' => $event->id,
                'title' => $event->title,
                'details' => $event->details,
                'image' => $event->image_url,
                'date' => $event->date,
                'address' => $event->address,
                'status' => $event->status,
                'user_id' => $event->user_id
            ];
        }
    
        return response()->json($eventData, 200);
    }   

    public function updateEventStatus($user_id)
    {
        $events = Event::join('event_participants', 'events.id', '=', 'event_participants.event_id')
            ->where('event_participants.user_id', '=', $user_id)
            ->select('events.*')
            ->get();
    
        foreach ($events as $event) {
            if ($event->image == null) {
                $event->image_url = null;
            } else {
                $event->image_url = asset('storage/images/' . $event->image);
            }
        }
    
        if ($events->isEmpty()) {
            // Handle the case where no events are found for the user
            return response()->json(['message' => 'No events found for the user'], 404);
        }
    
        $eventData = [];
    
        foreach ($events as $event) {
            $eventData[] = [
                'id' => $event->id,
                'title' => $event->title,
                'details' => $event->details,
                'image' => $event->image_url,
                'date' => $event->date,
                'address' => $event->address,
                'status' => $event->status,
                'user_id' => $event->user_id
            ];
        }
    
        return response()->json($eventData, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'event_id' => 'required', 
        ]);
    
        $eventParticipant = EventParticipants::create([
            'user_id' => $validatedData['user_id'],
            'event_id' => $validatedData['event_id'], 
        ]);
    
        if ($eventParticipant) {
            return response()->json(['message' => 'Event participant created successfully'], 201);
        } else {
            return response()->json(['message' => 'Failed to create event participant'], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventParticipants  $eventParticipants
     * @return \Illuminate\Http\Response
     */
    public function show(EventParticipants $eventParticipant)
    {
        return $eventParticipant;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventParticipants  $eventParticipants
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventParticipants $eventParticipant)
    {
        $data = $request->validate([
            // Define validation rules for your data here
        ]);

        $eventParticipant->update($data);

        return response($eventParticipant, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventParticipants  $eventParticipants
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $EventParticipant = EventParticipants::find($id);
        if ($EventParticipant) {
            $EventParticipant->delete();

            return $EventParticipant;
        } else {
            return response()->json(['message' => 'Event not found'], 404);
        }
    }

    public function destroySpecific($event_id, $user_id)
    {
        $eventParticipant = EventParticipants::where('event_id', $event_id)
            ->where('user_id', $user_id)
            ->first();

            $eventParticipant->delete();
            return response($eventParticipant, 200);
    }

    public function getEventParticipantsCount($event_id)
{
    $count = EventParticipants::where('event_id', $event_id)->count();

    return response()->json($count, 200);
}

}    
