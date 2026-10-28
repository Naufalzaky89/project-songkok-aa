<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date', now()->format('Y-m-d'));

        $orders = Order::with(['user', 'orderDetails'])
            ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
            ->where('payment_status', 'paid')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $summary = Order::whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
            ->where('payment_status', 'paid')
            ->selectRaw('COUNT(*) as total_orders, SUM(total_amount) as total_revenue, AVG(total_amount) as avg_order')
            ->first();

        $topProducts = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->whereBetween(DB::raw('DATE(orders.created_at)'), [$startDate, $endDate])
            ->where('orders.payment_status', 'paid')
            ->select('product_name', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(subtotal) as total_revenue'))
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->take(10)
            ->get();

        $dailySales = Order::whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
            ->where('payment_status', 'paid')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.reports.index', compact(
            'orders', 'summary', 'topProducts', 'dailySales', 'startDate', 'endDate'
        ));
    }
}
