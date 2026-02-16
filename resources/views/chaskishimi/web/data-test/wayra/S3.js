
var WAYRA_S1_3_VERBO_PRESENTE_KAYPACHA = [

    {
        "step_id": "WAYRA_S1_3_HS_01",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Presente (Kay Pacha) • 1.3 Elegir terminación (Yo = -ni)",
        "activity": "UYARINA - Escuchar",
        "description": "Eres una persona hablando de sí misma en presente (Kay Pacha). Tu decisión es identificar cuál terminación verbal corresponde a 'Yo' y seleccionarla.",
        "status": "ACTIVE",
        "weight": 10,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_3_HS_01_EX",
            "type": "HAYSTACK_PICK",
            "title": "Presente • Selección 01 (Yo = -ni)",
            "prompt": "Selecciona la terminación correcta para 'Yo' en presente:",
            "payload": {
                "question": { "es": "Terminación para 'Yo' (presente)", "ki": "-ni" },
                "haystack": ["-ni", "-nki", "-n", "-kuna", "-pi", "-m"],
                "correct": ["-ni"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_3_HS_02",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Presente (Kay Pacha) • 1.3 Elegir terminación (Tú = -nki)",
        "activity": "UYARINA - Escuchar",
        "description": "Estás hablando con alguien en presente. Tu decisión es escoger la terminación verbal que corresponde a 'Tú' en Kay Pacha.",
        "status": "ACTIVE",
        "weight": 20,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_3_HS_02_EX",
            "type": "HAYSTACK_PICK",
            "title": "Presente • Selección 02 (Tú = -nki)",
            "prompt": "Selecciona la terminación correcta para 'Tú' en presente:",
            "payload": {
                "question": { "es": "Terminación para 'Tú' (presente)", "ki": "-nki" },
                "haystack": ["-n", "-nki", "-ni", "-ta", "-ka", "-chu"],
                "correct": ["-nki"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_3_HS_03",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Presente (Kay Pacha) • 1.3 Elegir terminación (Él/Ella = -n)",
        "activity": "UYARINA - Escuchar",
        "description": "Vas a hablar de una tercera persona en presente. Tu decisión es identificar la terminación verbal correcta para 'Él/Ella'.",
        "status": "ACTIVE",
        "weight": 30,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_3_HS_03_EX",
            "type": "HAYSTACK_PICK",
            "title": "Presente • Selección 03 (Él/Ella = -n)",
            "prompt": "Selecciona la terminación correcta para 'Él/Ella' en presente:",
            "payload": {
                "question": { "es": "Terminación para 'Él/Ella' (presente)", "ki": "-n" },
                "haystack": ["-ni", "-nki", "-n", "-manta", "-kuna", "-lla"],
                "correct": ["-n"]
            }
        }
    },


    {
        "step_id": "WAYRA_S1_3_DM_01",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Presente (Kay Pacha) • 1.3 Emparejar persona con terminación",
        "activity": "UYARINA - Escuchar",
        "description": "Tu decisión es asociar cada persona gramatical con su terminación verbal en presente (Kay Pacha).",
        "status": "ACTIVE",
        "weight": 40,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_3_DM_01_EX",
            "type": "DRAG_MATCH",
            "title": "Presente • Emparejar 01 (terminaciones)",
            "prompt": "Empareja persona con terminación:",
            "payload": {
                "pairs": [
                    { "left": "Yo (Ñuka)", "right": "-ni" },
                    { "left": "Tú (Kan)", "right": "-nki" },
                    { "left": "Él/Ella (Pay)", "right": "-n" }
                ]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_3_DM_02",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Presente (Kay Pacha) • 1.3 Emparejar verbo con su forma",
        "activity": "UYARINA - Escuchar",
        "description": "Tu decisión es emparejar el verbo base con la forma conjugada correcta en presente. En este bloque usamos el verbo 'rantina' (comprar).",
        "status": "ACTIVE",
        "weight": 50,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_3_DM_02_EX",
            "type": "DRAG_MATCH",
            "title": "Presente • Emparejar 02 (rantina)",
            "prompt": "Empareja base con conjugación:",
            "payload": {
                "pairs": [
                    { "left": "Ñuka + rantina", "right": "rantini" },
                    { "left": "Kan + rantina", "right": "rantinki" },
                    { "left": "Pay + rantina", "right": "rantin" }
                ]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_3_DM_03",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Presente (Kay Pacha) • 1.3 Emparejar terminación con ejemplo",
        "activity": "UYARINA - Escuchar",
        "description": "Tu decisión es identificar qué ejemplo corresponde a cada terminación del presente. Así aprendes a reconocer el sujeto por el final del verbo.",
        "status": "ACTIVE",
        "weight": 60,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_3_DM_03_EX",
            "type": "DRAG_MATCH",
            "title": "Presente • Emparejar 03 (reconocer sujeto)",
            "prompt": "Empareja terminación con ejemplo:",
            "payload": {
                "pairs": [
                    { "left": "-ni", "right": "… rantini. (Yo…)" },
                    { "left": "-nki", "right": "… rantinki. (Tú…)" },
                    { "left": "-n", "right": "… rantin. (Él/Ella…)" }
                ]
            }
        }
    },

    {
        "step_id": "WAYRA_S1_3_FB_01",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Presente (Kay Pacha) • 1.3 Completar conjugación (Yo = -ni)",
        "activity": "UYARINA - Escuchar",
        "description": "Completa la conjugación en presente (Kay Pacha). Pista: 1ra persona usa terminación -ni. Si el sujeto es 'Yo', el verbo debe terminar en -ni.",
        "status": "ACTIVE",
        "weight": 70,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_3_FB_01_EX",
            "type": "FILL_BLANK",
            "title": "Completar • Presente 01 (Yo = -ni)",
            "prompt": "Completa la oración (Kay Pacha):",
            "payload": {
                "text": "Ñuka ranti____.",
                "answer": "ni",
                "trim": true,
                "ignoreCase": true
            }
        }
    },
    {
        "step_id": "WAYRA_S1_3_FB_02",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Presente (Kay Pacha) • 1.3 Completar conjugación (Tú = -nki)",
        "activity": "UYARINA - Escuchar",
        "description": "Completa la conjugación en presente (Kay Pacha). Pista: 2da persona usa terminación -nki. Si el sujeto es 'Tú', el verbo debe terminar en -nki.",
        "status": "ACTIVE",
        "weight": 80,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_3_FB_02_EX",
            "type": "FILL_BLANK",
            "title": "Completar • Presente 02 (Tú = -nki)",
            "prompt": "Completa la oración (Kay Pacha):",
            "payload": {
                "text": "Kan ranti____.",
                "answer": "nki",
                "trim": true,
                "ignoreCase": true
            }
        }
    },
    {
        "step_id": "WAYRA_S1_3_FB_03",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Presente (Kay Pacha) • 1.3 Completar conjugación (Él/Ella = -n)",
        "activity": "UYARINA - Escuchar",
        "description": "Completa la conjugación en presente (Kay Pacha). Pista: 3ra persona usa terminación -n. Si es 'Él/Ella', el verbo termina en -n.",
        "status": "ACTIVE",
        "weight": 90,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_3_FB_03_EX",
            "type": "FILL_BLANK",
            "title": "Completar • Presente 03 (Él/Ella = -n)",
            "prompt": "Completa la oración (Kay Pacha):",
            "payload": {
                "text": "Pay ranti____.",
                "answer": "n",
                "trim": true,
                "ignoreCase": true
            }
        }
    },

    {
        "step_id": "WAYRA_S1_3_MS_01",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Presente (Kay Pacha) • 1.3 Selección múltiple • Terminaciones del presente",
        "activity": "UYARINA - Escuchar",
        "description": "Tu decisión es identificar SOLO las terminaciones del presente (Kay Pacha). Selecciona -ni, -nki y -n.",
        "status": "ACTIVE",
        "weight": 100,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_3_MS_01_EX",
            "type": "MULTI_SELECT",
            "title": "Multi • Terminaciones Kay Pacha 01",
            "prompt": "Selecciona las terminaciones del presente (Kay Pacha):",
            "payload": {
                "options": [
                    { "id": "a", "text": "-ni" },
                    { "id": "b", "text": "-nki" },
                    { "id": "c", "text": "-n" },
                    { "id": "d", "text": "-kuna" }
                ],
                "correctIds": ["a", "b", "c"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_3_MS_02",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Presente (Kay Pacha) • 1.3 Selección múltiple • ¿Quién es el sujeto?",
        "activity": "UYARINA - Escuchar",
        "description": "Vas a deducir el sujeto por la terminación. Si el verbo termina en -nki, tu decisión es escoger a quién corresponde (Tú).",
        "status": "ACTIVE",
        "weight": 110,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_3_MS_02_EX",
            "type": "MULTI_SELECT",
            "title": "Multi • Reconocer sujeto 02",
            "prompt": "Si un verbo termina en “-nki”, ¿quién realiza la acción?",
            "payload": {
                "options": [
                    { "id": "a", "text": "Yo (Ñuka)" },
                    { "id": "b", "text": "Tú (Kan)" },
                    { "id": "c", "text": "Él/Ella (Pay)" },
                    { "id": "d", "text": "Nosotros (Ñukanchik)" }
                ],
                "correctIds": ["b"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_3_MS_03",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Presente (Kay Pacha) • 1.3 Selección múltiple • Formas correctas de 'rantina'",
        "activity": "UYARINA - Escuchar",
        "description": "Tu decisión es identificar cuáles formas son conjugaciones válidas en presente para el verbo 'rantina' (comprar).",
        "status": "ACTIVE",
        "weight": 120,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_3_MS_03_EX",
            "type": "MULTI_SELECT",
            "title": "Multi • Conjugaciones correctas 03",
            "prompt": "Selecciona las conjugaciones correctas en Kay Pacha:",
            "payload": {
                "options": [
                    { "id": "a", "text": "rantini" },
                    { "id": "b", "text": "rantinki" },
                    { "id": "c", "text": "rantin" },
                    { "id": "d", "text": "rantirka" }
                ],
                "correctIds": ["a", "b", "c"]
            }
        }
    },

    {
        "step_id": "WAYRA_S1_3_MSI_01",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Presente (Kay Pacha) • 1.3 Imagen • Acción del hablante (Yo = -ni)",
        "activity": "RIKSINA - Mirar",
        "description": "Mira la imagen: la persona habla de lo que hace ahora. Tu decisión es elegir la forma del verbo en presente para 'Yo' (termina en -ni).",
        "status": "ACTIVE",
        "weight": 130,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_3_MSI_01_EX",
            "type": "MULTI_SELECT_IMAGE",
            "title": "Imagen • Presente 01 (Yo)",
            "prompt": "Según la situación, selecciona la forma correcta:",
            "payload": {
                "image": "https://images.unsplash.com/photo-1520975897837-44a6b2f1c0a6?auto=format&fit=crop&w=1200&q=60",
                "alt": "persona diciendo yo lo hago ahora",
                "showImageFirst": true,
                "options": [
                    { "id": "a", "text": "rantini" },
                    { "id": "b", "text": "rantinki" },
                    { "id": "c", "text": "rantin" }
                ],
                "correctIds": ["a"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_3_MSI_02",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Presente (Kay Pacha) • 1.3 Imagen • Acción del oyente (Tú = -nki)",
        "activity": "RIKSINA - Mirar",
        "description": "Mira la escena: alguien le habla a otra persona (Tú). Tu decisión es elegir la forma del verbo en presente para 'Tú' (termina en -nki).",
        "status": "ACTIVE",
        "weight": 140,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_3_MSI_02_EX",
            "type": "MULTI_SELECT_IMAGE",
            "title": "Imagen • Presente 02 (Tú)",
            "prompt": "Selecciona la forma correcta para 'Tú' en presente:",
            "payload": {
                "image": "https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?auto=format&fit=crop&w=1200&q=60",
                "alt": "persona hablándole a otra (tú)",
                "showImageFirst": true,
                "options": [
                    { "id": "a", "text": "rantinki" },
                    { "id": "b", "text": "rantini" },
                    { "id": "c", "text": "rantin" }
                ],
                "correctIds": ["a"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_3_MSI_03",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Presente (Kay Pacha) • 1.3 Imagen • Acción de tercera persona (Él/Ella = -n)",
        "activity": "RIKSINA - Mirar",
        "description": "Observa a la tercera persona en la imagen. Tu decisión es escoger la forma del verbo en presente para 'Él/Ella' (termina en -n).",
        "status": "ACTIVE",
        "weight": 150,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_3_MSI_03_EX",
            "type": "MULTI_SELECT_IMAGE",
            "title": "Imagen • Presente 03 (Él/Ella)",
            "prompt": "Selecciona la forma correcta en presente:",
            "payload": {
                "image": "https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=1200&q=60",
                "alt": "persona tercera (él/ella)",
                "showImageFirst": true,
                "options": [
                    { "id": "a", "text": "rantin" },
                    { "id": "b", "text": "rantinki" },
                    { "id": "c", "text": "rantini" }
                ],
                "correctIds": ["a"]
            }
        }
    },

    {
        "step_id": "WAYRA_S1_3_OW_01",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Presente (Kay Pacha) • 1.3 Ordenar oración (Yo compro)",
        "activity": "UYARINA - Escuchar",
        "description": "Tu decisión es ordenar la oración en presente (Kay Pacha). Estructura básica: Pronombre + Verbo conjugado.",
        "status": "ACTIVE",
        "weight": 160,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_3_OW_01_EX",
            "type": "ORDER_WORDS",
            "title": "Ordenar • Presente 01 (Yo)",
            "prompt": "Ordena la oración (Pronombre + Verbo):",
            "payload": {
                "correctOrder": ["Ñuka", "rantini."],
                "items": ["rantini.", "Ñuka"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_3_OW_02",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Presente (Kay Pacha) • 1.3 Ordenar oración (Tú compras)",
        "activity": "UYARINA - Escuchar",
        "description": "Ordena la oración en presente (Kay Pacha). Pista: para 'Tú' el verbo termina en -nki.",
        "status": "ACTIVE",
        "weight": 170,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_3_OW_02_EX",
            "type": "ORDER_WORDS",
            "title": "Ordenar • Presente 02 (Tú)",
            "prompt": "Ordena la oración correctamente:",
            "payload": {
                "correctOrder": ["Kan", "rantinki."],
                "items": ["rantinki.", "Kan"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_3_OW_03",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Presente (Kay Pacha) • 1.3 Ordenar oración (Él/Ella compra)",
        "activity": "UYARINA - Escuchar",
        "description": "Tu decisión es ordenar la oración para tercera persona en presente (Kay Pacha). Pista: termina en -n.",
        "status": "ACTIVE",
        "weight": 180,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_3_OW_03_EX",
            "type": "ORDER_WORDS",
            "title": "Ordenar • Presente 03 (Él/Ella)",
            "prompt": "Ordena la oración correctamente:",
            "payload": {
                "correctOrder": ["Pay", "rantin."],
                "items": ["rantin.", "Pay"]
            }
        }
    }

];
