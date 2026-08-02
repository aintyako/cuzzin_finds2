<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Skincare') }}
        </h2>
    </x-slot>

    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        /* Custom scrollbar for dark mode */
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.02); }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
    </style>

    {{-- Main Container - Midnight Background --}}
    <div class="bg-[#0f172a] min-h-screen text-gray-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
            
            {{-- ========================================== --}}
            {{-- NEW ARRIVALS SECTION --}}
            {{-- ========================================== --}}
            @if($latestProducts->count() > 0)
                <div class="mb-16">
                    <h3 class="text-2xl font-black text-white uppercase tracking-widest mb-8 flex items-center gap-2">
                        New Arrivals ✨
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                        @foreach ($latestProducts as $product)
                            <div class="bg-[#1e293b] rounded-2xl overflow-hidden shadow-2xl hover:shadow-indigo-500/10 transition duration-300 group flex flex-col h-full border border-gray-800 relative">
                                
                                <div class="relative aspect-[4/5] overflow-hidden bg-[#0f172a]">
                                    <div class="flex overflow-x-auto snap-x snap-mandatory h-full w-full hide-scrollbar">
                                        @if($product->images && $product->images->count() > 0)
                                            @foreach($product->images as $image)
                                                <div class="flex-none w-full h-full snap-center relative">
                                                    <img src="{{ asset($image->image_path) }}" alt="{{ $product->name }}" class="object-cover w-full h-full opacity-90 group-hover:opacity-100 transition duration-500">
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="flex-none w-full h-full snap-center relative">
                                                <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="object-cover w-full h-full group-hover:scale-105 transition duration-500 opacity-90">
                                            </div>
                                        @endif
                                    </div>
                                    
                                    @if(isset($product->is_trending) && $product->is_trending)
                                        <span class="absolute top-3 left-3 bg-indigo-600 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-lg z-10">
                                            Trending 🔥
                                        </span>
                                    @endif

                                    @if($product->images && $product->images->count() > 1)
                                        <div class="absolute bottom-3 left-0 right-0 flex justify-center gap-1.5 z-10">
                                            @foreach($product->images as $image)
                                                <div class="w-1.5 h-1.5 rounded-full bg-white/20 shadow-md"></div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <div class="p-5 flex flex-col flex-grow">
                                    <p class="text-[10px] text-indigo-400 font-black uppercase tracking-widest mb-1">
                                        {{ $product->category->name }}
                                    </p>
                                    <h4 class="text-sm font-bold text-gray-200 leading-snug mb-4 flex-grow">
                                        {{ $product->name }}
                                    </h4>
                                    
                                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-800 gap-2">
                                        <span class="text-lg font-black text-white">
                                            ₱{{ number_format($product->price, 2) }}
                                        </span>

                                        @if(isset($product->is_sold_out) && $product->is_sold_out)
                                            <span class="bg-gray-800 text-gray-500 font-black text-xs px-3 py-2 rounded-lg tracking-widest uppercase">Sold Out</span>
                                        @else
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('wishlist.toggle', $product->id) }}" class="inline-flex items-center justify-center rounded-lg border border-rose-500/30 bg-rose-500/10 p-2 text-rose-400 hover:bg-rose-500/20 transition" title="Add to wishlist">
                                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21s-6.6-4.35-8.7-8.2C1.3 9.2 2.4 5.7 5.7 4.9c1.5-.3 3 .1 4.3 1.1 1.3-1 2.8-1.4 4.3-1.1 3.3.8 4.4 4.3 2.4 7.9C18.6 16.7 12 21 12 21z"></path></svg>
                                                </a>
                                                <a href="{{ route('cart.add', $product->id) }}" class="bg-indigo-600 hover:bg-white hover:text-indigo-600 text-white p-2 rounded-lg transition-all shadow-md active:scale-95">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ========================================== --}}
            {{-- ALL SKINCARE SECTION --}}
            {{-- ========================================== --}}
            <div>
                <h3 class="text-2xl font-black text-white uppercase tracking-widest mb-8 flex items-center gap-2">
                    Skincare Collection
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @forelse ($products as $product)
                        <div class="bg-[#1e293b] rounded-2xl overflow-hidden shadow-2xl hover:shadow-indigo-500/10 transition duration-300 group flex flex-col h-full border border-gray-800 relative">
                            
                            <div class="relative aspect-[4/5] overflow-hidden bg-[#0f172a]">
                                <div class="flex overflow-x-auto snap-x snap-mandatory h-full w-full hide-scrollbar">
                                    @if($product->images && $product->images->count() > 0)
                                        @foreach($product->images as $image)
                                            <div class="flex-none w-full h-full snap-center relative">
                                                <img src="{{ asset($image->image_path) }}" alt="{{ $product->name }}" class="object-cover w-full h-full opacity-90 transition duration-500">
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="flex-none w-full h-full snap-center relative">
                                            <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="object-cover w-full h-full group-hover:scale-105 transition duration-500 opacity-90">
                                        </div>
                                    @endif
                                </div>
                                
                                @if(isset($product->is_trending) && $product->is_trending)
                                    <span class="absolute top-3 left-3 bg-indigo-600 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-lg z-10">
                                        Trending 🔥
                                    </span>
                                @endif
                            </div>

                            <div class="p-5 flex flex-col flex-grow">
                                <p class="text-[10px] text-indigo-400 font-black uppercase tracking-widest mb-1">
                                    {{ $product->category->name }}
                                </p>
                                <h4 class="text-sm font-bold text-gray-200 leading-snug mb-4 flex-grow">
                                    {{ $product->name }}
                                </h4>
                                
                                <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-800 gap-2">
                                    <span class="text-lg font-black text-white">
                                        ₱{{ number_format($product->price, 2) }}
                                    </span>

                                    @if(isset($product->is_sold_out) && $product->is_sold_out)
                                        <span class="bg-gray-800 text-gray-500 font-black text-xs px-3 py-2 rounded-lg tracking-widest uppercase">Sold Out</span>
                                    @else
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('wishlist.toggle', $product->id) }}" class="inline-flex items-center justify-center rounded-lg border border-rose-500/30 bg-rose-500/10 p-2 text-rose-400 hover:bg-rose-500/20 transition" title="Add to wishlist">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21s-6.6-4.35-8.7-8.2C1.3 9.2 2.4 5.7 5.7 4.9c1.5-.3 3 .1 4.3 1.1 1.3-1 2.8-1.4 4.3-1.1 3.3.8 4.4 4.3 2.4 7.9C18.6 16.7 12 21 12 21z"></path></svg>
                                            </a>
                                            <a href="{{ route('cart.add', $product->id) }}" class="bg-indigo-600 hover:bg-white hover:text-indigo-600 text-white p-2 rounded-lg transition-all shadow-md active:scale-95">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center bg-[#1e293b] rounded-3xl border-2 border-dashed border-gray-700">
                            <p class="text-gray-500 font-medium italic">No skincare products available yet! ✨</p>
                        </div>
                    @endforelse
                </div>
                
                {{-- Pagination Styling for Dark Mode --}}
                <div class="mt-12 text-gray-400">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>