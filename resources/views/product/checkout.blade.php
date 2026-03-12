<x-app-layout>
    {{-- Main Container - Now with a deep dark background --}}
    <div class="bg-[#0f172a] text-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 py-16">
            <div class="mb-10">
                <h2 class="text-3xl font-black text-white tracking-tight italic">Finalize Order 💳</h2>
                <p class="text-gray-400 font-medium mt-2">Complete your details to finish the purchase.</p>
            </div>

            <form action="{{ route('order.place') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                @csrf
                
                <div class="lg:col-span-7 space-y-8">
                    {{-- Shipping Information Card --}}
                    <div class="bg-[#1e293b] p-8 rounded-3xl shadow-2xl border border-gray-700/50">
                        <h3 class="text-sm font-black uppercase tracking-[0.2em] text-indigo-400 mb-6">Shipping Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase text-gray-500 ml-1">Full Name</label>
                                <input type="text" name="name" required class="w-full px-5 py-3.5 bg-[#0f172a] border border-gray-700 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-bold text-sm text-white outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase text-gray-500 ml-1">Email Address</label>
                                <input type="email" name="email" required class="w-full px-5 py-3.5 bg-[#0f172a] border border-gray-700 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-bold text-sm text-white outline-none">
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-[10px] font-black uppercase text-gray-500 ml-1">Shipping Address</label>
                                <textarea name="address" rows="3" required class="w-full px-5 py-3.5 bg-[#0f172a] border border-gray-700 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-bold text-sm text-white outline-none"></textarea>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase text-gray-500 ml-1">City</label>
                                <input type="text" name="city" required class="w-full px-5 py-3.5 bg-[#0f172a] border border-gray-700 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-bold text-sm text-white outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase text-gray-500 ml-1">Phone Number</label>
                                <input type="text" name="phone" required class="w-full px-5 py-3.5 bg-[#0f172a] border border-gray-700 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-bold text-sm text-white outline-none">
                            </div>
                        </div>
                    </div>

                    {{-- Payment Method Card --}}
                    <div class="bg-[#1e293b] p-8 rounded-3xl shadow-2xl border border-gray-700/50">
                        <h3 class="text-sm font-black uppercase tracking-[0.2em] text-indigo-400 mb-6">Payment Method</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <label class="relative flex items-center justify-center p-4 border-2 rounded-2xl cursor-pointer transition-all border-indigo-500 bg-indigo-500/10" id="label-cod">
                                <input type="radio" name="payment_method" value="cod" checked class="hidden" onchange="toggleOnlineOptions(false)">
                                <span class="text-xs font-black uppercase text-indigo-400">Cash on Delivery</span>
                            </label>

                            <label class="relative flex items-center justify-center p-4 border-2 rounded-2xl cursor-pointer transition-all border-gray-700 bg-transparent hover:border-gray-500" id="label-online">
                                <input type="radio" name="payment_method" value="online" class="hidden" onchange="toggleOnlineOptions(true)">
                                <span class="text-xs font-black uppercase text-gray-500" id="text-online">Online Payment</span>
                            </label>
                        </div>

                        {{-- Hidden Online Options --}}
                        <div id="online-payment-options" class="hidden space-y-4 pt-4 border-t border-dashed border-gray-700 animate-fade-in-down">
                            <p class="text-[10px] font-black uppercase text-gray-500 ml-1">Select Provider</p>
                            <div class="grid grid-cols-3 gap-3">
                                <label class="flex flex-col items-center p-3 border border-gray-700 rounded-xl hover:bg-indigo-500/10 cursor-pointer transition-all group">
                                    <input type="radio" name="online_provider" value="gcash" class="mb-2 accent-indigo-500">
                                    <span class="text-[10px] font-bold text-gray-400 group-hover:text-indigo-400">GCash</span>
                                </label>
                                <label class="flex flex-col items-center p-3 border border-gray-700 rounded-xl hover:bg-indigo-500/10 cursor-pointer transition-all group">
                                    <input type="radio" name="online_provider" value="maya" class="mb-2 accent-indigo-500">
                                    <span class="text-[10px] font-bold text-gray-400 group-hover:text-indigo-400">Maya</span>
                                </label>
                                <label class="flex flex-col items-center p-3 border border-gray-700 rounded-xl hover:bg-indigo-500/10 cursor-pointer transition-all group">
                                    <input type="radio" name="online_provider" value="card" class="mb-2 accent-indigo-500">
                                    <span class="text-[10px] font-bold text-gray-400 group-hover:text-indigo-400">Card</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Side: Order Summary --}}
                <div class="lg:col-span-5">
                    <div class="bg-[#0f172a] rounded-3xl p-8 sticky top-8 text-white shadow-2xl border border-gray-800">
                        <h3 class="text-sm font-black uppercase tracking-[0.2em] text-indigo-400 mb-8">Order Summary</h3>
                        
                        <div class="space-y-6 mb-8 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
                            @foreach(session('cart') as $id => $details)
                            <div class="flex items-center justify-between group">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-white/5 rounded-xl overflow-hidden flex-shrink-0 border border-gray-800">
                                        <img src="{{ asset($details['image']) }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition">
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold leading-tight text-gray-200">{{ $details['name'] }}</p>
                                        <p class="text-[10px] text-gray-500">Qty: {{ $details['quantity'] }}</p>
                                    </div>
                                </div>
                                <p class="text-sm font-black text-gray-200">₱{{ number_format($details['price'] * $details['quantity'], 2) }}</p>
                            </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-800 pt-6 space-y-4">
                            <div class="flex justify-between text-gray-500">
                                <span class="text-xs font-bold uppercase">Subtotal</span>
                                <span class="font-bold">₱{{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-500">
                                <span class="text-xs font-bold uppercase">Shipping</span>
                                <span class="font-bold text-emerald-500">FREE</span>
                            </div>
                            <div class="flex justify-between items-end pt-4">
                                <span class="text-sm font-black uppercase tracking-widest text-indigo-400">Total</span>
                                <span class="text-3xl font-black text-white">₱{{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full mt-10 bg-indigo-600 hover:bg-indigo-500 text-white py-5 rounded-2xl font-black uppercase tracking-widest text-xs transition-all transform active:scale-95 shadow-xl shadow-indigo-500/20">
                            Place My Order
                        </button>
                        
                        <a href="{{ route('cart.index') }}" class="block text-center mt-6 text-[10px] font-black uppercase tracking-widest text-gray-600 hover:text-gray-400 transition-colors">
                            Go back to cart
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Dark Mode Toggling Logic --}}
    <script>
        function toggleOnlineOptions(show) {
            const onlineOptions = document.getElementById('online-payment-options');
            const labelCod = document.getElementById('label-cod');
            const labelOnline = document.getElementById('label-online');
            const textOnline = document.getElementById('text-online');

            if (show) {
                onlineOptions.classList.remove('hidden');
                labelOnline.classList.replace('border-gray-700', 'border-indigo-500');
                labelOnline.classList.add('bg-indigo-500/10');
                textOnline.classList.replace('text-gray-500', 'text-indigo-400');
                
                labelCod.classList.replace('border-indigo-500', 'border-gray-700');
                labelCod.classList.remove('bg-indigo-500/10');
                labelCod.querySelector('span').classList.replace('text-indigo-400', 'text-gray-500');
            } else {
                onlineOptions.classList.add('hidden');
                labelCod.classList.replace('border-gray-700', 'border-indigo-500');
                labelCod.classList.add('bg-indigo-500/10');
                labelCod.querySelector('span').classList.replace('text-gray-500', 'text-indigo-400');

                labelOnline.classList.replace('border-indigo-500', 'border-gray-700');
                labelOnline.classList.remove('bg-indigo-500/10');
                textOnline.classList.replace('text-indigo-400', 'text-gray-500');
            }
        }
    </script>

    <style>
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down {
            animation: fadeInDown 0.3s ease-out forwards;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        /* Overriding some default input styles for dark mode browsers */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus {
            -webkit-text-fill-color: white;
            -webkit-box-shadow: 0 0 0px 1000px #0f172a inset;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</x-app-layout>