<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Inventory;

class UpdateProductStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-product-stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update stock column in products table based on inventory quantities';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $products = Product::all();

        foreach ($products as $product) {
            $inventory = $product->inventory;
            if ($inventory) {
                $product->update(['stock' => $inventory->quantity]);
                $this->info("Updated product {$product->id} with stock {$inventory->quantity}");
            } else {
                $product->update(['stock' => 0]);
                $this->info("Updated product {$product->id} with stock 0 (no inventory)");
            }
        }

        $this->info('Stock update completed!');
    }
}
