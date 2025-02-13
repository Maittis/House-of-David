<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inquiry;

class InquiryReply extends Model
{
    use HasFactory;

    protected $fillable = ['inquiry_id', 'reply'];

    // Remove this method as it's incorrect for this model context.
    // public function reply()
    // {
    //     return $this->hasOne(Reply::class, 'inquiry_id');
    // }

    public function inquiry()
{
    return $this->belongsTo(Inquiry::class, 'inquiry_id');
}
}
