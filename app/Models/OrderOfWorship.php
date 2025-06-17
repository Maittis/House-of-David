<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOfWorship extends Model
{
    use HasFactory;

    protected $table = 'order_of_worship';

    protected $fillable = [
        'title',
        'type',
        'content',
        'image_path',
        'video_url',
    ];
}
