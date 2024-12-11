<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    /**
     * الحقول المسموح بتعبئتها بشكل جماعي
     */
    protected $fillable = [
        'title',
        'title_ar',
        'slug',
        'auction_type_id',
        'project_id',
        'reserved_price',
        'start_price',
        'end_price',
        'minsellingprice',
        'auction_end_date',
        'is_published',
        'description',
        'description_ar',
        'is_popular',
        'lot_no',
        'user_id',
        'status',
        'is_closed',
        'approval_status',
        'rejection_reason',
    ];

    /**
     * العلاقات
     */

    // العلاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة مع الفئة
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // العلاقة مع الفئة الفرعية
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }

    // العلاقة مع نوع المزاد
    public function auctiontype()
    {
        return $this->belongsTo(Auctiontype::class, 'auction_type_id');
    }

    // العلاقة مع المشروع
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // العلاقة مع المعرض
    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'product_id');
    }

    // العلاقة مع المواصفات
    public function specifications()
    {
        return $this->hasMany(Specification::class, 'product_id');
    }

    // العلاقة مع العروض
    public function bids()
    {
        return $this->hasMany(BidPlaced::class, 'product_id');
    }

    /**
     * الدوال المساعدة
     */

    // إذا كنت بحاجة إلى تحويل الأسعار بناءً على العملة
    public function setReservedPriceAttribute($value)
    {
        // منطق التحويل إذا لزم الأمر
        $this->attributes['reserved_price'] = $value;
    }
    // public function productGalleries()
    // {
    //     return $this->hasMany(Gallery::class, 'product_id', 'id');
    // }



    // علاقة مع BidPlaced
    public function bidPlaced()
    {
        return $this->hasMany(BidPlaced::class);
    }

    public function productGalleries()
    {
        return $this->hasMany(Gallery::class, 'product_id');
    }



}
