<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Data Produk</h2>
            <a href="{{ route('products.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">
                + Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('products.index') }}" method="GET"
                    class="mb-6 flex flex-wrap items-center gap-3">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama atau kode produk..."
                        class="rounded-md border-gray-300 shadow-sm text-sm flex-1 min-w-[200px]">

                    <select name="category_id" class="rounded-md border-gray-300 shadow-sm text-sm">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="stock_status" class="rounded-md border-gray-300 shadow-sm text-sm">
                        <option value="">Semua Stok</option>
                        <option value="menipis" @selected(request('stock_status') === 'menipis')>Menipis</option>
                        <option value="habis" @selected(request('stock_status') === 'habis')>Habis</option>
                    </select>

                    <select name="per_page" class="rounded-md border-gray-300 shadow-sm text-sm">
                        @foreach ([10, 25, 50] as $n)
                            <option value="{{ $n }}" @selected((int) request('per_page', 10) === $n)>{{ $n }} / halaman
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">
                        Cari
                    </button>
                    <a href="{{ route('products.index') }}"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm">
                        Reset
                    </a>
                </form>

                @php($batas = config('pos.low_stock_threshold'))

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Kode</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Nama Produk</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Kategori</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Harga</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500">Stok</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Nilai Stok</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($products as $product)
                                <tr
                                    class="@if($product->stock == 0) bg-red-50 @elseif($product->stock < $batas) bg-yellow-50 @endif">
                                    <td class="px-4 py-2 text-sm">{{ $product->code }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $product->name }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $product->category->name }}</td>
                                    <td class="px-4 py-2 text-sm text-right">{{ $product->price_rupiah }}</td>
                                    <td class="px-4 py-2 text-sm text-center font-semibold">
                                        {{ $product->stock }}
                                        <div><x-badge :stock="$product->stock" /></div>
                                    </td>
                                    <td class="px-4 py-2 text-sm text-right">
                                        Rp{{ number_format($product->stock_value, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-center space-x-2">
                                        <a href="{{ route('products.show', $product) }}"
                                            class="text-gray-600 hover:text-gray-900">Detail</a>
                                        <a href="{{ route('products.edit', $product) }}"
                                            class="text-indigo-600 hover:text-indigo-900">Ubah</a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus produk {{ $product->name }}?')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">Belum ada data produk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-50 font-semibold">
                                <td colspan="5" class="px-4 py-2 text-sm text-right">Total nilai stok (halaman ini)</td>
                                <td class="px-4 py-2 text-sm text-right">
                                    Rp{{ number_format($products->sum('stock_value'), 0, ',', '.') }}
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-4">{{ $products->links() }}</div>
            </x-card>
        </div>
    </div>
</x-app-layout>