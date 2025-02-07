<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inquiry;


class InquiryReply extends Model
{
    use HasFactory;

    protected $fillable = ['inquiry_id', 'reply'];

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }
}

