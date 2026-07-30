<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white tracking-tight">
            {{ __('Product Sales Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-[#0f172a] min-h-screen text-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- TOP FILTERS BAR --}}
            <div class="flex flex-wrap items-center gap-4 text-xs font-semibold">
                <div class="bg-[#1e293b] rounded-xl shadow-sm border border-gray-800 px-4 py-2 flex flex-col">
                    <span class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Auto date range</span>
                    <select class="bg-transparent text-white font-bold border-none p-0 focus:ring-0 text-xs cursor-pointer">
                        <option class="bg-[#1e293b]">This Week</option>
                        <option class="bg-[#1e293b]">This Month</option>
                        <option class="bg-[#1e293b]">Last 30 Days</option>
                    </select>
                </div>

                <div class="bg-[#1e293b] rounded-xl shadow-sm border border-gray-800 px-4 py-2 flex flex-col">
                    <span class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Services</span>
                    <select class="bg-transparent text-white font-bold border-none p-0 focus:ring-0 text-xs cursor-pointer">
                        <option class="bg-[#1e293b]">All</option>
                    </select>
                </div>

                <div class="bg-[#1e293b] rounded-xl shadow-sm border border-gray-800 px-4 py-2 flex flex-col">
                    <span class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Posts</span>
                    <select class="bg-transparent text-white font-bold border-none p-0 focus:ring-0 text-xs cursor-pointer">
                        <option class="bg-[#1e293b]">All</option>
                    </select>
                </div>
            </div>

            {{-- MAIN DASHBOARD GRID --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                {{-- LEFT COLUMN: KPI CARDS (Cols 3) --}}
                <div class="lg:col-span-3 flex flex-col gap-6">
                    {{-- Total Revenue Card --}}
                    <div class="bg-[#1e293b] rounded-2xl p-6 shadow-xl border border-gray-800 flex flex-col justify-between h-1/2">
                        <span class="text-xs font-medium text-gray-400">Total Revenue</span>
                        <div class="my-2">
                            <h3 class="text-4xl font-extrabold text-white tracking-tight">
                                ₱{{ number_format($totalRevenue ?? 0, 2) }}
                            </h3>
                            <p class="text-xs font-bold text-emerald-400 flex items-center gap-1 mt-1">
                                <span>↑ {{ $revenueGrowth ?? 0 }}%</span>
                            </p>
                        </div>
                        <span class="text-[11px] text-gray-500">vs previous period</span>
                    </div>

                    {{-- Sales Conversion Rate Card --}}
                    <div class="bg-[#1e293b] rounded-2xl p-6 shadow-xl border border-gray-800 flex flex-col justify-between h-1/2">
                        <span class="text-xs font-medium text-gray-400">Sales Conversion Rate</span>
                        <div class="my-2">
                            <h3 class="text-4xl font-extrabold text-white tracking-tight">{{ $conversionRate ?? 0 }}%</h3>
                            <p class="text-xs font-bold text-emerald-400 flex items-center gap-1 mt-1">
                                <span>{{ $conversionGrowth ?? 0 }}%</span>
                            </p>
                        </div>
                        <span class="text-[11px] text-gray-500">vs previous period</span>
                    </div>
                </div>

                {{-- MIDDLE COLUMN: SALES OVER TIME CHART (Cols 5) --}}
                <div class="lg:col-span-5 bg-[#1e293b] rounded-2xl p-6 shadow-xl border border-gray-800 flex flex-col justify-between">
                    <span class="text-xs font-medium text-gray-400 mb-2">Sales Over Time</span>
                    <div id="salesOverTimeChart" class="w-full h-full"></div>
                </div>

                {{-- RIGHT COLUMN: AVG SALES VALUE BAR CHART (Cols 4) --}}
                <div class="lg:col-span-4 bg-[#1e293b] rounded-2xl p-6 shadow-xl border border-gray-800 flex flex-col justify-between">
                    <span class="text-xs font-medium text-gray-400 mb-2">Avg Sales Value</span>
                    <div id="avgSalesChart" class="w-full h-full"></div>
                </div>

            </div>

            {{-- NEW SECTION: STOCK OVERVIEW & INVENTORY HEALTH --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                {{-- STOCK SUMMARY CARDS (Cols 4) --}}
                <div class="lg:col-span-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4">
                    {{-- Total Inventory Items --}}
                    <div class="bg-[#1e293b] rounded-2xl p-5 shadow-xl border border-gray-800 flex items-center justify-between">
                        <div>
                            <span class="text-xs font-medium text-gray-400 block">Total Items in Stock</span>
                            <h4 class="text-2xl font-bold text-white mt-1">{{ number_format($totalStock ?? 0) }}</h4>
                        </div>
                        <div class="p-3 bg-blue-500/10 text-blue-400 rounded-xl border border-blue-500/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                    </div>

                    {{-- Low Stock Warning --}}
                    <div class="bg-[#1e293b] rounded-2xl p-5 shadow-xl border border-gray-800 flex items-center justify-between">
                        <div>
                            <span class="text-xs font-medium text-gray-400 block">Low Stock Alert (≤ 5)</span>
                            <h4 class="text-2xl font-bold {{ ($lowStockCount ?? 0) > 0 ? 'text-amber-400' : 'text-white' }} mt-1">
                                {{ $lowStockCount ?? 0 }} Items
                            </h4>
                        </div>
                        <div class="p-3 bg-amber-500/10 text-amber-400 rounded-xl border border-amber-500/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                    </div>

                    {{-- Active Categories --}}
                    <div class="bg-[#1e293b] rounded-2xl p-5 shadow-xl border border-gray-800 flex items-center justify-between">
                        <div>
                            <span class="text-xs font-medium text-gray-400 block">Active Categories</span>
                            <h4 class="text-2xl font-bold text-white mt-1">{{ $totalCategories ?? 0 }}</h4>
                        </div>
                        <div class="p-3 bg-emerald-500/10 text-emerald-400 rounded-xl border border-emerald-500/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        </div>
                    </div>
                </div>

                {{-- RECENT PRODUCTS INVENTORY TABLE (Cols 8) --}}
                <div class="lg:col-span-8 bg-[#1e293b] rounded-2xl p-6 shadow-xl border border-gray-800 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Stock Overview & Recent Products</span>
                            <span class="text-[11px] text-gray-500">Showing latest {{ count($recentProducts ?? []) }} products</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs text-gray-400">
                                <thead class="text-[10px] text-gray-500 uppercase bg-[#0f172a]/50 rounded-lg">
                                    <tr>
                                        <th class="py-2.5 px-3">Product</th>
                                        <th class="py-2.5 px-3">Category</th>
                                        <th class="py-2.5 px-3">Price</th>
                                        <th class="py-2.5 px-3 text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-800">
                                    @forelse($recentProducts ?? [] as $product)
                                        <tr class="hover:bg-slate-800/40 transition">
                                            <td class="py-3 px-3 font-semibold text-white">
                                                {{ $product->name ?? 'Unnamed Product' }}
                                            </td>
                                            <td class="py-3 px-3">
                                                <span class="bg-slate-800 px-2 py-0.5 rounded text-[11px] text-gray-300">
                                                    {{ $product->category->name ?? 'Uncategorized' }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-3 font-medium text-gray-200">
                                                ₱{{ number_format($product->price ?? 0, 2) }}
                                            </td>
                                            <td class="py-3 px-3 text-right">
                                                @if(($product->quantity ?? $product->stock ?? 1) > 5)
                                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full border border-emerald-500/20">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> In Stock
                                                    </span>
                                                @elseif(($product->quantity ?? $product->stock ?? 1) > 0)
                                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-amber-400 bg-amber-500/10 px-2 py-0.5 rounded-full border border-amber-500/20">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> Low Stock
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-rose-400 bg-rose-500/10 px-2 py-0.5 rounded-full border border-rose-500/20">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> Out of Stock
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-6 text-center text-gray-500">
                                                No products found in inventory.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            {{-- BOTTOM ROW: LARGE CONVERSION RATE AREA CHART --}}
            <div class="bg-[#1e293b] rounded-2xl p-6 shadow-xl border border-gray-800">
                <span class="text-xs font-medium text-gray-400 block mb-4">Sales Conversion Rate</span>
                <div id="largeConversionChart" class="w-full h-72"></div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // DYNAMIC LARAVEL DATA VARIABLES
            const hourlyLabels = @json($hourlyLabels);
            const hourlySalesData = @json($hourlySalesData);

            const avgSalesLabels = @json($avgSalesLabels);
            const avgSalesData1 = @json($avgSalesData1);
            const avgSalesData2 = @json($avgSalesData2);

            const daysLabels = @json($daysLabels);
            const visitsData = @json($visitsData);
            const conversionsData = @json($conversionsData);

            // 1. SALES OVER TIME
            const salesOverTimeOptions = {
                series: [{ name: 'Sales', data: hourlySalesData }],
                chart: { type: 'line', height: 220, toolbar: { show: false }, foreColor: '#94a3b8' },
                stroke: { curve: 'smooth', width: 2.5, colors: ['#84cc16'] },
                grid: { borderColor: '#334155', strokeDashArray: 0 },
                xaxis: {
                    categories: hourlyLabels,
                    labels: { style: { colors: '#64748b', fontSize: '10px' } },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: { style: { colors: '#64748b', fontSize: '10px' } }
                },
                tooltip: { theme: 'dark' }
            };
            new ApexCharts(document.querySelector("#salesOverTimeChart"), salesOverTimeOptions).render();

            // 2. AVG SALES VALUE
            const avgSalesOptions = {
                series: [
                    { name: 'Primary Sales', data: avgSalesData1 },
                    { name: 'Secondary Sales', data: avgSalesData2 }
                ],
                chart: { type: 'bar', height: 220, stacked: true, toolbar: { show: false }, foreColor: '#94a3b8' },
                colors: ['#60a5fa', '#84cc16'],
                plotOptions: { bar: { columnWidth: '40%', borderRadius: 3 } },
                grid: { borderColor: '#334155' },
                xaxis: {
                    categories: avgSalesLabels,
                    labels: { style: { colors: '#64748b', fontSize: '10px' } },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: { style: { colors: '#64748b', fontSize: '10px' } }
                },
                legend: { show: false },
                dataLabels: { enabled: false },
                tooltip: { theme: 'dark' }
            };
            new ApexCharts(document.querySelector("#avgSalesChart"), avgSalesOptions).render();

            // 3. LARGE BOTTOM CONVERSION CHART
            const largeConversionOptions = {
                series: [
                    { name: 'Total Visits', data: visitsData },
                    { name: 'Conversions', data: conversionsData }
                ],
                chart: { type: 'area', height: 280, toolbar: { show: false }, foreColor: '#94a3b8' },
                colors: ['#475569', '#3b82f6'],
                fill: { type: 'solid', opacity: [0.4, 0.5] },
                stroke: { curve: 'smooth', width: 2 },
                grid: { borderColor: '#334155' },
                dataLabels: { enabled: false },
                xaxis: {
                    categories: daysLabels,
                    labels: { style: { colors: '#64748b', fontSize: '10px' } },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: { style: { colors: '#64748b', fontSize: '10px' } }
                },
                legend: { show: false },
                tooltip: { theme: 'dark' }
            };
            new ApexCharts(document.querySelector("#largeConversionChart"), largeConversionOptions).render();

        });
    </script>
</x-app-layout>