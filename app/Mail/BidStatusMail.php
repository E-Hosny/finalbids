<?php

namespace App\Mail;

use App\Models\BidPlaced;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BidStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bidPlaced;
    public $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(BidPlaced $bidPlaced, $status)
    {
        $this->bidPlaced = $bidPlaced;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = '';

        // تحديد عنوان الإيميل بناءً على الحالة
        if ($this->status == 'approved') {
            $subject = 'Your Bid has been Approved';
        } elseif ($this->status == 'rejected') {
            $subject = 'Your Bid has been Rejected';
        } else {
            $subject = 'Your Bid is Pending';
        }

        // بناء الإيميل
        return $this->view('emails.bid_status')
                    ->subject($subject)
                    ->with([
                        'bid' => $this->bidPlaced,
                        'status' => $this->status
                    ]);
    }
}
