<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyLocation extends Model
{
    protected $fillable = [
        'company_id',
        'country',
        'state',
        'city',
        'address',
        'postal_code',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
