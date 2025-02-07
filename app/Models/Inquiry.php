<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'message'];

    public function reply()
    {
        return $this->hasOne(InquiryReply::class);
    }
}
