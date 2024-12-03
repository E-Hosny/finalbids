<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    public $user;

    public function __construct(Product $product)
    {
        $this->product = $product;
        $this->user = $product->user;
    }

    public function build()
    {
        return $this->subject('Your Product Has Been Approved')
                    ->view('emails.product_approved');
    }
}
