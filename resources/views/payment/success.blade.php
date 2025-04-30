<x-product-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <div class="mb-6">
                        <svg class="mx-auto h-16 w-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>

                    <h1 class="text-2xl font-bold mb-2">Payment Successful!</h1>
                    <p class="text-gray-600 mb-4">Thank you for your purchase. Your order has been processed.</p>
                    <p class="text-gray-600 mb-6">Payment ID: {{ $order['payment_id'] }}</p>

                    <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
                        <h2 class="text-lg font-semibold mb-2">Order Details</h2>
                        <p class="mb-1"><span class="font-medium">Order ID:</span> {{ $order['id'] }}</p>
                        <p class="mb-1"><span class="font-medium">Date:</span> {{ $order['created_at']->format('M d, Y H:i') }}</p>
                        <p class="mb-4"><span class="font-medium">Total:</span> ${{ number_format($order['total'], 2) }}</p>

                        <h3 class="text-md font-semibold mb-2">Shipping Address</h3>
                        <p>{{ $order['customer']['first_name'] }} {{ $order['customer']['last_name'] }}</p>
                        <p>{{ $order['customer']['address'] }}</p>
                        <p>{{ $order['customer']['city'] }}, {{ $order['customer']['postal_code'] }}</p>
                        <p>{{ $order['customer']['country'] }}</p>
                        <p>{{ $order['customer']['email'] }}</p>
                        <p>{{ $order['customer']['phone'] }}</p>
                    </div>

                    <a href="{{ route('products.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-product-layout>
