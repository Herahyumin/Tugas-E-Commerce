<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order; // <-- INI ADALAH BARIS YANG HILANG

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $myProducts = $user->products()->latest()->get();

        // Ambil semua pesanan yang mengandung produk milik user yang sedang login
        $incomingOrders = Order::whereHas('items.product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('items.product', 'user')->latest()->get();

        return view('dashboard', [
            'products' => $myProducts,
            'orders' => $incomingOrders, // Kirim data pesanan masuk ke view
        ]);
    }
}