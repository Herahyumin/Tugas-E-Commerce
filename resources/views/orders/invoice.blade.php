<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body, .invoice-container {
                margin: 0;
                padding: 0;
                box-shadow: none;
                border: none;
            }
            #invoice-box, #invoice-box * {
                visibility: visible;
            }
            #invoice-box {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="invoice-container max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        {{-- Tombol Aksi --}}
        <div class="flex justify-between items-center mb-6 no-print">
            <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center text-sm text-gray-600 hover:text-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Detail Pesanan
            </a>
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak / Simpan PDF
            </button>
        </div>

        {{-- Konten Invoice --}}
        <div id="invoice-box" class="bg-white shadow-lg rounded-lg p-10">
            {{-- Header Invoice --}}
            <header class="flex justify-between items-start mb-10">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Computer-OnShop</h2>
                    <p class="text-gray-500">Struk Pembelian</p>
                </div>
                <div class="text-right">
                    <h1 class="text-3xl font-bold text-indigo-600">INVOICE</h1>
                    <p class="text-gray-500">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
            </header>

            {{-- Detail Info --}}
            <section class="grid grid-cols-2 gap-8 mb-10 pb-10 border-b">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase mb-2">Ditagihkan Kepada</p>
                    <p class="text-gray-800 font-medium">{{ $order->user->name }}</p>
                    <p class="text-gray-600">{{ $order->user->email }}</p>
                </div>
                {{-- ======================================================= --}}
                {{-- == BAGIAN ALAMAT PENGIRIMAN DITAMBAHKAN DI SINI == --}}
                {{-- ======================================================= --}}
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase mb-2">Dikirim Ke</p>
                    <address class="text-gray-600 not-italic">
                        {!! nl2br(e($order->shipping_address)) !!}
                    </address>
                </div>
            </section>

            {{-- Tabel Item --}}
            <section>
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jml</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-medium text-gray-900">{{ $item->product->name }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">Rp{{ number_format($item->price) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-700">Rp{{ number_format($item->price * $item->quantity) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>

            {{-- Kalkulasi Total --}}
            <section class="flex justify-end mt-8">
                <div class="w-full max-w-sm">
                    <dl class="space-y-4">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Subtotal Barang</dt>
                            <dd class="text-sm font-medium text-gray-800">Rp{{ number_format($order->total_amount - $order->shipping_cost) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Biaya Pengiriman ({{ $order->shipping_service }})</dt>
                            <dd class="text-sm font-medium text-gray-800">Rp{{ number_format($order->shipping_cost) }}</dd>
                        </div>
                        <div class="flex justify-between border-t pt-4">
                            <dt class="text-base font-bold text-gray-900">Total</dt>
                            <dd class="text-base font-bold text-gray-900">Rp{{ number_format($order->total_amount) }}</dd>
                        </div>
                    </dl>
                </div>
            </section>

            {{-- Footer Invoice --}}
            <footer class="mt-12 pt-8 border-t text-center">
                <p class="text-sm text-gray-500">Terima kasih telah berbelanja di <strong>Computer-OnShop</strong>!</p>
            </footer>
        </div>
    </div>
</body>
</html>
