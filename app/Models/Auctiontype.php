<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auctiontype extends Model
{
    use HasFactory;
    protected $table = 'auction_types';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'auction_type_id');
    }

    public function productss()
    {
        return $this->hasMany(Product::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class,'auction_type_id');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'product_id');
    }



    

   

    
    
}
