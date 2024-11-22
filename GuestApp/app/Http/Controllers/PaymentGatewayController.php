<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Cardinfo;
use Illuminate\Support\Str;



class PaymentGatewayController extends Controller
{
    public function showPaymentPage()
    {
        return view('paymentForm'); 
    }

    
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'userid' => 'required|uuid|exists:users,userid',
        //     'amount' => 'required|numeric|min:0',
        //     'address' => 'required',
        //     'city' => 'required',
        //     'zipcode' => 'required',
        //     'state' => 'required',
        //     'nameoncard' => 'required|string|max:255',
        //     'creditcardnumber' => 'required|string|max:255',
        //     'expyear' => 'required|int',
        //     'expmonth' => 'required|string',
        //     'cvv' => 'required|string|max:4',
        // ]);

         // Get authenticated user from Auth if caren/joe implemented this way
        //  $user = Auth::user();

        // if (!$user) {
        //     return response()->json(['error' => 'User not authenticated.'], 401);
        // }

         $cardInfo = null;

        $cardInfo = Cardinfo::create([
            'cardinfoid' => Str::uuid(),
            'nameoncard' => $request->nameoncard,
            'creditcardnumber' => $request->creditcardnumber,
            'expyear' => $request->expyear,
            'expmonth' => $request->expmonth,
            'cvv' => $request->cvv,
        ]);

        if (!$cardInfo) {
 
        return response()->json(['error' => 'Failed to save card information.'], 500);
        }

     $cardInfo->save();

        $transaction = Transaction::create([
            'transactionid' => (string) \Str::uuid(),
            //for testing take it from the request
            'userid' => $request->userid,
            //'userid' => $user->userid,// Use the authenticated user ID if Auth
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zipcode' => $request->zipcode,
            'infoid' => $cardInfo->cardinfoid,
            'amount' => $request->amount,
            'paydate' => now(),
        ]);

        return response()->json([
            'message' => 'Payment processed successfully.',
            'transaction' => $transaction   
        ]);

        //return redirect()->route('createUser')->with('welcomeMessage', $welcomeMessage);
    }
}
