<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $table ='products';

    // protected $fillable = [
    //     'title',
    //     'slug',
    //     'auction_type_id',
    //     'auction_end_date',
    //     'project_id',
    //     'reserved_price',
    //     'description',
    //     'is_popular', 
    //     'slug', 
    //     'lot_no',
    //     'start_price',
    //     'end_price',
    //     'lang_id',
    //     'minsellingprice',
    //     'title_ar',
    //     'description_ar',
    //     'user_id',
    //     'status',
    //     'is_published',
    // ];
    protected $fillable = [
        'title', 'title_ar', 'slug', 'auction_type_id', 'project_id',
        'reserved_price', 'start_price', 'end_price', 'minsellingprice',
        'auction_end_date', 'is_published', 'description', 'description_ar',
        'is_popular','lot_no','user_id', 'status', 'is_closed'
    ];
   
    public function setPriceAttribute($value)
    {
        if (session()->get('currency') == 'usd' || session()->get('currency') == 'USD') {
            $url  = "https://www.google.com/search?q=USDtoKES";
            $get = file_get_contents($url);
            $data = preg_split('/\D\s(.*?)\s=\s/',$get);
            $exhangeRate = (float) substr($data[1],0,7);
            $convertedAmount = $value * $exhangeRate;
            $this->attributes['reserved_price'] = number_format($convertedAmount, 2, '.', '');
        } else {
            $this->attributes['reserved_price'] = $value;
        }
    }
     

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class,'subcategory_id');
    }

    public function auctiontype()
    {
        return $this->belongsTo(Auctiontype::class,'auction_type_id');
    }
    public function project()
{
    return $this->belongsTo(Project::class);
}


    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'product_id');
    }
   
    public function specifications()
    {
        return $this->hasMany(Specification::class, 'product_id');
    }

    public function productGalleries() {
        return $this->hasMany(Gallery::class, 'product_id', 'id');
    }

    public function bidPlace()
    {
        return $this->hasMany(BidPlaced::class, 'product_id');
    }

    public function images()
    {
        return $this->hasMany(Gallery::class, 'product_id');
    }
    
    public function bids()
    {
        return $this->hasMany(BidPlaced::class, 'product_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
