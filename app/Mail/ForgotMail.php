<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp,$first_name;

 
public function __construct($otp,$first_name)
{
    $this->otp =$otp;
    $this->first_name = $first_name;

}


    public function build()
    {
        return $this->markdown('emails.forgot')
            ->subject('Forgot Password OTP');
    }
}
