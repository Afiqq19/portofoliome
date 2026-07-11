<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'title',
        'issuer',
        'date',
        'description',
        'image',
        'credential_url',
        'order',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
