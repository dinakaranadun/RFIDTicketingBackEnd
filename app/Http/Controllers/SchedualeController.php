<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Train;
use App\Models\Station;
use App\Models\Scheduale;
use Illuminate\Http\Request;

class SchedualeController extends Controller
{
    public function search(Request $request)
    {
        // Validate
        $validatedData = $request->validate([
            'departure' => 'required|string',
            'destination' => 'required|string',
            'date' => 'required|date',
        ]);

        $departure = $validatedData['departure'];
        $destination = $validatedData['destination'];
        $searchDate = $validatedData['date'];

        $date = Carbon::parse($searchDate);

        $departureStationId = Station::where('station_name', $departure)->value('id');
        $destinationStationId = Station::where('station_name', $destination)->value('id');

        // Get common train IDs where the departure station comes before the destination station in the order column
        $commonTrainIds = Scheduale::where('station_id', $departureStationId)
            ->whereIn('train_id', function ($query) use ($destinationStationId, $departureStationId) {
                $query->select('train_id')
                    ->from('schedule as dst_schedule')
                    ->where('dst_schedule.station_id', $destinationStationId)
                    ->whereColumn('schedule.train_id', 'dst_schedule.train_id') // Ensure same train
                    ->whereColumn('schedule.order', '<', 'dst_schedule.order'); // Ensure departure comes before destination
            })
            ->where(function ($query) use ($date) {
                if ($date->isToday()) {
                    $currentTime = now()->format('H:i:s');
                    $query->where('departure_time', '>', $currentTime);
                }
            })
            ->pluck('train_id');

        // Fetch train details
        $trains = Train::select(
                'train.*',
                'schedule.arrival_time',
                'schedule.departure_time',
                'schedule.station_id as departure_station_id',
                'station.station_name as departure_station_name',
                'dst_station.station_name as destination_station_name',
                'dst_station.id as destination_station_id'
            )
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
                'class' => function ($query) {
                    $query->select('train_id', 'class');
                }
            ])
            ->whereIn('schedule.train_id', $commonTrainIds)
            ->where('schedule.station_id', $departureStationId)
            ->where('dst_schedule.station_id', $destinationStationId)
            ->whereColumn('schedule.order', '<', 'dst_schedule.order') // Ensure correct station order
            // ->whereDate('schedule.departure_time', $date) // Uncomment this line if you need to filter by specific dates
            ->get();

        // Map the train results to the desired format
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
