<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContributionFeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contribution;
    public $feedback;

    /**
     * Create a new message instance.
     */
    public function __construct($contribution, $feedback)
    {
        $this->contribution = $contribution;
        $this->feedback = $feedback;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Feedback on Your Contribution')
            ->view('emails.contribution_feedback');
    }
}
