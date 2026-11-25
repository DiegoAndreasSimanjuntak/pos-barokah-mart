<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk - {{ $transaction->invoice_number ?? $transaction->id }}</title>
    <style>
        /* Pengaturan ukuran kertas kasir (Thermal 58mm) */
        @page {
            margin: 0;
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #000;
            width: 58mm;
            margin: 0 auto;
            padding: 10px 5mm;
            line-height: 1.2;
        }

        /* Utilitas Teks */
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .font-bold {
            font-weight: bold;
        }

        /* Garis Pemisah */
        .border-top {
            border-top: 1px dashed #000;
            padding-top: 5px;
            margin-top: 5px;
        }

        .border-bottom {
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }

        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
            padding: 2px 0;
        }

        /* Area tombol untuk layar */
        .action-bar {
            display: flex;
            gap: 6px;
            justify-content: center;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .btn-print {
            padding: 8px 10px;
            background-color: #4F46E5;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-family: sans-serif;
            font-size: 12px;
            white-space: nowrap;
        }

        .btn-back {
            background-color: #6B7280;
        }

        /* Mode Cetak: Sembunyikan tombol dan sesuaikan ukuran */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                width: 100%;
                padding: 0;
            }
        }
    </style>
</head>

<body>

    <!-- Tombol Aksi (Tidak akan ikut tercetak) -->
    <div class="no-print action-bar border-bottom">
        <button onclick="window.print()" class="btn-print">Cetak Sekarang</button>
        <a href="{{ route('pos.index') }}" class="btn-print btn-back">Kembali ke POS</a>
    </div>

    <!-- Header Toko -->
    <div class="text-center border-bottom">
        <div class="font-bold" style="font-size: 16px;">BAROKAH MART</div>
        <div style="font-size: 11px;">Jl. Raya Cikampek No. 123, Karawang</div>
        <div style="font-size: 11px;">Telp: 0812-3456-7890</div>
    </div>

    <!-- Informasi Transaksi -->
    <div class="border-bottom" style="font-size: 11px;">
        <table>
            <tr>
                <td class="text-left">Tgl</td>
                <td class="text-right">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td class="text-left">Kasir</td>
                <td class="text-right">{{ $transaction->user->name ?? 'Admin' }}</td>
            </tr>
            <tr>
                <td class="text-left">No.</td>
                <td class="text-right">{{ $transaction->invoice_number ?? 'TRX-' . $transaction->id }}</td>
            </tr>
        </table>
    </div>

    <!-- Daftar Belanjaan -->
    <div class="border-bottom">
        <table>
            @foreach($transaction->details as $item)
                <tr>
                    <td colspan="3" class="text-left font-bold" style="padding-bottom: 0;">
                        {{ $item->product->name ?? 'Produk' }}
                    </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 25%;">{{ $item->qty }}x</td>
                    <td class="text-left" style="width: 35%;">{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-right" style="width: 40%;">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <!-- Ringkasan Pembayaran -->
    <div class="border-bottom">
        <table>
            <tr>
                <td class="text-left font-bold">Total</td>
                <td class="text-right font-bold" style="font-size: 14px;">
                    {{ number_format($transaction->total, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td class="text-left">Bayar (Cash)</td>
                <td class="text-right">{{ number_format($transaction->pay ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-left">Kembalian</td>
                <td class="text-right">{{ number_format($transaction->change ?? 0, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <!-- Footer Struk -->
    <div class="text-center" style="font-size: 11px; margin-top: 15px;">
        <div class="font-bold">Terima Kasih</div>
        <div>Barang yang sudah dibeli</div>
        <div>tidak dapat ditukar/dikembalikan</div>
    </div>

    <!-- Otomatis buka dialog print saat halaman dimuat -->
    <script>
        window.onload = function () {
            window.print();
        }
    </script>
</body>

</html>