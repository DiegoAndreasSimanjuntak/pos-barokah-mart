<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Detail PO: {{ $po->po_number }}</h2>
            <a href="{{ route('purchase-orders.index') }}" class="text-gray-600 hover:text-gray-900 underline font-medium">Kembali ke Daftar</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-700 border border-green-400 rounded-md font-medium">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="p-4 bg-red-100 text-red-700 border border-red-400 rounded-md font-medium">{{ session('error') }}</div>
            @endif
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Info Supplier dan Status -->
                <div class="grid grid-cols-2 gap-4 text-sm mb-8 border-b pb-6">
                    <div>
                        <p class="text-gray-500 font-semibold mb-1">Informasi Supplier</p>
                        <p class="font-bold text-gray-900 text-lg">{{ $po->supplier->name }}</p>
                        @if($po->supplier->phone) <p class="text-gray-600">{{ $po->supplier->phone }}</p> @endif
                        @if($po->supplier->address) <p class="text-gray-600">{{ $po->supplier->address }}</p> @endif
                    </div>
                    <div class="text-right">
                        <p class="text-gray-500 font-semibold mb-1">Status Pesanan</p>
                        <p class="font-bold text-lg {{ $po->status === 'received' ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ strtoupper($po->status) }}
                        </p>
                        <p class="text-gray-600 mt-2">Dipesan: {{ $po->ordered_at->format('d/m/Y H:i') }}</p>
                        @if($po->status === 'received')
                            <p class="text-gray-600">Diterima: {{ $po->received_at->format('d/m/Y H:i') }}</p>
                        @endif
                    </div>
                </div>

                <!-- Tabel Item -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Produk</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-600">Qty</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-600">Harga Beli</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-600">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($po->items as $item)
                                <tr>
                                    <td class="px-4 py-3 text-gray-900 font-medium">{{ $item->product->name ?? 'Produk Dihapus' }}</td>
                                    <td class="px-4 py-3 text-right text-gray-600">{{ $item->qty }}</td>
                                    <td class="px-4 py-3 text-right text-gray-600">Rp{{ number_format($item->cost_price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right text-gray-900 font-medium">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="px-4 py-4 text-right text-lg text-gray-700">Total Pembelian:</th>
                                <th class="px-4 py-4 text-right text-xl font-bold text-indigo-700">Rp{{ number_format($po->total, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($po->note)
                    <div class="mt-6 bg-gray-50 p-4 rounded-md">
                        <p class="text-sm text-gray-500 font-semibold mb-1">Catatan:</p>
                        <p class="text-sm text-gray-800">{{ $po->note }}</p>
                    </div>
                @endif

                <!-- Tombol Terima Barang -->
                @if($po->status === 'pending')
                    <div class="mt-8 border-t pt-6 flex justify-end">
                        <form action="{{ route('purchase-orders.receive', $po) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin barang sudah datang? Aksi ini akan menambahkan stok produk ke sistem secara permanen.')">
                            @csrf
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-md font-bold shadow-lg transition flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Terima Barang & Tambah Stok
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>