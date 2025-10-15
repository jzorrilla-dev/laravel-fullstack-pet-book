<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;

class DonationController extends Controller
{
    public function index()
    {
        return view('donations.index');
    }
    
    public function create()
    {
        return view('donations.create');
    }
    
    public function checkout(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'donor_name' => 'nullable|string|max:255',
            'donor_email' => 'nullable|email|max:255',
            'message' => 'nullable|string|max:1000',
        ]);
        
        // Configurar Stripe con la clave secreta
        Stripe::setApiKey(config('services.stripe.secret'));
        
        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Donación a PetBook',
                        ],
                        'unit_amount' => $request->amount * 100, // Convertir a centavos
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('donations.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('donations.cancel'),
                'metadata' => [
                    'donor_name' => $request->donor_name,
                    'donor_email' => $request->donor_email,
                    'message' => $request->message,
                    'user_id' => Auth::id(),
                ],
            ]);
            
            // Guardar la donación en la base de datos con estado pendiente
            Donation::create([
                'user_id' => Auth::id(),
                'amount' => $request->amount,
                'currency' => 'USD',
                'payment_id' => $session->id,
                'payment_method' => 'stripe',
                'status' => 'pending',
                'donor_name' => $request->donor_name,
                'donor_email' => $request->donor_email,
                'message' => $request->message,
            ]);
            
            return redirect($session->url);
        } catch (ApiErrorException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
    public function success(Request $request)
    {
        if ($request->session_id) {
            $donation = Donation::where('payment_id', $request->session_id)->first();
            
            if ($donation) {
                $donation->update(['status' => 'completed']);
            }
        }
        
        return view('donations.success');
    }
    
    public function cancel()
    {
        return view('donations.cancel');
    }
}
