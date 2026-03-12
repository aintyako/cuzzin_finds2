<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#0f172a] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-6 py-4 rounded-xl shadow-sm flex items-center gap-3">
                    <span class="text-xl">✅</span>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">

                {{-- CHART SECTION --}}
                <div class="bg-[#1e293b] shadow-2xl sm:rounded-3xl p-8 border border-gray-800 flex flex-col">
                    <div class="mb-6">
                        <h3 class="text-xl font-black text-white italic tracking-tight">Total Stock Overview</h3>
                        <p class="text-sm text-gray-400 font-medium">Total individual items available per category</p>
                    </div>

                    <div id="categoryChart" class="w-full mt-auto"></div>
                </div>

                {{-- RECENT ACTIVITY LOGS SECTION --}}
                <div class="bg-[#1e293b] shadow-2xl sm:rounded-3xl p-8 border border-gray-800 flex flex-col">
                    <h3 class="text-xl font-black text-white italic tracking-tight mb-6">Recent Activity Logs 📝</h3>
                    
                    <div class="overflow-y-auto pr-2 custom-scrollbar" style="max-height: 420px;">
                        @if(isset($recentProducts) && $recentProducts->count() > 0)
                            <ul class="divide-y divide-gray-800">
                                @foreach($recentProducts as $logProduct)
                                    <li class="py-4 flex justify-between items-center hover:bg-white/5 transition rounded-xl px-3 group">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-xl bg-[#0f172a] border border-gray-700 flex items-center justify-center text-lg shadow-inner group-hover:border-indigo-500 transition">
                                                🛍️
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-300 leading-tight">
                                                    <span class="font-black text-white">{{ $logProduct->name }}</span> 
                                                    <span class="text-gray-500 font-medium">added to</span> 
                                                    <span class="font-black text-indigo-400">{{ $logProduct->category->name ?? 'Uncategorized' }}</span>
                                                </p>
                                                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-1">
                                                    {{ $logProduct->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="text-[10px] font-black px-3 py-1.5 bg-[#0f172a] text-indigo-400 border border-indigo-500/30 rounded-full tracking-widest">
                                                ₱{{ number_format($logProduct->price, 2) }}
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="py-20 text-center text-gray-500 italic font-medium">
                                No products added yet! 
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #0f172a;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #4f46e5;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const labels = @json($chartLabels);
            const data = @json($chartData);

            var options = {
                series: [{ name: 'Total Stock', data: data }],
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: { show: false },
                    fontFamily: 'inherit',
                    foreColor: '#94a3b8' // Slate 400 for axis labels
                },
                grid: {
                    borderColor: '#334155', // Slate 700 for grid lines
                    strokeDashArray: 4,
                },
                colors: ['#6366f1', '#8b5cf6', '#ec4899', '#f59e0b'], 
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        horizontal: false,
                        distributed: true,
                        columnWidth: '40%'
                    }
                },
                dataLabels: { 
                    enabled: true,
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        fontWeight: '900',
                        colors: ["#ffffff"]
                    }
                },
                xaxis: { 
                    categories: labels,
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                },
                yaxis: {
                    labels: {
                        style: { fontWeight: '600' }
                    },
                    title: {
                        text: 'Total Items',
                        style: { color: '#6366f1', fontWeight: '900' }
                    }
                },
                legend: { show: false },
                tooltip: {
                    theme: 'dark',
                    y: {
                        formatter: function (val) {
                            return val + " items";
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#categoryChart"), options);
            chart.render();
        });
    </script>
</x-app-layout>