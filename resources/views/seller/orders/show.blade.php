<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Pesanan Masuk #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('dashboard') }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">
                    &larr; Kembali ke Dashboard
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- ======================================================= --}}
                {{-- == KOLOM KIRI: BUKTI BAYAR & AKSI PENJUAL == --}}
                {{-- ======================================================= --}}
                <div class="md:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-200">Bukti Pembayaran</h3>
                        @if($order->payment_proof)
                            <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                                <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-full rounded-lg shadow-md hover:opacity-80 transition-opacity">
                            </a>
                            <p class="text-center text-sm mt-2 font-bold 
                                @if($order->payment_status == 'unpaid') text-red-600 @endif
                                @if($order->payment_status == 'paid') text-blue-600 @endif
                                @if($order->payment_status == 'verified') text-green-600 @endif
                            ">
                                Status Pembayaran: {{ ucfirst($order->payment_status) }}
                            </p>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">Pembeli belum mengunggah bukti pembayaran.</p>
                        @endif
                    </div>
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Aksi Pesanan</h3>
                        <form action="{{ route('orders.update_status', $order) }}" method="POST">
                            @csrf
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ubah Status Pengiriman</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
                                <option value="pending" @if($order->status == 'pending') selected @endif>Pending</option>
                                <option value="processing" @if($order->status == 'processing') selected @endif>Processing</option>
                                <option value="shipped" @if($order->status == 'shipped') selected @endif>Shipped</option>
                                <option value="completed" @if($order->status == 'completed') selected @endif>Completed</option>
                                <option value="cancelled" @if($order->status == 'cancelled') selected @endif>Cancelled</option>
                            </select>
                            <x-primary-button class="mt-4 w-full justify-center">
                                Perbarui Status
                            </x-primary-button>
                        </form>
                    </div>
                </div>

                {{-- ======================================================= --}}
                {{-- == KOLOM KANAN: DETAIL LENGKAP PESANAN == --}}
                {{-- ======================================================= --}}
                <div class="md:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-8 space-y-6">
                        {{-- Info Pembeli & Alamat --}}
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Detail Pembeli & Pengiriman</h4>
                            <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                <p><span class="font-semibold text-gray-700 dark:text-gray-300">Nama:</span> {{ $order->user->name }}</p>
                                <p><span class="font-semibold text-gray-700 dark:text-gray-300">Alamat:</span></p>
                                <address class="not-italic border-l-2 pl-3 ml-2 border-gray-200 dark:border-gray-600">
                                    {!! nl2br(e($order->shipping_address)) !!}
                                </address>
                                <p><span class="font-semibold text-gray-700 dark:text-gray-300">Kurir:</span> {{ $order->shipping_service }}</p>
                            </div>
                        </div>

                        {{-- Rincian Barang --}}
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Rincian Barang</h4>
                            <div class="space-y-4 border-t border-b border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($order->items as $item)
                                    <div class="flex items-center justify-between py-4">
                                        <div class="flex items-center">
                                            <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://placehold.co/100x100' }}" class="w-16 h-16 rounded-md object-cover mr-4">
                                            <div>
                                                <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $item->product->name }}</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $item->quantity }} x Rp{{ number_format($item->price) }}</p>
                                            </div>
                                        </div>
                                        <p class="font-semibold text-gray-700 dark:text-gray-300">Rp{{ number_format($item->price * $item->quantity) }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Total Pembayaran --}}
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                <span>Subtotal Barang</span>
                                <span>Rp{{ number_format($order->total_amount - $order->shipping_cost) }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                <span>Biaya Pengiriman</span>
                                <span>Rp{{ number_format($order->shipping_cost) }}</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold text-gray-900 dark:text-gray-100 mt-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                                <span>Total Pembayaran</span>
                                <span>Rp{{ number_format($order->total_amount) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
