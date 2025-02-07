<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = 'videos'; // If your table name is plural, otherwise adjust accordingly

    protected $fillable = [
        'title',
        'description',
        'url', // or whatever field you use to store video path or link
        // Add other fields here
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'video_id');
    }
}
