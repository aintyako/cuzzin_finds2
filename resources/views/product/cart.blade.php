<x-app-layout>
    {{-- Include SweetAlert2 Library --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="max-w-5xl mx-auto px-6 py-16 min-h-screen">
        
        <div class="flex items-center justify-between mb-10">
            <h2 class="text-3xl font-black text-gray-900 tracking-tight italic">Your Cart 🛒</h2>
            <span class="bg-indigo-100 text-indigo-700 px-4 py-1 rounded-full text-xs font-black uppercase tracking-widest">
                {{ count(session('cart', [])) }} Items
            </span>
        </div>

        @if(session('cart') && count(session('cart')) > 0)
            <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50/50 border-b border-gray-100">
                            <tr>
                                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Product Details</th>
                                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Price</th>
                                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Qty</th>
                                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Total</th>
                                <th class="px-8 py-5 text-right"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach(session('cart') as $id => $details)
                                <tr class="group transition-colors hover:bg-gray-50/30">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center">
                                            <div class="w-16 h-20 flex-shrink-0 overflow-hidden rounded-xl border border-gray-100 shadow-sm bg-gray-50">
                                                <img src="{{ asset($details['image']) }}" 
                                                     class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                                            </div>
                                            <div class="ml-6">
                                                <p class="font-black text-gray-900 text-sm leading-tight">{{ $details['name'] }}</p>
                                                <p class="text-[10px] text-indigo-500 font-bold uppercase mt-1">Unique ID: {{ substr($id, 0, 8) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-sm font-bold text-gray-600">
                                        ₱{{ number_format($details['price'], 2) }}
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 text-xs font-black text-gray-900">
                                            {{ $details['quantity'] }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-sm font-black text-gray-900">
                                        ₱{{ number_format($details['price'] * $details['quantity'], 2) }}
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        {{-- 1. HIDDEN FORM: Triggers via JavaScript --}}
                                        <form id="remove-form-{{ $id }}" action="{{ route('cart.remove', $id) }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>

                                        {{-- 2. CUSTOM BUTTON: Triggers the SweetAlert --}}
                                        <button type="button" 
                                                onclick="confirmDelete('{{ $id }}')" 
                                                class="text-red-400 hover:text-red-600 transition p-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="bg-gray-50/50 p-8 md:p-10 border-t border-gray-100">
                    <div class="flex flex-col md:flex-row justify-between items-end gap-6">
                        <div class="mb-2">
                            <a href="{{ route('shop.catalog') }}" class="inline-flex items-center text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-indigo-600 transition-colors">
                                <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Continue Shopping
                            </a>
                        </div>
                        
                        <div class="flex flex-col items-end">
                            <div class="text-right mb-4">
                                <p class="text-[9px] text-gray-400 font-black uppercase tracking-[0.3em] mb-1">Grand Total Bill</p>
                                <h3 class="text-3xl font-black text-gray-900 tracking-tight">
                                    ₱{{ number_format($total, 2) }}
                                </h3>
                            </div>

                            <button class="bg-[#5850ec] hover:bg-black text-white px-10 py-3.5 rounded-xl font-bold uppercase tracking-widest text-[11px] transition-all shadow-lg hover:shadow-indigo-200/50 transform hover:-translate-y-0.5 active:scale-95">
                                Proceed to Checkout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-32 bg-white rounded-3xl border-2 border-dashed border-gray-200">
                <div class="mb-6 text-7xl animate-bounce">🛍️</div>
                <h3 class="text-2xl font-black text-gray-900 mb-2">Your cart is empty!</h3>
                <p class="text-gray-500 font-medium">Let's find something amazing to add.</p>
                <a href="{{ route('shop.catalog') }}" class="mt-10 inline-block bg-indigo-600 text-white px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-black transition-all shadow-lg">
                    Discover New Arrivals
                </a>
            </div>
        @endif
    </div>

    {{-- SweetAlert Logic --}}
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to remove this beautiful item? 🛍️",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5850ec',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'No, keep it',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl font-bold uppercase tracking-widest text-xs px-6 py-3',
                    cancelButton: 'rounded-xl font-bold uppercase tracking-widest text-xs px-6 py-3'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('remove-form-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>