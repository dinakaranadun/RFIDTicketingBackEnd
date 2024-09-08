<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Station;
use App\Models\StationRoute;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::when(request('name'), function ($query, $name) {
            return $query->where('name', 'LIKE', '%' . $name . '%');
        })->paginate(10);
       

        return view('route.index', compact('routes'));
    }

    public function create()
    {
        $stations = Station::all();
        return view('route.create', compact('stations'));
    }

    public function store(Request $request)
    {
       
        $request->validate(
            [
                'name' => 'required|string',
                'stations' => 'required|array',
                'stations.*' => 'required|distinct|exists:station,id',
            ],
            [],
            [
                'name' => 'Route Name',
                'stations' => 'Stations',
                'stations.*' => 'Station',
            ]
        );

        $route = new Route();
        $route->name = $request->name;
        $route->save();

        foreach ($request->stations as $key => $station) {
            $route_station = new StationRoute();
            $route_station->route_id = $route->id;
            $route_station->station_id = $station;
            $route_station->order = $key;
            $route_station->save();
        }

        return redirect()->route('route.index')->with('success', 'Route added successfully');
    }

    public function edit(Route $route)
    {
        
        $stations = Station::all();
        return view('route.edit', compact('route', 'stations'));
    }

    public function update(Route $route, Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string',
                'stations' => 'required|array',
                'stations.*' => 'required|distinct|exists:station,id',
            ],
            [],
            [
                'name' => 'Route Name',
                'stations' => 'Stations',
                'stations.*' => 'Station',
            ]
        );

        $route->name = $request->name;
        $route->save();

        StationRoute::where('route_id', $route->id)->delete();
        foreach ($request->stations as $key => $station) {
            $route_station = new StationRoute();
            $route_station->route_id = $route->id;
            $route_station->station_id = $station;
            $route_station->order = $key;
            $route_station->save();
        }

        return redirect()->route('route.index')->with('success', 'Route updated successfully');
    }

    public function destroy(Route $route)
    {
        StationRoute::where('route_id', $route->id)->delete();
        $route->delete();
        return redirect()->route('route.index')->with('success', 'Route deleted successfully');
    }
}
