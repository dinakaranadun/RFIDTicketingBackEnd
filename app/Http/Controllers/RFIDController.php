<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\ScannerTicket;
use Illuminate\Support\Facades\Log; 
use App\Http\Controllers\SMSController;

class RFIDController extends Controller
{
    public function handleRFID(Request $request)
    {
        

         $request->validate([
            'rfid' => 'required|string',
            'scanner_id' => 'required|string'
        ]);

        $rfid = $request->input('rfid');
        $scannerId = $request->input('scanner_id');

        Log::info('RFID Tag: ' . $rfid);
        Log::info('Scanner ID: ' . $scannerId);

        $user = User::where('rfid', $rfid)->first();

        try{




        if (!$user) {

            $file = storage_path('app/UIDContainer.php');
           
            $write = $rfid;
            file_put_contents($file, $write);

            $rfid = $request->input('rfid');
            $scannerId = $request->input('scanner_id');
           
   
            return response()->json([
                'success' => true,
                'message' => 'RFID assigned to the user and stored in the file.',
                // 'rfid' => $rfid,
            ]);
        
        }

        if ($user->status != 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Account suspended. Please contact the nearest railway office.',
            ]);
        }

        $now = Carbon::now('Asia/Colombo');
        $twoHoursBefore = $now->copy()->subHours(2);

        $bookings = Ticket::where('passenger_id', $user->id)
                    ->whereDate('date', $now->toDateString())
                    ->whereIn('status', ['pending', 'in'])
                    // ->whereTime('time', '>=', $twoHoursBefore)
                    ->get();


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

            // if ($relevantBooking->end_station_id  == $scannerId) {
                $user->account_credits -= $cost;
                $user->save();
        
                $relevantBooking->status = 'out';
                $relevantBooking->save();

                $contactNumber = $user->contact_number;

                $message = "Thanks for using Sri lankan railway ticket cost deducted from your account!\n";
        
        
                $smsController = new SMSController();
                $smsController->sendSms( $contactNumber,$message);

                
        
                return response()->json([
                    'success' => true,
                    'message' => 'Exit allowed. Ticket status updated to "out".',
                    'cost_deducted' => $cost,
                    'remaining_credits' => $user->account_credits,
                ]);

                $this->createScannerTicket($scannerId, $relevantBooking->id, $now);
            // // }else{
            // //     return response()->json([
            // //         'success' => false,
            // //         'message' => 'Invalid exit station. Please exit at the correct station.',
            // //     ]);
            // }
    
            
        }
        }catch (\Exception $e) {
            Log::error('RFID Handling Error: ' . $e->getMessage());
    
            // Return a 500 response with the error message
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the RFID.',
            ], 500);
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
