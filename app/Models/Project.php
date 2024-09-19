<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Project extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'name_ar',
        'slug',
        'image_path',
        'status',
        'is_trending',
        'auction_type_id',
        'start_date_time',
        'buyers_premium',
        'category_id',
        'deposit_amount',
        'lang_id',
        'type',
        'end_date_time',
    ];
    

    // public function setPriceAttribute($value)
    // {
    //     if (session()->get('currency') == 'usd' || session()->get('currency') == 'USD') {
    //         $url  = "https://www.google.com/search?q=USDtoKES";
    //         $get = file_get_contents($url);
    //         $data = preg_split('/\D\s(.*?)\s=\s/',$get);
    //         $exhangeRate = (float) substr($data[1],0,7);
    //         $convertedAmount = $value * $exhangeRate;
    //         $this->attributes['deposit_amount'] = number_format($convertedAmount, 2, '.', '');
    //     } else {
    //         $this->attributes['deposit_amount'] = $value;
    //     }
    // }
    
    public function auctiontype()
{
    return $this->belongsTo(Auctiontype::class, 'auction_type_id');
}


public function category()
{
    return $this->belongsTo(Category::class, 'category_id');
}

public function products()
{
    return $this->hasMany(Product::class);
} 

    
    
}
