<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsherCollection extends Model
{
    use HasFactory;

    protected $fillable = [
        'usher_name',
        'payer_name',
        'date_time',
        'collection_type',
        'amount',
        'signature',
    ];
}
