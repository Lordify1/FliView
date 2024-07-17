<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    
    public function index()
    {
        return view('testapi');
    }

    public function initiatePayment(Request $request)
    {
       
        $email = $request->input('email');
        $amount = $request->input('amount') * 100;
        $transaction_ref = Str::random(20);
        $currency = 'NGN';
        $inType = 'inline';
        $callback_url = "http://127.0.0.1:10/";


        $payload = [
            'email' => $email,
            'amount' => $amount,
            'currency' => $currency,
            'transaction_ref' => $transaction_ref,
            'initiate_type' => $inType,
            'callback_url' => $callback_url,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'sandbox_sk_3c825a6306636bcc24700aae71f1a6fb2c9804d34065',
        ])->post('https://sandbox-api-d.squadco.com/transaction/initiate', $payload);

        
        if ($response->successful()) {

            return redirect()->away("https://sandbox-pay.squadco.com/$transaction_ref");

        } else {
            
            return back()->with('error', 'Failed to initiate payment. Please try again.');
        }
    }


}
