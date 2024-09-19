<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Useraddress extends Model
{
    use HasFactory;
    protected $table ='useraddresses';

    protected $fillable = [
        'first_name',
        'last_name',
        'apartment',
        'city',
        'country',
        'state',
        'zipcode',
        'is_save',
        'address_type',
        'is_primary'

    ];

    public function userAddress()
    {
        return $this->hasOne(Useraddress::class);

    }
}
