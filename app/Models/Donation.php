<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model {
    use HasFactory;
    
    protected $fillable = ['receipt_number','member_id', 'amount', 'payment_method', 'transaction_id', 'status', 'type'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }


    
}
