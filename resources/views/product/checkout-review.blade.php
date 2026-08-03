<x-app-layout>
    <div class="bg-[#0f172a] min-h-screen py-16">
        <div class="max-w-6xl mx-auto px-6">
            <div class="mb-10">
                <h2 class="text-3xl font-black text-white tracking-tight">Review Your Order</h2>
                <p class="text-gray-400 mt-2">Confirm your shipping details and payment before completing the purchase.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                <div class="lg:col-span-7 space-y-6">
                    <div class="bg-[#1e293b] rounded-3xl border border-gray-800 p-8 shadow-2xl">
                        <h3 class="text-sm font-black uppercase tracking-[0.25em] text-indigo-400 mb-6">Shipping Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-300">
                            <div><span class="text-gray-500 uppercase text-[10px]">Name</span><p class="font-bold mt-1">{{ $checkoutData['name'] }}</p></div>
                            <div><span class="text-gray-500 uppercase text-[10px]">Email</span><p class="font-bold mt-1">{{ $checkoutData['email'] }}</p></div>
                            <div class="md:col-span-2"><span class="text-gray-500 uppercase text-[10px]">Address</span><p class="font-bold mt-1">{{ $checkoutData['address'] }}</p></div>
                            <div><span class="text-gray-500 uppercase text-[10px]">City</span><p class="font-bold mt-1">{{ $checkoutData['city'] }}</p></div>
                            <div><span class="text-gray-500 uppercase text-[10px]">Phone</span><p class="font-bold mt-1">{{ $checkoutData['phone'] }}</p></div>
                        </div>
                    </div>

                    <div class="bg-[#1e293b] rounded-3xl border border-gray-800 p-8 shadow-2xl">
                        <h3 class="text-sm font-black uppercase tracking-[0.25em] text-indigo-400 mb-6">Payment Method</h3>
                        <div class="space-y-3 text-gray-300">
                            <p><span class="text-gray-500 uppercase text-[10px]">Method</span><br><strong>{{ strtoupper($checkoutData['payment_method']) === 'COD' ? 'Cash on Delivery' : 'Online Payment' }}</strong></p>
                            @if($checkoutData['payment_method'] === 'online' && !empty($checkoutData['online_provider']))
                                <p><span class="text-gray-500 uppercase text-[10px]">Provider</span><br><strong>{{ ucfirst($checkoutData['online_provider']) }}</strong></p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="bg-[#0f172a] rounded-3xl border border-gray-800 p-8 shadow-2xl">
                        <h3 class="text-sm font-black uppercase tracking-[0.25em] text-indigo-400 mb-6">Order Summary</h3>
                        <div class="space-y-4 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($checkoutData['items'] as $item)
                                <div class="flex items-center justify-between gap-4 p-4 bg-[#111827] rounded-3xl border border-gray-800">
                                    <div>
                                        <p class="font-bold text-white">{{ $item['name'] }}</p>
                                        <p class="text-[11px] text-gray-500">Qty: {{ $item['quantity'] }}</p>
                                    </div>
                                    <p class="text-gray-200">₱{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-800 pt-6 mt-6 space-y-4">
                            <div class="flex justify-between text-gray-400 uppercase text-[10px] tracking-[0.2em]">
                                <span>Subtotal</span>
                                <span>₱{{ number_format($checkoutData['total'], 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-400 uppercase text-[10px] tracking-[0.2em]">
                                <span>Shipping</span>
                                <span class="text-emerald-400">FREE</span>
                            </div>
                            <div class="flex justify-between text-white font-black text-lg uppercase tracking-[0.2em]">
                                <span>Total</span>
                                <span>₱{{ number_format($checkoutData['total'], 2) }}</span>
                            </div>
                        </div>

                        <div class="mt-8 grid gap-4">
                            <a href="{{ route('checkout.confirm') }}" class="block text-center bg-indigo-600 hover:bg-indigo-500 text-white py-4 rounded-2xl font-black uppercase tracking-[0.2em] text-sm transition">Review & Confirm</a>
                            <a href="{{ route('checkout.index') }}" class="block text-center text-gray-400 border border-gray-700 rounded-2xl py-4 font-black uppercase tracking-[0.2em] text-sm hover:bg-white/5 transition">Edit Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.12); border-radius: 999px; }
    </style>
</x-app-layout>