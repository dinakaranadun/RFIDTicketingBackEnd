<?php

namespace App\Http\Controllers;

use App\Models\Train;
use Illuminate\Http\Request;

class TrainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trains = Train::with('class')->get();
        return response()->json($trains);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'departure' => 'required|string',
            'destination' => 'required|string',
            'class' => 'required|string',
            'date' => 'required|date',
        ]);

        // Extract validated data
        $departure = $validatedData['departure'];
        $destination = $validatedData['destination'];
        $class = $validatedData['class'];
        $date = $validatedData['date'];

        // Perform the search query
        $searchedTrains = Train::where('start_station', $departure)
            ->where('end_station', $destination)
            ->where('class', $class)
            ->whereDate('departure_time', $date)
            ->get();

    
        return response()->json($searchedTrains);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
