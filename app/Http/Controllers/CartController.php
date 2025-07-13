<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang belanja.
     */
    public function index()
    {
        // Ambil data keranjang dari session
        $cartItems = session()->get('cart', []);
        
        return view('cart.index', ['cartItems' => $cartItems]);
    }

    /**
     * Menambahkan item ke keranjang.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < 1) {
            return back()->with('error', 'Maaf, stok produk telah habis.');
        }

        // Ambil keranjang yang sudah ada dari session, atau buat array kosong jika belum ada
        $cart = session()->get('cart', []);

        // Cek apakah produk sudah ada di keranjang
        if(isset($cart[$product->id])) {
            // Jika sudah ada, kita bisa tambahkan kuantitasnya (untuk nanti)
            // Untuk sekarang, kita beri pesan bahwa produk sudah ada
            return back()->with('success', 'Produk sudah ada di dalam keranjang!');
        } else {
            // Jika belum ada, tambahkan produk baru ke keranjang
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        // Simpan kembali array keranjang yang sudah diperbarui ke dalam session
        session()->put('cart', $cart);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($id);
        $cart = session()->get('cart');

        // Cek apakah stok mencukupi
        if ($request->quantity > $product->stock) {
            return back()->with('error', 'Maaf, stok produk tidak mencukupi.');
        }

        // Jika item ada di keranjang, update jumlahnya
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $cart = session()->get('cart');

        // Jika item ada di keranjang, hapus
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
