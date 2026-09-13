<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'title',
        'bio',
        'avatar',
        'resume_path',
        'email',
        'phone',
        'location',
        'trakteer_url',
        'enable_skills',
        'enable_projects',
        'enable_certificates',
        'enable_estimator',
        'enable_architecture',
        'enable_landing_page',
        'maintenance_status',
        'maintenance_title',
        'maintenance_message',
        'google_analytics_id',
    ];

    protected $casts = [
        'enable_skills' => 'boolean',
        'enable_projects' => 'boolean',
        'enable_certificates' => 'boolean',
        'enable_estimator' => 'boolean',
        'enable_architecture' => 'boolean',
        'enable_landing_page' => 'boolean',
    ];

    public function socialLinks(): HasMany
    {
        return $this->hasMany(SocialLink::class)->orderBy('order');
    }
}
