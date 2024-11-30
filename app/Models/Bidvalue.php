<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidvalue extends Model
{
    use HasFactory;
    protected $table ='bid_values';
    protected $fillable = [
        'id',
        'bidvalue',
        'increment',
        'cal_amount',
        'status',
       
    ];
}
