<x-app-layout>
    <div class="bg-[#0f172a] min-h-screen py-16">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-10 gap-4">
                <div>
                    <h2 class="text-3xl font-black text-white tracking-tight">My Orders</h2>
                    <p class="text-gray-400 mt-2">Review the orders you've placed and their current status.</p>
                </div>
                <a href="{{ route('shop.catalog') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-3 rounded-2xl font-black uppercase tracking-[0.2em] text-xs transition">
                    Continue Shopping
                </a>
            </div>

            @if($orders->isEmpty())
                <div class="bg-[#1e293b] rounded-3xl border border-dashed border-gray-700 p-16 text-center text-gray-400">
                    <p class="text-2xl font-black text-white mb-3">No orders yet</p>
                    <p class="text-sm">Place an order and it will appear here with full details.</p>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($orders as $order)
                        <div class="bg-[#1e293b] rounded-3xl border border-gray-800 p-8 shadow-2xl">
                            <div class="flex flex-col md:flex-row justify-between gap-4">
                                <div>
                                    <p class="text-[10px] uppercase tracking-[0.3em] text-indigo-400 font-black mb-3">Order #{{ $order->id }}</p>
                                    <h3 class="text-xl font-black text-white">{{ $order->name }}</h3>
                                    <p class="text-sm text-gray-400 mt-2">{{ $order->email }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] uppercase tracking-[0.3em] text-gray-500 font-black">Placed</p>
                                    <p class="font-black text-white">{{ $order->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>

                            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-300">
                                <div class="bg-[#0f172a] rounded-3xl p-5 border border-gray-700">
                                    <span class="text-[10px] uppercase tracking-[0.3em] text-gray-500">Total</span>
                                    <p class="font-black text-white mt-2">₱{{ number_format($order->total_amount, 2) }}</p>
                                </div>
                                <div class="bg-[#0f172a] rounded-3xl p-5 border border-gray-700">
                                    <span class="text-[10px] uppercase tracking-[0.3em] text-gray-500">Status</span>
                                    <p class="font-black text-emerald-400 mt-2">{{ ucfirst($order->status) }}</p>
                                </div>
                                <div class="bg-[#0f172a] rounded-3xl p-5 border border-gray-700">
                                    <span class="text-[10px] uppercase tracking-[0.3em] text-gray-500">Shipping</span>
                                    <p class="font-black text-white mt-2">{{ $order->address }}, {{ $order->city }}</p>
                                </div>
                            </div>

                            <div class="mt-8 bg-[#0f172a] rounded-3xl p-6 border border-gray-700">
                                <h4 class="text-sm font-black uppercase tracking-[0.3em] text-indigo-400 mb-4">Items</h4>
                                <div class="space-y-3 text-gray-300 text-sm">
                                    @foreach(json_decode($order->items_json, true) as $item)
                                        <div class="flex justify-between gap-4">
                                            <span>{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                                            <span>₱{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>