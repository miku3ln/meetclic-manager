<?php

namespace App\Mail\RewardByBusiness;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PrizeWinnerMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string  $winnerName,
        public string  $winnerEmail,
        public string  $prizeName,
        public string  $prizeDescription,
        public ?string $prizeImage,
        public string  $prizeCode,
        public string  $businessName,
        public string  $businessAddress,
        public ?string $businessMapsUrl,
        public ?string $businessPhone,
        public ?string $yapitaPhone,
        public string  $logoUrl,
        public string  $eventName = 'Sorteo Yapita',
        public ?string $redeemUntil = null,
    )
    {
    }


    public static function whatsappUrl(
        ?string $phone,
        string $message
    ): ?string {

        // ==========================================
        // 1. LIMPIAR NÚMERO
        // ==========================================
        $digits = preg_replace(
            '/\D+/',
            '',
            $phone ?? ''
        );

        if (empty($digits)) {
            return null;
        }

        // ==========================================
        // 2. NORMALIZAR ECUADOR
        // ==========================================

        // 0991234567 -> 593991234567
        if (preg_match('/^09\d{8}$/', $digits)) {
            $digits = '593' . substr($digits, 1);
        }

        // 991234567 -> 593991234567
        elseif (preg_match('/^9\d{8}$/', $digits)) {
            $digits = '593' . $digits;
        }

        // 00593991234567 -> 593991234567
        elseif (str_starts_with($digits, '00')) {
            $digits = substr($digits, 2);
        }

        // ==========================================
        // 3. VALIDAR NÚMERO
        // ==========================================
        if (!preg_match('/^[1-9]\d{7,14}$/', $digits)) {
            return null;
        }

        // ==========================================
        // 4. GENERAR URL
        // ==========================================
        return 'https://wa.me/'
            . $digits
            . '?text='
            . rawurlencode($message);
    }


    public function getManagerData(): array
    {
        // ==========================================
        // 1. GANADOR
        // ==========================================
        $winner = [
            'name' => $this->winnerName,
            'email' => $this->winnerEmail,
        ];

        // ==========================================
        // 2. PREMIO GANADO
        // ==========================================
        $prize = [
            'code' => $this->prizeCode,
            'name' => $this->prizeName,
            'description' => $this->prizeDescription,
            'image' => $this->prizeImage,
            'redeem_until' => $this->redeemUntil,
        ];

        // ==========================================
        // 3. EMPRESA AUSPICIANTE
        // ==========================================
        $business = [
            'name' => $this->businessName,
            'address' => $this->businessAddress,
            'phone' => $this->businessPhone,
            'maps_url' => $this->businessMapsUrl,
        ];

        // ==========================================
        // 4. EVENTO
        // ==========================================
        $event = [
            'name' => $this->eventName,
        ];

        // ==========================================
        // 5. YAPITA
        // ==========================================
        $yapita = [
            'name' => 'Yapita',
            'phone' => $this->yapitaPhone,
            'logo_url' => $this->logoUrl,
            'community_url' => 'https://meetclic.com/',
        ];

        // ==========================================
        // 6. MENSAJE WHATSAPP EMPRESA
        // ==========================================
        $businessMessage = [
            'Hola, ' . $business['name'] . '.',
            '',
            'Soy ' . $winner['name'] . '.',
            'Correo: ' . $winner['email'],
            '',
            'He ganado un premio en el evento '
            . $event['name'] . ', mediante Yapita.',
            '',
            'Premio: ' . $prize['name'],
            'Código: ' . $prize['code'],
        ];

        if (!empty($prize['redeem_until'])) {
            $businessMessage[] =
                'Vigencia: ' . $prize['redeem_until'];
        }

        $businessMessage = array_merge(
            $businessMessage,
            [
                '',
                'Me gustaría coordinar la entrega de mi premio.',
                '¿Podrían indicarme el horario y los requisitos?',
                '',
                '¡Muchas gracias!',
            ]
        );

        // ==========================================
        // 7. MENSAJE WHATSAPP YAPITA
        // ==========================================
        $yapitaMessage = [
            'Hola, equipo Yapita.',
            '',
            'Soy ' . $winner['name'] . '.',
            'Correo: ' . $winner['email'],
            '',
            'Gané el premio: ' . $prize['name'],
            'Código: ' . $prize['code'],
            'Empresa: ' . $business['name'],
            'Evento: ' . $event['name'],
            '',
            'Necesito ayuda para coordinar el canje.',
            '¿Podrían orientarme?',
            '',
            '¡Gracias!',
        ];

        // ==========================================
        // 8. ENLACES WHATSAPP
        // ==========================================
        $businessWhatsappUrl = self::whatsappUrl(
            $business['phone'],
            implode("\n", $businessMessage)
        );

        $yapitaWhatsappUrl = self::whatsappUrl(
            $yapita['phone'],
            implode("\n", $yapitaMessage)
        );

        // ==========================================
        // 9. CONTENIDO DINÁMICO DEL CORREO
        // ==========================================
        $content = [
            'meta' => [
                'title' => '¡Ganaste un premio en Yapita!',
                'subject' => '🎉 ¡Tu premio te espera en Yapita!',
            ],

            'header' => [
                'title' => '🎉 ¡Felicidades, ganaste!',
                'subtitle' => '¡Tu participación tiene recompensa!',
            ],

            'intro' => [
                'greeting' => 'Hola,',
                'message' => '¡Tenemos una gran noticia! Has ganado un premio gracias a una empresa que cree en nuestra comunidad. Descubre cómo disfrutarlo.',
            ],

            'prize' => [
                'code_title' => 'CÓDIGO DE TU PREMIO',
                'code_hint' => 'Guarda este código: te ayudará a identificar tu premio al coordinar su entrega.',
                'deadline_label' => 'Canjear hasta',
            ],

            'winner' => [
                'title' => 'Datos del ganador',
                'name_label' => 'Nombre',
                'email_label' => 'Correo electrónico',
            ],

            'business' => [
                'title' => 'Conoce a la empresa que hizo posible tu premio',
                'maps_button' => '📍 Ver ubicación en Google Maps',
            ],

            'contact' => [
                'title' => '¡Coordina la entrega de tu premio!',

                'business_description' => 'Escríbele a la empresa auspiciante por WhatsApp. Tu mensaje ya incluirá tus datos, el premio y el código de referencia.',

                'business_button' => '💬 Contactar a',

                'yapita_description' => '¿Tienes preguntas o necesitas ayuda para recibir tu premio? ¡En Yapita estamos para acompañarte!',

                'yapita_button' => '💬 Hablar con Yapita',

                'notice' => 'Antes de visitar la empresa, confirma el horario, la disponibilidad y las condiciones de entrega. WhatsApp abrirá un mensaje preparado que podrás revisar antes de enviarlo.',
            ],

            'community' => [
                'title' => '✨ ¡Esto es solo el comienzo!',

                'description' => 'En Yapita la emoción no termina con este sorteo. Sigue explorando empresas aliadas, participa en nuevas actividades, descubre eventos y gana más Yapitas y recompensas. Cada participación fortalece a los negocios de nuestra comunidad y abre nuevas oportunidades para todos.',

                'slogan' => 'Randi Randi: ¡todos aportamos, todos ganamos!',

                'button' => 'Descubrir más oportunidades en Yapita',
            ],

            'footer' => [
                'message' => 'Gracias por ser parte de una comunidad que comparte, apoya y crece unida.',

                'copyright' => 'Yapita. Todos los derechos reservados.',
            ],
        ];

        // ==========================================
        // 10. RETORNAR VARIABLES PARA BLADE
        // ==========================================
        return [
            'content' => $content,

            // GANADOR
            'winnerName' => $winner['name'],
            'winnerEmail' => $winner['email'],

            // PREMIO
            'prizeName' => $prize['name'],
            'prizeDescription' => $prize['description'],
            'prizeImage' => $prize['image'],
            'prizeCode' => $prize['code'],
            'redeemUntil' => $prize['redeem_until'],

            // EMPRESA
            'businessName' => $business['name'],
            'businessAddress' => $business['address'],
            'businessMapsUrl' => $business['maps_url'],
            'businessWhatsappUrl' => $businessWhatsappUrl,

            // YAPITA
            'yapitaWhatsappUrl' => $yapitaWhatsappUrl,
            'logoUrl' => $yapita['logo_url'],
            'communityUrl' => $yapita['community_url'],

            // EVENTO
            'eventName' => $event['name'],

            // IDIOMA
            'language' => 'es',
        ];
    }



    public function build()
    {
        // ==========================================
        // 1. OBTENER DATOS COMPLETOS
        // ==========================================
        $data = $this->getManagerData();

        // ==========================================
        // 2. CONSTRUIR CORREO
        // ==========================================
        return $this
            ->subject($data['content']['meta']['subject'])
            ->view('emails.reward-by-business.prize-winner')
            ->with($data);
    }

}
