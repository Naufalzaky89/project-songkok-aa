<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users    = User::where('role', 'user')->get();
        $products = Product::all();

        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $payments = ['unpaid', 'paid', 'paid', 'paid', 'unpaid'];
        $methods  = ['Transfer Bank', 'COD', 'QRIS'];

        foreach ($users as $user) {
            for ($i = 0; $i < 3; $i++) {
                $statusIndex = array_rand($statuses);
                $shippingCost = 15000;
                $selectedProducts = $products->random(rand(1, 3));

                $total = $shippingCost;
                $details = [];
                foreach ($selectedProducts as $product) {
                    $qty      = rand(1, 3);
                    $subtotal = $product->price * $qty;
                    $total   += $subtotal;
                    $details[] = [
                        'product_id'    => $product->id,
                        'product_name'  => $product->name,
                        'product_price' => $product->price,
                        'quantity'      => $qty,
                        'subtotal'      => $subtotal,
                    ];
                }

                $order = Order::create([
                    'user_id'              => $user->id,
                    'order_number'         => 'ORD-' . strtoupper(Str::random(8)),
                    'total_amount'         => $total,
                    'status'               => $statuses[$statusIndex],
                    'payment_status'       => $payments[$statusIndex],
                    'payment_method'       => $methods[array_rand($methods)],
                    'shipping_address'     => 'Jl. Contoh No. ' . rand(1, 100),
                    'shipping_city'        => collect(['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Semarang'])->random(),
                    'shipping_province'    => collect(['DKI Jakarta', 'Jawa Barat', 'Jawa Timur', 'DIY', 'Jawa Tengah'])->random(),
                    'shipping_postal_code' => rand(10000, 99999),
                    'shipping_phone'       => '08' . rand(100000000, 999999999),
                    'shipping_cost'        => $shippingCost,
                    'created_at'           => now()->subDays(rand(0, 30)),
                ]);

                foreach ($details as $detail) {
                    OrderDetail::create(array_merge($detail, ['order_id' => $order->id]));
                }
            }
        }
    }
}
