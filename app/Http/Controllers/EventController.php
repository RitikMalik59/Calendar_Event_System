<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Resources\EventCollection;
use App\Http\Resources\EventResource;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $events = Event::all();
        $start = $request->get('start');
        $end = $request->get('end');
        // dd($start);
        // $query = Event::whereDate('start_date', '>=', $start)->get();
        $query = Event::whereBetween('start_date', [$start, $end])->get();
        // dd($query);
        $events = EventResource::collection($query);
        return response()->json($events);
        // return response()->json(EventResource::collection(Event::all()));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'title' => 'required',
        //     'description' => 'required|email',
        // ]);
        $data = $request->all();
        // dd($data);
        $event = Event::create($data);
        return response()->json($event);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id, Event $event)
    {
        // echo $id;
        // dd($request);
        $delete_event = Event::find($id);
        // dd($delete_event);
        $delete_event->delete();
        return response()->json($delete_event);
    }
}
