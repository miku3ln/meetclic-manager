<?php

namespace App\Components;

require_once 'Twilio/autoload.php';

use Twilio\Rest\Client;

class Twilio
{

    public $accountSid = 'AC7634f8468b7f5f6097f55b7ebd92814a';//AC6ad659b1001eaced3e3ebb98f2dabc91
    public $authToken = '579795166440aa9cca68053f4d17cada';//7999cc43bef3823662d5d4e7dd3525e3

    public $numberConfig = '+14155238886';
    public $numberConfigWhatsApp = '+14155238886';

    public function __construct($apikey = null)
    {

    }

    public function createSms()
    {

        $sid = $this->accountSid;
        $token = $this->authToken;
        $client = new Client($sid, $token);
        $msj = '';
        $fromNumber = $this->numberConfig;
        $toNumber = '+593969143060';
        $success = false;
        $result = [];
        try {
            // Use the client to do fun stuff like send text messages!
            $client->messages->create(
            // the number you'd like to send the message to
                $toNumber,
                array(
                    // A Twilio phone number you purchased at twilio.com/console
                    'from' => $fromNumber,
                    // the body of the text message you'd like to send
                    'body' => 'Soy perro desde php'
                )
            );


        } catch (\Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,

            );
            return ($result);
        }

    }

    public function createSmsWhatsApp($params = [])
    {
        $toNumber = isset($params['to']) ? $params['to'] : '+593994838506';
        $sid = $this->accountSid;
        $token = $this->authToken;
        $client = new Client($sid, $token);
        $msj = '';
        $success = false;
        $result = [];
        $bodyCurrent = isset($params['body']) ? $params['body'] : "Un cordial saludo desde el departamento de sistemas Meetclic https://meetclic.com/";
        try {

            // Use the client to do fun stuff like send text messages!
            $data = $client->messages->create("whatsapp:" . $toNumber, // to
                [
                    "from" => "whatsapp:" . $this->numberConfigWhatsApp,
                    "body" => $bodyCurrent
                ]
            );
            $success = true;
            $result = array(
                "success" => $success,
                "msj" => $msj,
                'data' => $data,
                'id' => $data->sid
            );

        } catch (\Exception $e) {
            $success = false;
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,

            );

        }

        return $result;

    }

}
