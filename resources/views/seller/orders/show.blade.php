<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pesanan Masuk #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Kolom Kiri: Bukti Pembayaran & Aksi --}}
            <div class="md:col-span-1 space-y-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2">Bukti Pembayaran</h3>
                    @if($order->payment_proof)
                        <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-full rounded-lg shadow-md">
                        <p class="text-center text-sm mt-2 text-gray-500">Status: {{ ucfirst($order->payment_status) }}</p>
                    @else
                        <p class="text-sm text-gray-500">Pembeli belum mengunggah bukti pembayaran.</p>
                    @endif
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2">Aksi Pesanan</h3>
                    {{-- Form untuk verifikasi pembayaran dan update status pengiriman --}}
                </div>
            </div>
            {{-- Kolom Kanan: Detail Pesanan --}}
            <div class="md:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                {{-- (Kita bisa copy-paste detail dari halaman order/show.blade.php milik pembeli) --}}
                <p>Detail pesanan akan ditampilkan di sini.</p>
            </div>
        </div>
    </div>
</x-app-layout>