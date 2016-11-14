<?php

namespace Cart\Models;

use Cart\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // Tell Eloquent what the fillable columns are in the table
    protected $fillable = [
        'email',
        'name',
    ];

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
