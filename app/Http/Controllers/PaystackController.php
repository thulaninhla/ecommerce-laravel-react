<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Transaction;

class PaystackController extends Controller
{
    // Step 1: Redirect to Paystack Payment Page
    public function redirectToGateway(Request $request)
    {
        $paystackSecret = env('PAYSTACK_SECRET_KEY');

       $response = Http::withOptions([
        'verify' => public_path('cacert.pem')
         ])->withToken(env('PAYSTACK_SECRET_KEY'))->post('https://api.paystack.co/transaction/initialize', [
        'email' => $request->email,
        'amount' => $request->amount * 100,
        'callback_url' => route('payment.callback'),
    ]);
        if ($response->successful()) {
            return redirect($response->json()['data']['authorization_url']);
        } else {
            return redirect()->route('payment.success')->with('error', 'Could not initialize payment.');
        }
    }

    // Step 2: Handle Callback
    public function handleGatewayCallback(Request $request)
{

    $reference = $request->query('reference');
    $paystackSecret = env('PAYSTACK_SECRET_KEY');

    if (!$reference) {
        return redirect()->route('payment.failed')->with('error', 'No payment reference provided.');
    }

    $response = Http::withToken($paystackSecret)
        ->get("https://api.paystack.co/transaction/verify/{$reference}");


    if ($response->successful()) {
        $data = $response->json()['data'];

        if ($data['status'] === 'success') {

            // 💾 Save to DB
        Transaction::create([
            'reference' => $data['reference'],
            'email' => $data['customer']['email'],
            'amount' => $data['amount'],
            'status' => $data['status'],
        ]);
            // ✅ Clear cart here
            session()->forget('cart');

            return redirect()->route('payment.success')->with('details', $data);
        } else {
            return redirect()->route('payment.failed')->with('error', 'Payment was not successful.');
        }
    }

    return redirect()->route('payment.failed')->with('error', 'Could not verify payment.');
    }

}
