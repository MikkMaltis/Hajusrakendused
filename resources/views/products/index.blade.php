<x-product-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-6 text-center">Our Products</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <img src="https://placehold.co/600x400?text={{ urlencode($product->name) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover mb-4 rounded">
                            <h2 class="text-xl font-semibold mb-2">{{ $product->name }}</h2>
                            <p class="text-gray-700 mb-2">${{ number_format($product->price, 2) }}</p>
                            <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                            <p class="text-sm text-gray-500 mb-4">In Stock: {{ $product->stock }}</p>

                            <form action="{{ route('add.to.cart') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="flex items-center mb-4">
                                    <label for="quantity-{{ $product->id }}" class="mr-2">Quantity:</label>
                                    <select name="quantity" id="quantity-{{ $product->id }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        @for($i = 1; $i <= min(5, $product->stock); $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <button type="submit" class="text-black font-bold py-2 px-4 rounded w-full">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-product-layout>
