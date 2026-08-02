<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Clothes') }}
        </h2>
    </x-slot>

    {{-- 1. GLOBAL MODAL STATE --}}
    <div x-data="{ 
        open: false, 
        currentName: '', 
        currentId: null,
        currentImages: [],
        openModal(id, name, images) {
            this.currentId = id;
            this.currentName = name;
            this.currentImages = images;
            this.open = true;
        }
    }">

        {{-- Main Container - Midnight Background --}}
        <div class="py-12 bg-[#0f172a] min-h-screen text-gray-100">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                {{-- NEW ARRIVALS SECTION --}}
                <div class="mb-10">
                    <h3 class="text-lg font-bold text-white mb-6 uppercase tracking-widest flex items-center gap-2">
                        New Arrivals ✨
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($latestProducts as $item)
                            <div class="bg-[#1e293b] rounded-2xl overflow-hidden shadow-2xl hover:shadow-indigo-500/10 transition duration-300 border border-gray-800 flex flex-col h-full group">
                                
                                {{-- 2. CLICK TRIGGER (NEW ARRIVALS) --}}
                                <div class="relative aspect-[4/5] overflow-hidden bg-[#0f172a] cursor-zoom-in" 
                                     @click="openModal({{ $item->id }}, '{{ $item->name }}', {{ $item->images->map(fn($img) => asset($img->image_path)) }})">
                                    <img src="{{ asset($item->image_url) }}" alt="{{ $item->name }}" class="object-cover w-full h-full opacity-90 transition duration-500 group-hover:scale-105 group-hover:opacity-100">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-indigo-900/20 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <span class="bg-indigo-600/90 p-3 rounded-full shadow-lg text-lg">🔍</span>
                                    </div>
                                </div>

                                <div class="p-4 flex flex-col flex-grow">
                                    <p class="text-[10px] text-indigo-400 font-black uppercase tracking-widest mb-1">
                                        {{ $item->category->name ?? 'Clothes' }}
                                    </p>
                                    <h4 class="text-sm font-bold text-gray-200 mb-2 leading-snug">{{ $item->name }}</h4>

                                    @if($item->colors && count($item->colors) > 0)
                                        <div class="flex gap-1.5 mb-4">
                                            @foreach($item->colors as $color)
                                                <div class="w-4 h-4 rounded-full border border-white/10 shadow-sm" style="background-color: {{ $color }};"></div>
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-800 gap-2">
                                        <span class="text-lg font-black text-white">₱{{ number_format($item->price, 2) }}</span>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('wishlist.toggle', $item->id) }}" class="inline-flex items-center justify-center rounded-lg border border-rose-500/30 bg-rose-500/10 p-2 text-rose-400 hover:bg-rose-500/20 transition" title="Add to wishlist">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21s-6.6-4.35-8.7-8.2C1.3 9.2 2.4 5.7 5.7 4.9c1.5-.3 3 .1 4.3 1.1 1.3-1 2.8-1.4 4.3-1.1 3.3.8 4.4 4.3 2.4 7.9C18.6 16.7 12 21 12 21z"></path></svg>
                                            </a>
                                            <a href="{{ route('cart.add', $item->id) }}" class="bg-indigo-600 hover:bg-white hover:text-indigo-600 text-white p-2 rounded-lg transition-all shadow-md active:scale-95">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <hr class="border-gray-800 my-12">

                {{-- ALL CLOTHES SECTION --}}
                <div>
                    <h3 class="text-lg font-bold text-white mb-6 uppercase tracking-widest">All Clothes</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        @forelse($products as $product)
                            <div class="bg-[#1e293b] rounded-2xl overflow-hidden shadow-2xl hover:shadow-indigo-500/10 transition duration-300 border border-gray-800 flex flex-col h-full group">
                                
                                {{-- 3. CLICK TRIGGER (ALL CLOTHES) --}}
                                <div class="relative aspect-[4/5] overflow-hidden bg-[#0f172a] cursor-zoom-in"
                                     @click="openModal({{ $product->id }}, '{{ $product->name }}', {{ $product->images->map(fn($img) => asset($img->image_path)) }})">
                                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="object-cover w-full h-full opacity-90 transition duration-500 group-hover:scale-105 group-hover:opacity-100">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-indigo-900/20 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <span class="bg-indigo-600/90 p-3 rounded-full shadow-lg text-lg">🔍</span>
                                    </div>
                                </div>

                                <div class="p-4 flex flex-col flex-grow">
                                    <h4 class="text-sm font-bold text-gray-200 mb-2 leading-snug">{{ $product->name }}</h4>

                                    @if($product->colors && count($product->colors) > 0)
                                        <div class="flex gap-1.5 mb-4">
                                            @foreach($product->colors as $color)
                                                <div class="w-4 h-4 rounded-full border border-white/10 shadow-sm" style="background-color: {{ $color }};"></div>
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-800 gap-2">
                                        <span class="text-lg font-black text-white">₱{{ number_format($product->price, 2) }}</span>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('wishlist.toggle', $product->id) }}" class="inline-flex items-center justify-center rounded-lg border border-rose-500/30 bg-rose-500/10 p-2 text-rose-400 hover:bg-rose-500/20 transition" title="Add to wishlist">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21s-6.6-4.35-8.7-8.2C1.3 9.2 2.4 5.7 5.7 4.9c1.5-.3 3 .1 4.3 1.1 1.3-1 2.8-1.4 4.3-1.1 3.3.8 4.4 4.3 2.4 7.9C18.6 16.7 12 21 12 21z"></path></svg>
                                            </a>
                                            <a href="{{ route('cart.add', $product->id) }}" class="bg-indigo-600 hover:bg-white hover:text-indigo-600 text-white p-2 rounded-lg transition-all shadow-md active:scale-95">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center bg-[#1e293b] rounded-xl border-2 border-dashed border-gray-700">
                                <p class="text-gray-500 italic">No clothes added yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. MODAL OVERLAY - DARK THEME UPDATE --}}
        <div x-show="open" 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-md"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @keydown.escape.window="open = false"
             style="display: none;">
            
            <div class="bg-[#1e293b] rounded-3xl max-w-4xl w-full h-[90vh] overflow-hidden relative shadow-2xl flex flex-col md:flex-row border border-gray-700" @click.away="open = false">
                
                <button @click="open = false" class="absolute top-4 right-4 z-50 bg-gray-800/90 p-2 rounded-full hover:bg-white hover:text-black text-white shadow-md transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                {{-- LEFT SIDE: SCROLLABLE GALLERY --}}
                <div class="md:w-2/3 bg-[#0f172a] h-full overflow-y-auto p-6 custom-scrollbar">
                    <div class="space-y-6">
                        <template x-for="img in currentImages" :key="img">
                            <div class="relative group">
                                <img :src="img" class="w-full rounded-2xl shadow-sm border border-gray-800 opacity-90 transition group-hover:opacity-100">
                                
                                <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <a :href="'/add-to-cart/' + currentId + '?selected_image=' + encodeURIComponent(img)" 
                                       class="bg-indigo-600 hover:bg-white hover:text-indigo-600 text-white px-4 py-2 rounded-xl shadow-xl flex items-center gap-2 font-bold text-sm tracking-wide transition-all active:scale-95">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Add this Color to Cart
                                    </a>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- RIGHT SIDE: INFO --}}
                <div class="md:w-1/3 p-8 flex flex-col justify-center bg-[#1e293b] border-l border-gray-800">
                    <h3 class="text-2xl font-black text-white mb-2" x-text="currentName"></h3>
                    <p class="text-indigo-400 text-xs mb-6 uppercase tracking-[0.2em] font-black">Selection Gallery</p>
                    
                    <div class="bg-[#0f172a] p-4 rounded-2xl mb-8 border border-gray-800">
                        <p class="text-gray-400 text-sm leading-relaxed italic">
                            Browse the colors on the left. Hover over any photo to add that specific item to your cart! ✨
                        </p>
                    </div>

                    <button @click="open = false" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-bold uppercase tracking-widest hover:bg-indigo-500 transition shadow-lg active:scale-95">
                        Close Gallery
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.02); }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #5850ec; }
        
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</x-app-layout>