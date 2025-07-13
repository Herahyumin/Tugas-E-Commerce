<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout.
     */
    public function index()
    {
        $cartItems = session()->get('cart', []);
        if (count($cartItems) == 0) {
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong!');
        }

        $addresses = Auth::user()->addresses;

        if ($addresses->isEmpty()) {
            return redirect()->route('addresses.create')->with('info', 'Silakan tambahkan alamat pengiriman terlebih dahulu.');
        }

        $shippingOptions = [
            ['name' => 'JNE REG (2-3 Hari)', 'price' => 15000],
            ['name' => 'J&T Express (2-3 Hari)', 'price' => 18000],
            ['name' => 'SiCepat BEST (1 Hari)', 'price' => 25000],
        ];

        return view('checkout.index', compact('cartItems', 'shippingOptions', 'addresses'));
    }

    /**
     * Memproses dan menyimpan pesanan.
     */
    public function store(Request $request)
    {
        // Untuk Debugging: Hentikan program dan tampilkan semua data yang dikirim dari form.
        // Jika halaman ini muncul, berarti form dan route sudah benar.
        // Hapus atau beri komentar pada baris ini setelah debugging selesai.
        // dd($request->all());

        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'shipping_service' => 'required|string',
            'shipping_cost' => 'required|numeric|min:0',
        ]);

        $address = Address::where('id', $request->address_id)->where('user_id', Auth::id())->firstOrFail();
        
        $cart = session()->get('cart', []);
        if (count($cart) == 0) {
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong!');
        }

        DB::beginTransaction();
        try {
            $cartTotal = 0;
            foreach ($cart as $id => $details) {
                $cartTotal += $details['price'] * $details['quantity'];
            }
            
            $grandTotal = $cartTotal + $request->shipping_cost;

            $shippingAddressString = "{$address->recipient_name}, {$address->phone_number}, {$address->full_address}, {$address->city}, {$address->province}, {$address->postal_code}";

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $grandTotal,
                'status' => 'pending',
                'shipping_address' => $shippingAddressString,
                'shipping_service' => $request->shipping_service,
                'shipping_cost' => $request->shipping_cost,
            ]);

            foreach ($cart as $id => $details) {
                $product = Product::find($id);
                if ($product->stock < $details['quantity']) {
                    DB::rollBack();
                    return redirect()->route('cart.index')->with('error', 'Maaf, stok produk ' . $product->name . ' tidak mencukupi.');
                }
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);
                $product->decrement('stock', $details['quantity']);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('orders.show', $order)->with('success', 'Pesanan Anda telah berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Untuk debugging, kita bisa log errornya
            // \Log::error('Checkout Error: '.$e->getMessage());
            return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan saat memproses pesanan Anda. Silakan coba lagi.');
        }
    }
}
