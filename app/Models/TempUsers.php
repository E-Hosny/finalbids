<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempUsers extends Model
{
    use HasFactory;
    protected $table ='temp_users';


    protected $fillable = [
        'first_name',
        'last_name',
        'role',
        'email',
        'country_code',
        'phone',
        'profile_image',
        'otp',
        'refer_code',
        'status',
        'password',
        'is_term',
        'lang_id',
        'currency_code',
        'is_otp_verify',
        'notify_on',
    ];

}
