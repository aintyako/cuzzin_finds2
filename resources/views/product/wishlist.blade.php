<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Your Wishlist') }} ❤️
        </h2>
    </x-slot>

    <div class="min-h-screen bg-[#0f172a] text-gray-100 py-12">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            @if(count($wishlist) > 0)
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($wishlist as $item)
                        <div class="bg-[#1e293b] rounded-2xl border border-gray-800 overflow-hidden shadow-xl">
                            <div class="aspect-[4/5] bg-[#0f172a]">
                                <img src="{{ asset($item['image'] ?? '') }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                            </div>

                            <div class="p-5">
                                <h3 class="text-lg font-black text-white">{{ $item['name'] }}</h3>
                                <p class="mt-2 text-indigo-400 font-semibold">₱{{ number_format($item['price'], 2) }}</p>

                                <div class="mt-6 flex gap-3">
                                    <a href="{{ route('wishlist.move-to-cart', $item['id']) }}" class="flex-1 inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-500 text-white py-3 rounded-xl font-bold uppercase tracking-widest text-xs transition">
                                        Move to Cart
                                    </a>
                                    <a href="{{ route('wishlist.toggle', $item['id']) }}" class="inline-flex items-center justify-center bg-rose-600/20 text-rose-400 hover:bg-rose-600/30 px-4 py-3 rounded-xl transition">
                                        Remove
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-3xl border-2 border-dashed border-gray-700 bg-[#1e293b] py-20 text-center">
                    <div class="text-6xl mb-4">💖</div>
                    <h3 class="text-2xl font-black text-white">Your wishlist is empty</h3>
                    <p class="mt-2 text-gray-500">Save products you love and come back to them later.</p>
                    <a href="{{ route('shop.catalog') }}" class="mt-8 inline-block bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-3 rounded-2xl font-black uppercase tracking-widest text-xs transition">
                        Browse Products
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
