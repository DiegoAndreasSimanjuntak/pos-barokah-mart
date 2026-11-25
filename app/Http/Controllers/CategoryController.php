<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->orderBy('name')
            ->paginate(10);

        return view('master-data.category.index', compact('categories'));
    }

    public function create()
    {
        return view('master-data.category.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $products = $category->products()->orderBy('name')->get();

        $totalStok = $products->sum('stock');
        $totalNilai = $products->sum(fn($p) => $p->stock * $p->price);

        return view('master-data.category.show', compact('category', 'products', 'totalStok', 'totalNilai'));
    }

    public function edit(Category $category)
    {
        return view('master-data.category.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        // Kategori yang masih punya produk tidak boleh dihapus
        if ($category->products()->exists()) {
            return redirect()->route('categories.index')
                ->with('error', 'Kategori ' . $category->name . ' tidak dapat dihapus karena masih memiliki produk.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
