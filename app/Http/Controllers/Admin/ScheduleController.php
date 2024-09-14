<?php

namespace App\Http\Controllers\Admin;
use App\Models\Route;
use App\Models\Train;
use App\Models\Station;
use App\Models\Scheduale;
use App\Models\TrainRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;


class ScheduleController extends Controller
{
    public function index(){
        $trains = Train::when(request('name'), function ($query, $name) {
            return $query->where('name', 'LIKE', '%' . $name . '%');
        })
        ->with('routes') 
        ->paginate(10);
    
        return view('schedule.index', compact('trains'));
    }
    

    public function create(){
        $stations = Station::all();
        $trains = Train::all();
        $routes = Route::all();
        return view('schedule.create', compact('stations','trains','routes'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'train' => 'required|integer', 
                'route' => 'required|integer',
                'stations' => 'required|array', 
                'arrival_times' => 'required|array', 
                'departure_times' => 'required|array', 
                'arrival_times.*' => 'required|date_format:H:i', 
                'departure_times.*' => 'required|date_format:H:i',
                
            ],
            [],
            [
                'train' => 'Train',
                'route' => 'Route',
                'stations' => 'Stations',
                'arrival_times.*' => 'Arrival Time',
                'departure_times.*' => 'Departure Time',
            ]
        );

        
        foreach($request->stations as $key => $station) {
            $schedule = new Scheduale();
            $schedule->train_id = $request->train;
            $schedule->station_id = $station;
            $schedule->arrival_time = $request->arrival_times[$key]; 
            $schedule->departure_time = $request->departure_times[$key]; 
            $schedule->order = $key;
            $schedule->save();
        }
        
        $train_route= new TrainRoute();
        $train_route->train_id = $request->train;
        $train_route->route_id = $request->route;
        $train_route->save();

        return redirect()->route('schedule.index')->with('success', 'Schedule added successfully');
    }

    public function edit($id)
    {
        $schedules = Scheduale::with(['train', 'station'])
            ->where('train_id', $id)
            ->orderBy('station_id')
            ->get();

        $trains = Train::all();
        $stations = Station::all();

        // Get the routes assigned to this train
        $train = Train::with('routes')->find($id);
        $routes = Route::all(); // Get all routes for dropdown

        return view('schedule.edit', compact('schedules', 'trains', 'stations', 'routes', 'train', 'id'));
    }

    public function update(Request $request, $id)
    {
       
        $request->validate(
            [
                'route' => 'required',
                'stations' => 'required|array',
                'arrival_times' => 'required|array',
                'departure_times' => 'required|array',
                'arrival_times.*' => 'required|valid_time',
                'departure_times.*' => 'required|valid_time',
            ],
            [],
            [
                'route' => 'Route',
                'stations' => 'Stations',
                'arrival_times.*' => 'Arrival Time',
                'departure_times.*' => 'Departure Time',
            ]
        );

        $train = Train::find($id);
        $train->routes()->sync([$request->route]);
        Scheduale::where('train_id', $id)->delete();

        foreach ($request->stations as $key => $station) {
            $schedule = new Scheduale();
            $schedule->train_id = $id;
            $schedule->station_id = $station;
            $schedule->arrival_time = $request->arrival_times[$key];
            $schedule->departure_time = $request->departure_times[$key];
            $schedule->order = $key;
            $schedule->save();
        }
        


        return redirect()->route('schedule.index')->with('success', 'Schedule updated successfully');
    }


    public function destroy($id){
        Scheduale::where('train_id', $id)->delete();
        return redirect()->route('schedule.index')->with('success', 'Schedule deleted successfully');
    }

}
