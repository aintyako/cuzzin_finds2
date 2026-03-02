<x-app-layout>
    <div class="relative h-screen w-full bg-gray-900 overflow-hidden text-white flex items-center">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('build/images/cuzzin_finds.jpg') }}" 
                 class="w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-r from-black via-black/80 to-transparent"></div>
        </div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
            <div class="md:w-1/2">
                <h1 class="text-4xl md:text-6xl font-black text-[#d4af37] tracking-widest uppercase mb-4">
                    Bangkok<br>Pasabuy
                </h1>
            </div>

            <div class="md:w-1/2 flex flex-col items-center text-center">
                <h2 class="text-3xl font-bold mb-3">Discover Your Style</h2>
                <p class="text-gray-300 mb-6 max-w-md">Browse the latest fashion curated just for you.</p>
                
                <a href="{{ route('shop.catalog') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-4 rounded-md font-bold transition shadow-2xl scale-110">
                    Start Shopping
                </a>
            </div>
        </div>
    </div>
</x-app-layout>