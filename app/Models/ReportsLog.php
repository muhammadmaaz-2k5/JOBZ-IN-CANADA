<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportsLog extends Model
{
    protected $table = 'reports_log';

    protected $fillable = [
        'user_id',
        'report_id',
        'action',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function report()
    {
        return $this->belongsTo(JobReport::class, 'report_id');
    }
}
