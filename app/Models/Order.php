<?php

namespace Cart\Models;

use Cart\Models\Product;

use Cart\Models\Address;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Tell Eloquent what the fillable columns are in the table
    protected $fillable = [

        'hash',
        'total',
        'paid',
        'address_id'
    ];

    // Create the relationship with the address
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'orders_products')->withPivot('quantity');
    }
        
}
