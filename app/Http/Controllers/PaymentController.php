<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Exception\ApiErrorException;

class PaymentController extends Controller
{
    /**
     * Show the checkout page
     */
    public function checkout()
    {
        if (!session('cart') || count(session('cart')) == 0) {
            return redirect()->route('products.index')
                ->with('error', 'Your cart is empty!');
        }

        $cart = session('cart');
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('payment.checkout', compact('cart', 'total'));
    }

    /**
     * Process the checkout and redirect to Stripe
     */
    public function processPayment(Request $request)
    {
        dd('tere');
        // Validate customer information
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
        ]);

        // Store customer information in session
        session(['customer_info' => $validated]);

        // Get cart items from session
        $cart = session('cart');
        if (!$cart || count($cart) == 0) {
            return redirect()->route('products.index')
                ->with('error', 'Your cart is empty!');
        }

         // Debug the Stripe key
         if (empty(config('services.stripe.secret'))) {
            return back()->with('error', 'Stripe secret key is not configured.');
        }

        // Initialize Stripe
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Create line items for Stripe
            $line_items = [];
            foreach ($cart as $item) {
                $line_items[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $item['name'],
                        ],
                        'unit_amount' => round($item['price'] * 100), // Stripe uses cents
                    ],
                    'quantity' => $item['quantity'],
                ];
            }

            // Create Stripe checkout session
            $stripeSession = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('payment.cancel'),
                'customer_email' => $validated['email'],
                'metadata' => [
                    'order_id' => 'ORD-' . Str::random(10),
                ],
            ]);

            // Store session ID in Laravel session
            session(['stripe_session_id' => $stripeSession->id]);

            // Redirect to Stripe Checkout
            return redirect($stripeSession->url);

        } catch (ApiErrorException $e) {
            return back()->with('error', 'Error connecting to Stripe: ' . $e->getMessage());
        }
    }

    /**
     * Handle successful payment
     */
    public function success(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $sessionId = $request->get('session_id');

        try {
            // Retrieve the checkout session to confirm payment
            $session = StripeSession::retrieve($sessionId);

            // If payment was successful
            if ($session->payment_status === 'paid') {
                // Prepare order data
                $order = [
                    'id' => $session->metadata->order_id,
                    'customer' => session('customer_info'),
                    'cart' => session('cart'),
                    'total' => array_reduce(session('cart'), function($carry, $item) {
                        return $carry + ($item['price'] * $item['quantity']);
                    }, 0),
                    'payment_id' => $session->payment_intent,
                    'created_at' => now(),
                ];

                // Here you would typically store the order in your database
                // For now, we'll just store it in the session for demo purposes
                session(['last_order' => $order]);

                // Clear cart and customer info from session
                session()->forget(['cart', 'customer_info', 'stripe_session_id']);

                return view('payment.success', ['order' => $order]);
            }

            return redirect()->route('cart')
                ->with('error', 'Payment was not completed successfully.');

        } catch (ApiErrorException $e) {
            return redirect()->route('cart')
                ->with('error', 'Error verifying payment: ' . $e->getMessage());
        }
    }

    /**
     * Handle cancelled payment
     */
    public function cancel()
    {
        return redirect()->route('cart')
            ->with('error', 'Payment was cancelled. Your items are still in your cart.');
    }
}
