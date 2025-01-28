<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsReply extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'reply_message'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
