<?php

namespace App\Http\Controllers\Admin;

use App\Models\Forum;
use App\Models\Route;
use App\Models\Train;
use App\Models\Ticket;
use App\Models\Station;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
//        $total_bookings = Bookin
        $total_trains = Train::count();
        $total_stations = Station::count();
        $total_revenue = Ticket::where('status', 'out')->sum('cost');
        $total_forums = Forum::count();

        $earn_per_day_dt = Ticket::select(['date', DB::raw('sum(cost) as earn')])
            ->where('status', 'out')
            ->whereDate('date', '>=', now()->subMonth())
            ->whereDate('date', '<=', now())
            ->groupBy('date')
            ->get()
            ->pluck('earn', 'date');
            //dd($earn_per_day_dt);
        $range = CarbonPeriod::create(now()->subMonth(), now());
        $earn_per_day = [];
        foreach ($range as $date) {
            $earn_per_day[$date->format('Y-m-d')] = $earn_per_day_dt[$date->format('Y-m-d')] ?? 0;
        }

        return view('dashboard', compact('total_trains', 'total_stations', 'total_revenue', 'total_forums', 'earn_per_day'));
    }
}
