<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Stripe\Stripe;
use App\Models\User;
use Stripe\PaymentIntent;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\SMSController;

class PaymentController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    
        $amount = $request->amount * 100; 
    
        $paymentIntent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'lkr', 
            'payment_method_types' => ['card'],
        ]);
    
        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }

    public function paymentSuccess(Request $request){
        
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'amount' => 'required',
        ]);



        $user_id = $validatedData['user_id'];
        $amount = $validatedData['amount'];
        $date = Carbon::now();

        $user = User::find($user_id);
        $contactNumber=$user->contact_number;

        if($user){
            $user->account_credits += $amount;
            $user->save();

            $transaction = new Transaction();
            $transaction->amount = $amount;
            $transaction->date = $date;
            $transaction->passenger_id = $user_id;
            $transaction->save();

            $contactNumber = (string)$contactNumber;
            if (strpos($contactNumber, '0') === 0) {
                $contactNumber = '94' . substr($contactNumber, 1);
            } else {
                $contactNumber = '94' . $contactNumber;
            }

            $message = "Your Payment is Successful!\n"
            . "Amount Credited to Account: Rs.".$amount."\n"
            . "Thank You for Using Sri Lankan railway";


            $smsController = new SMSController();
            $smsController->sendSms( $contactNumber,$message);

        }


        



    }
}
