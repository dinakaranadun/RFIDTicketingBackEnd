<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\Train;
use App\Models\TrainClass;
use Illuminate\Http\Request;

class TrainController extends Controller
{
    public function index()
    {
        $trains = Train::when(request('name'), function ($query, $name) {
            return $query->where('name', 'LIKE', '%' . $name . '%');
        })->with('startStation', 'endStation')->paginate(10);
        return view('train.index', compact('trains'));
    }

    public function create()
    {
        $stations = Station::all();
        return view('train.create', compact('stations'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string',
                'start_station' => 'required|exists:station,id',
                'end_station' => 'required|exists:station,id',
                'train_type' => 'required|string',
                'working_days'=> 'required|string',
                'special_note'=> 'nullable|string',
                'available_classes' => 'required',
                'available_classes.*' => 'required',
                
            ],
            [
                'available_classes.required' => 'At least one class is required',
            ],
            [
                'name' => 'Train Name',

            ]
        );

        $train = new Train();
        $train->name = $request->name;
        $train->start_station = $request->start_station;
        $train->end_station = $request->end_station;
        $train->train_type = $request->train_type;
        $train->working_days = $request->working_days;
        $train->special_note = $request->special_note;
        $train->save();

        foreach ($request->available_classes as $class) {
            $train_class = new TrainClass();
            $train_class->train_id = $train->id;
            $train_class->class = $class;
            $train_class->save();
        }

        return redirect()->route('train.index')->with('success', 'Train added successfully');
    }

    public function edit(Train $train)
    {
        $stations = Station::all();
        $trains = Train::all();
        return view('train.edit', compact('train', 'stations','trains'));
    }

    public function update(Train $train, Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string',
                'start_station' => 'required|exists:station,id',
                'end_station' => 'required|exists:station,id',
                'working_days'=> 'required|string',
                'special_note'=> 'nullable|string',
                'train_type' => 'required|string',
                'available_classes' => 'required',
                'available_classes.*' => 'required',
            ],
            [
                'available_classes.required' => 'At least one class is required',
            ],
            [
                'name' => 'Train Name',
            ]
        );

        $train->name = $request->name;
        $train->start_station = $request->start_station;
        $train->end_station = $request->end_station;
        $train->train_type = $request->train_type;
        $train->working_days = $request->working_days;
        $train->special_note = $request->special_note;
        $train->save();

        TrainClass::where('train_id', $train->id)->delete();
        foreach ($request->available_classes as $class) {
            $train_class = new TrainClass();
            $train_class->train_id = $train->id;
            $train_class->class = $class;
            $train_class->save();
        }

        return redirect()->route('train.index')->with('success', 'Train updated successfully');
    }

    public function destroy(Train $train)
    {
        TrainClass::where('train_id', $train->id)->delete();
        $train->delete();
        return redirect()->route('train.index')->with('success', 'Train deleted successfully');
    }
}
