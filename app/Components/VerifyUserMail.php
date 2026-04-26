<?php

namespace App\Components;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyUserMail extends Mailable
{
    use SerializesModels;

    public $user;
    public $url;

    const SUBJECT = 'Activa tu cuenta';

    public function __construct($user, $url)
    {
        $this->user = $user;
        $this->url = $url;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject(self::SUBJECT)
            ->view('mail.verify-user')
            ->with([
                'user' => $this->user,
                'url' => $this->url
            ]);
    }
}
