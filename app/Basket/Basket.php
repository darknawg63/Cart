<?php

namespace Cart\Basket;

use Cart\Models\Product;
use Cart\Support\Storage\Contracts\StorageInterface;
use Cart\Basket\Exceptions\QuantityExceededException;

class Basket
{
    protected $storage;
    protected $product;

    public function __construct(StorageInterface $storage, Product $product)
    {
        $this->storage = $storage;
        $this->product = $product;
    }

    public function add(Product $product, $quantity)
    {
        if ($this->has($product))
        {
            $quantity = $this->get($product)['quantity'] + $quantity;
        };

        $this->update($product, $quantity);
    }

    public function update(Product $product, $quantity)
    {
        // We need to hit the database to find if there are enough items in stock
        if (!$this->product->find($product->id)->hasStock($quantity))
        {
            throw new QuantityExceededException;
        }

        // This was not working with strict type checking, probably because of $quantity 
        // being a string. We could type cast to integer like (int) $quantity, but I've 
        // chosen to not strictly check the type with '==='.
        if ($quantity == 0)
        {
            $this->remove($product);

            return;
        }

        $this->storage->set($product->id, [

            'product_id' => $product->id,
            'quantity' => (int) $quantity

        ]);
    }

    public function remove(Product $product)
    {
        $this->storage->unset($product->id);
    }

    public function has(Product $product)
    {
        return $this->storage->exists($product->id);
    }

    public function get(Product $product)
    {
        return $this->storage->get($product->id);
    }

    public function clear()
    {
        $this->storage->clear();
    }

    /**
     *
     * Gets the whole bucket by calling the all() function of the SessionStorage class
     * then iterates over each product in the bucket and pushing its id onto the array
     * ids[]
     *
     * The array of id's is passed to the find() method of the Product model which 
     * which retrieves a collection of database record objects matching the id's.
     * The collection of records is iterated through, attaching a quantity attribute
     * to each and adding the quantity from the session bucket to that attribute.
     *
     */ 
    public function all()
    {
        $ids = [];
        $items = [];

        foreach ($this->storage->all() as $product)
        {
            $ids[] = $product['product_id'];
        }

        // We pass in a whole array of id's to Eloquent which will use only one query
        $products = $this->product->find($ids);

        foreach ($products as $product)
        {
            $product->quantity = $this->get($product)['quantity'];
            $items[] = $product;
        }

        // For my own clarification, this returns an array of database objects
        return $items;
    }

    public function itemCount()
    {
        return count($this->storage);
    }

    public function subTotal()
    {
        $total = 0;

        foreach ($this->all() as $item)
        {
            if ($item->outOfStock())
            {
                continue;
            }

            $total = $total + $item->price * $item->quantity;
        }

        return $total;
    }

    public function refresh()
    {
        // The all() function returns an array of database objects.
        foreach ($this->all() as $item)
        {
            if (!$item->hasStock($item->quantity))
            {
                $this->update($item, $item->stock);
            }
        }
    }
}