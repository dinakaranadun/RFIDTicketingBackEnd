<?php

namespace App\Http\Controllers\Admin;

use App\Models\Route;
use App\Models\Train;
use App\Models\Ticket;
use App\Models\Station;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
//        $total_bookings = Bookin
        $total_trains = Train::count();
        $total_stations = Station::count();
        $total_revenue = Ticket::where('status', 'out')->sum('cost');
        $total_routes = Route::Count();
        return view('dashboard', compact('total_trains', 'total_stations','total_revenue','total_routes'));
    }
}
