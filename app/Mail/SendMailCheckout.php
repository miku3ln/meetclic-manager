<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailCheckout extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;

    const SUBJECT = 'Comprobante de Orden ';
    const VIEW_TEMPLATE_SEND_MESSAGE = 'mail.sendMessageCheckout';

    public function __construct($data)
    {
        //
        $this->data = $data;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $from=env('MAIL_USERNAME');

        $resultMsj = $this->from($from)
            ->subject(self::SUBJECT)
            ->view(self::VIEW_TEMPLATE_SEND_MESSAGE)
            ->with('data', $this->data);

        return $resultMsj;
    }
}
