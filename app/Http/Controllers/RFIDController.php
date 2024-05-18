<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\ScannerTicket;
use Illuminate\Support\Facades\Log; 

class RFIDController extends Controller
{
    public function handleRFID(Request $request)
    {
        $request->validate([
            'rfid' => 'required|string',
            'scanner_id' => 'required|string'
        ]);

        // Rfid data
        $rfid = $request->input('rfid');
        $scannerId = $request->input('scanner_id');

        Log::info('RFID Tag: ' . $rfid);
        Log::info('Scanner ID: ' . $scannerId);

        $user = User::where('rfid', $rfid)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'RFID not associated with any user',
            ], 404);
        }

        $now = Carbon::now();
        // $twoHoursBefore = $now->copy()->subHours(2);

        $bookings = Ticket::where('passenger_id', $user->id)
                        ->whereDate('date', $now->toDateString())
                        ->whereIn('status', ['pending', 'in'])
                        ->get();
                         // ->whereTime('date', '>=', $twoHoursBefore->toTimeString())


        if ($bookings->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No valid booking found for today.',
            ]);
        }

        $relevantBooking = $bookings->first(function ($booking) use ($scannerId) {
            return $booking->start_station_id== $scannerId;
        });

        if (!$relevantBooking) {
            return response()->json([
                'success' => false,
                'message' => 'No relevant booking found for the RFID scanner station ID.',
            ]);
        }

        // Process the relevant booking
        if ($relevantBooking->status == 'pending') {
            $relevantBooking->status = 'in';
            $relevantBooking->save();

            $this->createScannerTicket($scannerId, $relevantBooking->id, $now);


            return response()->json([
                'success' => true,
                'message' => 'Access allowed. Ticket status updated to "in".',
            ]);
        } elseif ($relevantBooking->status == 'in') {
            
            $cost = $relevantBooking->cost;

            if ($relevantBooking->end_station_id  == $scannerId) {
                $user->account_credits -= $cost;
                $user->save();
        
                $relevantBooking->status = 'out';
                $relevantBooking->save();

                
        
                return response()->json([
                    'success' => true,
                    'message' => 'Exit allowed. Ticket status updated to "out".',
                    'cost_deducted' => $cost,
                    'remaining_credits' => $user->account_credits,
                ]);

                $this->createScannerTicket($scannerId, $relevantBooking->id, $now);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid exit station. Please exit at the correct station.',
                ]);
            }
    
            
        }

       
    }

    private function createScannerTicket($scannerId, $ticketId, $now)
    {
        ScannerTicket::create([
            'scanner_id' => $scannerId,
            'ticket_id' => $ticketId,
            'date' => $now->toDateString(),
            'time' => $now->toTimeString(),

        ]);
    }
    // private function calculateExtraFee($expectedExitScannerId, $actualExitScannerId)
    // {
        
       
    // }
}
