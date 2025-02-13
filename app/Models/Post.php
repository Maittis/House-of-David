<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // If your table name is not 'posts', specify it here
    // protected $table = 'your_table_name';

    // Fillable attributes for mass assignment protection
    protected $fillable = ['title', 'content', 'image_path'];



    // Optional: If you want to automatically manage timestamps
    public $timestamps = true;

    // Optional: Define relationships if needed
    // public function user() {
    //     return $this->belongsTo(User::class);
    // }
}
