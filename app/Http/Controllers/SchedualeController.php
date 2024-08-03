<?php

namespace App\Http\Controllers;

use App\Models\Train;
use App\Models\Station;
use App\Models\Scheduale;
use Illuminate\Http\Request;

class SchedualeController extends Controller
{
    public function search(Request $request){

        $validatedData = $request->validate([
            'departure' => 'required|string',
            'destination' => 'required|string',
            'date' => 'required|date',
        ]);
        $departure = $validatedData['departure'];
        $destination = $validatedData['destination'];
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
            ->join('schedule as dst_schedule', 'train.id', '=', 'dst_schedule.train_id')
            ->join('station as dst_station', 'dst_schedule.station_id', '=', 'dst_station.id')
            ->with([
                'startStation' => function ($query) {
                    $query->select('id', 'station_name');
                },
                'endStation' => function ($query) {
                    $query->select('id', 'station_name');
                },
                'class'=> function($query){
                    $query->select('train_id', 'class');
                }
            ])
            ->whereIn('schedule.train_id', $commonTrainIds)
            ->where('schedule.station_id', $departureStationId)
            ->where('dst_schedule.station_id', $destinationStationId)
            // ->whereDate('schedule.departure_time', $date)
            ->get();

            $result = $trains->map(function ($train) {
                return [
                    'train_id' => $train->id,
                    'train_name' => $train->name,
                    'start_station' => $train->startStation->station_name,
                    'end_station' => $train->endStation->station_name,
                    'train_type' => $train->train_type,
                    'departure_time' => $train->departure_time,
                    'arrival_time' => $train->arrival_time,
                    'departure_station_name' => $train->departure_station_name,
                    'destination_station_name' => $train->destination_station_name,
                    'working_days' => $train->working_days,
                    'classes' => $train->class->pluck('class')->unique()->values()->all(),
                ];
            });
            return response()->json($result);


    }
}
