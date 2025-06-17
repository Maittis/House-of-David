<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsReply extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'reply_message', 'provider'];

    public function member()
    {
        return $this->belongsTo(Member::class)->withDefault();
    }

    public static function providers()
    {
        return [
            'twilio' => 'Twilio',
            'textme' => 'TextMe',
            'pingme' => 'PingMe'
        ];
    }
}
