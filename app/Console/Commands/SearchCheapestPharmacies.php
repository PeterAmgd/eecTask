<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class SearchCheapestPharmacies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:search-cheapest {productId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get the most 5 cheapest pharmacies by product_id';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $productId = $this->argument('productId');

        // Fetch the product
        $product = Product::find($productId);

        if (!$product) {
            $this->error('Product not found.');
            return;
        }

        // Get the 5 cheapest pharmacies for the product
        $cheapestPharmacies = $product->pharmacies()
            ->orderBy('pharmacy_product.price')
            ->take(5)
            ->get(['pharmacies.id', 'pharmacies.name', 'pharmacy_product.price']);

        $this->info(json_encode($cheapestPharmacies, JSON_PRETTY_PRINT));
    }

}
