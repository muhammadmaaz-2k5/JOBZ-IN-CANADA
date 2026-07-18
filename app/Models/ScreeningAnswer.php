<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScreeningAnswer extends Model
{
    protected $fillable = [
        'application_id',
        'question_id',
        'answer',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function question()
    {
        return $this->belongsTo(ScreeningQuestion::class, 'question_id');
    }
}
