<?php

namespace App\Http\Controllers\Admin;

use App\Models\Route;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class PassengerFlowController extends Controller
{
    public function index(){
        $routes = Route::with('stations')->get();
        return view('reports.passengerflowindex',compact('routes'));
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'route_id' => 'required|exists:route,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
    
        $route = Route::with('stations')->find($request->route_id);
    
        if (!$route) {
            return redirect()->back()->withErrors(['route_id' => 'Selected route does not exist.']);
        }
    
        $tickets = Ticket::where('status', 'out')
            ->whereBetween('date', [$request->start_date, $request->end_date])
            ->whereIn('start_station_id', $route->stations->pluck('id'))
            ->get();
    
        $passengerFlow = $tickets->groupBy('start_station_id')->map(function($stationTickets) {
            return $stationTickets->count();
        });
    
        // no tickets 
        if ($passengerFlow->isEmpty()) {
            return view('reports.passengerflowindex', [
                'selectedRoute' => $route,
                'passengerFlow' => $passengerFlow,
                'tickets' => $tickets,
                'routes' => Route::with('stations')->get(),
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'message' => 'No data available for the selected date range and route.'
            ]);
        }
    
        return view('reports.passengerflowindex', [
            'selectedRoute' => $route,
            'passengerFlow' => $passengerFlow,
            'tickets' => $tickets,
            'routes' => Route::with('stations')->get(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
    }
    
}
