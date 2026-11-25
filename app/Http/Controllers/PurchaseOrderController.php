<?php
namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('supplier')->latest()->paginate(10);
        return view('purchase-orders.index', compact('purchaseOrders'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('purchase-orders.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.cost_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $po = PurchaseOrder::create([
                'po_number' => 'PO-' . time(),
                'supplier_id' => $request->supplier_id,
                'status' => 'pending',
                'ordered_at' => now(),
                'note' => $request->note,
                'total' => 0
            ]);

            $total = 0;
            foreach ($request->items as $item) {
                $subtotal = $item['qty'] * $item['cost_price'];
                $total += $subtotal;

                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'cost_price' => $item['cost_price'],
                    'subtotal' => $subtotal,
                ]);
            }

            $po->update(['total' => $total]);
        });

        return redirect()->route('purchase-orders.index')->with('success', 'PO berhasil dibuat.');
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $po = $purchaseOrder->load('items.product', 'supplier');
        return view('purchase-orders.show', compact('po'));
    }

    public function receive(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status === 'received') {
            return back()->with('error', 'PO sudah diterima.');
        }

        DB::transaction(function () use ($purchaseOrder) {
            foreach ($purchaseOrder->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->qty);
                }
            }
            $purchaseOrder->update([
                'status' => 'received',
                'received_at' => now()
            ]);
        });

        return back()->with('success', 'Barang diterima, stok berhasil ditambahkan.');
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status === 'received') {
            return back()->with('error', 'PO yang sudah diterima tidak bisa dihapus.');
        }
        $purchaseOrder->delete();
        return back()->with('success', 'PO berhasil dihapus.');
    }
}