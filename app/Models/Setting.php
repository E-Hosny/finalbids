<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_ar',
        'slug',
        'is_static',
        'image',
        'image_ar',
        'value',
        'value_ar',
    ];
}