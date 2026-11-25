<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Detail Produk</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <div class="mb-6">
                    <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $product->code }} &middot; {{ $product->category->name }}</p>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-6">
                    <div class="bg-gray-50 rounded-md p-4 text-center">
                        <p class="text-xs text-gray-500">Harga</p>
                        <p class="text-lg font-semibold">{{ $product->price_rupiah }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-md p-4 text-center">
                        <p class="text-xs text-gray-500">Stok Saat Ini</p>
                        <p class="text-lg font-semibold">{{ $product->stock }} {{ $product->unit }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-md p-4 text-center">
                        <p class="text-xs text-gray-500">Total Terjual</p>
                        <p class="text-lg font-semibold">{{ $totalTerjual }} {{ $product->unit }}</p>
                    </div>
                </div>

                <h4 class="font-medium mb-2">Riwayat Penjualan Terakhir</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left">No. Invoice</th>
                                <th class="px-3 py-2 text-left">Tanggal</th>
                                <th class="px-3 py-2 text-center">Qty</th>
                                <th class="px-3 py-2 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($riwayat as $item)
                                <tr>
                                    <td class="px-3 py-2">{{ $item->transaction->invoice_number }}</td>
                                    <td class="px-3 py-2">{{ $item->transaction->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-3 py-2 text-center">{{ $item->qty }}</td>
                                    <td class="px-3 py-2 text-right">Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-4 text-center text-gray-500">Belum pernah terjual.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Tabel Peringkat 5 Hari Penjualan Tertinggi (Latihan 2) -->
                <h4 class="font-medium mt-6 mb-2">5 Hari Penjualan Tertinggi</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left">Peringkat</th>
                                <th class="px-3 py-2 text-left">Tanggal</th>
                                <th class="px-3 py-2 text-right">Unit Terjual</th>
                                <th class="px-3 py-2 text-right">Total Penjualan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($hariTerlaris as $hari)
                                <tr>
                                    <td class="px-3 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-3 py-2">{{ \Carbon\Carbon::parse($hari->tanggal)->format('d M Y') }}</td>
                                    <td class="px-3 py-2 text-right">{{ $hari->total_qty }} {{ $product->unit }}</td>
                                    <td class="px-3 py-2 text-right">Rp{{ number_format($hari->total_rupiah, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-4 text-center text-gray-500">Belum ada data penjualan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('products.index') }}"
                    class="inline-block mt-6 text-sm text-gray-600 hover:text-gray-900">
                    &larr; Kembali
                </a>
            </x-card>
        </div>
    </div>
</x-app-layout>