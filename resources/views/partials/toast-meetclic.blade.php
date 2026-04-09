@if(!empty($allowCss))
    <style>
        :root {
            --mc-azulClic: #4C4CFF;
            --mc-amarilloVital: #FFCC00;
            --mc-blanco: #FFFFFF;
            --mc-grisOscuro: #2C2C2C;
            --mc-moradoSuave: #5C5CFF;
        }

        /* Block */
        .mc-toast {
            display: flex;
            align-items: flex-start;
            gap: 12px;

            width: min(560px, 100%);
            padding: 14px 14px 14px 12px;

            background: var(--mc-blanco);
            color: var(--mc-grisOscuro);

            border: 1px solid rgba(44, 44, 44, .12);
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(44, 44, 44, .10);

            position: relative;
            overflow: hidden;
        }

        /* Left accent bar */
        .mc-toast::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 6px;
            background: var(--mc-azulClic);
        }

        /* Elements */
        .mc-toast__icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex: 0 0 auto;
            margin-top: 1px;
            background: rgba(76, 76, 255, .10);
            color: var(--mc-azulClic);
            font-size: 20px;
        }

        .mc-toast__content {
            flex: 1 1 auto;
            min-width: 0;
        }

        .mc-toast__title {
            font-weight: 800;
            font-size: 14px;
            line-height: 1.2;
            margin: 0 0 4px 0;
            color: var(--mc-grisOscuro);
        }

        .mc-toast__desc {
            font-size: 13px;
            line-height: 1.35;
            margin: 0;
            color: rgba(44, 44, 44, .82);
        }

        .mc-toast__close {
            appearance: none;
            border: 0;
            background: transparent;
            cursor: pointer;

            flex: 0 0 auto;
            padding: 6px 8px;
            margin: -4px -2px 0 0;

            color: rgba(44, 44, 44, .55);
            border-radius: 10px;
        }

        .mc-toast__close:hover {
            background: rgba(44, 44, 44, .06);
            color: rgba(44, 44, 44, .85);
        }

        .mc-toast__close-x {
            display: inline-block;
            font-size: 18px;
            line-height: 1;
        }

        /* =========================
           Modifiers (MeetClic palette)
        ========================= */

        /* SUCCESS: azulClic + moradoSuave (no verde, por paleta) */
        .mc-toast--success::before {
            background: var(--mc-azulClic);
        }

        .mc-toast--success .mc-toast__icon {
            background: rgba(76, 76, 255, .12);
            color: var(--mc-azulClic);
        }

        /* WARNING: amarilloVital */
        .mc-toast--warning::before {
            background: var(--mc-amarilloVital);
        }

        .mc-toast--warning .mc-toast__icon {
            background: rgba(255, 204, 0, .18);
            color: var(--mc-grisOscuro);
        }

        /* ERROR: usamos moradoSuave como “alerta fuerte” dentro paleta */
        .mc-toast--error::before {
            background: var(--mc-moradoSuave);
        }

        .mc-toast--error .mc-toast__icon {
            background: rgba(92, 92, 255, .16);
            color: var(--mc-moradoSuave);
        }

        /* Responsive */
        @media (max-width: 420px) {
            .mc-toast {
                padding: 12px;
                border-radius: 12px;
            }

            .mc-toast__icon {
                width: 36px;
                height: 36px;
                border-radius: 11px;
                font-size: 18px;
            }
        }

        .mc-toast-stack {
            position: fixed;
            right: 16px;
            bottom: 16px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            z-index: 9999;
            width: min(560px, calc(100% - 32px));
        }
    </style>
@endif

@if(!empty($allowJs))
    <script>

        function initToastLoad() {
            var typeToast = "warning";
            var titleToast = "Atención";
            var descToast = "";
            var allowToast = false;
            console.log("$gamification_result", $gamification_result);
            if ($gamification_result) {
                console.log("enter----------->");
                var resultTask = ($gamification_result);

                if ([-2, -3, -4, -6, -5, 420, -7].includes(resultTask.type)) {
                    allowToast = true;
                    var resultMessage = {type: null, title: "", desc: ""};
                    if (resultTask.type == -7) {
                        var configMessage=$TASK_TOAST[resultTask.type];
                        resultMessage.type =configMessage.type;
                        resultMessage.title =configMessage.title;
                        resultMessage.desc = resultTask.message;


                    } else {
                        resultMessage = $TASK_TOAST[resultTask.type];
                    }


                    typeToast = resultMessage.type;
                    titleToast = resultMessage.title;
                    descToast = resultMessage.desc;

                    if (allowToast) {
                        var html = mcBuildToastUI({
                            type: typeToast,
                            title: titleToast,
                            desc: descToast,
                            floating: true
                        });
                        document.body.insertAdjacentHTML('beforeend', html);
                    }
                }

            }
        }

        function mcEscapeHtml(str) {
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function mcBuildToastUI(opt) {
            opt = opt || {};

            var type = (opt.type || 'success').toLowerCase();
            var title = opt.title || '';
            var desc = opt.desc || '';
            var floating = !!opt.floating;
            var closable = (opt.closable !== false);

            // Config por tipo (solo dentro de la paleta MeetClic)
            var map = {
                success: {
                    cls: 'mc-toast--success',
                    icon: 'fa fa-check-circle',
                    aria: 'polite'
                },
                warning: {
                    cls: 'mc-toast--warning',
                    icon: 'fa fa-exclamation-triangle',
                    aria: 'polite'
                },
                error: {
                    cls: 'mc-toast--error',
                    icon: 'fa fa-times-circle',
                    aria: 'assertive'
                }
            };

            var meta = map[type] || map.success;
            if (meta) {


                var closeBtn = closable ? [
                    '<button type="button" class="mc-toast__close" aria-label="Cerrar" ',
                    'onclick="this.closest(\'.mc-toast\').remove()">',
                    '<span class="mc-toast__close-x" aria-hidden="true">&times;</span>',
                    '</button>'
                ].join('') : '';

                var toast = [
                    '<div class="mc-toast ', meta.cls, '" role="alert" aria-live="', meta.aria, '">',
                    '<div class="mc-toast__icon" aria-hidden="true">',
                    '<i class="', meta.icon, '"></i>',
                    '</div>',

                    '<div class="mc-toast__content">',
                    '<div class="mc-toast__title">', mcEscapeHtml(title), '</div>',
                    '<div class="mc-toast__desc">', mcEscapeHtml(desc), '</div>',
                    '</div>',

                    closeBtn,
                    '</div>'
                ].join('');
            } else {
                toast = [];
            }
            // Si es flotante, lo ponemos dentro del stack (si tu ya tienes stack fijo, puedes omitir wrapper)
            if (!floating) return toast;

            return [
                '<div class="mc-toast-stack">',
                toast,
                '</div>'
            ].join('');
        }
    </script>
@endif
