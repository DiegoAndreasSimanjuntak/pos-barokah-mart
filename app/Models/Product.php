<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = ['category_id', 'code', 'name', 'unit', 'price', 'stock', 'image'];

    // Accessor: $product->price_rupiah (Jawaban Latihan 2)
    protected function priceRupiah(): Attribute
    {
        return Attribute::make(
            get: fn() => 'Rp' . number_format($this->price, 0, ',', '.'),
        );
    }

    // Accessor: $product->stock_value (Jawaban Latihan 1 - Bab 8)
    protected function stockValue(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->stock * $this->price,
        );
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }


}
