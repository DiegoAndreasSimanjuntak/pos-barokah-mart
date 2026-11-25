@csrf
<div>
    <label class="block text-sm font-medium text-gray-700">Nama Supplier</label>
    <input type="text" name="name" value="{{ old('name', $supplier->name ?? '') }}"
        class="mt-1 block w-full rounded-md border-gray-300">
    @error('name')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>
<div>
    <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
    <input type="text" name="phone" value="{{ old('phone', $supplier->phone ?? '') }}"
        class="mt-1 block w-full rounded-md border-gray-300">
    @error('phone')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>
<div>
    <label class="block text-sm font-medium text-gray-700">Alamat</label>
    <textarea name="address" rows="3"
        class="mt-1 block w-full rounded-md border-gray-300">{{ old('address', $supplier->address ?? '') }}</textarea>
</div>
<button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">Simpan</button>