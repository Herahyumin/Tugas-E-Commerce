<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Pesanan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('orders.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">
                    &larr; Kembali ke Riwayat Pesanan
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                {{-- Bagian Header Kartu --}}
                <div class="p-6 sm:px-8 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center">
                        <div class="mb-4 sm:mb-0">
                            <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                Pesanan #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Dipesan pada {{ $order->created_at->format('d F Y, H:i') }}
                            </p>
                        </div>
                        <a href="{{ route('orders.invoice', $order) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Lihat & Cetak Struk
                        </a>
                    </div>
                </div>

                <div class="p-6 sm:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                    {{-- Kolom Kiri: Info Pengiriman & Status --}}
                    <div class="md:col-span-1 space-y-6">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Status Pesanan</h4>
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                @if($order->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                                @if($order->status == 'processing') bg-blue-100 text-blue-800 @endif
                                @if($order->status == 'shipped') bg-cyan-100 text-cyan-800 @endif
                                @if($order->status == 'completed') bg-green-100 text-green-800 @endif
                                @if($order->status == 'cancelled') bg-red-100 text-red-800 @endif
                            ">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>

                        {{-- Tambahan: Status Pembayaran --}}
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Status Pembayaran</h4>
                            <p class="text-sm font-bold 
                                @if($order->payment_status == 'unpaid') text-red-600 @endif
                                @if($order->payment_status == 'paid') text-blue-600 @endif
                                @if($order->payment_status == 'verified') text-green-600 @endif
                            ">
                                {{ ucfirst($order->payment_status) }}
                            </p>
                        </div>

                        {{-- Tambahan: Form Upload hanya muncul jika belum bayar atau sudah bayar tapi mau ganti bukti --}}
                        @if($order->payment_status != 'verified')
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Unggah Bukti Pembayaran</h4>
                            <form action="{{ route('orders.payment', $order) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="payment_proof" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" required>
                                <x-primary-button class="mt-2">Unggah</x-primary-button>
                            </form>
                            @if ($order->payment_proof)
                                <p class="text-xs text-gray-500 mt-2">Bukti yang sudah diunggah:</p>
                                <img src="{{ asset('storage/' . $order->payment_proof) }}" class="mt-1 w-full rounded-md shadow-md">
                            @endif
                        </div>
                        @endif

                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Alamat Pengiriman</h4>
                            <address class="text-sm text-gray-600 dark:text-gray-400 not-italic">
                                {!! nl2br(e($order->shipping_address)) !!}
                            </address>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Kurir Pengiriman</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->shipping_service }}</p>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Rincian Barang & Total --}}
                    <div class="md:col-span-2">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Rincian Barang</h4>
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
                        <div class="mt-4 space-y-2">
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
    </div>
</x-app-layout>
