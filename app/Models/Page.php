<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'title_ar',
        'slug',
        'content',
        'content_ar',
        'image',
        'is_static',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
     // notice that here the attribute name is in snake_case
     protected $appends = ['without_html_content'];

     
    public function getWithoutHtmlContentAttribute()
    {
        return strip_tags($this->content);
    }
}