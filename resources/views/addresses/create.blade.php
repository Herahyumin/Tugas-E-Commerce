<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Alamat Baru</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <form action="{{ route('addresses.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="label" value="Label Alamat (Contoh: Rumah, Kantor)" />
                            <x-text-input id="label" name="label" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="recipient_name" value="Nama Penerima" />
                            <x-text-input id="recipient_name" name="recipient_name" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="phone_number" value="Nomor Telepon" />
                            <x-text-input id="phone_number" name="phone_number" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="postal_code" value="Kode Pos" />
                            <x-text-input id="postal_code" name="postal_code" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            {{-- Mengubah name menjadi 'province' agar sesuai dengan database --}}
                            <x-input-label for="province" value="Provinsi" />
                            <x-text-input id="province" name="province" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            {{-- Mengubah name menjadi 'city' agar sesuai dengan database --}}
                            <x-input-label for="city" value="Kota/Kabupaten" />
                            <x-text-input id="city" name="city" class="mt-1 block w-full" required />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="full_address" value="Alamat Lengkap (Nama Jalan, Gedung, No. Rumah)" />
                            <textarea id="full_address" name="full_address" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end mt-6">
                        <x-primary-button>Simpan Alamat</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </x-app-layout>
