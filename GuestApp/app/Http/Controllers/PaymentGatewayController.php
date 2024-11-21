<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\Cardinfo;



class PaymentGatewayController extends Controller
{
    public function showPaymentPage()
    {
        return view('paymentForm'); 
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            //see how to take 'visa' or 'when the user clicks on add card'
            'payment_method' => 'required|in:visa,paypal', 
            'cardholdername' => 'required_if:payment_method,visa|string|max:255',
            'cardnumber' => 'required_if:payment_method,visa|string|max:255',
            'expirationdate' => 'required_if:payment_method,visa|date_format:Y-m-d',
            'cvv' => 'required_if:payment_method,visa|string|max:4',
            'email' => 'required_if:payment_method,paypal|email|max:255',
            'amount' => 'required|numeric|min:0', 
            //see how to take the amount from the step before entering card info
        ]);


         // Get authenticated user 
         $user = Auth::user();

         $paymentMethod = Payment::where('paymentmethod', $request->payment_method)->first(); 

         $cardInfo = null;
        if ($request->payment_method == 'visa') {
            $cardInfo = Cardinfo::create([
                'cardholdername' => $request->cardholdername,
                'cardnumber' => $request->cardnumber,
                'expirationdate' => $request->expirationdate,
                'cvv' => $request->cvv,
            ]);
        }

        elseif($request->payment_method == 'paypal'){
            $cardInfo = Cardinfo ::create([
                'email' => $request->email, 
            ]);
        }

        $transaction = Transaction::create([
            'transactionid' => (string) \Str::uuid(),
            'userid' => $user->userid, // Use the authenticated user ID
            'paymentmethodid' => $paymentMethod->paymentid,
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
