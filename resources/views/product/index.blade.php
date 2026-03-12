<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Our Collection') }}
        </h2>
    </x-slot>

    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        /* Custom scrollbar for the dark theme */
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.02); }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
    </style>

    {{-- Main Container - Midnight Background --}}
    <div class="bg-[#0f172a] min-h-screen text-gray-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse ($products as $product)
                    <div class="bg-[#1e293b] rounded-2xl overflow-hidden shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500 group flex flex-col h-full border border-gray-800 relative">
                        
                        <div class="relative aspect-[4/5] overflow-hidden bg-[#0f172a]">
                            
                            <div class="flex overflow-x-auto snap-x snap-mandatory h-full w-full hide-scrollbar">
                                @if($product->images && $product->images->count() > 0)
                                    @foreach($product->images as $image)
                                        <div class="flex-none w-full h-full snap-center relative">
                                            <img src="{{ asset($image->image_path) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="object-cover w-full h-full opacity-90 group-hover:scale-110 group-hover:opacity-100 transition duration-700">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="flex-none w-full h-full snap-center relative">
                                        <img src="{{ asset($product->image_url) }}" 
                                             alt="{{ $product->name }}" 
                                             class="object-cover w-full h-full opacity-90 group-hover:scale-110 transition duration-700">
                                    </div>
                                @endif
                            </div>

                            {{-- DARK THEME DESCRIPTION OVERLAY --}}
                            <div class="absolute inset-0 bg-black/80 backdrop-blur-[4px] z-30 flex items-center justify-center p-6 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                                <div class="text-center transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                    <p class="text-[10px] uppercase tracking-[0.2em] mb-2 text-indigo-400 font-black">Product Details</p>
                                    <p class="text-sm leading-relaxed font-medium text-gray-200">
                                        {{ $product->description ?? 'No description available.' }}
                                    </p>
                                </div>
                            </div>
                            
                            @if(isset($product->is_trending) && $product->is_trending)
                                <span class="absolute top-3 left-3 bg-indigo-600 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-lg z-10">
                                    Trending 🔥
                                </span>
                            @endif

                            {{-- ADMIN CONTROLS - RE-STYLED FOR DARK MODE --}}
                            @if(auth()->check())
                                <div class="absolute top-3 right-3 z-40 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                                       class="bg-blue-600 hover:bg-blue-500 text-white p-2.5 rounded-xl shadow-xl flex items-center justify-center transition active:scale-90">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>

                                    <form action="{{ route('admin.products.toggle-stock', $product->id) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="{{ isset($product->is_sold_out) && $product->is_sold_out ? 'bg-emerald-600 hover:bg-emerald-500' : 'bg-rose-600 hover:bg-rose-500' }} text-white p-2.5 rounded-xl shadow-xl transition active:scale-90">
                                            @if(isset($product->is_sold_out) && $product->is_sold_out)
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                            @endif
                                        </button>
                                    </form>
                                </div>
                            @endif

                            @if($product->images && $product->images->count() > 1)
                                <div class="absolute bottom-3 left-0 right-0 flex justify-center gap-1.5 z-10 group-hover:opacity-0 transition-opacity">
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
                            
                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-800">
                                <span class="text-lg font-black text-white">
                                    ₱{{ number_format($product->price, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center bg-[#1e293b] rounded-3xl border-2 border-dashed border-gray-700">
                        <p class="text-gray-500 font-medium italic">No products available in this section yet! 🛍️</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-12 text-gray-400">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>