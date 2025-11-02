SET
FOREIGN_KEY_CHECKS=0;
SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
time_zone = "+00:00";

INSERT INTO `tracking_click_types` (`id`, `uid`, `code`, `description`, `icon_type`, `icon_class`, `icon_url`, `is_default`) VALUES
                                                                                                                                 (1, 'CLK_DEFAULT', 'default', 'Tipo de interacción no especificado', 'icon', 'fa fa-question', NULL, 1),
                                                                                                                                 (2, 'CLK_CLICK', 'click', 'Clic directo en un enlace o botón', 'icon', 'fa fa-hand-pointer-o', NULL, 0),
                                                                                                                                 (3, 'CLK_VIEW', 'view', 'Visualización de página o componente', 'icon', 'fa fa-eye', NULL, 0),
                                                                                                                                 (4, 'CLK_SHARE', 'share', 'Contenido compartido por el usuario', 'icon', 'fa fa-share-alt', NULL, 0),
                                                                                                                                 (5, 'CLK_REFERRAL', 'referral', 'Acceso generado por recomendación', 'icon', 'fa fa-user-plus', NULL, 0),
                                                                                                                                 (6, 'CLK_QR_SCAN', 'qr_scan', 'Escaneo de un código QR físico', 'icon', 'fa fa-qrcode', NULL, 0),
                                                                                                                                 (7, 'CLK_WEB_TRACKING', 'web_tracking', 'Tracking automatizado desde la web', 'icon', 'fa fa-globe', NULL, 0),
                                                                                                                                 (8, 'CLK_BUTTON_PRESS', 'button_press', 'Presión sobre botón interactivo', 'icon', 'fa fa-hand-o-up', NULL, 0),
                                                                                                                                 (9, 'CLK_HOVER', 'hover', 'Permanencia del mouse sobre un elemento', 'icon', 'fa fa-mouse-pointer', NULL, 0),
                                                                                                                                 (10, 'CLK_SCROLL', 'scroll', 'Desplazamiento en la página o sección', 'icon', 'fa fa-arrows-v', NULL, 0),
                                                                                                                                 (11, 'CLK_FORM_SUBMIT', 'form_submit', 'Envío de un formulario de contacto o reserva', 'icon', 'fa fa-paper-plane', NULL, 0),
                                                                                                                                 (12, 'CLK_VIDEO_PLAY', 'video_play', 'Reproducción de un video embebido', 'icon', 'fa fa-play-circle', NULL, 0),
                                                                                                                                 (13, 'CLK_WHATSAPP_CLICK', 'whatsapp_click', 'Click en botón de contacto por WhatsApp', 'icon', 'fa fa-whatsapp', NULL, 0),
                                                                                                                                 (14, 'CLK_PHONE_CALL', 'phone_call', 'Click o tap para llamar por teléfono', 'icon', 'fa fa-phone', NULL, 0),
                                                                                                                                 (15, 'CLK_MAP_OPEN', 'map_open', 'Click para ver ubicación en Google Maps', 'icon', 'fa fa-map-marker', NULL, 0),
                                                                                                                                 (16, 'CLK_DOWNLOAD_FILE', 'download_file', 'Descarga de documentos o archivos', 'icon', 'fa fa-download', NULL, 0),
                                                                                                                                 (17, 'CLK_SHARE_QR', 'share_qr', 'El usuario muestra su propio código QR', 'icon', 'fa fa-qrcode', NULL, 0);

--
-- Dumping data for table `tracking_sources`
--

INSERT INTO `tracking_sources` (`id`, `uid`, `code`, `description`, `icon_type`, `icon_class`, `icon_url`, `is_default`) VALUES
                                                                                                                             (1, 'SRC_DEFAULT', 'default', 'Fuente de tráfico no identificada', 'icon', 'fa fa-question-circle', NULL, 1),
                                                                                                                             (2, 'SRC_FACEBOOK', 'facebook', 'Desde Facebook (publicación, historia o anuncio)', 'icon', 'fa fa-facebook', NULL, 0),
                                                                                                                             (3, 'SRC_INSTAGRAM', 'instagram', 'Desde Instagram (bio, historia o reels)', 'icon', 'fa fa-instagram', NULL, 0),
                                                                                                                             (4, 'SRC_TIKTOK', 'tiktok', 'Desde TikTok (video o perfil)', 'icon', 'fa fa-music', NULL, 0),
                                                                                                                             (5, 'SRC_WHATSAPP', 'whatsapp', 'Enlace compartido por WhatsApp', 'icon', 'fa fa-whatsapp', NULL, 0),
                                                                                                                             (6, 'SRC_TELEGRAM', 'telegram', 'Desde canal o grupo de Telegram', 'icon', 'fa fa-telegram', NULL, 0),
                                                                                                                             (7, 'SRC_EMAIL', 'email', 'Enlace desde correo electrónico', 'icon', 'fa fa-envelope', NULL, 0),
                                                                                                                             (8, 'SRC_GOOGLE', 'google', 'Desde Google Search o Google Ads', 'icon', 'fa fa-google', NULL, 0),
                                                                                                                             (9, 'SRC_EXTERNAL_SITE', 'external_site', 'Desde un sitio web externo no identificado', 'icon', 'fa fa-external-link', NULL, 0),
                                                                                                                             (10, 'SRC_BANNER_WEB', 'banner_web', 'Desde banner en sitio web externo', 'icon', 'fa fa-picture-o', NULL, 0),
                                                                                                                             (11, 'SRC_REFERRAL', 'referral', 'Recomendación directa de otro usuario', 'icon', 'fa fa-user-plus', NULL, 0),
                                                                                                                             (12, 'SRC_MANUAL', 'manual', 'Link escrito o pegado manualmente', 'icon', 'fa fa-keyboard-o', NULL, 0),
                                                                                                                             (13, 'SRC_MEETCLICK', 'meetclick', 'Desde otra sección de la plataforma MeetClic', 'icon', 'fa fa-globe', NULL, 1),
                                                                                                                             (14, 'SRC_QR_ENTRY', 'qr_entry', 'Código QR ubicado en la entrada del local', 'icon', 'fa fa-qrcode', NULL, 0),
                                                                                                                             (15, 'SRC_QR_TABLE', 'qr_table', 'Código QR sobre la mesa del cliente', 'icon', 'fa fa-qrcode', NULL, 0),
                                                                                                                             (16, 'SRC_QR_WALL', 'qr_wall', 'Código QR en una pared del negocio', 'icon', 'fa fa-qrcode', NULL, 0),
                                                                                                                             (17, 'SRC_QR_MENU', 'qr_menu', 'Código QR impreso en la carta o menú físico', 'icon', 'fa fa-cutlery', NULL, 1),
                                                                                                                             (18, 'SRC_QR_TICKET', 'qr_ticket', 'Código QR en ticket o entrada impresa', 'icon', 'fa fa-ticket', NULL, 0),
                                                                                                                             (19, 'SRC_QR_STAND', 'qr_stand', 'Código QR en stand o tótem publicitario', 'icon', 'fa fa-desktop', NULL, 0),
                                                                                                                             (20, 'SRC_QR_FLYER', 'qr_flyer', 'Código QR en un volante o folleto impreso', 'icon', 'fa fa-file-text-o', NULL, 0),
                                                                                                                             (21, 'SRC_QR_CAMERA', 'qr_camera', 'Código QR visible en cámara o pantalla', 'icon', 'fa fa-video-camera', NULL, 0),
                                                                                                                             (22, 'SRC_QR_SHOWCASE', 'qr_showcase', 'Código QR en vitrina visible desde el exterior', 'icon', 'fa fa-eye', NULL, 0),
                                                                                                                             (23, 'SRC_QR_CARD', 'qr_card', 'Código QR en tarjeta física (presentación o fidelización)', 'icon', 'fa fa-id-card', NULL, 0),
                                                                                                                             (24, 'SRC_QR_EVENT', 'qr_event', 'Código QR mostrado en eventos presenciales', 'icon', 'fa fa-calendar-check-o', NULL, 0),
                                                                                                                             (25, 'SRC_QR_PACKAGING', 'qr_packaging', 'Código QR en envases o etiquetas de producto', 'icon', 'fa fa-archive', NULL, 0),
                                                                                                                             (26, 'SRC_QR_MUPI', 'qr_mupi', 'Código QR en cartel callejero (MUPI, etc.)', 'icon', 'fa fa-map', NULL, 0);
SET
FOREIGN_KEY_CHECKS=1;
COMMIT;
