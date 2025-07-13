<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    // Menampilkan semua alamat pengguna
    public function index()
    {
        $addresses = Auth::user()->addresses()->latest()->get();
        return view('addresses.index', compact('addresses'));
    }

    // Menampilkan form tambah alamat
    public function create()
    {
        return view('addresses.create');
    }

    // Menyimpan alamat baru
    public function store(Request $request)
    {
        // Menyesuaikan aturan validasi agar sesuai dengan database
        $request->validate([
            'label' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'full_address' => 'required|string',
            'province' => 'required|string|max:255', // <-- Diubah dari 'province_id'
            'city' => 'required|string|max:255',     // <-- Diubah dari 'city_id'
            'postal_code' => 'required|string|max:10',
        ]);

        Auth::user()->addresses()->create($request->all());

        return redirect()->route('addresses.index')->with('success', 'Alamat baru berhasil ditambahkan.');
    }
}
