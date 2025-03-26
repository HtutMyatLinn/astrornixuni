<?php

namespace App\Mail;

use App\Models\Contribution;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContributionPublishedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $contribution;

    public function __construct(Contribution $contribution)
    {
        $this->contribution = $contribution;
    }

    public function build()
    {
        return $this->subject('Your Contribution Has Been Published')
            ->view('emails.contribution_published') // Create this email template
            ->with(['contribution' => $this->contribution]);
    }
}
