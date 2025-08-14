<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'file_name',
        'invoice_number',
        'vendor',
        'total_amount',
        'po_number',
        'status'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];
}