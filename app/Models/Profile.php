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
    ];

    protected $casts = [
        'enable_skills' => 'boolean',
        'enable_projects' => 'boolean',
        'enable_certificates' => 'boolean',
    ];

    public function socialLinks(): HasMany
    {
        return $this->hasMany(SocialLink::class)->orderBy('order');
    }
}
