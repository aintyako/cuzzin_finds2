<x-app-layout>
    <div class="bg-[#0f172a] text-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 py-16">
            <div class="mb-10">
                <h2 class="text-3xl md:text-4xl font-black text-white tracking-tight">Checkout</h2>
                <p class="text-gray-400 mt-2 max-w-2xl">Enter your shipping details, choose a payment option, and review your order before confirming.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                <div class="lg:col-span-7 space-y-8">
                    <div class="bg-[#1e293b] rounded-3xl border border-gray-800 p-8 shadow-xl">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em] text-indigo-400 font-black">Shipping information</p>
                                <h3 class="mt-4 text-xl font-black text-white">Customer details</h3>
                            </div>
                            <span class="inline-flex items-center rounded-full bg-indigo-500/10 text-indigo-300 text-[10px] uppercase tracking-[0.3em] font-bold px-3 py-2">Required</span>
                        </div>

                        <form action="{{ route('checkout.review') }}" method="POST" class="space-y-6 mt-8">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[11px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Full Name</label>
                                    <input type="text" name="name" required value="{{ old('name') }}" class="w-full rounded-3xl border border-gray-700 bg-[#0f172a] px-5 py-3 text-sm font-bold text-white outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" />
                                    @error('name')<p class="mt-2 text-xs text-rose-400">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-[11px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Email Address</label>
                                    <input type="email" name="email" required value="{{ old('email') }}" class="w-full rounded-3xl border border-gray-700 bg-[#0f172a] px-5 py-3 text-sm font-bold text-white outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" />
                                    @error('email')<p class="mt-2 text-xs text-rose-400">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Shipping Address</label>
                                <textarea name="address" rows="3" required class="w-full rounded-3xl border border-gray-700 bg-[#0f172a] px-5 py-3 text-sm font-bold text-white outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">{{ old('address') }}</textarea>
                                @error('address')<p class="mt-2 text-xs text-rose-400">{{ $message }}</p>@enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[11px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">City</label>
                                    <input type="text" name="city" required value="{{ old('city') }}" class="w-full rounded-3xl border border-gray-700 bg-[#0f172a] px-5 py-3 text-sm font-bold text-white outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" />
                                    @error('city')<p class="mt-2 text-xs text-rose-400">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-[11px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Phone Number</label>
                                    <input type="text" name="phone" required value="{{ old('phone') }}" class="w-full rounded-3xl border border-gray-700 bg-[#0f172a] px-5 py-3 text-sm font-bold text-white outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" />
                                    @error('phone')<p class="mt-2 text-xs text-rose-400">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="rounded-3xl border border-gray-700 bg-[#111827] p-6">
                                <p class="text-[11px] uppercase tracking-[0.3em] text-gray-500 mb-4">Payment method</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <label class="cursor-pointer rounded-3xl border border-gray-700 bg-white/5 p-4 transition hover:border-indigo-500">
                                        <input type="radio" name="payment_method" value="cod" checked class="sr-only" onchange="toggleOnlineOptions(false)">
                                        <div class="flex items-center justify-between gap-4">
                                            <div>
                                                <p class="text-sm font-black text-white">Cash on Delivery</p>
                                                <p class="text-xs text-gray-400 mt-1">Pay when you receive your order.</p>
                                            </div>
                                            <span class="inline-flex items-center rounded-full bg-indigo-500/10 px-3 py-1 text-[10px] uppercase tracking-[0.2em] text-indigo-300">Fast</span>
                                        </div>
                                    </label>
                                    <label class="cursor-pointer rounded-3xl border border-gray-700 bg-white/5 p-4 transition hover:border-indigo-500">
                                        <input type="radio" name="payment_method" value="online" class="sr-only" onchange="toggleOnlineOptions(true)">
                                        <div class="flex items-center justify-between gap-4">
                                            <div>
                                                <p class="text-sm font-black text-white">Online Payment</p>
                                                <p class="text-xs text-gray-400 mt-1">Choose GCash, Maya, or Card.</p>
                                            </div>
                                            <span class="inline-flex items-center rounded-full bg-indigo-500/10 px-3 py-1 text-[10px] uppercase tracking-[0.2em] text-indigo-300">Secure</span>
                                        </div>
                                    </label>
                                </div>

                                <div id="online-payment-options" class="mt-6 hidden rounded-3xl border border-gray-700 bg-[#0f172a] p-4">
                                    <p class="text-[10px] uppercase tracking-[0.3em] text-gray-500 mb-4">Choose provider</p>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        <label class="provider-option relative cursor-pointer rounded-3xl border border-gray-700 bg-white/5 p-4 text-center text-sm text-gray-300 transition hover:border-indigo-500 hover:text-indigo-100">
                                            <input id="provider-gcash" type="radio" name="online_provider" value="gcash" class="provider-radio sr-only" />
                                            <div class="font-black uppercase tracking-[0.2em] text-indigo-300">GCash</div>
                                            <div class="text-[10px] text-gray-400 mt-2">Scan QR or use app transfer.</div>
                                            <span class="option-marker absolute right-4 top-4 h-4 w-4 rounded-full border border-gray-500"></span>
                                        </label>
                                        <label class="provider-option relative cursor-pointer rounded-3xl border border-gray-700 bg-white/5 p-4 text-center text-sm text-gray-300 transition hover:border-indigo-500 hover:text-indigo-100">
                                            <input id="provider-maya" type="radio" name="online_provider" value="maya" class="provider-radio sr-only" />
                                            <div class="font-black uppercase tracking-[0.2em] text-indigo-300">Maya</div>
                                            <div class="text-[10px] text-gray-400 mt-2">Pay with your Maya wallet.</div>
                                            <span class="option-marker absolute right-4 top-4 h-4 w-4 rounded-full border border-gray-500"></span>
                                        </label>
                                        <label class="provider-option relative cursor-pointer rounded-3xl border border-gray-700 bg-white/5 p-4 text-center text-sm text-gray-300 transition hover:border-indigo-500 hover:text-indigo-100">
                                            <input id="provider-card" type="radio" name="online_provider" value="card" class="provider-radio sr-only" />
                                            <div class="font-black uppercase tracking-[0.2em] text-indigo-300">Card</div>
                                            <div class="text-[10px] text-gray-400 mt-2">Use Visa, Mastercard, or JCB.</div>
                                            <span class="option-marker absolute right-4 top-4 h-4 w-4 rounded-full border border-gray-500"></span>
                                        </label>
                                    </div>
                                    <p class="mt-4 text-[10px] uppercase tracking-[0.3em] text-gray-500">You can switch back to cash if you prefer payment on delivery.</p>
                                </div>
                            </div>

                            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                <div class="rounded-3xl border border-gray-700 bg-white/5 p-4 text-sm text-gray-300">
                                    <p class="font-black uppercase tracking-[0.3em] text-gray-400">Need help?</p>
                                    <p class="mt-2 text-xs">We’ll guide you through order review and confirmation.</p>
                                </div>
                                <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-indigo-600 px-6 py-4 text-sm font-black uppercase tracking-[0.2em] text-white transition hover:bg-indigo-500">Review Order</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="space-y-6">
                        <div class="rounded-3xl border border-gray-800 bg-[#0f172a] p-8 shadow-xl">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] uppercase tracking-[0.3em] text-indigo-400 font-black">Order summary</p>
                                    <h3 class="mt-3 text-xl font-black text-white">Review before next step</h3>
                                </div>
                                <span class="rounded-full bg-white/5 px-3 py-1 text-xs uppercase tracking-[0.2em] text-gray-400">{{ count(session('cart', [])) }} items</span>
                            </div>

                            <div class="mt-8 space-y-4 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
                                @foreach(session('cart') as $id => $details)
                                    <div class="flex items-center justify-between gap-3 rounded-3xl border border-gray-800 bg-white/5 p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-16 w-16 overflow-hidden rounded-3xl bg-[#111827] border border-gray-700">
                                                <img src="{{ asset($details['image']) }}" class="h-full w-full object-cover" alt="{{ $details['name'] }}">
                                            </div>
                                            <div>
                                                <p class="font-black text-white">{{ $details['name'] }}</p>
                                                <p class="text-xs text-gray-400">Qty {{ $details['quantity'] }}</p>
                                            </div>
                                        </div>
                                        <p class="font-black text-white">₱{{ number_format($details['price'] * $details['quantity'], 2) }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-6 space-y-3 border-t border-gray-800 pt-5 text-sm text-gray-300">
                                <div class="flex justify-between">
                                    <span>Subtotal</span>
                                    <span>₱{{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Shipping</span>
                                    <span class="text-emerald-400">FREE</span>
                                </div>
                                <div class="flex justify-between font-black text-white text-lg">
                                    <span>Total</span>
                                    <span>₱{{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-gray-800 bg-[#111827] p-8 shadow-xl">
                            <p class="text-[11px] uppercase tracking-[0.3em] text-indigo-400 font-black mb-4">Checkout confidence</p>
                            <div class="grid gap-4 text-sm text-gray-300">
                                <div class="flex items-center gap-3 rounded-3xl border border-gray-700 bg-[#0f172a] p-4">
                                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-indigo-500/10 text-indigo-300">✓</span>
                                    <p>Secure checkout backed by trusted payment options.</p>
                                </div>
                                <div class="flex items-center gap-3 rounded-3xl border border-gray-700 bg-[#0f172a] p-4">
                                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-indigo-500/10 text-indigo-300">✓</span>
                                    <p>Track your order from payment to delivery.</p>
                                </div>
                                <div class="flex items-center gap-3 rounded-3xl border border-gray-700 bg-[#0f172a] p-4">
                                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-indigo-500/10 text-indigo-300">✓</span>
                                    <p>Easy support if you need help with your order.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleOnlineOptions(show) {
            const onlineOptions = document.getElementById('online-payment-options');
            const providerRadios = document.querySelectorAll('input[name="online_provider"]');

            if (show) {
                onlineOptions.classList.remove('hidden');
                providerRadios.forEach(function (radio) {
                    radio.required = true;
                });
            } else {
                onlineOptions.classList.add('hidden');
                providerRadios.forEach(function (radio) {
                    radio.required = false;
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const options = document.querySelectorAll('.provider-option');
            options.forEach(function (option) {
                option.addEventListener('click', function () {
                    const input = this.querySelector('.provider-radio');
                    if (input) {
                        input.checked = true;
                        options.forEach(function (other) {
                            other.classList.remove('border-indigo-500', 'bg-indigo-500/10', 'text-white');
                        });
                        this.classList.add('border-indigo-500', 'bg-indigo-500/10', 'text-white');
                    }
                });
            });
        });
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.12); border-radius: 999px; }
    </style>
</x-app-layout>