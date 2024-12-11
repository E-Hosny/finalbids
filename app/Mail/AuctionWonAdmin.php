<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuctionWonAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $winningBid;
    public $product;

    public function __construct($winningBid, $product)
    {
        $this->winningBid = $winningBid;
        $this->product = $product;
    }

    public function build()
    {
        return $this->markdown('emails.auction-won-admin')
                    ->subject('تم إغلاق مزاد وتحديد الفائز')
                    ->with([
                        'winningBid' => $this->winningBid,
                        'product' => $this->product,
                        'winner' => $this->winningBid->user
                    ]);
    }
}

class AuctionWonUser extends Mailable
{
    use Queueable, SerializesModels;

    public $winningBid;
    public $product;
    public $paymentLink;

    public function __construct($winningBid, $product, $paymentLink)
    {
        $this->winningBid = $winningBid;
        $this->product = $product;
        $this->paymentLink = $paymentLink;
    }

    public function build()
    {
        return $this->markdown('emails.auction-won-user')
                    ->subject('تهانينا! لقد فزت بالمزاد')
                    ->with([
                        'winningBid' => $this->winningBid,
                        'product' => $this->product,
                        'paymentLink' => $this->paymentLink
                    ]);
    }
}