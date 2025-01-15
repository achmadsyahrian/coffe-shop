@extends('layouts.main')
@section('container')
    <style>
        .invoice-header {
            display: flex;
            justify-content: space-between;
        }

        .invoice-details,
        .invoice-header-right {
            width: 30%;
        }

        .invoice-header-right {
            text-align: right;
        }

        .address {
            white-space: normal;
            word-wrap: break-word;
            hyphens: auto;
        }
    </style>

    <section class="blog-banner-area" id="category">
        <div class="container h-60">
            <div class="blog-banner">
                <div class="text-center">
                    <h1>INVOICE #{{ $transaction->invoice_number }}</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="section-margin--small mb-5">
        <div class="container invoice-page">
            <div class="invoice-header d-flex justify-content-between">
                <div class="invoice-details">
                    <h5>Outlet Information</h5>
                    <p class="mb-0">{{ $outlet->name }}</p> <!-- Assuming outlet is available -->
                    <p class="mb-0">{{ $outlet->address }}</p>
                    <p class="mb-0">{{ $outlet->phone }}</p>
                </div>

                <div class="invoice-header-right">
                    <h5>Customer Information</h5>
                    <p class="mb-0">{{ $transaction->user->name }}</p>
                    <p class="mb-0">
                        @if ($transaction->alamat_lengkap)
                        {{ $transaction->alamat_lengkap }},
                        @endif
                        {{ $transaction->kecamatan }},
                        {{ $transaction->kabupaten }},
                        {{ $transaction->provinsi }}
                    </p>
                    <p class="mb-0">{{ $transaction->user->phone }}</p>
                </div>
            </div>

            <!-- Invoice Details Section -->
            <div class="invoice-body mt-4">
                <div class="invoice-items">
                    <h5>Invoice #{{ $transaction->invoice_number }}</h5>
                    <p>Status :
                        @if ($transaction->payment_status == 'new')
                            Pending
                        @elseif ($transaction->payment_status == 'completed')
                            Selesai
                        @elseif ($transaction->payment_status == 'reject')
                            Ditolak
                        @else
                            {{ ucfirst($transaction->payment_status) }}
                        @endif
                    </p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalQuantity = 0;
                                $grandTotal = 0;
                            @endphp

                            @foreach ($transaction->transactionItems as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>Rp. {{ number_format($item->product->harga, 2, ',', '.') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp. {{ number_format($item->sub_total, 2, ',', '.') }}</td>
                                </tr>

                                @php
                                    $totalQuantity += $item->quantity;
                                    $grandTotal += $item->sub_total;
                                @endphp
                            @endforeach
                        </tbody>

                        <!-- Grand Total Row -->
                        <tfoot>
                            <tr>
                                <td><strong>Total</strong></td>
                                <td></td> <!-- Kosongkan kolom harga -->
                                <td>{{ $totalQuantity }}</td>
                                <td><strong>Rp. {{ number_format($grandTotal, 2, ',', '.') }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="#" class="button button-postComment text-center button--active" onclick="window.print()"><i
                        class="fas fa-print"></i> <span class="ml-2">Print Invoice</span></a>
            </div>
        </div>
    </section>
@endsection
