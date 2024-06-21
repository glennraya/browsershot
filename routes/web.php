<?php

use Carbon\Carbon;
use App\Models\Sale;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Report route — template of the report.
Route::get('/report', function (Request $request) {
    $top_selling = Product::select(
        'products.name',
        'products.price',
        DB::raw('sales.date_purchased'),
        DB::raw('SUM(sales.quantity) as total_quantity_sold')
    )
    ->join('sales', 'products.id', '=', 'sales.product_id')
    ->whereBetween('sales.date_purchased', [Carbon::create(2021, 1, 1), Carbon::create(2024, 12, 31)])
    ->groupBy('products.id', 'products.name', 'products.price', DB::raw('sales.date_purchased'))
    ->orderBy('date_purchased', 'asc')
    ->orderBy('total_quantity_sold', 'desc')
    ->get();

    $payload = [
        'date' => now(),
        'report_number' => '423212-1',
        'name' => 'The Boring Company',
        'address' => 'Pine Rd. Arcadia, Texas US',
        'phone' => '+1999-000-7777',
        'email' => 'xyz@example.com',
        'tax_rate' => 12.99,
        'items' => $top_selling,
    ];

    return view('report', ['payload' => $payload]);
});

Route::get('/dashboard', function () {
    // $topSellingProducts = Product::select(
    //     'products.name',
    //     'products.price',
    //     DB::raw('SUM(sales.quantity) as total_quantity_sold')
    // )
    // ->join('sales', 'products.id', '=', 'sales.product_id')
    // ->groupBy('products.id', 'products.name', 'products.price')
    // ->orderBy('total_quantity_sold', 'desc')
    // ->take(5) // Get top 5 products
    // ->get();

    // $payload = [
    //     'report_number' => '423212-1',
    //     'name' => 'XYZ Incorporated',
    //     'address' => 'Pine Rd. Arcadia, Texas US',
    //     'phone' => '+1999-000-7777',
    //     'email' => 'xyz@example.com',
    //     'tax_rate' => 12.99,
    //     'items' => [
    //         ['item' => 'iPhone 14 Pro Max', 'quantity' => 1, 'price' => 1200, 'subtotal' => 1200],
    //     ],
    //     'top_selling' => $topSellingProducts
    // ];

    // $html = view('report', ['payload' => $payload])->render();

    // Browsershot::html($html)
    //     ->showBackground()
    //     ->margins(4, 0, 4, 0)
    //     ->save(storage_path('/app/reports/') . 'example.pdf');

    return Inertia::render('Dashboard', [
        'products' => Product::simplePaginate(10),
        // 'top_selling_products' => $topSellingProducts,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/filter', [ReportController::class, 'generateReport']);
});

require __DIR__.'/auth.php';
