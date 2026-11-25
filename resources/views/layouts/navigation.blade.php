<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-8">
                <a href="{{ route('dashboard') }}" class="font-bold text-indigo-600 text-lg">
                    Barokah Mart
                </a>

                <div class="flex space-x-6 text-sm font-medium">
                    <a href="{{ route('dashboard') }}"
                        class="{{ request()->routeIs('dashboard') ? 'text-indigo-600 border-b-2 border-indigo-600 py-5' : 'text-gray-500 hover:text-gray-700 py-5' }}">
                        Dashboard
                    </a>

                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('categories.index') }}"
                            class="{{ request()->routeIs('categories.*') ? 'text-indigo-600 border-b-2 border-indigo-600 py-5' : 'text-gray-500 hover:text-gray-700 py-5' }}">
                            Kategori
                        </a>

                        <a href="{{ route('products.index') }}"
                            class="{{ request()->routeIs('products.*') ? 'text-indigo-600 border-b-2 border-indigo-600 py-5' : 'text-gray-500 hover:text-gray-700 py-5' }}">
                            Produk
                        </a>

                        <a href="{{ route('report.sales') }}"
                            class="{{ request()->routeIs('report.*') ? 'text-indigo-600 border-b-2 border-indigo-600 py-5' : 'text-gray-500 hover:text-gray-700 py-5' }}">
                            Laporan
                        </a>

                        <a href="{{ route('suppliers.index') }}"
                            class="{{ request()->routeIs('suppliers.*') ? 'text-indigo-600 border-b-2 border-indigo-600 py-5' : 'text-gray-500 hover:text-gray-700 py-5' }}">
                            Supplier
                        </a>
                        <a href="{{ route('purchase-orders.index') }}"
                            class="{{ request()->routeIs('purchase-orders.*') ? 'text-indigo-600 border-b-2 border-indigo-600 py-5' : 'text-gray-500 hover:text-gray-700 py-5' }}">
                            Purchase Order
                        </a>
                        <a href="{{ route('users.index') }}"
                            class="{{ request()->routeIs('users.*') ? 'text-indigo-600 border-b-2 border-indigo-600 py-5' : 'text-gray-500 hover:text-gray-700 py-5' }}">
                            Akun Kasir
                        </a>
                    @endif

                    <a href="{{ route('pos.index') }}"
                        class="{{ request()->routeIs('pos.*') ? 'text-indigo-600 border-b-2 border-indigo-600 py-5' : 'text-gray-500 hover:text-gray-700 py-5' }}">
                        Transaksi
                    </a>

                    @if (auth()->user()->role === 'kasir')
                        <a href="{{ route('pos.history') }}"
                            class="{{ request()->routeIs('pos.history') ? 'text-indigo-600 border-b-2 border-indigo-600 py-5' : 'text-gray-500 hover:text-gray-700 py-5' }}">
                            Riwayat Transaksi Saya
                        </a>
                    @endif
                </div>
            </div>

            <div class="flex items-center space-x-4 text-sm">
                <span class="text-gray-600">
                    {{ auth()->user()->name }} <span class="text-xs text-gray-400">({{ auth()->user()->role }})</span>
                </span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>