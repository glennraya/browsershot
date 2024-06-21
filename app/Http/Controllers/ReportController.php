<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Browsershot\Browsershot;

class ReportController extends Controller
{
    public function generateReport(Request $request)
    {
        $top_selling = Product::select(
            'products.name',
            'products.price',
            DB::raw('sales.date_purchased'),
            DB::raw('SUM(sales.quantity) as total_quantity_sold')
        )
        ->join('sales', 'products.id', '=', 'sales.product_id')
        ->whereBetween('sales.date_purchased', [Carbon::create($request->start), Carbon::create($request->end)])
        ->groupBy('products.id', 'products.name', 'products.price', DB::raw('sales.date_purchased'))
        ->orderBy('date_purchased', 'asc')
        ->orderBy('total_quantity_sold', 'desc')
        ->get();

        $payload = [
            'name' => 'The Boring Company',
            'address' => 'Pine Rd. Arcadia, Texas US',
            'phone' => '+1 999-000-7777',
            'email' => 'xyz@example.com',
            'tax_rate' => 12.99,
            'items' => $top_selling,
        ];

        $template = view('report', ['payload' => $payload])->render();

        Browsershot::html($template)
            ->showBackground()
            ->margins(4, 4, 4, 4)
            ->save(storage_path('/app/reports/example.pdf'));
    }
}
