<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTypes extends Model
{
    use HasFactory;

    protected $table = 'paymenttypes'; // Specify the correct table name
    protected $fillable = [
        'user_id',
        'product_id',
        'cash',
        'payment',
        'image'
    ];

    // Define relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
