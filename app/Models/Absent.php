<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absent extends Model
{
    protected $fillable = ['member_id', 'last_attendance'];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
