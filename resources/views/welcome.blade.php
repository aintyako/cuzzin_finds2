<x-app-layout>
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
    </div>
</x-app-layout>