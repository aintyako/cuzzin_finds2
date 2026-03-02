<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard 👑') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl shadow-sm flex items-center gap-3">
                    <span class="text-xl">✅</span>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            {{-- 
                SIDE-BY-SIDE GRID 
            --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">

                {{-- CHART SECTION --}}
                <div class="bg-white shadow-sm sm:rounded-xl p-6 border border-gray-100 flex flex-col">
                    <div class="mb-6">
                        {{-- Updated Header Logic --}}
                        <h3 class="text-xl font-bold text-gray-900">Total Stock Overview</h3>
                        <p class="text-sm text-gray-500">Total individual items (images) available per category</p>
                    </div>

                    <div id="categoryChart" class="w-full mt-auto"></div>
                </div>

                {{-- RECENT ACTIVITY LOGS SECTION --}}
                <div class="bg-white shadow-sm sm:rounded-xl p-6 border border-gray-100 flex flex-col">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Recent Activity Logs 📝</h3>
                    
                    {{-- 
                        FIXED HEIGHT SCROLL CONTAINER 
                        max-h-[420px] matches the standard height of the ApexChart + Header 
                    --}}
                    <div class="overflow-y-auto pr-2 custom-scrollbar" style="max-height: 420px;">
                        @if(isset($recentProducts) && $recentProducts->count() > 0)
                            <ul class="divide-y divide-gray-100">
                                @foreach($recentProducts as $logProduct)
                                    <li class="py-4 flex justify-between items-center hover:bg-gray-50 transition rounded-lg px-2">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center text-lg shadow-sm">
                                                🛍️
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-900 leading-tight">
                                                    <span class="font-bold">{{ $logProduct->name }}</span> added to <span class="font-semibold text-indigo-600">{{ $logProduct->category->name ?? 'Uncategorized' }}</span>.
                                                </p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    {{ $logProduct->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="text-[10px] font-black px-2 py-1 bg-gray-100 text-gray-600 rounded-full tracking-widest">
                                                ₱{{ number_format($logProduct->price, 2) }}
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="py-20 text-center text-gray-400 italic">
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
            background: #f1f1f1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
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
                    fontFamily: 'inherit'
                },
                colors: ['#ec4899', '#4f46e5', '#eab308', '#06b6d4'], 
                plotOptions: {
                    bar: {
                        borderRadius: 6,
                        horizontal: false,
                        distributed: true,
                        columnWidth: '35%'
                    }
                },
                dataLabels: { 
                    enabled: true,
                    formatter: function (val) {
                        return val;
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },
                xaxis: { 
                    categories: labels,
                    position: 'bottom',
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                },
                yaxis: {
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: { show: true },
                    title: {
                        text: 'Total Individual Items',
                    }
                },
                legend: { show: false },
                tooltip: {
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