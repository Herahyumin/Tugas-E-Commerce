<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 sm:p-8 space-y-8">

                    {{-- Bagian 1: Pilih Alamat --}}
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">1. Pilih Alamat Pengiriman</h3>
                        <div class="space-y-3">
                            @foreach($addresses as $address)
                                <label class="flex items-start p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="address_id" value="{{ $address->id }}" class="h-4 w-4 mt-1 text-indigo-600 border-gray-300 focus:ring-indigo-500" required>
                                    <div class="ml-4">
                                        <p class="font-semibold">{{ $address->label }}</p>
                                        <p class="text-sm text-gray-700">{{ $address->recipient_name }} ({{ $address->phone_number }})</p>
                                        <p class="text-sm text-gray-500">{{ $address->full_address }}, {{ $address->city }}, {{ $address->province }}, {{ $address->postal_code }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        <a href="{{ route('addresses.create') }}" class="text-sm text-indigo-600 hover:underline mt-2 inline-block">+ Tambah alamat baru</a>
                    </div>

                    {{-- Bagian 2: Ringkasan Barang --}}
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">2. Ringkasan Pesanan</h3>
                        <div class="space-y-4 border-b pb-6 mb-6">
                            @php $cartTotal = 0; @endphp
                            @foreach(session('cart', []) as $id => $details)
                                @php $cartTotal += $details['price'] * $details['quantity']; @endphp
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <img src="{{ $details['image'] ? asset('storage/' . $details['image']) : 'https://placehold.co/100x100' }}" class="w-16 h-16 rounded-md object-cover mr-4">
                                        <div>
                                            <p class="font-semibold">{{ $details['name'] }}</p>
                                            <p class="text-sm text-gray-500">Jumlah: {{ $details['quantity'] }}</p>
                                        </div>
                                    </div>
                                    <p class="font-semibold">Rp{{ number_format($details['price'] * $details['quantity']) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Bagian 3: Pilih Pengiriman --}}
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">3. Pilih Metode Pengiriman</h3>
                        <div class="space-y-3 border-b pb-6 mb-6">
                            @foreach($shippingOptions as $option)
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="shipping_option" value="{{ $option['name'] }}" data-cost="{{ $option['price'] }}" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" required>
                                    <div class="ml-4 flex justify-between w-full">
                                        <span class="text-sm font-medium text-gray-900">{{ $option['name'] }}</span>
                                        <span class="text-sm font-semibold text-gray-700">Rp{{ number_format($option['price']) }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        {{-- Hidden inputs untuk menyimpan data pengiriman yang dipilih --}}
                        <input type="hidden" name="shipping_service" id="shipping_service_input">
                        <input type="hidden" name="shipping_cost" id="shipping_cost_input">
                    </div>

                    {{-- Bagian 4: Rincian Pembayaran & Tombol --}}
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">4. Rincian Pembayaran</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <p class="text-gray-600">Subtotal Barang</p>
                                <p class="text-gray-800">Rp{{ number_format($cartTotal) }}</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-gray-600">Biaya Pengiriman</p>
                                <p class="text-gray-800" id="shipping-cost-display">Rp0</p>
                            </div>
                            <div class="flex justify-between text-lg font-bold text-gray-900 pt-2 border-t mt-2">
                                <p>Total Pembayaran</p>
                                <p id="grand-total-display">Rp{{ number_format($cartTotal) }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-8">
                            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                Buat Pesanan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const shippingOptions = document.querySelectorAll('input[name="shipping_option"]');
            const shippingCostDisplay = document.getElementById('shipping-cost-display');
            const grandTotalDisplay = document.getElementById('grand-total-display');
            const shippingServiceInput = document.getElementById('shipping_service_input');
            const shippingCostInput = document.getElementById('shipping_cost_input');
            
            const cartTotal = {{ $cartTotal }};

            shippingOptions.forEach(option => {
                option.addEventListener('change', function () {
                    if (this.checked) {
                        const cost = parseFloat(this.dataset.cost);
                        const serviceName = this.value;
                        const grandTotal = cartTotal + cost;

                        // Update tampilan
                        shippingCostDisplay.textContent = 'Rp' + cost.toLocaleString('id-ID');
                        grandTotalDisplay.textContent = 'Rp' + grandTotal.toLocaleString('id-ID');

                        // Update hidden inputs untuk dikirim ke server
                        shippingServiceInput.value = serviceName;
                        shippingCostInput.value = cost;
                    }
                });
            });
        });
    </script>
</x-app-layout>