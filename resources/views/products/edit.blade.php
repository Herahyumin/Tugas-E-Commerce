<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk') }}: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8">
                    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kolom Kiri: Info Dasar -->
                            <div class="space-y-6">
                                <!-- Nama Produk -->
                                <div>
                                    <x-input-label for="name" :value="__('Nama Produk')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $product->name)" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <!-- Deskripsi -->
                                <div>
                                    <x-input-label for="description" :value="__('Deskripsi Produk')" />
                                    <textarea id="description" name="description" rows="8" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $product->description) }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Kolom Kanan: Harga, Stok, Gambar -->
                            <div class="space-y-6">
                                <!-- Harga -->
                                <div>
                                    <x-input-label for="price" :value="__('Harga (Rp)')" />
                                    <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price', $product->price)" required />
                                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                </div>

                                <!-- Stok -->
                                <div>
                                    <x-input-label for="stock" :value="__('Jumlah Stok')" />
                                    <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" :value="old('stock', $product->stock)" required />
                                    <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                                </div>
                                
                                <!-- Gambar -->
                                <div>
                                    <x-input-label for="image" :value="__('Ganti Gambar Produk (Opsional)')" />
                                    <input type="file" id="image" name="image" class="block w-full text-sm text-gray-500 mt-1
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-indigo-50 file:text-indigo-700
                                        hover:file:bg-indigo-100
                                    "/>
                                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                    @if ($product->image)
                                        <div class="mt-4">
                                            <p class="text-sm text-gray-500">Gambar saat ini:</p>
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="mt-2 w-32 h-32 object-cover rounded-md shadow-md">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200">
                             <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <x-primary-button>
                                {{ __('Update Produk') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
