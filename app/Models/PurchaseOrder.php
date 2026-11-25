<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = ['po_number', 'supplier_id', 'total', 'status', 'ordered_at', 'received_at', 'note'];
    protected $casts = ['ordered_at' => 'datetime', 'received_at' => 'datetime'];

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}