<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Reply;
use App\Models\User;

class Inquiry extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'message',
        'user_id'
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get the user that owns the inquiry.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reply associated with the inquiry.
     */
    public function reply()
    {
        return $this->hasOne(InquiryReply::class, 'inquiry_id');
    }



}
