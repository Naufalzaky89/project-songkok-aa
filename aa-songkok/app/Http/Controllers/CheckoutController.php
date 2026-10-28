<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong!');
        }
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $user = auth()->user();
        return view('checkout.index', compact('cart', 'total', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address'     => 'required|string',
            'shipping_city'        => 'required|string',
            'shipping_province'    => 'required|string',
            'shipping_postal_code' => 'required|string',
            'shipping_phone'       => 'required|string',
            'payment_method'       => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        // Validate stock
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if (!$product || $product->stock < $item['quantity']) {
                return back()->with('error', "Stok {$item['name']} tidak mencukupi!");
            }
        }

        $shippingCost = 15000;
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $total = $subtotal + $shippingCost;

        $order = Order::create([
            'user_id'              => auth()->id(),
            'order_number'         => 'ORD-' . strtoupper(Str::random(8)),
            'total_amount'         => $total,
            'status'               => 'pending',
            'payment_status'       => 'unpaid',
            'payment_method'       => $request->payment_method,
            'shipping_address'     => $request->shipping_address,
            'shipping_city'        => $request->shipping_city,
            'shipping_province'    => $request->shipping_province,
            'shipping_postal_code' => $request->shipping_postal_code,
            'shipping_phone'       => $request->shipping_phone,
            'shipping_cost'        => $shippingCost,
            'notes'                => $request->notes,
        ]);

        foreach ($cart as $id => $item) {
            OrderDetail::create([
                'order_id'      => $order->id,
                'product_id'    => $id,
                'product_name'  => $item['name'],
                'product_price' => $item['price'],
                'quantity'      => $item['quantity'],
                'subtotal'      => $item['price'] * $item['quantity'],
            ]);

            Product::where('id', $id)->decrement('stock', $item['quantity']);
        }

        session()->forget('cart');

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Pesanan berhasil dibuat! Nomor pesanan: ' . $order->order_number);
    }
}
