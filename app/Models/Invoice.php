<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'payment_id',
        'invoice_number',
        'subtotal',
        'tax',
        'total',
        'invoice_url',
    ];

    protected $casts = [
        'subtotal' => 'integer',
        'tax' => 'integer',
        'total' => 'integer',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
