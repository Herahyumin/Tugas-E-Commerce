<?php
namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerOrderController extends Controller
{
    public function show(Order $order)
    {
        // Otorisasi: Pastikan user yang login adalah penjual dari salah satu barang di pesanan ini
        $isSeller = $order->items()->whereHas('product', function ($query) {
            $query->where('user_id', Auth::id());
        })->exists();

        if (!$isSeller) {
            abort(403);
        }

        return view('seller.orders.show', compact('order'));
    }
}