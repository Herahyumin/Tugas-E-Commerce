<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Keranjang Belanja Anda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Penampil Pesan Sukses/Error --}}
            <div class="mb-6">
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session('cart') && count(session('cart')) > 0)
                    @php
                        $total = 0;
                    @endphp
                    <h3 class="text-2xl font-semibold text-gray-800 mb-6">Daftar Item ({{ count(session('cart')) }})</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Jumlah</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($cartItems as $id => $details)
                                    @php
                                        $subtotal = $details['price'] * $details['quantity'];
                                        $total += $subtotal;
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-16 w-16">
                                                    <img class="h-16 w-16 rounded-md object-cover" src="{{ $details['image'] ? asset('storage/' . $details['image']) : 'https://placehold.co/100x100/e2e8f0/e2e8f0?text=Img' }}" alt="{{ $details['name'] }}">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $details['name'] }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp{{ number_format($details['price']) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <form action="{{ route('cart.update', $id) }}" method="POST">
                                                @csrf
                                                <input type="number" name="quantity" value="{{ $details['quantity'] }}" class="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                <button type="submit" class="ml-2 inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">Update</button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Rp{{ number_format($subtotal) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('cart.destroy', $id) }}" class="text-red-600 hover:text-red-900" onclick="return confirm('Anda yakin ingin menghapus item ini?')">Hapus</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Total Belanja -->
                    <div class="mt-8 flex justify-end">
                        <div class="w-full max-w-sm">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <dl class="space-y-2">
                                    <div class="flex items-center justify-between border-t border-gray-200 pt-2">
                                        <dt class="text-base font-bold text-gray-900">Total</dt>
                                        <dd class="text-base font-bold text-gray-900">Rp{{ number_format($total) }}</dd>
                                    </div>
                                </dl>
                                <div class="mt-6">
                                    {{-- =============================================== --}}
                                    {{-- == PERUBAHAN DILAKUKAN PADA LINK DI BAWAH INI == --}}
                                    {{-- =============================================== --}}
                                    <a href="{{ route('checkout.index') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                        Lanjut ke Checkout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                @else
                    <div class="text-center py-24">
                        <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">Keranjang Anda Kosong</h3>
                        <p class="mt-1 text-sm text-gray-500">Sepertinya Anda belum menambahkan produk apapun.</p>
                        <div class="mt-6">
                            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                Mulai Belanja
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
