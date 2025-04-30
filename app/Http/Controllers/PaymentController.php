<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

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
     * Process the payment
     */
    public function process(Request $request)
    {
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

        // Generate a unique order ID
        $orderId = 'ORD-' . Str::random(10);

        // Store order information in session for processing
        session(['pending_order' => [
            'id' => $orderId,
            'customer' => $validated,
            'cart' => session('cart'),
            'total' => $request->input('total'),
            'created_at' => now(),
        ]]);

        // Redirect to payment gateway page
        return view('payment.gateway', [
            'orderId' => $orderId,
            'total' => $request->input('total')
        ]);
    }

    /**
     * Simulate payment success
     */
    public function success()
    {
        // Check if there's a pending order
        if (!session('pending_order')) {
            return redirect()->route('products.index');
        }

        $order = session('pending_order');

        // Clear cart and pending order from session
        session()->forget('cart');
        session()->forget('pending_order');

        return view('payment.success', ['order' => $order]);
    }

    /**
     * Simulate payment failure
     */
    public function cancel()
    {
        // Pending order remains in session, but we clear the pending_order
        session()->forget('pending_order');

        return redirect()->route('cart')
            ->with('error', 'Payment was cancelled. Your items are still in your cart.');
    }
}
