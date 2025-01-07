<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $code)
    {
        $this->code = $code;
    }

    public function build()
    {
        return $this->view('emails.verification-code')
                    ->subject('Your Verification Code')
                    ->with(['code' => $this->code]);
    }
}
