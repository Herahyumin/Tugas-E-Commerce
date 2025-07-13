<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>computer-onshop - Jual Beli Komputer Terpercaya</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen">
            <nav class="bg-white shadow-sm sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="flex-shrink-0 flex items-center">
                                <a href="{{ route('home') }}" class="font-bold text-xl text-gray-800">
                                    Computer-OnShop
                                </a>
                                <div class="hidden sm:flex items-center ml-6">
                                    <span class="border-l border-gray-200 h-6"></span>
                                    <p class="ml-6 text-xs text-gray-500">
                                        Developed by kelompok 6
                                    </p>
                                </div>
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

            <main>
                <div class="bg-white">
                    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 text-center">
                        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block">Temukan Komputer Impian Anda</span>
                            <span class="block text-indigo-600">Di Computer-OnShop</span>
                        </h1>
                        <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                            Jelajahi ribuan produk komputer dan aksesoris dari penjual terpercaya di seluruh negeri.
                        </p>
                        
                        {{-- ======================================================= --}}
                        {{-- == FORM PENCARIAN DITAMBAHKAN DI SINI == --}}
                        {{-- ======================================================= --}}
                        <div class="mt-8 max-w-xl mx-auto">
                            <form action="{{ route('home') }}" method="GET" class="flex items-center w-full">
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search" id="search" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Cari laptop, keyboard, mouse..." value="{{ $searchTerm ?? '' }}">
                                </div>
                                <button type="submit" class="ml-3 inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                    Cari
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50">
                    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                        {{-- ======================================================= --}}
                        {{-- == JUDUL HALAMAN DIBUAT DINAMIS == --}}
                        {{-- ======================================================= --}}
                        @if ($searchTerm)
                            <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 mb-8">
                                Hasil pencarian untuk: <span class="text-indigo-600">"{{ $searchTerm }}"</span>
                            </h2>
                        @else
                            <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 mb-8">Produk Terbaru</h2>
                        @endif
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-10">
                            @forelse ($products as $product)
                                <div class="group relative bg-white border border-gray-200 rounded-lg flex flex-col overflow-hidden transition-shadow duration-300 hover:shadow-xl">
                                    <div class="aspect-w-3 aspect-h-2 bg-gray-200 sm:aspect-none sm:h-48">
                                        <a href="{{ route('products.show', $product->id) }}">
                                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/600x400/e2e8f0/e2e8f0?text=Image' }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center sm:w-full sm:h-full transition-transform duration-300 group-hover:scale-105">
                                        </a>
                                    </div>
                                    <div class="p-4 flex flex-col flex-grow">
                                        <h3 class="text-sm font-medium text-gray-700 truncate">
                                            <a href="{{ route('products.show', $product->id) }}">
                                                <span aria-hidden="true" class="absolute inset-0"></span>
                                                {{ $product->name }}
                                            </a>
                                        </h3>
                                        <p class="text-xs text-gray-500 mt-1">Oleh: {{ $product->user->name }}</p>
                                        <div class="mt-auto pt-4">
                                            <p class="text-lg font-semibold text-gray-900">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-24">
                                    <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    <h3 class="mt-2 text-lg font-medium text-gray-900">Tidak Ada Hasil</h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        @if ($searchTerm)
                                            Tidak ada produk yang cocok dengan pencarian Anda. Coba kata kunci lain.
                                        @else
                                            Belum ada produk yang dijual untuk saat ini.
                                        @endif
                                    </p>
                                </div>
                            @endforelse
                        </div>

                        {{-- ======================================================= --}}
                        {{-- == LINK PAGINASI DITAMBAHKAN DI SINI == --}}
                        {{-- ======================================================= --}}
                        <div class="mt-12">
                            {{ $products->appends(['search' => $searchTerm])->links() }}
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
