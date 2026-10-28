<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('orderDetails')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', auth()->id())
            ->with(['orderDetails.product'])
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function cancel($id)
    {
        $order = Order::where('user_id', auth()->id())->findOrFail($id);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan!');
        }

        // Restore stock
        foreach ($order->orderDetails as $detail) {
            if ($detail->product) {
                $detail->product->increment('stock', $detail->quantity);
            }
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Pesanan berhasil dibatalkan!');
    }
}
