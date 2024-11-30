<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminProductAddedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $product; // تعريف المتغير ليتم استخدامه في الـ view

    /**
     * Create a new message instance.
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Product Added Notification')
                    ->view('emails.admin_product_added_mail') // تأكد أن اسم الـ view صحيح
                    ->with('product', $this->product); // إرسال البيانات إلى الـ view
    }
}

