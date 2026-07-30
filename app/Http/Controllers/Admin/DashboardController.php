<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order; // Ensure you have an Order model or replace with your checkout table
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. STAT CARDS DATA (Safely handles missing 'quantity' column)
        $totalProducts = Product::count();
        $totalCategories = Category::count();

        // Check if 'quantity' or 'stock' column exists to prevent QueryException
        if (Schema::hasColumn('products', 'quantity')) {
            $totalStock = Product::sum('quantity');
            $lowStockCount = Product::where('quantity', '<=', 5)->count();
        } elseif (Schema::hasColumn('products', 'stock')) {
            $totalStock = Product::sum('stock');
            $lowStockCount = Product::where('stock', '<=', 5)->count();
        } else {
            // Fallback if stock/quantity column isn't in your migration yet
            $totalStock = $totalProducts; 
            $lowStockCount = 0;
        }

        // 2. TOTAL REVENUE & CONVERSION
        $totalRevenue = 0;
        if (class_exists('App\Models\Order') && Schema::hasTable('orders')) {
            $totalRevenue = Order::sum('total_amount') ?? 0;
        }

        $revenueGrowth = 13;
        $conversionRate = 26;
        $conversionGrowth = 8;

        // 3. RECENT ACTIVITY LOGS
        $recentProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();

        // 4. CHART DATA: Hourly Sales Over Time (Today)
        $hourlySales = [];
        if (class_exists('App\Models\Order') && Schema::hasTable('orders')) {
            $hourlySales = Order::whereDate('created_at', today())
                ->select(
                    DB::raw('DATE_FORMAT(created_at, "%H:00") as hour'),
                    DB::raw('SUM(total_amount) as total')
                )
                ->groupBy('hour')
                ->pluck('total', 'hour')
                ->toArray();
        }

        $hourlyLabels = array_keys($hourlySales);
        $hourlySalesData = array_values($hourlySales);

        // Fallbacks if no sales recorded today yet
        if (empty($hourlyLabels)) {
            $hourlyLabels = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00'];
            $hourlySalesData = [0, 0, 0, 0, 0, 0, 0];
        }

        // 5. CHART DATA: Avg Sales Value (Weekly overview)
        $avgSalesLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $avgSalesData1 = [0, 0, 0, 0, 0, 0, 0];
        $avgSalesData2 = [0, 0, 0, 0, 0, 0, 0];

        // 6. CHART DATA: Monthly Conversion Area Chart (30 Days)
        $daysLabels = range(1, 30);
        $visitsData = array_fill(0, 30, 0);
        $conversionsData = array_fill(0, 30, 0);

        return view('dashboard', compact(
            'totalProducts',
            'totalStock',
            'totalCategories',
            'lowStockCount',
            'totalRevenue',
            'revenueGrowth',
            'conversionRate',
            'conversionGrowth',
            'recentProducts',
            'hourlyLabels',
            'hourlySalesData',
            'avgSalesLabels',
            'avgSalesData1',
            'avgSalesData2',
            'daysLabels',
            'visitsData',
            'conversionsData'
        ));
    }
}