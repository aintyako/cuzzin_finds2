<x-app-layout>
    <div class="bg-[#0f172a] min-h-screen py-16">
        <div class="max-w-5xl mx-auto px-6">
            <div class="mb-10 text-center">
                <h2 class="text-3xl font-black text-white tracking-tight">Confirm Your Order</h2>
                <p class="text-gray-400 mt-2">One last step before we place your order.</p>
            </div>

            <div class="bg-[#1e293b] border border-gray-800 rounded-3xl p-8 shadow-2xl">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div class="bg-[#0f172a] rounded-3xl p-6 border border-gray-700">
                            <h3 class="text-xs font-black uppercase tracking-[0.25em] text-indigo-400 mb-4">Order Details</h3>
                            <div class="space-y-3 text-gray-300 text-sm">
                                <p><span class="text-gray-500 uppercase text-[10px]">Name</span><br>{{ $checkoutData['name'] }}</p>
                                <p><span class="text-gray-500 uppercase text-[10px]">Email</span><br>{{ $checkoutData['email'] }}</p>
                                <p><span class="text-gray-500 uppercase text-[10px]">Address</span><br>{{ $checkoutData['address'] }}</p>
                                <p><span class="text-gray-500 uppercase text-[10px]">City</span><br>{{ $checkoutData['city'] }}</p>
                                <p><span class="text-gray-500 uppercase text-[10px]">Phone</span><br>{{ $checkoutData['phone'] }}</p>
                                <p><span class="text-gray-500 uppercase text-[10px]">Payment</span><br>{{ strtoupper($checkoutData['payment_method']) === 'COD' ? 'Cash on Delivery' : 'Online Payment (' . ucfirst($checkoutData['online_provider'] ?? 'N/A') . ')' }}</p>
                            </div>
                        </div>

                        <div class="bg-[#0f172a] rounded-3xl p-6 border border-gray-700">
                            <h3 class="text-xs font-black uppercase tracking-[0.25em] text-indigo-400 mb-4">Items</h3>
                            <div class="space-y-4">
                                @foreach($checkoutData['items'] as $item)
                                    <div class="flex items-center justify-between text-gray-300">
                                        <span>{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                                        <span class="font-black">₱{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#0f172a] rounded-3xl p-8 border border-gray-700 shadow-xl">
                        <h3 class="text-xs font-black uppercase tracking-[0.25em] text-indigo-400 mb-6">Payment Summary</h3>
                        <div class="space-y-4 text-gray-300 text-sm">
                            <div class="flex justify-between"><span>Subtotal</span><span>₱{{ number_format($checkoutData['total'], 2) }}</span></div>
                            <div class="flex justify-between"><span>Shipping</span><span class="text-emerald-400">FREE</span></div>
                            <div class="border-t border-gray-700 pt-4 flex justify-between text-white font-black text-lg"><span>Total</span><span>₱{{ number_format($checkoutData['total'], 2) }}</span></div>
                        </div>

                        <form action="{{ route('order.place') }}" method="POST" class="mt-10">
                            @csrf
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white py-4 rounded-2xl font-black uppercase tracking-[0.2em] text-sm transition">Place My Order</button>
                        </form>

                        <a href="{{ route('checkout.index') }}" class="block text-center mt-6 text-gray-400 text-sm uppercase tracking-[0.25em] hover:text-white">Edit checkout info</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>