<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidPlaced extends Model
{
    use HasFactory;

    // حالات المزايدة
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;

    // حالات الدفع
    const PAYMENT_STATUS = [
        'UNPAID' => 'unpaid',
        'PENDING' => 'pending',
        'PAID' => 'paid',
        'FAILED' => 'failed'
    ];

    protected $table = 'bid_placed';

    protected $fillable = [
        'user_id', 
        'product_id', 
        'auction_type_id', 
        'project_id',
        'bid_amount', 
        'total_amount', 
        'buyers_premium', 
        'mail_sent', 
        'status', 
        'outbid', 
        'sold',
        // حقول الدفع الجديدة
        'myfatoorah_payment_id',
        'myfatoorah_invoice_id',
        'payment_status',
        'payment_data',
        'paid_at',
    ];

    protected $casts = [
        'payment_data' => 'array',
        'paid_at' => 'datetime',
        'bid_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'buyers_premium' => 'decimal:2'
    ];

    // العلاقات الحالية
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function auctiontype()
    {
        return $this->belongsTo(AuctionType::class, 'auction_type_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    // Scopes للدفع
    public function scopeUnpaid($query)
    {
        return $query->where('payment_status', self::PAYMENT_STATUS['UNPAID']);
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', self::PAYMENT_STATUS['PENDING']);
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', self::PAYMENT_STATUS['PAID']);
    }

    public function scopeFailed($query)
    {
        return $query->where('payment_status', self::PAYMENT_STATUS['FAILED']);
    }

    // Helper Methods للدفع
    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    public function isPending()
    {
        return $this->payment_status === self::PAYMENT_STATUS['PENDING'];
    }

    public function markAsPaid()
    {
        $this->update([
            'payment_status' => self::PAYMENT_STATUS['PAID'],
            'paid_at' => now(),
            'sold' => 2 // تحديث حالة البيع عند اكتمال الدفع
        ]);
    }

    public function markAsFailed()
    {
        $this->update([
            'payment_status' => self::PAYMENT_STATUS['FAILED']
        ]);
    }

    public function updatePaymentData($paymentId, $invoiceId, $additionalData = [])
    {
        $this->update([
            'myfatoorah_payment_id' => $paymentId,
            'myfatoorah_invoice_id' => $invoiceId,
            'payment_data' => array_merge($this->payment_data ?? [], $additionalData),
            'payment_status' => self::PAYMENT_STATUS['PENDING']
        ]);
    }

    // Helper Methods للمزايدات
    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function isPendingApproval()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function canBePaid()
    {
        return $this->isApproved() && 
               !$this->isPaid() && 
               $this->payment_status !== self::PAYMENT_STATUS['PENDING'];
    }

    public function getFormattedBidAmount()
    {
        return number_format($this->bid_amount, 2);
    }

    public function getFormattedTotalAmount()
    {
        return number_format($this->total_amount, 2);
    }
}