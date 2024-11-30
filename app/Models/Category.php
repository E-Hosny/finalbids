<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'slug',
        'image_path',
        'status',
        'lang_id',
        'type',
        'name_ar',
       
    ];

    public function products()
{
    return $this->hasMany(Product::class, 'category_id');
}

public function projects()
{
    return $this->hasMany(Project::class, 'category_id');
}



}
