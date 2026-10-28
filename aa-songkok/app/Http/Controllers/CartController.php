<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->stock < 1) {
            return back()->with('error', 'Stok produk habis!');
        }

        $cart = session()->get('cart', []);
        $qty = $request->input('quantity', 1);

        if (isset($cart[$id])) {
            $newQty = $cart[$id]['quantity'] + $qty;
            if ($newQty > $product->stock) {
                return back()->with('error', 'Jumlah melebihi stok yang tersedia!');
            }
            $cart[$id]['quantity'] = $newQty;
        } else {
            $cart[$id] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'image'    => $product->image,
                'quantity' => $qty,
                'stock'    => $product->stock,
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $product = Product::findOrFail($id);

        if (isset($cart[$id])) {
            $qty = max(1, (int) $request->quantity);
            if ($qty > $product->stock) {
                return back()->with('error', 'Jumlah melebihi stok!');
            }
            $cart[$id]['quantity'] = $qty;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Keranjang diperbarui!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        return back()->with('success', 'Produk dihapus dari keranjang!');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang dikosongkan!');
    }
}
