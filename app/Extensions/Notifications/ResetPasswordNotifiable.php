<?php

namespace App\Extensions\Notifications;

use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

//Overwrite method Notification  Illuminate\Auth\Notifications\ResetPassword;
class ResetPasswordNotifiable extends Notification
{
    public $token;

    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;

    /**
     * Create a notification instance.
     *
     * @param string $token
     * @return void
     */
    public function __construct($params = [])
    {
        if (isset($params['token'])) {
            $token = $params['token'];
            $this->token = $token;
        }
    }

    public function toMail($notifiable)
    {
        $link = url("/password/reset/?token=" . $this->token);

        return (new MailMessage)
            ->view('reset.emailer')
            ->from('info@example.com')
            ->subject('Reset your password')
            ->line("Hey, We've successfully changed the text ")
            ->action('Reset Password', $link)
            ->attach('reset.attachment')
            ->line('Thank you!');
    }

    public function toSendMailByConfigEnv($params)
    {
        $notifiable = $params['notifiable'];
        $token = $params['token'];
        $email = $params['email'];
        $notification = $notifiable;
        if ($notifiable && static::$toMailCallback && $token) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }
        $subject = isset($params['mail']['subject']) ? $params['mail']['subject'] : Lang::getFromJson('Reset Password Notification');
        $line = isset($params['mail']['line']) ? $params['mail']['line'] : Lang::getFromJson('You are receiving this email because we received a password reset request for your account.');
        $apiUrlBase = env('MAIL_ALLOW_PRODUCTION') ? env('MAIL_APP_URL_SERVER') : env('MAIL_APP_URL_DEVELOPERS');
        $actionUrl = (isset($params['mail']['actionUrl']) ? $params['mail']['actionUrl'] : url("/anyAction"));
        $link = url("/password/reset/" . $token . '?email=' . $email);

        $infoLine1 = Lang::getFromJson('Reset Password');
//Lang::getFromJson('Reset Password'), url(config('app.url').route('password.reset', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()], false))
        $result = (new MailMessage)
            ->subject($subject)
            ->line($line)
            ->action($infoLine1, $link)
            ->line(Lang::getFromJson('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))
            ->line(Lang::getFromJson('If you did not request a password reset, no further action is required.'));

        $message = $result;

        if (!$notifiable->routeNotificationFor('mail', $notification) &&
            !$message instanceof Mailable) {
            return;
        }

        if ($message instanceof Mailable) {
            return $message->send($this->mailer);
        }

        $this->mailer->send(
            $this->buildView($message),
            array_merge($message->data(), $this->additionalMessageData($notification)),
            $this->messageBuilder($notifiable, $notification, $message)
        );
    }

    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}
