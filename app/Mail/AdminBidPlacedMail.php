<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminBidPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $first_name;
    public $product_name;
    public $product_image;
    public $bid_amount;
    public $auction_end_time;
    public $user_email;
    public $total_amount;
    public $buyers_premium;

    public function __construct($first_name, $product_name, $product_image, $bid_amount, $auction_end_time, $user_email, $total_amount, $buyers_premium)
    {
        $this->first_name = $first_name;
        $this->product_name = $product_name;
        $this->product_image = $product_image;
        $this->bid_amount = $bid_amount;
        $this->auction_end_time = $auction_end_time;
        $this->user_email = $user_email;
        $this->total_amount = $total_amount;
        $this->buyers_premium = $buyers_premium;
    }

    public function build()
    {
        return $this->markdown('emails.bid_placed')
                    ->subject('New Bid Placed - Admin Notification');
    }
}