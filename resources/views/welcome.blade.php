<x-app-layout :hide-nav="true">
    <div class="relative min-h-screen w-full bg-[#0b0e1a] overflow-hidden text-white flex flex-col items-center justify-center py-16 px-6">
        
        {{-- Route-map background --}}
        <img src="{{ asset('build/images/home.png') }}" 
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/60"></div>

        {{-- Heading --}}
        <div class="relative z-10 text-center mb-10">
            <h1 class="text-4xl md:text-6xl font-black text-[#d4af37] tracking-widest uppercase mb-4">
                Cuzzin Finds
            </h1>
            <p class="text-gray-300 text-sm md:text-base tracking-wide max-w-md mx-auto">
                Real finds, straight from the source — Bangkok, Seoul, Tokyo &amp; beyond.
            </p>
        </div>

        {{-- Layered 3d photo tiles on top --}}
        <div class="relative z-10 flex items-center justify-center h-[320px] w-full max-w-3xl">
            <div class="absolute w-[220px] h-[280px] rounded-2xl overflow-hidden border-[3px] border-[#d4af37]/50"
                 style="transform: translateX(-240px) rotate(-8deg) perspective(700px) rotateY(18deg); box-shadow: -15px 25px 40px rgba(0,0,0,0.5);">
                <img src="{{ asset('build/images/bangkok.jpg') }}" class="w-full h-full object-cover" alt="Bangkok">
            </div>

            <div class="absolute w-[220px] h-[280px] z-10 rounded-2xl overflow-hidden border-[3px] border-[#d4af37]/60"
                 style="box-shadow: 0 25px 45px rgba(0,0,0,0.6);">
                <img src="{{ asset('build/images/korea.jpg') }}" class="w-full h-full object-cover" alt="Korea">
            </div>

            <div class="absolute w-[220px] h-[280px] rounded-2xl overflow-hidden border-[3px] border-[#d4af37]/50"
                 style="transform: translateX(240px) rotate(8deg) perspective(700px) rotateY(-18deg); box-shadow: 15px 25px 40px rgba(0,0,0,0.5);">
                <img src="{{ asset('build/images/japan.jpg') }}" class="w-full h-full object-cover" alt="Japan">
            </div>
        </div>

        {{-- CTA --}}
        <a href="{{ route('shop.catalog') }}" class="relative z-10 mt-10 bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-4 rounded-md font-bold transition shadow-2xl">
            Start Shopping
        </a>

        {{-- Trust badges --}}
        <div class="relative z-10 mt-12 grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-4xl w-full text-center">
            <div class="bg-white/5 border border-white/10 rounded-3xl py-5 px-6 backdrop-blur-sm">
                <p class="text-2xl font-black text-[#d4af37]">Trust</p>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400 mt-2">Secure checkout</p>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-3xl py-5 px-6 backdrop-blur-sm">
                <p class="text-2xl font-black text-[#d4af37]">Fast</p>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400 mt-2">Free shipping over ₱1,500</p>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-3xl py-5 px-6 backdrop-blur-sm">
                <p class="text-2xl font-black text-[#d4af37]">Loved</p>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400 mt-2">1,000+ happy shoppers</p>
            </div>
        </div>

        {{-- Featured categories --}}
        <div class="relative z-10 mt-14 w-full max-w-6xl grid gap-5 sm:grid-cols-3">
            <a href="{{ route('product.clothes') }}" class="group block rounded-3xl border border-white/10 bg-white/5 p-6 transition hover:border-indigo-500/40 hover:bg-indigo-500/5">
                <p class="text-sm uppercase tracking-[0.3em] text-gray-500">Featured</p>
                <h3 class="mt-4 text-xl font-black text-white">Clothes</h3>
                <p class="mt-3 text-sm text-gray-400">Streetwear, cozy fits, and curated fashion from across Asia.</p>
            </a>
            <a href="{{ route('product.skincare') }}" class="group block rounded-3xl border border-white/10 bg-white/5 p-6 transition hover:border-indigo-500/40 hover:bg-indigo-500/5">
                <p class="text-sm uppercase tracking-[0.3em] text-gray-500">Featured</p>
                <h3 class="mt-4 text-xl font-black text-white">Skincare</h3>
                <p class="mt-3 text-sm text-gray-400">K-beauty essentials, glossy skin care, and glow-ready routines.</p>
            </a>
            <a href="{{ route('wishlist.index') }}" class="group block rounded-3xl border border-white/10 bg-white/5 p-6 transition hover:border-indigo-500/40 hover:bg-indigo-500/5">
                <p class="text-sm uppercase tracking-[0.3em] text-gray-500">Must-check</p>
                <h3 class="mt-4 text-xl font-black text-white">Wishlist</h3>
                <p class="mt-3 text-sm text-gray-400">Save your favorite finds and revisit them whenever you’re ready.</p>
            </a>
        </div>
    </div>
</x-app-layout>