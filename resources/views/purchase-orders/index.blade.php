<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Riwayat Pembelian (PO)</h2>
            <a href="{{ route('purchase-orders.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-semibold transition">+
                Buat PO Baru</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-400 rounded-md text-sm">
                        {{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-3 bg-red-100 text-red-700 border border-red-400 rounded-md text-sm">
                        {{ session('error') }}</div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">No. PO</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Supplier</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-600">Total</th>
                                <th class="px-4 py-3 text-center font-semibold text-gray-600">Status</th>
                                <th class="px-4 py-3 text-center font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($purchaseOrders as $po)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $po->po_number }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $po->ordered_at->format('d M Y') }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $po->supplier->name }}</td>
                                    <td class="px-4 py-3 text-right text-gray-900">
                                        Rp{{ number_format($po->total, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full font-semibold {{ $po->status === 'received' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                            {{ strtoupper($po->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center space-x-3">
                                        <a href="{{ route('purchase-orders.show', $po) }}"
                                            class="text-indigo-600 hover:text-indigo-900 font-medium">Detail</a>
                                        @if($po->status === 'pending')
                                            <form action="{{ route('purchase-orders.destroy', $po) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus PO ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 font-medium">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500 italic">Belum ada data
                                        Purchase Order.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $purchaseOrders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>