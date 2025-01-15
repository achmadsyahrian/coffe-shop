<?php

use App\Models\Rate;
use App\Models\Outlet;
use App\Models\Product;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MetodeWpController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CreateOutletController;
use App\Http\Controllers\DashboardTransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StaffController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// =================================================================================================================
// Main Section
Route::get('/', function () {
    $popularProducts = Product::with('category') // Memuat relasi kategori
        ->leftJoin('transaction_items', 'products.id', '=', 'transaction_items.product_id')
        ->select('products.id', 'products.name', 'products.photo_1', 'products.category_id', 'products.harga', DB::raw('SUM(transaction_items.quantity) as total_quantity'))
        ->groupBy('products.id', 'products.name', 'products.photo_1', 'products.category_id', 'products.harga')
        ->orderByDesc('total_quantity')
        ->paginate(10);
    
    return view('index', [
        'products' => Product::latest()->get(),
        'popularProducts' => $popularProducts
    ]);
});

Route::get('/shop', function() {
    return view('shop', [
        'products' => Product::filter(request(['search']))->paginate(9)->withQueryString(),
        'newProducts' => Product::latest()->get()
    ]);
});

Route::get('/shop/product-{product:id}', [ProductController::class, 'detail']);


// =================================================================================================================
// Transaction Section
Route::get('/checkout', [TransactionController::class, 'index'])->middleware('auth');
Route::post('/transaction', [TransactionController::class, 'store'])->name('transaction.add')->middleware('auth');
Route::get('/confirmation', function() {
    return view('confirmation');
});
Route::get('/invoice/{invoice_number}', [TransactionController::class, 'showInvoice'])->name('invoice.show');


// =================================================================================================================
// Region Controller
Route::post('/getKabupaten', [TransactionController::class, 'getKabupaten'])->name('getKabupaten')->middleware('auth');
Route::post('/getKecamatan', [TransactionController::class, 'getKecamatan'])->name('getKecamatan')->middleware('auth');


// =================================================================================================================
// Cart Section
Route::get('/cart', [CartController::class, 'index'])->name('cart.index')->middleware('auth');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add')->middleware('auth');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove')->middleware('auth');


// =================================================================================================================
// Order Section
Route::get('/orders', [OrderController::class, 'index'])->middleware('auth');
Route::get('/orders/{transaction:id}', [OrderController::class, 'detail'])->middleware('auth');

// =================================================================================================================
// Dashboard / Customer Section
Route::get('/dashboard/customers', function() {
    $customers = User::where('role_id', 3)->paginate(10);

    $customers->each(function($customer) {
        // Memuat transaksi beserta itemnya
        $transactions = $customer->transactions()
            ->whereHas('transactionItems') // Memastikan transaksi memiliki item
            ->with('transactionItems') // Memuat relasi transactionItems
            ->get();

        // Menghitung total item yang dibeli oleh customer
        $customer->total_items_bought = $transactions->sum(function($transaction) {
            return $transaction->transactionItems->sum('quantity');
        });
    });

    return view('dashboard.customers.index', compact('customers'));
})->name('customers.index')->middleware('auth');


// =================================================================================================================
// Dashboard / Outlet Section
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::resource('/dashboard/products', ProductController::class)->middleware('auth');
Route::get('/dashboard/populer-products', [ProductController::class, 'populer'])->middleware('auth');
Route::resource('/dashboard/categories', CategoryController:: class)->middleware('auth');

// Route::get('/create-outlet', [CreateOutletController::class, 'index'])->middleware('auth');
// Route::post('/create-outlet', [CreateOutletController::class, 'store'])->middleware('auth');


// =================================================================================================================
// Dashboard / Staff Section
Route::resource('/dashboard/staff', StaffController::class)->middleware('auth');
Route::put('/dashboard/staff/reset-password/{id}', [StaffController::class, 'resetPassword'])->name('staff.resetPassword')->middleware('auth');

// =================================================================================================================
// Authentication Section
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);


// =================================================================================================================
// Metode Section
Route::get('/tablewp', [MetodeWpController::class, 'table'])->name('tablewp')->middleware('auth');
Route::get('/metodewp', [MetodeWpController::class, 'index'])->name('metodewp')->middleware('auth');

// =================================================================================================================
// Dashboard Transaction Section
Route::get('/dashboard/transaction/new', [DashboardTransactionController::class, 'showNew'])->middleware('auth');
Route::get('/dashboard/transaction/new/{transaction:id}', [DashboardTransactionController::class, 'confirmation'])->middleware('auth');
Route::put('/dashboard/transaction/new/{transaction}', [DashboardTransactionController::class, 'changeStatus'])->name('transaction.update')->middleware('auth');

Route::get('/dashboard/transaction/completed', [DashboardTransactionController::class, 'showComplete'])->middleware('auth');
Route::get('/dashboard/transaction/completed/{transaction:id}', [DashboardTransactionController::class, 'detailComplete'])->middleware('auth');

Route::get('/dashboard/transaction/rejected', [DashboardTransactionController::class, 'showReject'])->middleware('auth');
Route::get('/dashboard/transaction/rejected/{transaction:id}', [DashboardTransactionController::class, 'detailReject'])->middleware('auth');

Route::get('/dashboard/transaction/report', [ReportController::class, 'index'])->name('report.index')->middleware('auth');
Route::post('/dashboard/transaction/report/print', [ReportController::class, 'print'])->name('report.print')->middleware('auth');


Route::post('/review', [ReviewController::class, 'store']);

