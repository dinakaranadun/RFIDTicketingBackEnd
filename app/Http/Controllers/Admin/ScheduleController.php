<?php

namespace App\Http\Controllers\Admin;
use App\Models\Train;
use App\Models\Station;
use App\Models\Scheduale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ScheduleController extends Controller
{
    public function index(){
        $trains = Train::when(request('name'), function ($query, $name) {
            return $query->where('name', 'LIKE', '%' . $name . '%');
        })->paginate(10);
       
        return view('schedule.index', compact('trains'));
        
        
    }

    public function create(){
        $stations = Station::all();
        $trains = Train::all();
        return view('schedule.create', compact('stations','trains'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'train' => 'required|integer', 
                'stations' => 'required|array', 
                'arrival_times' => 'required|array', 
                'departure_times' => 'required|array', 
                'arrival_times.*' => 'required|date_format:H:i', 
                'departure_times.*' => 'required|date_format:H:i',
            ],
            [],
            [
                'train' => 'Train',
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
            $schedule->save();
        }

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
    
        return view('schedule.edit', compact('schedules', 'trains', 'stations', 'id'));
    }

    public function update(Request $request, $id)
    {


        $request->validate(
            [
                'stations' => 'required|array', 
                'arrival_times' => 'required|array', 
                'departure_times' => 'required|array', 
                'arrival_times.*' => 'required|date_format:H:i:s', 
                'departure_times.*' => 'required|date_format:H:i:s',
            ],
            [],
            [
                'stations' => 'Stations',
                'arrival_times.*' => 'Arrival Time',
                'departure_times.*' => 'Departure Time',
            ]
        );


        
        Scheduale::where('train_id', $id)->delete();

        
        foreach($request->stations as $key => $station) {
            $schedule = new Scheduale();
            $schedule->train_id = $id;
            $schedule->station_id = $station;
            $schedule->arrival_time = $request->arrival_times[$key]; 
            $schedule->departure_time = $request->departure_times[$key]; 
            $schedule->save();
        }

        return redirect()->route('schedule.index')->with('success', 'Schedule updated successfully');
    }

    public function destroy($id){
        Scheduale::where('train_id', $id)->delete();
        return redirect()->route('schedule.index')->with('success', 'Schedule deleted successfully');
    }

}
