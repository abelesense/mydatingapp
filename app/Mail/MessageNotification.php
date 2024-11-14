<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $sender;
    public $messageText;

    public function __construct($sender, $messageText)
    {
        $this->sender = $sender;
        $this->messageText = $messageText;
    }

    public function build()
    {
        return $this->subject('Новое сообщение')
            ->view('emails.message_notification');
    }
}

