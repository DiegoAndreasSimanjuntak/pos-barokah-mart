<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Tambah Supplier</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form action="{{ route('suppliers.store') }}" method="POST" class="space-y-4">
                    @include('suppliers._form')
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>