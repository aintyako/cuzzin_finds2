<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Our Collection') }}
        </h2>
    </x-slot>

    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse ($products as $product)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 group flex flex-col h-full border border-gray-100 relative">
                    
                    <div class="relative aspect-[4/5] overflow-hidden bg-gray-100">
                        
                        <div class="flex overflow-x-auto snap-x snap-mandatory h-full w-full hide-scrollbar">
                            
                            {{-- Check if we have multiple images in the new table --}}
                            @if($product->images && $product->images->count() > 0)
                                @foreach($product->images as $image)
                                    <div class="flex-none w-full h-full snap-center relative">
                                        <img src="{{ asset($image->image_path) }}" 
                                             alt="{{ $product->name }}" 
                                             class="object-cover w-full h-full">
                                    </div>
                                @endforeach
                            @else
                                {{-- Fallback for old products that only have 1 image_url --}}
                                <div class="flex-none w-full h-full snap-center relative">
                                    <img src="{{ asset($product->image_url) }}" 
                                         alt="{{ $product->name }}" 
                                         class="object-cover w-full h-full group-hover:scale-105 transition duration-500">
                                </div>
                            @endif

                        </div>
                        
                        @if(isset($product->is_trending) && $product->is_trending)
                            <span class="absolute top-3 left-3 bg-black text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-lg z-10">
                                Trending 🔥
                            </span>
                        @endif

                        {{-- ADMIN CONTROLS (Visible to all logged-in users for testing) --}}
                        @if(auth()->check())
                            <div class="absolute top-3 right-3 z-20 flex flex-col gap-2">
                                {{-- Edit Button --}}
                                <a href="{{ route('admin.products.edit', $product->id) }}" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-lg shadow-md flex items-center justify-center transition" title="Edit Product">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>

                                {{-- Sold Out Toggle Form --}}
                                <form action="{{ route('admin.products.toggle-stock', $product->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="{{ isset($product->is_sold_out) && $product->is_sold_out ? 'bg-green-500 hover:bg-green-600' : 'bg-red-500 hover:bg-red-600' }} text-white p-2 rounded-lg shadow-md flex items-center justify-center transition"
                                            title="{{ isset($product->is_sold_out) && $product->is_sold_out ? 'Mark as In Stock' : 'Mark as Sold Out' }}">
                                        @if(isset($product->is_sold_out) && $product->is_sold_out)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                        @endif
                                    </button>
                                </form>

                                {{-- Delete Button Form --}}
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="m-0" onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-gray-800 hover:bg-black text-white p-2 rounded-lg shadow-md flex items-center justify-center transition"
                                            title="Delete Product">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        @endif

                        @if($product->images && $product->images->count() > 1)
                            <div class="absolute bottom-3 left-0 right-0 flex justify-center gap-1.5 z-10">
                                @foreach($product->images as $image)
                                    <div class="w-1.5 h-1.5 rounded-full bg-white/80 shadow-md"></div>
                                @endforeach
                            </div>
                        @endif

                    </div>

                    <div class="p-5 flex flex-col flex-grow">
                        <p class="text-[10px] text-indigo-500 font-black uppercase tracking-widest mb-1">
                            {{ $product->category->name }}
                        </p>
                        <h4 class="text-sm font-bold text-gray-900 leading-snug mb-4 flex-grow">
                            {{ $product->name }}
                        </h4>
                        
                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-50">
                            <span class="text-lg font-black text-gray-900">
                                ₱{{ number_format($product->price, 2) }}
                            </span>

                            @if(isset($product->is_sold_out) && $product->is_sold_out)
                                <span class="bg-gray-100 text-gray-500 font-black text-xs px-3 py-2 rounded-lg tracking-widest uppercase">
                                    Sold Out
                                </span>
                            @else
                                <a href="{{ route('cart.add', $product->id) }}" 
                                   class="bg-indigo-600 hover:bg-black text-white p-2 rounded-lg transition-colors shadow-md">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white rounded-3xl border-2 border-dashed border-gray-200">
                    <p class="text-gray-400 font-medium italic">No products available in this section yet! 🛍️</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-12">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>