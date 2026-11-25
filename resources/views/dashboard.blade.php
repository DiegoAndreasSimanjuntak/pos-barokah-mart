<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Ringkasan Hari Ini</h3>
                <div class="mt-8">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">Simulasi Tabel Produk</h3>
                    <div class="border rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama
                                        Produk</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Stok &
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">Indomie Goreng Rasa Original</td>
                                    <td class="px-6 py-4 text-sm text-center font-semibold">
                                        25
                                        <div class="mt-1"><x-badge :stock="25" /></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">Minyak Goreng Bimoli 1L</td>
                                    <td class="px-6 py-4 text-sm text-center font-semibold">
                                        4
                                        <div class="mt-1"><x-badge :stock="4" /></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">Beras Rojolele 5kg</td>
                                    <td class="px-6 py-4 text-sm text-center font-semibold">
                                        0
                                        <div class="mt-1"><x-badge :stock="0" /></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <p class="text-gray-600">
                    Selamat datang, <strong>{{ auth()->user()->name }}</strong>. Anda masuk sebagai <span
                        class="uppercase font-semibold text-indigo-600">{{ auth()->user()->role }}</span>.
                </p>
            </x-card>
        </div>
    </div>
</x-app-layout>