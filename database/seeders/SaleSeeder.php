<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all products that are not expired
        $products = Product::where('is_expired', 0)->get();

        // Loop through each product and create a sale
        foreach ($products as $product) {
            Sale::create([
                'product_id' => $product->id,
                'quantity' => rand(1, $product->quantity), // Random quantity between 1 and available quantity
                'date_purchased' => Carbon::now()->subYears(rand(0, 3)), // Random date within the last year
            ]);
        }
    }
}
