<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuctionWinnerUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $first_name;
    public $product_title;
    public $product_image;
    public $winning_amount;
    public $auction_end_date;
    public $payment_link;

    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        $this->first_name = $data['name'];
        $this->product_title = $data['product_title'];
        $this->product_image = $data['product_image'];
        $this->winning_amount = $data['winning_amount'];
        $this->auction_end_date = $data['auction_end_date'];
        $this->payment_link = $data['payment_link'];
        
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->markdown('emails.auction_winner_user')
                    ->subject('تهانينا! لقد فزت بالمزاد')
                    ->with([
                        'first_name' => $this->first_name,
                        'product_title' => $this->product_title,
                        'product_image' => $this->product_image,
                        'winning_amount' => $this->winning_amount,
                        'auction_end_date' => $this->auction_end_date,
                        'payment_link' => $this->payment_link
                    ]);
    }
}