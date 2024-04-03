<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'pay_head',
        'due_date',
        'due_amount',
        'deposite_date',
        'mode',
        'receipt',
        'paid_amount',
        'amount',
        'surchange',
        'complete',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
