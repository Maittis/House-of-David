<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_datetime',
        'end_datetime',
        'location',
        'image_path',
        'slug'
    ];

    protected $dates = [
        'start_datetime',
        'end_datetime',
    ];

    public function scopeUpcoming($query, $limit = 3)
    {
        return $query->where('start_datetime', '>=', now())
                    ->orderBy('start_datetime', 'asc')
                    ->limit($limit);
    }
}
