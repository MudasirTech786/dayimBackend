<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'sheet_no'
    ];

    protected $primaryKey = 'id'; // Set primary key explicitly

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
