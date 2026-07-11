<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'long_description',
        'thumbnail',
        'screenshots',
        'tech_stack',
        'demo_url',
        'github_url',
        'zip_path',
        'apk_path',
        'download_count',
        'credentials',
        'is_featured',
        'status',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'screenshots' => 'array',
            'tech_stack' => 'array',
            'credentials' => 'array',
            'is_featured' => 'boolean',
        ];
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    protected static function booted(): void
    {
        static::creating(function (Project $project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }
}
