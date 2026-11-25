<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // 1. Pencarian Nama atau Kode Produk (Materi 10.2)
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('code', 'like', "%{$keyword}%");
            });
        }

        // 2. Filter Kategori (Materi 10.2)
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 3. Filter Status Stok: Semua / Menipis / Habis (Latihan 1)
        $batas = config('pos.low_stock_threshold', 10);
        match ($request->query('stock_status')) {
            'habis' => $query->where('stock', 0),
            'menipis' => $query->where('stock', '>', 0)->where('stock', '<', $batas),
            default => null,
        };

        // 4. Pilihan Jumlah Baris per Halaman (Latihan 2)
        $pilihan = [10, 25, 50];
        $perPage = in_array((int) $request->query('per_page'), $pilihan, true)
            ? (int) $request->query('per_page')
            : 10;

        $products = $query->latest()->paginate($perPage)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('master-data.product.index', compact('products', 'categories'));
    }

    // ... biarkan method create, store, edit, update, destroy tetap seperti sebelumnya

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('master-data.product.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['transactionDetails.transaction']);

        $totalTerjual = $product->transactionDetails->sum('qty');

        $riwayat = $product->transactionDetails()
            ->with('transaction')
            ->latest()
            ->take(10)
            ->get();

        // 5 hari dengan penjualan tertinggi untuk produk ini (Latihan 2)
        $hariTerlaris = $product->transactionDetails()
            ->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->selectRaw('DATE(transactions.created_at) as tanggal, SUM(transaction_details.qty) as total_qty, SUM(transaction_details.subtotal) as total_rupiah')
            ->groupBy('tanggal')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        return view('master-data.product.show', compact('product', 'totalTerjual', 'riwayat', 'hariTerlaris'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('master-data.product.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
