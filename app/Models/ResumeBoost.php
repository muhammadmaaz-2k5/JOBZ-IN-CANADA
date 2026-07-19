<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumeBoost extends Model
{
    protected $fillable = [
        'user_id',
        'starts_at',
        'expires_at',
        'payment_id',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function isValid()
    {
        return $this->expires_at && $this->expires_at->isFuture();
    }
}
