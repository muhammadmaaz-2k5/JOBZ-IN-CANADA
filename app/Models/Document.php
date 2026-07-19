<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'google_drive_file_id',
        'original_name',
        'mime_type',
        'status',
        'uploaded_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
