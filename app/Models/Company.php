<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'company_name',
        'slug',
        'logo',
        'logo_public_id',
        'cover_image',
        'cover_image_public_id',
        'description',
        'website',
        'industry',
        'company_size',
        'founded_year',
        'headquarters',
        'email',
        'phone',
        'verification_status',
        'average_rating',
    ];

    public function locations()
    {
        return $this->hasMany(CompanyLocation::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function reviews()
    {
        return $this->hasMany(CompanyReview::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'company_followers')->withTimestamps();
    }

    public function employers()
    {
        return $this->hasMany(EmployerProfile::class);
    }
}
