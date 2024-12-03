<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    public $user;
    public $rejectionReason;

    public function __construct(Product $product)
    {
        $this->product = $product;
        $this->user = $product->user;
        $this->rejectionReason = $product->rejection_reason;
    }

    public function build()
    {
        return $this->subject('Your Product Has Been Rejected')
                    ->view('emails.product_rejected');
    }
}
