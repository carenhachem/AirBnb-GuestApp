<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Cardinfo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class PaymentGatewayController extends Controller
{
    public function showPaymentPage()
    {
        return view('paymentForm'); 
    }

    public function previewReceipt(Request $request)
    {
        // $this->validate($request, [
        //     'userid' => 'required|uuid|exists:users,userid',
        //     'email' => 'required|email|exists,users,email',
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

        $receiptData = [
            'userid' => $request->userid,
            'amount' => $request->amount,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zipcode' => $request->zipcode,
            'nameoncard' => $request->nameoncard,
            'creditcardnumber' => $request->creditcardnumber,
            'expyear' => $request->expyear,
            'expmonth' => $request->expmonth,
            'cvv' => $request->cvv,
            'email' =>$request->email,
        ];

        return view('receiptPreview', ['receiptData' => $receiptData]);

    }

    public function confirm(Request $request)
    {
        // the request is the receipt data
        // $request->validate([
        //     'userid' => 'required|uuid|exists:users,userid',
        //     'email' => 'required|email|exists:users,email',
        //     'amount' => 'required|numeric|min:0',
        //     'address' => 'required|string',
        //     'city' => 'required|string',
        //     'zipcode' => 'required|string',
        //     'state' => 'required|string',
        //     'nameoncard' => 'required|string|max:255',
        //     'creditcardnumber' => 'required|string|max:255',
        //     'expyear' => 'required|integer',
        //     'expmonth' => 'required|integer',
        //     'cvv' => 'required|string|max:4',
        // ]);

        $cardInfo = Cardinfo::create([
            'cardinfoid' => Str::uuid(),
            'nameoncard' => $request->nameoncard,
            'creditcardnumber' => $request->creditcardnumber,
            'expyear' => $request->expyear,
            'expmonth' => $request->expmonth,
            'cvv' => $request->cvv,
        ]);
        $cardInfo->save();

        $transaction = Transaction::create([
            'transactionid' => (string) \Str::uuid(),
            'userid' => $request->userid,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zipcode' => $request->zipcode,
            'infoid' => $cardInfo->cardinfoid,
            'amount' => $request->amount,
            'paydate' => now(),
        ]);
        $transaction->save();

       Mail::send('emails.receipt', ['transaction' => $transaction], function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Payment Receipt');
        });

        return response()->json([
            'message' => 'Payment confirmed successfully. A confirmation email has been sent.',
            'transaction' => $transaction
        ]);
    }

    
    public function confirmAndDownload(Request $request)
    {
        //the request is the receipt data

        // $request->validate([
        //     'userid' => 'required|uuid|exists:users,userid',
        //     'email' => 'required|email|exists:users,email',
        //     'amount' => 'required|numeric|min:0',
        //     'address' => 'required|string',
        //     'city' => 'required|string',
        //     'zipcode' => 'required|string',
        //     'state' => 'required|string',
        //     'nameoncard' => 'required|string|max:255',
        //     'creditcardnumber' => 'required|string|max:255',
        //     'expyear' => 'required|integer',
        //     'expmonth' => 'required|integer',
        //     'cvv' => 'required|string|max:4',
        // ]);

        $cardInfo = Cardinfo::create([
            'cardinfoid' => Str::uuid(),
            'nameoncard' => $request->nameoncard,
            'creditcardnumber' => $request->creditcardnumber,
            'expyear' => $request->expyear,
            'expmonth' => $request->expmonth,
            'cvv' => $request->cvv,
        ]);
        $cardInfo->save();

        $transaction = Transaction::create([
            'transactionid' => (string) \Str::uuid(),
            'userid' => $request->userid,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zipcode' => $request->zipcode,
            'infoid' => $cardInfo->cardinfoid,
            'amount' => $request->amount,
            'paydate' => now(),
        ]);
        $transaction->save();

         Mail::send('emails.receipt', ['transaction' => $transaction], function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Payment Receipt');
        });

        $pdf = PDF::loadView('pdf.receipt', ['transaction' => $transaction]);

        return $pdf->download('receipt-' . $transaction->transactionid . '.pdf');

    }
}
