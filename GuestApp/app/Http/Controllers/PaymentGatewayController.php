<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Cardinfo;
use App\Models\AccomodationLocation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ReservationController;
use Illuminate\Http\Client\Response;

class PaymentGatewayController extends Controller
{
    public function showPaymentPage()
    {
        return view('paymentForm'); 
    }

    public function previewReceipt(Request $request)
    {
          /*$request->validate([
        'userid' => 'required|uuid|exists:users,userid',
        'email' => 'required|email',
        'totalPrice' => 'required|numeric|min:0',
        'address' => 'required',
        'city' => 'required',
        'zipcode' => 'required',
        'state' => 'required',
        'nameoncard' => 'required|string|max:255',
        'creditcardnumber' => 'required|string|max:255',
        'expyear' => 'required|int',
        'expmonth' => 'required|string',
        'cvv' => 'required|string|max:4',
    ]);*/


        $user = Auth::user();

        $locationId = $request->input('accommodation_locationid');

         $accommodationLocation = AccomodationLocation::find($locationId);
         $accommodationAddress = $accommodationLocation->address;

        $receiptData = array_merge($request->except('accommodation_locationid'), [
            'userid' => $user->userid,
            'username' => $user->username,
            'date' => now()->format('d-m-Y'),
            'accommodation_address' => $accommodationAddress, 
        ]);

        return view('receiptPreview', ['receiptData' => $receiptData]);

    }

    public function confirmAndDownload(Request $request)
    {
        // $request->validate([
        //     'userid' => 'required|uuid|exists:users,userid',
        //     'email' => 'required|email|exists:users,email',
        //     'totalPrice' => 'required|numeric|min:0',
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

        $transaction = [
            'userid' => $request->userid,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zipcode' => $request->zipcode,
            'amount' => $request->totalPrice,
            'paydate' => now(),
        ];
        try {
            // Send email
            Mail::send('receipt', [
                'transaction' => $transaction,
                'accommodation_name' => $request->accomodation_name,
                'accommodation_location' => $request->accommodation_address
            ], function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Payment Receipt');
            });
    
            Log::info('Email sent successfully to: ' . $request->email);
        } catch (\Exception $e) {
            Log::error('Failed to send email to: ' . $request->email . '. Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to send confirmation email.',
                'transaction' => $transaction,
            ], 500);
        }

        $data = [
            'transaction' => $transaction, 
         //   'location' => $request->accommodation_address,
            'accommodation_name' => $request->accomodation_name,
            'accomodation_name' => $request->accomodation_name,
            'accommodation_location' => $request->accommodation_address,
            'accommodation_id' =>$request->accomodation_id,
            'checkin' =>$request->checkin,
            'checkout' =>$request->checkout,
            'pricepernight'=>$request->pricepernight,
            'username' =>$request->username
        ];

        try {
            // Save the PDF
            $pdf = PDF::loadView('receiptPdf', ['data' => $data]);
            $filePath = (storage_path('app\\public\\receipts\\' . $data['username'] . '_receipt.pdf'));
            $pdf->save($filePath);
        
        } catch (\Exception $e) {
            Log::error('Failed to generate PDF. Error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to generate PDF.', 'transaction' => $transaction], 500);
        }
            return $pdf->download('receipt-' . $request->username . '.pdf');
    }   
}