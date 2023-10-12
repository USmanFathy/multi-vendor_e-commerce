<?php

namespace App\Listeners;

use App\Facades\Cart;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class DeductProductQuatity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(): void
    {
        try {
            foreach (Cart::get() as $item){
                Product::where('id' ,$item->product_id)
                    ->update([
                        'quantity' => DB::raw("quantity - {$item->quantity}"),
                        'sales_count' => $item->quantity
                    ]);
            };
        }catch (\Throwable $e){}

    }
}
