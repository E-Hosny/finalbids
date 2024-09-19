<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $subject;
    public $first_name;

 
public function __construct($subject,$first_name)
{
    $this->subject =$subject;
    $this->first_name = $first_name;
}


    public function build()
    {
        return $this->markdown('emails.welcome')
            ->subject('Welcome Mail');
    }
}
