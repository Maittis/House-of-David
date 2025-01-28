<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    protected $fillable = ['name'];

    public function attendances()
{
    return $this->hasMany(Attendance::class);
}

public function members()
{
    return $this->hasManyThrough(Member::class, Attendance::class, 'service_id', 'id', 'id', 'member_id');
}

}




