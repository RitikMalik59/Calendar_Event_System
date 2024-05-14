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
        // $query = Event::whereDate('start_date', $start)->dd();
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
        //
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
    public function destroy(Event $event)
    {
        //
    }
}
