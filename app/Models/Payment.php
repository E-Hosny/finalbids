<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'bid_id',
        'amount',
        'currency',
        'payment_id',
        'invoice_id',
        'status',
        'payment_data',
        'paid_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'payment_data' => 'array'
    ];

    // العلاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة مع المزايدة
    public function bid()
    {
        return $this->belongsTo(BidPlaced::class, 'bid_id');
    }

    // العلاقة مع سجلات الدفع
    public function logs()
    {
        return $this->hasMany(PaymentLog::class);
    }
}