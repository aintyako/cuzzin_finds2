<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
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

        <div class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                {{-- NEW ARRIVALS SECTION --}}
                <div class="mb-10">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 uppercase tracking-widest">New Arrivals ✨</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($latestProducts as $item)
                            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition duration-300 border border-gray-100 flex flex-col h-full group">
                                
                                {{-- 2. CLICK TRIGGER (NEW ARRIVALS) --}}
                                <div class="relative aspect-[4/5] overflow-hidden bg-gray-100 cursor-zoom-in" 
                                     @click="openModal({{ $item->id }}, '{{ $item->name }}', {{ $item->images->map(fn($img) => asset($img->image_path)) }})">
                                    <img src="{{ asset($item->image_url) }}" alt="{{ $item->name }}" class="object-cover w-full h-full transition duration-500 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <span class="bg-white/90 p-2 rounded-full shadow-lg text-lg">🔍</span>
                                    </div>
                                </div>

                                <div class="p-4 flex flex-col flex-grow">
                                    <p class="text-[10px] text-indigo-500 font-black uppercase tracking-widest mb-1">
                                        {{ $item->category->name ?? 'Clothes' }}
                                    </p>
                                    <h4 class="text-sm font-bold text-gray-800 mb-2">{{ $item->name }}</h4>

                                    @if($item->colors && count($item->colors) > 0)
                                        <div class="flex gap-1.5 mb-4">
                                            @foreach($item->colors as $color)
                                                <div class="w-4 h-4 rounded-full border border-gray-200 shadow-sm" style="background-color: {{ $color }};"></div>
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-50">
                                        <span class="text-lg font-black text-gray-900">₱{{ number_format($item->price, 2) }}</span>
                                        <a href="{{ route('cart.add', $item->id) }}" class="bg-indigo-600 hover:bg-black text-white p-2 rounded-lg transition-colors shadow-md">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <hr class="border-gray-200 my-12">

                {{-- ALL CLOTHES SECTION --}}
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-6 uppercase tracking-widest">All Clothes</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        @forelse($products as $product)
                            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition duration-300 border border-gray-100 flex flex-col h-full group">
                                
                                {{-- 3. CLICK TRIGGER (ALL CLOTHES) --}}
                                <div class="relative aspect-[4/5] overflow-hidden bg-gray-100 cursor-zoom-in"
                                     @click="openModal({{ $product->id }}, '{{ $product->name }}', {{ $product->images->map(fn($img) => asset($img->image_path)) }})">
                                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="object-cover w-full h-full transition duration-500 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <span class="bg-white/90 p-2 rounded-full shadow-lg text-lg">🔍</span>
                                    </div>
                                </div>

                                <div class="p-4 flex flex-col flex-grow">
                                    <h4 class="text-sm font-bold text-gray-800 mb-2">{{ $product->name }}</h4>

                                    @if($product->colors && count($product->colors) > 0)
                                        <div class="flex gap-1.5 mb-4">
                                            @foreach($product->colors as $color)
                                                <div class="w-4 h-4 rounded-full border border-gray-200 shadow-sm" style="background-color: {{ $color }};"></div>
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-50">
                                        <span class="text-lg font-black text-gray-900">₱{{ number_format($product->price, 2) }}</span>
                                        <a href="{{ route('cart.add', $product->id) }}" class="bg-indigo-600 hover:bg-black text-white p-2 rounded-lg transition-colors shadow-md">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center bg-white rounded-xl border-2 border-dashed border-gray-200">
                                <p class="text-gray-500 italic">No clothes added yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. MODAL OVERLAY WITH INTERNAL SCROLL & CART BUTTONS --}}
        <div x-show="open" 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @keydown.escape.window="open = false"
             style="display: none;">
            
            <div class="bg-white rounded-3xl max-w-4xl w-full h-[90vh] overflow-hidden relative shadow-2xl flex flex-col md:flex-row" @click.away="open = false">
                
                <button @click="open = false" class="absolute top-4 right-4 z-50 bg-white/90 p-2 rounded-full hover:bg-white shadow-md transition">
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                {{-- LEFT SIDE: SCROLLABLE GALLERY WITH BUTTON OVERLAYS --}}
                <div class="md:w-2/3 bg-gray-100 h-full overflow-y-auto p-6 custom-scrollbar">
                    <div class="space-y-6">
                        <template x-for="img in currentImages" :key="img">
                            <div class="relative group">
                                <img :src="img" class="w-full rounded-2xl shadow-sm border border-gray-200">
                                
                                {{-- HOVER BUTTON WITH SELECTED IMAGE PARAMETER --}}
                                <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <a :href="'/add-to-cart/' + currentId + '?selected_image=' + encodeURIComponent(img)" 
                                       class="bg-indigo-600 hover:bg-black text-white px-4 py-2 rounded-xl shadow-xl flex items-center gap-2 font-bold text-sm tracking-wide transition-all active:scale-95">
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
                <div class="md:w-1/3 p-8 flex flex-col justify-center bg-white border-l border-gray-50">
                    <h3 class="text-2xl font-black text-gray-900 mb-2" x-text="currentName"></h3>
                    <p class="text-indigo-600 text-xs mb-6 uppercase tracking-[0.2em] font-black">Selection Gallery</p>
                    
                    <div class="bg-gray-50 p-4 rounded-2xl mb-8 border border-gray-100">
                        <p class="text-gray-600 text-sm leading-relaxed italic">
                            Browse the colors on the left. Hover over any photo to add that specific item to your cart! ✨
                        </p>
                    </div>

                    <button @click="open = false" class="w-full bg-black text-white py-4 rounded-2xl font-bold uppercase tracking-widest hover:bg-gray-800 transition shadow-lg active:scale-95">
                        Close Gallery
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
    </style>
</x-app-layout>