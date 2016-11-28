<?php

// UpdateStock.php

namespace Cart\Handlers;

use Cart\Handlers\Contracts\HandlerInterface;


class UpdateStock implements HandlerInterface
{
    public function handle($event)
    {
        // $product is an object(Cart\Models\Product), so it
        // has a method called decrement. quantity is not part
        // of the database object, but of the Basket, though
        // the 'orders_product' table does have a quantity field.
        foreach ($event->basket->all() as $product)
        {
            $product->decrement('stock', $product->quantity);
        }
    }
}