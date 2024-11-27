<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Cardinfo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;




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

        $user = Auth::user();

        $receiptData = [
            'userid' => $user->userid,
            'username' => $user->username,
            'amount' => /*$request->amount*/ 30.0,
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

            'checkin' =>/*$request->checkin*/ 2024-10-10,
            'checkout' =>/*$request->checkout*/ 2024-10-15,
            'accommodation_name' =>/*$request->-accommodation_name*/ 'test',
            'location' =>/*$request->location*/ 'baabda',
            'pricepernight'=>/*$request->pricepernight*/ 105.0,
            'date'=>now()

        ];

        return view('receiptPreview', ['receiptData' => $receiptData]);

    }

    public function confirm(Request $request)
    {
       // the request is the receipt data
        // $request->validate([
        //     'userid' => 'required|uuid|exists:users,userid',
        //     'email' => 'required|email',
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
            'cardinfoid' => (string) \Str::uuid(),
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

        try {
            // Send email with accommodation details
            Mail::send('receipt', [
                'transaction' => $transaction,
                'accommodation_name' => $request->accommodation_name,
                'accommodation_location' => $request->location
            ], function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Payment Receipt');
            });
    
            Log::info('Email sent successfully to: ' . $request->email);
        } catch (\Exception $e) {
            Log::error('Failed to send email to: ' . $request->email . '. Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Payment confirmed, but failed to send confirmation email.',
                'transaction' => $transaction,
            ], 500);
        }

        return response()->json([
            'message' => 'Payment confirmed successfully. A confirmation email has been sent.',
            'transaction' => $transaction,
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
            'cardinfoid' => (string) \Str::uuid(),
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

        try {
            // Send email
            Mail::send('receipt', [
                'transaction' => $transaction,
                'accommodation_name' => $request->accommodation_name,
                'accommodation_location' => $request->location
            ], function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Payment Receipt');
            });
    
            Log::info('Email sent successfully to: ' . $request->email);
        } catch (\Exception $e) {
            Log::error('Failed to send email to: ' . $request->email . '. Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Payment confirmed, but failed to send confirmation email.',
                'transaction' => $transaction,
            ], 500);
        }

        $data = [
            'transaction' => $transaction, 
            'location' => $request->location,
            'accommodation_name' => $request->accommodation_name,
            'accommodation_location' => $request->location,
            'checkin' =>$request->checkin,
            'checkout' =>$request->checkout,
            'pricepernight'=>$request->pricepernight,
            'username' =>$request->username
        ];

        $pdf = PDF::loadView('receiptPdf', ['data' => $data]);
        return $pdf->download('receipt-' . $request->username . '.pdf');

        // return response()->json([
        //     'message' => 'Payment confirmed successfully. A confirmation email has been sent.',
        //     'transaction' => $transaction
        // ]);

    }
}
