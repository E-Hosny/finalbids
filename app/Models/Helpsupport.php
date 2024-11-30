<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Helpsupport extends Model
{
    use HasFactory;
    protected $table ='help_support';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'mobile',
        'email',
    ];

}
