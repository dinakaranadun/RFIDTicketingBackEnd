<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SMSController;

class RefundController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::where('status', 'refund requested')
        ->with('passenger', 'startStation', 'endStation')
        ->when($request->name, function ($query, $name) {
            return $query->whereHas('passenger', function ($query) use ($name) {
                $query->where(function ($query) use ($name) {
                    $query->where(DB::raw('CONCAT(fName, " ", lName)'), 'LIKE', '%' . $name . '%')
                        ->orWhere('NIC', 'LIKE', '%' . $name . '%');
                });
            });
        })
        ->paginate(10);

    return view('refund.index', compact('tickets'));
    }

    public function update(Ticket $ticket,$id){
        $ticket->status = 'refunded';
        $ticket->save();

        $user=User::findorfail($id);
        $contactNumber=$user->contact_number;
        $user->account_credits+=$ticket->cost*0.75;
        $user->save();

        $message = "Your Refund is Successful!\n"
            . "Amount Credited to Account: Rs.".$ticket->cost*0.75." About 75% of the Ticket Cost\n"
            . "Thank You for Using Sri Lankan railway";


            $smsController = new SMSController();
            $smsController->sendSms( $contactNumber,$message);



        return redirect()->back()->with('success', 'Ticket refunded successfully');


    }

}
