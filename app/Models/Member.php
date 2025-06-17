<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mobile_number',
        'age',
        'last_attendance',
        'gender',
    ];

    // Automatically cast last_attendance as a date
    // protected $casts = [
    //     'last_attendance' => 'date',
    // ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // public function services()
    // {
    //     return $this->belongsToMany(Service::class, 'attendances', 'member_id', 'service_id')
    //                 ->withPivot('date')
    //                 ->withTimestamps();
    // }
}
