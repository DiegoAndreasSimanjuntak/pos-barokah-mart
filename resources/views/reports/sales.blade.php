<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Laporan Penjualan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Filter Form -->
            <x-card class="mb-6">
                <form method="GET" action="{{ route('report.sales') }}" class="flex flex-wrap items-end gap-4">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Dari Tanggal</label>
                        <input type="date" name="start" value="{{ $start->format('Y-m-d') }}"
                            class="rounded-md border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end" value="{{ $end->format('Y-m-d') }}"
                            class="rounded-md border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Kasir</label>
                        <select name="user_id" class="rounded-md border-gray-300 text-sm min-w-[150px]">
                            <option value="">Semua Kasir</option>
                            @foreach ($kasirs as $kasir)
                                <option value="{{ $kasir->id }}" @selected(request('user_id') == $kasir->id)>
                                    {{ $kasir->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit"
                            class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm hover:bg-gray-700">Tampilkan</button>
                        <a href="{{ route('report.export', request()->query()) }}"
                            class="bg-green-600 text-white px-4 py-2 rounded-md text-sm hover:bg-green-700">Export
                            Excel</a>
                    </div>
                </form>
            </x-card>

            <!-- Summary Cards -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <x-card class="text-center">
                    <p class="text-gray-500 text-sm">Total Penjualan</p>
                    <p class="text-2xl font-bold text-indigo-600">Rp{{ number_format($totalPenjualan, 0, ',', '.') }}
                    </p>
                </x-card>
                <x-card class="text-center">
                    <p class="text-gray-500 text-sm">Jumlah Transaksi</p>
                    <p class="text-2xl font-bold">{{ $jumlahTransaksi }}</p>
                </x-card>
            </div>

            <!-- Data Table -->
            <x-card>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left">No. Invoice</th>
                                <th class="px-3 py-2 text-left">Tanggal</th>
                                <th class="px-3 py-2 text-left">Kasir</th>
                                <th class="px-3 py-2 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($transactions as $trx)
                                <tr>
                                    <td class="px-3 py-2">{{ $trx->invoice_number }}</td>
                                    <td class="px-3 py-2">{{ $trx->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-3 py-2">{{ $trx->user->name }}</td>
                                    <td class="px-3 py-2 text-right">Rp{{ number_format($trx->total, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-6 text-center text-gray-500">Tidak ada transaksi pada
                                        periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>

        </div>
    </div>
</x-app-layout>