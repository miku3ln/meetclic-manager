<script>

    class MaskanaContactUtil {

        /**
         * Normalize Ecuadorian mobile phone numbers
         * to international WhatsApp format.
         *
         * Supported examples:
         * 0985339457     -> 593985339457
         * 985339457      -> 593985339457
         * +593985339457  -> 593985339457
         * 593985339457   -> 593985339457
         */
        static normalizeEcuadorPhone(phone) {
            if (phone === null || phone === undefined) {
                return null;
            }

            const raw = String(phone).trim();

            // Allow formatting separators, but not letters.
            if (!/^\+?[\d\s().-]+$/.test(raw)) {
                return null;
            }

            const digits = raw.replace(/\D/g, '');

            let localNumber;

            if (/^09\d{8}$/.test(digits)) {
                localNumber = digits.substring(1);

            } else if (/^9\d{8}$/.test(digits)) {
                localNumber = digits;

            } else if (/^5939\d{8}$/.test(digits)) {
                localNumber = digits.substring(3);

            } else if (/^005939\d{8}$/.test(digits)) {
                localNumber = digits.substring(5);

            } else {
                return null;
            }

            return `593${localNumber}`;
        }

        /**
         * Build a customer-friendly WhatsApp message.
         */
        static getWhatsAppMessage(businessName = '') {
            const name = String(businessName || 'su empresa').trim();

            return [
                '¡Hola! 👋',
                '',
                `Encontré a *${name}* a través de *Yapita*, la plataforma que conecta a las personas con los negocios locales.`,
                '',
                '🎃 Estoy explorando las empresas participantes en el evento de Halloween de Otavalo y me gustaría conocer más información sobre sus productos, servicios y promociones.',
                '',
                '¡Muchas gracias!'
            ].join('\n');
        }

        /**
         * Generate a valid WhatsApp URL.
         */
        static getWhatsAppLink(phone, businessName = '') {
            const normalizedPhone = this.normalizeEcuadorPhone(phone);

            if (!normalizedPhone) {
                return '';
            }

            const message = this.getWhatsAppMessage(businessName);

            return `https://wa.me/${normalizedPhone}?text=${encodeURIComponent(message)}`;
        }
    }
    window.MaskanaContactUtil = MaskanaContactUtil;

</script>
