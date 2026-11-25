<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\SalesReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    private function rentangTanggal(Request $request): array
    {
        $start = $request->filled('start') ? Carbon::parse($request->start)->startOfDay() : now()->subDays(6)->startOfDay();
        $end = $request->filled('end') ? Carbon::parse($request->end)->endOfDay() : now()->endOfDay();

        return [$start, $end];
    }

    public function sales(Request $request)
    {
        [$start, $end] = $this->rentangTanggal($request);

        $transactions = Transaction::with('user')
            ->whereBetween('created_at', [$start, $end])
            ->when($request->filled('user_id'), fn($q) => $q->where('user_id', $request->user_id))
            ->latest()
            ->get();

        $totalPenjualan = $transactions->sum('total');
        $jumlahTransaksi = $transactions->count();

        $kasirs = User::whereIn('role', ['admin', 'kasir'])->orderBy('name')->get(['id', 'name']);

        return view('reports.sales', compact('transactions', 'totalPenjualan', 'jumlahTransaksi', 'start', 'end', 'kasirs'));
    }

    public function export(Request $request)
    {
        [$start, $end] = $this->rentangTanggal($request);

        $filename = 'laporan-penjualan-' . $start->format('Ymd') . '-' . $end->format('Ymd') . '.xlsx';

        return Excel::download(new SalesReportExport($start, $end, $request->input('user_id')), $filename);
    }
}
