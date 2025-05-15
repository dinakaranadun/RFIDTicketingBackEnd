<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Ticket;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RevenueReportController extends Controller
{
    public function index(){
        return view('reports.revenue');
    }

 
    public function generateRevenueReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'report_type' => 'required|in:monthly,date'
        ]);
        
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));
        $reportType = $request->input('report_type'); 
    
        if ($reportType === 'monthly') {
            $earn_per_month = Ticket::select([DB::raw("DATE_FORMAT(date, '%Y-%m') as month"), DB::raw('SUM(cost) as earn')])
                ->where('status', 'out')
                ->whereDate('date', '>=', $startDate)
                ->whereDate('date', '<=', $endDate)
                ->groupBy(DB::raw("DATE_FORMAT(date, '%Y-%m')"))
                ->orderBy(DB::raw("DATE_FORMAT(date, '%Y-%m')"))
                ->get()
                ->pluck('earn', 'month');
    
            // months array
            $monthsInRange = CarbonPeriod::create($startDate->startOfMonth(), '1 month', $endDate->endOfMonth())->toArray();
            $earn_per_month_formatted = [];
    
            foreach ($monthsInRange as $month) {
                $formattedMonth = $month->format('Y-m'); 
                $earn_per_month_formatted[$formattedMonth] = $earn_per_month[$formattedMonth] ?? 0;
            }
        } elseif ($reportType === 'date') {
            $earn_per_day_dt = Ticket::select(['date', DB::raw('SUM(cost) as earn')])
                ->where('status', 'out')
                ->whereDate('date', '>=', $startDate)
                ->whereDate('date', '<=', $endDate)
                ->groupBy('date')
                ->get()
                ->pluck('earn', 'date');
    
            $range = CarbonPeriod::create($startDate, $endDate);
            $earn_per_day = [];
    
            foreach ($range as $date) {
                $earn_per_day[$date->format('Y-m-d')] = $earn_per_day_dt[$date->format('Y-m-d')] ?? 0;
            }
        }
    
        return view('reports.revenue', [
            'earn_per_month' => $earn_per_month_formatted ?? [],
            'earn_per_day' => $earn_per_day ?? [],
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'report_type' => $reportType
        ]);
    }

}
