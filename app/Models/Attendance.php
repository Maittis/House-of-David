<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'member_id',
        'date',
    ];

    /**
     * Define the relationship with Member model.
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Define the relationship with Service model (if applicable).
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}



