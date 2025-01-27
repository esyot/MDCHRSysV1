<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Request;

class VerificationEmail extends Mailable
{
    public function build()
    {
        $code = Auth::user()->code;
        
        return $this->subject('Verification Code')->view('emails.verification-code', [
            'code' => $code
        ]);
    }

}
