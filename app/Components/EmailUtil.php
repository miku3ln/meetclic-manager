<?php

namespace App\Components;

use App\Components\Mandrill;
use App\Mail\SendMailSchedule;
use Illuminate\Support\Facades\Mail;
use App\Models\TemplateConfigMailingByEmails;
use App\Mail\SendMailContactUs;
use App\Mail\SendMailCheckout;
use App\Mail\SendMailCheckoutVerify;
use App\Mail\SendMailCheckoutSupervisor;
use App\Mail\SendMailDelivered;

class EmailUtil
{
    const API_KEY_MANDRILL = 'tbx1ctXmJPD7cT0ulGg96Q';
    const FROM_NAME = 'Meetcli';
    const FROM_EMAIL = "info@meetclic.com";
    const TO_EMAIL = "kalexmiguelalba@gmail.com";

    public function sendMailMandrill($params)
    {

        $plantilla = isset($params['plantilla']) ? $params['plantilla'] : '';
        $template_content_mail = isset($params['template_content_mail']) ? $params['template_content_mail'] : null;
        $att = isset($params['att']) ? $params['att'] : null;
        $imgatt = isset($params['imgatt']) ? $params['imgatt'] : null;
        $contenido = isset($params['message']) ? $params['message'] : '<h1>Soy Un mensaje no configurado</h1>';
        $subject = isset($params['subject']) ? $params['subject'] : 'Sin Asunto';
        $from_name = isset($params['from_name']) ? $params['from_name'] : self::FROM_NAME;
        $to_email = isset($params['email']) ? $params['email'] : self::TO_EMAIL;
        $result = array();
        $template_name = '';
        $template_content = '';
        try {

            $mandrill = new Mandrill(self::API_KEY_MANDRILL);
            $mandrillTemplate = false;
            if (!$plantilla == '') {
                $mandrillTemplate = true;
                $template_name = $plantilla;
                /* Remplaso contenido de template con links a vistas */
                $template_content = isset($template_content_mail) ? $template_content_mail : array();
            }
            $message = array(
                'html' => $contenido, //'<p>Example HTML content</p>',
// 'text' => 'Example text content',
                'subject' => $subject, //'example subject',
                'from_email' => self::FROM_EMAIL,
                'from_name' => $from_name, /* TODO:FIJAR NOMBRE DE ENVIO */
                'to' => array(
                    array(
                        'email' => $to_email, //'decheverria@tradesystem.com.ec',
                        'name' => 'Recipient Name',
                        'type' => 'to'
                    )
                ),
                'headers' => array('Reply-To' => 'message.reply@example.com'),
                'important' => false,
                'track_opens' => null,
                'track_clicks' => null,
                'auto_text' => null,
                'auto_html' => null,
                'inline_css' => null,
                'url_strip_qs' => null,
                'preserve_recipients' => null,
                'view_content_link' => null,
                //'bcc_address' => 'message.bcc_address@example.com',
                'tracking_domain' => null,
                'signing_domain' => null,
                'return_path_domain' => null,
                'merge' => true,
                'global_merge_vars' => array(
                    array(
                        'name' => 'merge1',
                        'content' => 'merge1 content'
                    )
                ),
                'merge_vars' => array(
                    array(
                        'rcpt' => 'recipient.email@example.com',
                        'vars' => array(
                            array(
                                'name' => 'merge2',
                                'content' => 'merge2 content'
                            )
                        )
                    )
                ),
            );

            $result = ($mandrillTemplate) ? $mandrill->messages->sendTemplate($template_name, $template_content, $message) : $mandrill->messages->send($message);
            return $result;
// Crear registro de actividad
        } catch (Mandrill_Error $e) {
// Mandrill errors are thrown as exceptions
            $result = 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
// A mandrill error occurred: Mandrill_Invalid_Key - Invalid API key
            throw $e;
            return $result;
        }
    }

    public function sendMailByPages($params)
    {

        $data = $params;
        $toUsers = array(
            'kalexmiguelalba@gmail.com',
            'developers.dev26@gmail.com',
        );
        $dataMessage = $data['dataMessage'];
        $typePage = $data['typePage'];
        $business_id = $data['business_id'];
        $typeTemplate = $data['typeTemplate'];

        $modelEmail = new TemplateConfigMailingByEmails();
        $emailsSend = $modelEmail->getListEmailsByBusiness([
            'filters' => [
                'business_id' => $business_id,
                'type' => $typePage,

            ]
        ]);
        $dataManager=[];
        $dataManager['emails-by-default']=false;
        if (count($emailsSend) > 0) {
            $dataEmails = $emailsSend;
        } else {
            $dataManager['emails-by-default']=true;
            $dataEmails = $toUsers;
        }

        $success = true;
        $msj = 'Mensaje Enviado Correctamente.';


        if ($typeTemplate == 'contactUsForm') {
            foreach ($dataEmails as $key => $mailSend) {

                Mail::to($mailSend)->send(new SendMailContactUs($dataMessage));
            }
        } else if ($typeTemplate == 'checkoutForm') {
            foreach ($dataEmails as $key => $mailSend) {

                Mail::to($mailSend)->send(new SendMailCheckout($dataMessage));
            }
        }
        if (count(Mail::failures()) > 0) {
            $success = false;
            $msj = 'Mensaje no enviado.';

        }
        $result = array(
            'success' => $success,
            'msj' => $msj,
            'dataManager'=>$dataManager,
            "mails-send"=>$dataEmails
        );
        return $result;
    }
    public function sendMailBySchedule($params)
    {

        $data = $params;

       $toEmail=env('mailScheduleOne');
       if(!$toEmail){
        $toEmail='kalexmiguelalba@gmail.com';
       }
        $toUsers = array(
            $toEmail
        );
        $dataMessage = $data['dataMessage'];

        $dataManager=[];
        $dataManager['emails-by-default']=true;
        $dataEmails = $toUsers;
        $success = true;
        $msj = 'Mensaje Enviado Correctamente.';
        foreach ($dataEmails as $key => $mailSend) {
            Mail::to($mailSend)->send(new \App\Mail\SendMailSchedule($dataMessage));

        }
        if (count(Mail::failures()) > 0) {
            $success = false;
            $msj = 'Mensaje no enviado.';

        }
        $result = array(
            'success' => $success,
            'msj' => $msj,
            'dataManager'=>$dataManager
        );
        return $result;
    }
    public function sendMailCustomerShop($params)
    {

        $data = $params;
        $mailSend = $data['mailSend'];
        $dataMessage = $data['dataMessage'];
        $typeTemplate = $data['typeTemplate'];
        $success=true;
        $msj='Mensaje Enviado';
        if ($typeTemplate == 'checkout') {
            Mail::to($mailSend)->send(new SendMailCheckout($dataMessage));
        } else if ($typeTemplate == 'checkoutVerified') {

            Mail::to($mailSend)->send(new SendMailCheckoutVerify($dataMessage));
        } else if ($typeTemplate == 'delivered') {

            Mail::to($mailSend)->send(new SendMailDelivered($dataMessage));
        }

        if (count(Mail::failures()) > 0) {
            $success = false;
            $msj = 'Mensaje no enviado.';

        }
        $result = array(
            'success' => $success,
            'msj' => $msj
        );
        return $result;
    }
}
