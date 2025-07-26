<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $requestData;

    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }

    public function build()
    {
        return $this->subject('New Request Submitted')
                    ->view('emails.new_request_notification')
                    ->with('requestData', $this->requestData);
    }
}
