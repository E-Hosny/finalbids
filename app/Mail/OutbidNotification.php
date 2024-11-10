<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OutbidNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $first_name;
    public $product_name;
    public $product_image;
    public $bid_amount;
    public $auction_end_time;
    public $product_slug;

    /**
     * Create a new message instance.
     */
    // $first_name,$product_name,$product_image,$bid_amount,$auction_end_time)
    public function __construct($first_name,$product_name,$product_image,$bid_amount,$auction_end_time,$product_slug)
    {
        $this->first_name = $first_name;
        $this->product_name = $product_name;
        $this->product_image = $product_image;
        $this->bid_amount = $bid_amount;
        $this->auction_end_time = $auction_end_time;
        $this->product_slug =$product_slug;
    }

    /**
     * Get the message envelope.
     */
   
    public function build()
    {
        return $this->markdown('emails.outbidmail')
            ->subject('You were just outbid ');
    }

 
}
