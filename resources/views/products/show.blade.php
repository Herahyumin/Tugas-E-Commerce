<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $product->name }} - computer-onshop</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen">
            <!-- Navigation -->
            <nav class="bg-white shadow-sm sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="flex-shrink-0 flex items-center">
                                <a href="{{ route('home') }}" class="font-bold text-xl text-gray-800">
                                    Computer-OnShop
                                </a>
                            </div>
                        </div>
                        <div class="flex items-center">
                            @if (Route::has('login'))
                                <div class="space-x-4">
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Dashboard</a>
                                    @else
                                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Log in</a>
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="ml-4 inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">Register</a>
                                        @endif
                                    @endauth
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </nav>

            {{-- ====================================================== --}}
            {{-- == BAGIAN 1 YANG DIPERBAIKI: PENAMPIL PESAN DITAMBAHKAN == --}}
            {{-- ====================================================== --}}
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-6">
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md" role="alert">
                        <p class="font-bold">Berhasil!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md" role="alert">
                        <p class="font-bold">Oops!</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif
            </div>

            <!-- Page Content -->
            <main class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    
                    <!-- Breadcrumbs -->
                    <nav class="flex mb-5" aria-label="Breadcrumb">
                        {{-- ... (kode breadcrumb tidak berubah) ... --}}
                        <ol role="list" class="flex items-center space-x-2 text-sm">
                            <li>
                                <div class="flex items-center">
                                    <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-500">
                                        <svg class="flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd" /></svg>
                                        <span class="sr-only">Home</span>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="flex-shrink-0 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" /></svg>
                                    <span class="ml-2 text-gray-500 truncate w-48 md:w-auto">{{ $product->name }}</span>
                                </div>
                            </li>
                        </ol>
                    </nav>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 md:flex md:space-x-10">
                            <!-- Product Image -->
                            <div class="md:w-1/2">
                                <div class="aspect-w-1 aspect-h-1 w-full bg-gray-100 rounded-lg overflow-hidden">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/600x600/e2e8f0/e2e8f0?text=Image' }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center">
                                </div>
                            </div>

                            <!-- Product Details -->
                            <div class="md:w-1/2 mt-6 md:mt-0 flex flex-col">
                                {{-- ... (kode detail produk tidak berubah) ... --}}
                                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ $product->name }}</h1>
                                <div class="mt-3">
                                    <p class="text-3xl text-gray-900">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="mt-6">
                                    <span class="text-sm text-gray-500">Dijual oleh </span>
                                    <span class="text-sm font-semibold text-indigo-600">{{ $product->user->name }}</span>
                                </div>
                                <div class="mt-6">
                                    <h3 class="sr-only">Deskripsi</h3>
                                    <div class="text-base text-gray-700 space-y-6">
                                        {!! nl2br(e($product->description)) !!}
                                    </div>
                                </div>

                                <!-- Aksi Pembelian -->
                                <div class="mt-auto pt-8">
                                    <div class="flex items-center mb-4">
                                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                        <p class="text-sm text-gray-500">Stok tersisa: <span class="font-bold text-gray-700">{{ $product->stock }}</span> buah</p>
                                    </div>

                                    {{-- ==================================================== --}}
                                    {{-- == BAGIAN 2 YANG DIPERBAIKI: TOMBOL DIBUNGKUS FORM == --}}
                                    {{-- ==================================================== --}}
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        
                                        <button type="submit" class="w-full bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:bg-gray-400" {{ $product->stock == 0 ? 'disabled' : '' }}>
                                            {{ $product->stock > 0 ? 'Tambah ke Keranjang' : 'Stok Habis' }}
                                        </button>
                                    </form>

                                    @can('update', $product)
                                        <div class="mt-4 flex justify-center space-x-4">
                                            <a href="{{ route('products.edit', $product->id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Edit Produk</a>
                                            <span class="text-gray-300">|</span>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus produk ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-500">Hapus Produk</button>
                                            </form>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
