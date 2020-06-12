<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{ Order, State };

class PaymentController extends Controller
{
    
    /**
     * Manage payment
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function __invoke(Request $request, Order $order)
    {
        $this->authorize('manage', $order);

        $state = null;

        if($request->payment_intent_id === 'error') {
            $state = 'erreur'; 
        } else {
            \Stripe\Stripe::setApiKey(config('stripe.secret_key'));
            $intent = \Stripe\PaymentIntent::retrieve($request->payment_intent_id);
            if ($intent->status === 'succeeded') {
                $request->session()->forget($order->reference); 
                $order->payment_infos()->create(['payment_id' => $intent->id]);         
                $state = 'paiement_ok';  
                // Création de la facture à prévoir              
            } else {
                $state = 'erreur';     
            }
        }

        $order->state_id = State::whereSlug($state)->first()->id;              
        $order->save();
    }
}
