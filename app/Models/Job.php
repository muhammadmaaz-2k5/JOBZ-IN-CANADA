<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'company_id',
        'employer_id',
        'category_id',
        'title',
        'slug',
        'description',
        'responsibilities',
        'requirements',
        'benefits',
        'employment_type',
        'language',
        'workplace_type',
        'experience_level',
        'education_level',
        'salary_type',
        'salary_min',
        'salary_max',
        'currency',
        'vacancies',
        'location',
        'country',
        'city',
        'latitude',
        'longitude',
        'application_deadline',
        'status',
        'featured',
        'urgent',
        'auto_close_on_deadline',
        'allow_cover_letter',
        'resume_required',
        'portfolio_required',
        'views_count',
        'applications_count',
        'published_at',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'urgent' => 'boolean',
        'auto_close_on_deadline' => 'boolean',
        'allow_cover_letter' => 'boolean',
        'resume_required' => 'boolean',
        'portfolio_required' => 'boolean',
        'application_deadline' => 'datetime',
        'published_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skills')->withTimestamps();
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_jobs')->withTimestamps();
    }

    public function reports()
    {
        return $this->hasMany(JobReport::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['keyword'] ?? null, function ($query, $keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                  ->orWhere('description', 'like', '%' . $keyword . '%')
                  ->orWhereHas('company', function ($c) use ($keyword) {
                      $c->where('company_name', 'like', '%' . $keyword . '%');
                  })
                  ->orWhereHas('skills', function ($s) use ($keyword) {
                      $s->where('name', 'like', '%' . $keyword . '%');
                  })
                  ->orWhereHas('category', function ($cat) use ($keyword) {
                      $cat->where('name', 'like', '%' . $keyword . '%');
                  });
            });
        });

        $query->when($filters['category'] ?? null, function ($query, $categoryId) {
            $categoryIds = Category::where('id', $categoryId)
                ->orWhere('parent_id', $categoryId)
                ->pluck('id');
            $query->whereIn('category_id', $categoryIds);
        });

        $query->when($filters['location'] ?? null, function ($query, $location) use ($filters) {
            $distance = $filters['distance'] ?? null;
            if ($distance && is_numeric($distance) && $distance > 0) {
                // Approximate center point based on existing jobs in this location
                $centerJob = \App\Models\Job::whereNotNull('latitude')
                    ->whereNotNull('longitude')
                    ->where(function($q) use ($location) {
                        $q->where('city', 'like', '%' . $location . '%')
                          ->orWhere('country', 'like', '%' . $location . '%');
                    })->first();

                if ($centerJob) {
                    $lat = $centerJob->latitude;
                    $lng = $centerJob->longitude;

                    // Haversine formula
                    $query->whereRaw(
                        "(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) <= ?",
                        [$lat, $lng, $lat, $distance]
                    );
                } else {
                    // Fallback to text match
                    $query->where(function ($q) use ($location) {
                        $q->where('city', 'like', '%' . $location . '%')
                          ->orWhere('country', 'like', '%' . $location . '%');
                    });
                }
            } else {
                $query->where(function ($q) use ($location) {
                    $q->where('city', 'like', '%' . $location . '%')
                      ->orWhere('country', 'like', '%' . $location . '%');
                });
            }
        });

        $query->when($filters['language'] ?? null, function ($query, $language) {
            if (is_array($language)) {
                $query->whereIn('language', $language);
            } else {
                $query->where('language', $language);
            }
        });

        $query->when($filters['workplace_type'] ?? null, function ($query, $workplace) {
            if (is_array($workplace)) {
                $query->whereIn('workplace_type', $workplace);
            } else {
                $query->where('workplace_type', $workplace);
            }
        });

        $query->when($filters['employment_type'] ?? null, function ($query, $employment) {
            if (is_array($employment)) {
                $query->whereIn('employment_type', $employment);
            } else {
                $query->where('employment_type', $employment);
            }
        });

        $query->when($filters['experience_level'] ?? null, function ($query, $experience) {
            if (is_array($experience)) {
                $query->whereIn('experience_level', $experience);
            } else {
                $query->where('experience_level', $experience);
            }
        });

        $query->when($filters['education_level'] ?? null, function ($query, $education) {
            if (is_array($education)) {
                $query->whereIn('education_level', $education);
            } else {
                $query->where('education_level', $education);
            }
        });

        $query->when($filters['salary_min'] ?? null, function ($query, $min) {
            $query->where('salary_max', '>=', $min);
        });

        $query->when($filters['salary_max'] ?? null, function ($query, $max) {
            $query->where('salary_min', '<=', $max);
        });

        $query->when($filters['posted_date'] ?? null, function ($query, $postedDate) {
            $date = match($postedDate) {
                '24h' => now()->subDay(),
                '3d' => now()->subDays(3),
                '7d' => now()->subDays(7),
                '14d' => now()->subDays(14),
                default => null
            };
            if ($date) {
                $query->where('created_at', '>=', $date);
            }
        });

        $query->when($filters['featured'] ?? null, function ($query) {
            $query->where('featured', true);
        });

        $query->when($filters['urgent'] ?? null, function ($query) {
            $query->where('urgent', true);
        });

        $query->when($filters['verified_companies'] ?? null, function ($query) {
            $query->whereHas('company', function ($c) {
                $c->where('verification_status', 'verified');
            });
        });

        $query->when($filters['easy_apply'] ?? null, function ($query) {
            $query->whereDoesntHave('screeningQuestions');
        });

        $query->when($filters['salary_visible'] ?? null, function ($query) {
            $query->whereNotNull('salary_min')->whereNotNull('salary_max');
        });

        return $query;
    }

    public function screeningQuestions()
    {
        return $this->hasMany(ScreeningQuestion::class);
    }

    public function activePromotion()
    {
        return $this->hasOne(FeaturedJob::class)
            ->where('expires_at', '>=', now())
            ->latestOfMany();
    }
}
