<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function getTransactionData(request $request){
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
        ]);

        $user_id = $validatedData['user_id'];

        $transactions = Transaction::where('passenger_id', $user_id)
                        ->orderBy('date', 'desc') 
                        ->get();

        return response()->json([
            'transaction' => $transactions,
        ]);
    }
}
