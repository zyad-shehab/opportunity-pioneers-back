<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class VerificationCodeMail extends Mailable
{

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
