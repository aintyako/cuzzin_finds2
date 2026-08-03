<x-app-layout>
    <div class="bg-[#0f172a] min-h-screen py-16">
        <div class="max-w-3xl mx-auto px-6 text-center text-white">
            <div class="bg-[#1e293b] rounded-3xl border border-gray-800 p-12 shadow-2xl">
                <div class="text-6xl mb-6">🎉</div>
                <h1 class="text-4xl font-black mb-4">Order Confirmed!</h1>
                <p class="text-gray-400 mb-8">Thanks for your purchase. Your order has been placed successfully and is being processed.</p>

                <div class="grid grid-cols-1 gap-6 text-left text-gray-300">
                    <div class="bg-[#0f172a] border border-gray-700 rounded-3xl p-6">
                        <p class="text-xs uppercase tracking-[0.3em] text-indigo-400 mb-3">Order ID</p>
                        <p class="font-black text-white">#{{ $order->id }}</p>
                    </div>
                    <div class="bg-[#0f172a] border border-gray-700 rounded-3xl p-6">
                        <p class="text-xs uppercase tracking-[0.3em] text-indigo-400 mb-3">Amount Paid</p>
                        <p class="font-black text-white">₱{{ number_format($order->total_amount, 2) }}</p>
                    </div>
                    <div class="bg-[#0f172a] border border-gray-700 rounded-3xl p-6">
                        <p class="text-xs uppercase tracking-[0.3em] text-indigo-400 mb-3">Shipping To</p>
                        <p>{{ $order->address }}, {{ $order->city }}</p>
                    </div>
                </div>

                @auth
                    <a href="{{ route('orders.index') }}" class="mt-10 inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-4 rounded-2xl font-black uppercase tracking-[0.2em] text-sm transition">View My Orders</a>
                @else
                    <a href="{{ route('shop.catalog') }}" class="mt-10 inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-4 rounded-2xl font-black uppercase tracking-[0.2em] text-sm transition">Continue Shopping</a>
                    <p class="mt-4 text-sm text-gray-400">You placed your order as a guest. Check your email for your receipt and order details.</p>
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>