<?php

namespace App\Mail\Gamification;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskRewardMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $userName,
        public string $taskName,
        public string $taskDescription,
        public ?string $taskImage,
        public int $points,
        public string $logoUrl,
        public string $walletUrl
    ) {}

    public function build()
    {
        return $this
            ->subject('🎉 ¡Ganaste Yapitas!')
            ->view('emails.gamification.task-reward');
    }
}
