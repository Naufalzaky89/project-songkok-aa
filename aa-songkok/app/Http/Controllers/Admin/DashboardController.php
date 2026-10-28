<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders    = Order::count();
        $totalRevenue   = Order::where('payment_status', 'paid')->sum('total_amount');
        $totalProducts  = Product::count();
        $totalUsers     = User::where('role', 'user')->count();
        $pendingOrders  = Order::where('status', 'pending')->count();

        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Chart data - last 7 days
        $salesChart = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(6))
            ->where('payment_status', 'paid')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = [];
        $chartData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('d M');
            $found = $salesChart->firstWhere('date', $date);
            $chartData[] = $found ? (float) $found->total : 0;
        }

        // Top products
        $topProducts = DB::table('order_details')
            ->select('product_name', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders', 'totalRevenue', 'totalProducts',
            'totalUsers', 'pendingOrders', 'recentOrders',
            'chartLabels', 'chartData', 'topProducts'
        ));
    }
}
