<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'po_number',
        'vendor',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];
}