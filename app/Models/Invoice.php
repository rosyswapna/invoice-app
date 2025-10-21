<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    // Optional: specify table name if not standard
    // protected $table = 'invoices';

    // Allow mass assignment for these fields
    protected $fillable = [
        'invoice_number',
        'customer_name',
        'customer_email',
        'invoice_date',
        'due_date',
        'subtotal',
        'tax',
        'discount',
        'total',
        'status',
        'notes',
    ];

    // Optional: cast fields
    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    
}
