<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminBidPlacedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $bidDetails;

    /**
     * Create a new message instance.
     */
    public function __construct($bidDetails)
    {
        $this->bidDetails = $bidDetails;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Bid Placed Notification')
                    ->view('emails.admin_bid_placed_notification')
                    ->with('bidDetails', $this->bidDetails);
    }
}
