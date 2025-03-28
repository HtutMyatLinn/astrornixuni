<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $originalInquiry;
    public $responseContent;

    public function __construct($userName, $originalInquiry, $responseContent)
    {
        $this->userName = $userName;
        $this->originalInquiry = $originalInquiry;
        $this->responseContent = $responseContent;
    }

    public function build()
    {
        return $this->subject('Response to Your Inquiry')
            ->view('emails.inquiry_response')
            ->with([
                'userName' => $this->userName,
                'originalInquiry' => $this->originalInquiry,
                'responseContent' => $this->responseContent
            ]);
    }
}
