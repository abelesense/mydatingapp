<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MatchNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $matchedUser;

    public function __construct(User $matchedUser)
    {
        $this->matchedUser = $matchedUser;
    }

    public function build()
    {
        return $this->subject('You have a new match!')
            ->view('emails.match_notification');
    }
}
