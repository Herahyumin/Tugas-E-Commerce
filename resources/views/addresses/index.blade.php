{{-- Tampilan sederhana untuk daftar alamat, bisa kamu percantik nanti --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Alamat Saya</h2>
            <a href="{{ route('addresses.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase">
                + Tambah Alamat Baru
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @forelse($addresses as $address)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-4">
                    <p class="font-bold">{{ $address->label }} @if($address->is_default) (Utama) @endif</p>
                    <p>{{ $address->recipient_name }} ({{ $address->phone_number }})</p>
                    <p>{{ $address->full_address }}, {{ $address->postal_code }}</p>
                </div>
            @empty
                <p>Anda belum memiliki alamat tersimpan.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>