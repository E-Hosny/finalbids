<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Gallery extends Model
{
    use HasFactory,SoftDeletes;
    protected $table ='product_galleries';
    protected $fillable = [
        'product_id',
        'image_path',
        'lot_no',
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
