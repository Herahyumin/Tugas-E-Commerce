<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Pesanan Anda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                @forelse ($orders as $order)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                        {{-- Bagian Atas Kartu: Info Utama --}}
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex flex-col sm:flex-row justify-between sm:items-center">
                                {{-- Info Kiri: ID & Tanggal --}}
                                <div class="mb-4 sm:mb-0">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Nomor Pesanan</p>
                                    <p class="font-bold text-lg text-gray-900 dark:text-gray-100">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Tanggal: {{ $order->created_at->format('d F Y') }}</p>
                                </div>
                                {{-- Info Kanan: Total & Status --}}
                                <div class="flex items-center space-x-6">
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Pembayaran</p>
                                        <p class="font-semibold text-lg text-gray-900 dark:text-gray-100">Rp{{ number_format($order->total_amount) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                                            @if($order->status == 'processing') bg-blue-100 text-blue-800 @endif
                                            @if($order->status == 'shipped') bg-cyan-100 text-cyan-800 @endif
                                            @if($order->status == 'completed') bg-green-100 text-green-800 @endif
                                            @if($order->status == 'cancelled') bg-red-100 text-red-800 @endif
                                        ">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Bagian Bawah Kartu: Tombol Aksi --}}
                        <div class="p-4 bg-gray-50 dark:bg-gray-800/50 flex justify-end">
                            <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                                Lihat Detail Pesanan
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="text-center py-16">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-gray-100">Tidak ada riwayat pesanan</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Anda belum pernah melakukan pemesanan.</p>
                        </div>
                    </div>
                @endforelse

                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
