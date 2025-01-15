<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\TransactionItem;
use App\Models\Transaction;
class DashboardController extends Controller
{
    public function index()
    {
        // Mendapatkan produk yang terkait dengan outlet yang login
        $productBuy = Product::pluck('id');

        // Mengecek role_id pengguna yang sedang login
        $roleId = auth()->user()->role_id;

        if ($roleId == 1) {
            // 1. Data total grand_total dari transaksi yang memiliki transaction_id dengan product_id sesuai outlet yang login
            $totalGrandTotal = Transaction::whereIn('id', function ($query) use ($productBuy) {
                $query->select('transaction_id')
                    ->from('transaction_items')
                    ->whereIn('product_id', $productBuy);
            })
            ->where('payment_status', 'completed') // Menambahkan kondisi payment_status
            ->sum('grand_total');

            // 2. Data total produk yang memiliki outlet_id sesuai outlet user yang login
            $totalProducts = Product::count();

            // 3. Data total pesanan yang memiliki payment_status = completed
            $totalCompletedOrders = Transaction::whereIn('id', 
                function ($query) use ($productBuy) {
                    $query->select('transaction_id')
                        ->from('transaction_items')
                        ->whereIn('product_id', $productBuy);
                }
            )
            ->where('payment_status', 'completed') // Menambahkan kondisi payment_status
            ->count();

            return view('dashboard.index', [
                'totalGrandTotal' => $totalGrandTotal,
                'totalProducts' => $totalProducts,
                'totalCompletedOrders' => $totalCompletedOrders
            ]);
        } else {
            // Data transaksi dengan status baru
            $newTransactions = Transaction::whereIn('id', function ($query) use ($productBuy) {
                $query->select('transaction_id')
                    ->from('transaction_items')
                    ->whereIn('product_id', $productBuy);
            })
            ->where('payment_status', 'new') // status baru
            ->count();

            // Data transaksi dengan status completed
            $completedTransactions = Transaction::whereIn('id', function ($query) use ($productBuy) {
                $query->select('transaction_id')
                    ->from('transaction_items')
                    ->whereIn('product_id', $productBuy);
            })
            ->where('payment_status', 'completed') // status selesai
            ->count();

            // Data transaksi dengan status rejected
            $rejectedTransactions = Transaction::whereIn('id', function ($query) use ($productBuy) {
                $query->select('transaction_id')
                    ->from('transaction_items')
                    ->whereIn('product_id', $productBuy);
            })
            ->where('payment_status', 'rejected') // status ditolak
            ->count();

            return view('dashboard.index', [
                'newTransactions' => $newTransactions,
                'completedTransactions' => $completedTransactions,
                'rejectedTransactions' => $rejectedTransactions
            ]);
        }
    }


}
