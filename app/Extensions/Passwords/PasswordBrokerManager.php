<?php

namespace App\Extensions\Passwords;

/*use Illuminate\Auth\Passwords\PasswordBroker as BasePasswordBroker;*/

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Extensions\Notifications\ResetPasswordNotifiable;

class PasswordBrokerManager
{
    const SEND_MAIL_TYPE_DEFAULT = 0;
    const SEND_MAIL_TYPE_CUSTOMER_DEVELOPER = 1;
    use SendsPasswordResetEmails;

    public function sendResetLinkManager(Request $request)
    {
        $broken = $this->broker();
        $response = $broken->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    public function managerResetPassword($params)
    {
        $result = [];
        $credentials = $params['credentials'];
        $request = $params['request'];

        $typeSend = isset($params['typeSend']) ? $params['typeSend'] : self::SEND_MAIL_TYPE_DEFAULT;
        if ($typeSend == self::SEND_MAIL_TYPE_DEFAULT) {

            $result = $this->sendResetLinkManager($request);

        } /*elseif ($typeSend == self::SEND_MAIL_TYPE_CUSTOMER_DEVELOPER) {

            $broken = $this->broker();
            $user = $broken->getUser($credentials);
            $token = $broken->createToken($user);
            $notifiable = new ResetPasswordNotifiable();
            $resultSend = $notifiable->toSendMailByConfigEnv([
                'notifiable' => $notifiable,
                'token' => $token,
                'email' =>$credentials['email']

            ]);
            var_dump('hola',$resultSend);
            die();

        }*/


        return $result;
    }

/*    public function sendPasswordResetNotification($token)
    {
        $this->notify(new App\Notifications\MailResetPasswordNotification($token));
    }*/


}
