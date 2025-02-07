<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = [
        'body',
        'user_id', // Assuming comments are linked to users
        'video_id', // Assuming comments are linked to videos
        // Add other fields here
    ];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
