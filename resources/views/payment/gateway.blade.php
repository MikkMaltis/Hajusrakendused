<x-product-layout>
    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <h1 class="text-2xl font-bold mb-6">Payment Gateway</h1>

                    <div class="mb-8 p-4 bg-blue-50 rounded-lg">
                        <p class="text-lg mb-4">Order #{{ $orderId }}</p>
                        <p class="text-xl font-semibold mb-2">Total: ${{ number_format($total, 2) }}</p>
                        <p class="text-sm text-gray-600 mb-6">This is a simulation of a payment gateway.</p>

                        <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-sm">Since this is a demo, you can choose the payment outcome:</p>
                        </div>

                        <div class="flex justify-center space-x-4 mt-8">
                            <a href="{{ route('payment.success') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded">
                                Simulate Successful Payment
                            </a>

                            <a href="{{ route('payment.cancel') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-6 rounded">
                                Simulate Failed Payment
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-product-layout>
