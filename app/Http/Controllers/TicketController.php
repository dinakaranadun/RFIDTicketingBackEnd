<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Station;
use App\Models\Scheduale;
use App\Models\Train;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $cost_for_1km = 2;
    $minimum_distance_cost = 20;

    $data = $request->validate([
        'trainId' => 'required|integer',
        'departure_id' => 'required|integer',
        'destination_id' => 'required|integer',
        'class' => 'required|string',
        'date' => 'required|date',
    ]);

    $departure_station_distance = Station::select('distance_from_central_station')
        ->where('id', $data['departure_id'])
        ->value('distance_from_central_station');

    $destination_station_distance = Station::select('distance_from_central_station')
        ->where('id', $data['destination_id'])
        ->value('distance_from_central_station');

    $distance = abs($departure_station_distance - $destination_station_distance);

    if ($distance < 50) {
        if ($data['class'] == 'First Class') {
            return response()->json(
                [
                    'error' => 'First Class is not available for distances less than 50km.'
                ]
            );
        }
    }

    if ($distance < 3) {
        $cost = $minimum_distance_cost;
    } else {
        if ($data['class'] == 'First Class') {
            $cost = $minimum_distance_cost + ($distance - 3) * $cost_for_1km * 3;
        } elseif ($data['class'] == 'Second Class') {
            $cost = $minimum_distance_cost + ($distance - 3) * $cost_for_1km * 2;
        } else {
            $cost = $minimum_distance_cost + ($distance - 3) * $cost_for_1km;
        }
    }

    // Round the cost to the nearest 10th
    $cost = round($cost);

    $response = [
        'data' => $data,
        'cost' => $cost
    ];

    return response()->json($response);
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
       $data=$request->validate([
            'trainId'=>'required|integer',
            'departure'=>'required|string',
            'destination'=>'required|string',
            'departure_id'=>'required|integer',
            'destination_id'=>'required|integer',
            'class'=>'required|string',
            'date'=>'required|date',
            'cost'=>'required|numeric',
            'passenger_id'=>'required|integer'
        ]);

        $data['time'] = Scheduale::select('arrival_time')
                        ->where('train_id', $data['trainId'])
                        ->where('station_id', $data['departure_id'])
                        ->value('arrival_time');

        $data['date'] = Carbon::parse($data['date'])->format('Y-m-d');


        
        $ticket = new Ticket();    
        $ticket->start_station = $data['departure'];
        $ticket->destination = $data['destination'];
        $ticket->class = $data['class'];
        $ticket->date = $data['date'];
        $ticket->time = $data['time'];
        $ticket->cost = $data['cost'];
        $ticket->passenger_id = $data['passenger_id'];
        $ticket->train_id = $data['trainId'];
        $ticket->status = 'pending';
        $ticket->save();
        return response()->json(['message' => 'Booking successful', 'ticket' => $ticket], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $request->validate([
            'passenger_id' => 'required|integer'
        ]);
    
        $passengerId = $request->input('passenger_id');
    
        if (!$passengerId) {
            return response()->json(['error' => 'Invalid request'], 400);
        }
    
        $pendingTicketsByPassenger = Ticket::where('passenger_id', $passengerId)
            ->where('status', 'pending')
            ->with(['train' => function ($query) {
                $query->select('id', 'name');
            }])
            ->get();
    
        return response()->json($pendingTicketsByPassenger);
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
    public function destroy($bookingId)
    {
        $ticket = Ticket::find($bookingId);
    
        if (!$ticket) {
            return response()->json(['error' => 'Ticket not found'], 404);
        }
    
        $ticket->delete();
    
        return response()->json(['message' => 'Ticket deleted successfully'], 200);
    }
}
