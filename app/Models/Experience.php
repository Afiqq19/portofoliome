<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'profile_id',
        'category',
        'title',
        'company',
        'period',
        'description',
        'tags',
        'color',
        'order',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'education' => 'Pendidikan',
            'organization' => 'Organisasi',
            default => 'Karir & Magang',
        };
    }

    public function getCategoryIconAttribute(): string
    {
        return match($this->category) {
            'education' => 'bx bxs-graduation',
            'organization' => 'bx bx-group',
            default => 'bx bx-briefcase',
        };
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Get tags as an array
     */
    public function getTagsArrayAttribute(): array
    {
        if (empty($this->tags)) {
            return [];
        }
        return array_values(array_filter(array_map('trim', explode(',', $this->tags))));
    }
}
