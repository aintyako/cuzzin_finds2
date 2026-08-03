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

                                    <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="m-0" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button onclick="confirmProductDelete({{ $product->id }})" class="bg-red-600 hover:bg-red-500 text-white p-2.5 rounded-xl shadow-xl flex items-center justify-center transition active:scale-90">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
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
                            <div class="flex items-start justify-between gap-3 mb-4">
                                <h4 class="text-sm font-bold text-gray-200 leading-snug flex-1">
                                    {{ $product->name }}
                                </h4>
                                @if($product->sold_out)
                                    <span class="bg-gray-800 text-gray-400 text-[10px] uppercase tracking-[0.2em] font-black px-3 py-1 rounded-full">Sold Out</span>
                                @endif
                            </div>
                            
                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-800 gap-2">
                                <span class="text-lg font-black text-white">
                                    ₱{{ number_format($product->price, 2) }}
                                </span>
                                <a href="{{ route('wishlist.toggle', $product->id) }}" class="inline-flex items-center justify-center rounded-lg border border-rose-500/30 bg-rose-500/10 p-2 text-rose-400 hover:bg-rose-500/20 transition" title="Add to wishlist">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21s-6.6-4.35-8.7-8.2C1.3 9.2 2.4 5.7 5.7 4.9c1.5-.3 3 .1 4.3 1.1 1.3-1 2.8-1.4 4.3-1.1 3.3.8 4.4 4.3 2.4 7.9C18.6 16.7 12 21 12 21z"></path></svg>
                                </a>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmProductDelete(productId, isDashboard = false) {
            Swal.fire({
                title: 'Delete Product?',
                text: 'This action cannot be undone! 🗑️',
                icon: 'warning',
                background: '#1e293b',
                color: '#f3f4f6',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'rounded-3xl border border-gray-700 shadow-2xl',
                    confirmButton: 'rounded-xl font-bold uppercase tracking-widest text-xs px-6 py-3',
                    cancelButton: 'rounded-xl font-bold uppercase tracking-widest text-xs px-6 py-3'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const formId = isDashboard ? `delete-dashboard-${productId}` : `delete-form-${productId}`;
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
</x-app-layout>