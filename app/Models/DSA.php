<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DSA extends Model
{
    use HasFactory;
    protected $table = 'dsa';
    protected $fillable = [
        'event',
    ];
}
