<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function index()
    {
        $stations = Station::when(request('name'), function ($query, $name) {
            return $query->where('station_name', 'LIKE', '%' . $name . '%');
        })->paginate(10);

        return view('station.index', compact('stations'));
    }

    public function create()
    {
        return view('station.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'station_name' => 'required|string',
                'distance_from_central_station' => 'required|numeric',
            ],
            [],
            [
                'station_name' => 'Station Name',
                'distance_from_central_station' => 'Distance from Central Station',
            ]
        );

        $station = new Station();
        $station->station_name = $request->station_name;
        $station->distance_from_central_station = $request->distance_from_central_station;
        $station->save();

        return redirect()->route('station.index')->with('success', 'Station added successfully');
    }

    public function edit(Station $station)
    {
        return view('station.edit', compact('station'));
    }

    public function update(Station $station, Request $request)
    {
        $request->validate(
            [
                'station_name' => 'required|string',
                'distance_from_central_station' => 'required|numeric',
            ],
            [],
            [
                'station_name' => 'Station Name',
                'distance_from_central_station' => 'Distance from Central Station',
            ]
        );

        $station->station_name = $request->station_name;
        $station->distance_from_central_station = $request->distance_from_central_station;
        $station->save();

        return redirect()->route('station.index')->with('success', 'Station updated successfully');
    }

    public function destroy(Station $station)
    {
        $station->delete();
        return redirect()->route('station.index')->with('success', 'Station deleted successfully');
    }
}
