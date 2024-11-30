<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class notwinnerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $first_name;
    public $product_name;
    public $product_image;
    public $bid_amount;
    public $auction_end_time;

 
    public function __construct($first_name,$product_name,$product_image,$bid_amount,$auction_end_time)
    {
        $this->first_name = $first_name;
        $this->product_name = $product_name;
        $this->product_image = $product_image;
        $this->bid_amount = $bid_amount;
        $this->auction_end_time = $auction_end_time;

    }
    
    
        public function build()
        {
            return $this->markdown('emails.notwinner')
                ->subject('You did not win this time');
        }
}
