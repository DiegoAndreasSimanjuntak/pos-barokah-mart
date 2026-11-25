<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Buat Purchase Order</h2>
    </x-slot>

    <div class="py-12" x-data="poForm({{ Js::from($products) }})">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('purchase-orders.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Supplier</label>
                        <select name="supplier_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            required>
                            <option value="">Pilih Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="border-t pt-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Produk</h3>
                        <template x-for="(row, index) in rows" :key="index">
                            <div class="flex gap-4 items-end mb-4">
                                <div class="flex-1">
                                    <label class="block text-xs font-medium text-gray-700">Produk</label>
                                    <select x-model="row.product_id" :name="'items['+index+'][product_id]'"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        required>
                                        <option value="">Pilih Produk</option>
                                        @foreach($products as $prod)
                                            <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-24">
                                    <label class="block text-xs font-medium text-gray-700">Qty</label>
                                    <input type="number" x-model.number="row.qty" :name="'items['+index+'][qty]'"
                                        min="1"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        required>
                                </div>
                                <div class="w-40">
                                    <label class="block text-xs font-medium text-gray-700">Harga Beli (Satuan)</label>
                                    <input type="number" x-model.number="row.cost_price"
                                        :name="'items['+index+'][cost_price]'" min="0"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        required>
                                </div>
                                <div class="w-40">
                                    <label class="block text-xs font-medium text-gray-700">Subtotal</label>
                                    <div class="mt-2 text-gray-700 font-semibold"
                                        x-text="rupiah(row.qty * row.cost_price)"></div>
                                </div>
                                <button type="button" @click="rows.splice(index, 1)"
                                    class="text-red-600 mb-2 font-semibold" x-show="rows.length > 1">Hapus</button>
                            </div>
                        </template>
                    </div>

                    <div class="flex justify-between items-center border-t pt-4">
                        <button type="button" @click="rows.push({ product_id: '', qty: 1, cost_price: 0})"
                            class="text-indigo-600 text-sm font-semibold mt-2">+ Tambah Baris Produk</button>
                        <div class="text-lg font-bold text-gray-800">
                            Total: <span x-text="rupiah(total)"></span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                        <textarea name="note" rows="2"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('note') }}</textarea>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md font-semibold transition">Simpan
                            Purchase Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script Alpine.js diletakkan di slot scripts (jika layout kamu mendukungnya) atau biarkan saja di sini -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('poForm', (products) => ({
                products: products,
                rows: [{ product_id: '', qty: 1, cost_price: 0 }],
                get total() {
                    return this.rows.reduce((sum, row) => sum + (row.qty * row.cost_price), 0);
                },
                rupiah(number) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(number);
                }
            }));
        });
    </script>
</x-app-layout>