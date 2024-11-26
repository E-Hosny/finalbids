<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BidPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $first_name;
    public $product_name;
    public $product_image;
    public $bid_amount;
    public $auction_end_time;

    public function __construct($first_name, $product_name, $product_image, $bid_amount, $auction_end_time)
    {
        $this->first_name = $first_name;
        $this->product_name = $product_name;
        $this->product_image = $product_image;
        $this->bid_amount = $bid_amount;
        $this->auction_end_time = $auction_end_time;
    }

    public function build()
    {
        return $this->view('emails.bid_placed')
                    ->subject('Your Bid Has Been Placed')
                    ->with([
                        'first_name' => $this->first_name,
                        'product_name' => $this->product_name,
                        'product_image' => $this->product_image,
                        'bid_amount' => $this->bid_amount,
                        'auction_end_time' => $this->auction_end_time,
                    ]);
    }
}
