<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempAddress extends Model
{
    use HasFactory;
    protected $table ='temp_address';

    protected $fillable = [
        'first_name',
        'last_name',
        'apartment',
        'city',
        'country',
        'state',
        'zipcode',
        'is_save',
        'phone',
        'user_id',
        'bid_placed_id',
    ];
}
