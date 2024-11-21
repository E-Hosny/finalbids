<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidPlaced extends Model
{
    use HasFactory;

    protected $table = 'bid_placed'; // اسم الجدول في قاعدة البيانات
    // protected $fillable = [
    //     'user_id',
    //     'product_id',
    //     'auction_type_id',
    //     'project_id',
    //     'bid_amount',
    //     'total_amount',
    //     'buyers_premium',
    //     'mail_sent',
    //     'status',
    //     'outbid',
    //     'sold',
    // ];

    protected $fillable = [
        'user_id', 'product_id', 'auction_type_id', 'project_id',
        'bid_amount', 'total_amount', 'buyers_premium', 'mail_sent', 
        'status', 'outbid', 'sold'
    ];
    /**
     * العلاقة مع المستخدم.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    /**
     * العلاقة مع المنتج.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

  

    /**
     * العلاقة مع نوع المزاد.
     */
    public function auctiontype()
    {
        return $this->belongsTo(AuctionType::class, 'auction_type_id', 'id');
    }

    /**
     * العلاقة مع المشروع.
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
