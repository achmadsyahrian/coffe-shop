<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - {{$outlet->name}}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            width: 100vw;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            /* Pastikan logo container mengisi lebar penuh */
            margin-bottom: 20px;
            /* Jarak bawah jika diperlukan */
        }

        .logo-img {
            width: 70px;
            height: 70px;
        }

        .store-name {
            font-size: 30px;
            font-weight: 700;
            text-align: center;
            margin-left: 5px;
            /* Menjaga teks tetap rata tengah */
        }


        .address {
            font-size: 12px;
            margin-top: 5px;
        }

        .period {
            text-align: center;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            white-space: nowrap;
            /* Prevent text from breaking */
        }

        .report-table th {
            background-color: #f4f4f4;
        }

        .report-table td {
            background-color: #fff;
        }

        .grand-total {
            text-align: right;
            font-size: 14px;
            font-weight: bold;
            margin-top: 20px;
        }

        .print-btn {
            background-color: #795548;
            /* Warna hijau */
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin: 20px;
            display: flex;
            justify-content: center;
            transition: background-color 0.3s;
        }

        .print-btn:hover {
            background-color: #543429;
        }

        .print-btn:focus {
            outline: none;
        }

        @media print {
            @page {
                size: landscape;
                margin: 10mm;
                /* Menambah ruang margin untuk menghindari terpotong */
            }

            .print-btn {
                display: none;
            }

            body {
                font-size: 12px;
                /* Menyesuaikan ukuran font agar lebih cocok untuk print */
                margin: 0;
                padding: 0;
            }

            .container {
                width: 100%;
                margin: 0;
                padding: 0;
            }

            .header {
                text-align: center;
                margin-bottom: 20px;
            }

            .report-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            .report-table th,
            .report-table td {
                padding: 12px;
                text-align: left;
                border: 1px solid #ddd;
                font-size: 12px;
                /* Ukuran font lebih kecil untuk print */
                word-wrap: break-word;
                /* Agar teks tidak terpotong */
            }

            .grand-total {
                text-align: right;
                font-size: 14px;
                font-weight: bold;
                margin-top: 20px;
            }

            /* Menyesuaikan tabel agar tidak overflow */
            .report-table th,
            .report-table td {
                padding: 10px;
                text-align: left;
                white-space: normal;
                /* Allow text to wrap */
            }

            /* Sesuaikan ukuran tabel untuk menghindari overflow */
            .report-table {
                table-layout: auto;
                /* Mengatur tata letak otomatis agar lebih fleksibel */
            }
        }
    </style>


</head>

<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="logo">
                <img src="{{ asset('favicon.png') }}" alt="Logo Toko Kopi" class="logo-img">
                <span class="store-name">{{ $outlet->name }}</span>
            </div>
            <div class="address">
                <p>{{ $outlet->address }}</p>
            </div>
        </header>

        <!-- Periode Laporan -->
        <div class="period">
            <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($request->start_date)->format('d F Y') }} -
                {{ \Carbon\Carbon::parse($request->end_date)->format('d F Y') }}</p>
        </div>


        <!-- Tabel Laporan -->
        <table class="report-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>No. Faktur</th>
                    <th>Nama Pembeli</th>
                    <th>Pesanan</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Total Harga</th>
                    <th>Status Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalHargaItem = 0;
                    $totalHarga = 0;
                    $totalQty = 0;
                @endphp
                @foreach ($transactions as $transaction)
                    @foreach ($transaction->transactionItems as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($transaction->payment_date)->format('d/m/Y') }}</td>
                            <td>{{ $transaction->invoice_number }}</td>
                            <td>{{ $transaction->user->name }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td>Rp. {{ number_format($item->product->harga, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp. {{ number_format($item->product->harga * $item->quantity, 0, ',', '.') }}</td>
                            <td>
                                {{ $transaction->payment_status == 'completed' ? 'Selesai' : ($transaction->payment_status == 'reject' ? 'Ditolak' : ucfirst($transaction->payment_status)) }}
                            </td>
                        </tr>
                        @php
                            // Update total harga dan qty
                            $totalHargaItem += $item->product->harga;
                            $totalHarga += $item->product->harga * $item->quantity;
                            $totalQty += $item->quantity;
                        @endphp
                    @endforeach
                @endforeach
                <!-- Baris Grand Total -->
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold;">Total:</td>
                    <td>Rp. {{ number_format($totalHargaItem, 0, ',', '.') }}</td>
                    <td>{{ $totalQty }}</td>
                    <td>Rp. {{ number_format($totalHarga, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    <button class="print-btn" onclick="window.print()"><i class="fas fa-print" style="margin-right: 5px;"></i> Print</button>

    <script src="https://kit.fontawesome.com/23dde1eb1b.js" crossorigin="anonymous"></script>
    <script>
        function printPage() {
            window.print();
        }
    </script>

</body>

</html>
