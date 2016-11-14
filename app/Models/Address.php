<?php


namespace Cart\Models;

use Cart\Models\Order;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    // Tell Eloquent what the fillable columns are in the table
    protected $fillable = [
        'address1',
        'address2',
        'city',
        'postal_code',
    ];
}
