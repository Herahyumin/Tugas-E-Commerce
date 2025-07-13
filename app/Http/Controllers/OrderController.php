<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan milik pengguna yang sedang login.
     */
    public function index()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10); // Ambil pesanan, urutkan dari terbaru

        return view('orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail satu pesanan.
     */
    public function show(Order $order)
    {
        // Pastikan pengguna hanya bisa melihat pesanannya sendiri
        if (Auth::id() !== $order->user_id) {
            abort(403); // Akses ditolak
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Menampilkan halaman struk untuk dicetak.
     * KODE BARU DITAMBAHKAN DI SINI
     */
    public function showInvoice(Order $order)
    {
        // Pastikan pengguna hanya bisa melihat struk miliknya sendiri
        if (Auth::id() !== $order->user_id) {
            abort(403);
        }

        // Tampilkan view 'invoice' dan kirim data pesanan ke dalamnya
        return view('orders.invoice', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
        ]);

        // Cek otorisasi: pastikan user yang login adalah penjual dari salah satu barang di pesanan ini
        $isSellerOfThisOrder = $order->items()->whereHas('product', function ($query) {
            $query->where('user_id', Auth::id());
        })->exists();

        if (!$isSellerOfThisOrder) {
            abort(403, 'Anda tidak berhak mengubah status pesanan ini.');
        }

        // Update status pesanan
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function submitPayment(Request $request, Order $order)
    {
        // Pastikan pengguna hanya bisa submit untuk pesanannya sendiri
        if (Auth::id() !== $order->user_id) {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Hapus bukti lama jika ada
        if ($order->payment_proof) {
            Storage::disk('public')->delete($order->payment_proof);
        }

        // Simpan gambar baru
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        // Update database
        $order->update([
            'payment_proof' => $path,
            'payment_status' => 'paid', // Ubah status pembayaran menjadi 'paid'
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah.');
    }
}
