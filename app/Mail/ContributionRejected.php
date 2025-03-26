<?php

namespace App\Mail;

use App\Models\Contribution;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContributionRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $contribution;

    // Pass the contribution to the mailable
    public function __construct(Contribution $contribution)
    {
        $this->contribution = $contribution;
    }

    public function build()
    {
        return $this->subject('Your Contribution Has Been Rejected')
            ->view('emails.contribution_rejected');
    }
}
