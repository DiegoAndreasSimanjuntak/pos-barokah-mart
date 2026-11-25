<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class TopProductsExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function __construct(protected $start, protected $end, protected $userId = null)
    {
    }

    public function collection(): \Illuminate\Support\Collection
    {
        return DB::table('transaction_details')
            ->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->join('products', 'products.id', '=', 'transaction_details.product_id')
            ->whereBetween('transactions.created_at', [$this->start, $this->end])
            ->when($this->userId, fn($q) => $q->where('transactions.user_id', $this->userId))
            ->groupBy('products.id', 'products.code', 'products.name')
            ->selectRaw('products.code, products.name, SUM(transaction_details.qty) as total_qty, SUM(transaction_details.subtotal) as total_rupiah')
            ->orderByDesc('total_qty')
            ->get();
    }

    public function headings(): array
    {
        return ['Peringkat', 'Kode', 'Nama Produk', 'Unit Terjual', 'Total Penjualan'];
    }

    public function map(mixed $row): array
    {
        static $peringkat = 0;
        $peringkat++;

        return [
            $peringkat,
            $row->code,
            $row->name,
            $row->total_qty,
            $row->total_rupiah
        ];
    }

    public function title(): string
    {
        return 'Produk Terlaris';
    }
}