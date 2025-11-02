<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailCustomer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;


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
        $from = env('MAIL_USERNAME');
        $subject = isset($this->data['subject']) ? $this->data['subject'] : 'Not Subject';
        $resultMsj = $this->from($from)
            ->subject($subject)
            ->view('mail.sendMessageCustomer')
            ->with('data', $this->data);

        return $resultMsj;
    }
}
