<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $first_name;

 
public function __construct($otp, $first_name)
{
    $this->otp = $otp;
    $this->first_name = $first_name;
}


    public function build()
    {
        return $this->markdown('emails.resetpassword')
            ->subject('Otp Verification ');
    }
}


