<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('New User Registration')
            ->view('emails.new_user_notification')
            ->with([
                'username' => $this->user->username,
                'email' => $this->user->email,
                'faculty_id' => $this->user->faculty->faculty,
            ]);
    }
}
