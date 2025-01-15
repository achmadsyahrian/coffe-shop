<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;

class DashboardTransactionController extends Controller
{
    public function showNew()
    {
        $productBuy = Product::pluck('id');
        $transactionItems = TransactionItem::whereIn('product_id', $productBuy)->get();
        $transactionIds = $transactionItems->pluck('transaction_id')->unique();
        $transactions = Transaction::whereIn('id', $transactionIds)
                                    ->where('payment_status', 'new')
                                    ->get();
        return view('dashboard.transactions.new.index', [
            'transactions' => $transactions,
        ]);
    }

    public function confirmation(Transaction $transaction) 
    {
        return view('dashboard.transactions.detail', [
        'transaction' => $transaction,
        'transactionItems' => TransactionItem::where('transaction_id', $transaction->id)->get()
        ]);
    }

    public function changeStatus(Request $request, Transaction $transaction)
    {
        $validateData = $request->validate([
            'payment_status' => 'required'
        ]);

        $transaction->payment_status = $validateData['payment_status'];
        $transaction->staff_id = auth()->user()->id;
        $transaction->save();

        if ($validateData['payment_status'] === 'completed') {
            foreach ($transaction->transactionItems as $item) {
                // Ambil produk terkait
                $product = $item->product;

                if ($product) {
                    // Kurangi stok sesuai quantity dalam transaksi
                    $product->stock -= $item->quantity;

                    // Cegah stok negatif
                    if ($product->stock < 0) {
                        return redirect('/dashboard/transaction/new')->with('error', 'Stock not sufficient for product: ' . $product->name);
                    }

                    // Simpan perubahan stok
                    $product->save();
                }
            }
        }

        return redirect('/dashboard/transaction/new')->with('success', 'Payment has been confirmed!');
    }


    public function showComplete()
    {
        $outletAuth = Outlet::first()->get('id');
        $productBuy = Product::pluck('id');
        $transactionItems = TransactionItem::whereIn('product_id', $productBuy)->get();
        $transactionIds = $transactionItems->pluck('transaction_id')->unique();
        $transactions = Transaction::whereIn('id', $transactionIds)
                                    ->where('payment_status', 'completed')
                                    ->get();
        
        return view('dashboard.transactions.complete.index', [
            'transactions' => $transactions,
        ]);
    }

    public function detailComplete(Transaction $transaction) 
    {
        return view('dashboard.transactions.detail', [
        'transaction' => $transaction,
        'transactionItems' => TransactionItem::where('transaction_id', $transaction->id)->get()
        ]);
    }

    public function showReject()
    {
        $outletAuth = Outlet::first()->get('id');
        $productBuy = Product::pluck('id');
        $transactionItems = TransactionItem::whereIn('product_id', $productBuy)->get();
        $transactionIds = $transactionItems->pluck('transaction_id')->unique();
        $transactions = Transaction::whereIn('id', $transactionIds)
                                    ->where('payment_status', 'reject')
                                    ->get();
        
        return view('dashboard.transactions.reject.index', [
            'transactions' => $transactions,
        ]);
    }

    public function detailReject(Transaction $transaction) 
    {
        return view('dashboard.transactions.detail', [
        'transaction' => $transaction,
        'transactionItems' => TransactionItem::where('transaction_id', $transaction->id)->get()
        ]);
    }


}
