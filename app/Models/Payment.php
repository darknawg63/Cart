<?php


namespace Cart\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // Tell Eloquent what the fillable columns are in the table
    protected $fillable = [
        'failed',
        'transaction_id'
    ];
}
