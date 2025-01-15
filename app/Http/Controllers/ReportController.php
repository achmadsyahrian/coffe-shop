<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('dashboard.report.index');
    }

    public function print(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $transactions = Transaction::whereBetween('created_at', [
            $request->start_date . ' 00:00:00',
            $request->end_date . ' 23:59:59'
        ])
        ->whereIn('payment_status', ['completed', 'reject'])
        ->get();

        $grandTotal = $transactions->sum(function ($transaction) {
            return $transaction->transactionItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });
        });

        return view('dashboard.report.print', compact('transactions', 'grandTotal', 'request'));
    }

}
