<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidPlaced extends Model
{
    use HasFactory;
    protected $table ='bid_placed';
    protected $fillable = [
        'user_id',
        'project_id',
        'product_id',
        'bid_amount',
        'total_amount',
        'status',
        'outbid',
        'buyers_premium',
        'mail_sent',	
       
    ];
    public function tempAddress()
    {
        return $this->hasOne(TempAddress::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function auctiontype()
    {
        return $this->belongsTo(Auctiontype::class,'auction_type_id');
    }
    
    public function user()
{
    return $this->belongsTo(User::class);
}




   

}
