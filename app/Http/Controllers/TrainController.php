<?php

namespace App\Http\Controllers;

use App\Models\Train;
use App\Models\Station;
use App\Models\Scheduale;
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
        // Validate 
        $validatedData = $request->validate([
            'departure' => 'required|string',
            'destination' => 'required|string',
            'class' => 'required|string',
            'date' => 'required|date',
        ]);

    
        $departure = $validatedData['departure'];
        $destination = $validatedData['destination'];
        $travelClass = $validatedData['class'];
        $date = $validatedData['date'];

        
        $departureStationId = Station::where('station_name', $departure)->value('id');
        $destinationStationId = Station::where('station_name', $destination)->value('id');

        
        $commonTrainIds = Scheduale::where('station_id', $departureStationId)
            ->whereIn('train_id', function ($query) use ($destinationStationId) {
                $query->select('train_id')
                    ->from('schedule')
                    ->where('station_id', $destinationStationId);
            })
            ->pluck('train_id');

        $trains = Train::select('train.*', 'schedule.arrival_time', 'schedule.departure_time', 'schedule.station_id as departure_station_id', 'station.station_name as departure_station_name', 'dst_station.station_name as destination_station_name', 'dst_station.id as destination_station_id')
        ->join('schedule', 'train.id', '=', 'schedule.train_id')
        ->join('station', 'schedule.station_id', '=', 'station.id')
        ->join('train_class', 'train.id', '=', 'train_class.train_id')
        ->join('schedule as dst_schedule', 'train.id', '=', 'dst_schedule.train_id')
        ->join('station as dst_station', 'dst_schedule.station_id', '=', 'dst_station.id')
        ->with([
            'startStation' => function ($query) {
                $query->select('id', 'station_name');
            },
            'endStation' => function ($query) {
                $query->select('id', 'station_name');
            }
        ])
        ->whereIn('schedule.train_id', $commonTrainIds)
        ->where('train_class.class', $travelClass)
        ->where('schedule.station_id', $departureStationId)
        ->where('dst_schedule.station_id', $destinationStationId)
        // ->whereDate('schedule.departure_time', $date)
        ->get();
        return response()->json($trains);
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
