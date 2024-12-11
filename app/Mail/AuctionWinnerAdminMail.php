<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuctionWinnerAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $first_name;
    public $product_title;
    public $product_image;
    public $winning_amount;
    public $auction_end_date;
    public $winner_email;
    public $winner_phone;

    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        $this->first_name = $data['winner_name'];
        $this->product_title = $data['product_title'];
        $this->product_image = $data['product_image'];
        $this->winning_amount = $data['winning_amount'];
        $this->auction_end_date = $data['auction_end_date'];
        $this->winner_email = $data['winner_email'];
        $this->winner_phone = $data['winner_phone'];
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->markdown('emails.auction_winner_admin')
                    ->subject('إشعار فوز بالمزاد')
                    ->with([
                        'first_name' => $this->first_name,
                        'product_title' => $this->product_title,
                        'product_image' => $this->product_image,
                        'winning_amount' => $this->winning_amount,
                        'auction_end_date' => $this->auction_end_date,
                        'winner_email' => $this->winner_email,
                        'winner_phone' => $this->winner_phone
                    ]);
    }
}