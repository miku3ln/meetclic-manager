
var WAYRA_S1_2_SALUDO_PRESENTACION = [


    {
        "step_id": "WAYRA_S1_2_HS_01",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Saludos y Presentación • 1.2 Elegir saludo (Buenos días)",
        "activity": "UYARINA - Escuchar",
        "description": "Eres una persona llegando a saludar. Tu decisión es identificar cómo se dice “Buenos días” en Kichwa y seleccionarlo entre varias palabras.",
        "status": "ACTIVE",
        "weight": 10,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_2_HS_01_EX",
            "type": "HAYSTACK_PICK",
            "title": "Saludos • Selección 01 (Buenos días)",
            "prompt": "Selecciona la palabra correcta en Kichwa:",
            "payload": {
                "question": { "es": "Buenos días", "ki": "Alli puncha" },
                "haystack": ["Alli puncha", "Napaykuna", "Ñuka", "Wasi", "Yaku", "Rumi"],
                "correct": ["Alli puncha"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_2_HS_02",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Saludos y Presentación • 1.2 Elegir saludo (Hola)",
        "activity": "UYARINA - Escuchar",
        "description": "Estás iniciando una conversación. Tu decisión es escoger la forma correcta de decir “Hola / Saludos” en Kichwa.",
        "status": "ACTIVE",
        "weight": 20,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_2_HS_02_EX",
            "type": "HAYSTACK_PICK",
            "title": "Saludos • Selección 02 (Hola)",
            "prompt": "Selecciona el saludo correcto en Kichwa:",
            "payload": {
                "question": { "es": "Hola / Saludos", "ki": "Napaykuna" },
                "haystack": ["Kan", "Napaykuna", "Pay", "Maki", "Allpa"],
                "correct": ["Napaykuna"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_2_HS_03",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Saludos y Presentación • 1.2 Elegir frase (Mi nombre es...)",
        "activity": "UYARINA - Escuchar",
        "description": "Vas a presentarte. Tu decisión es identificar la frase base en Kichwa que significa “Mi nombre es…”.",
        "status": "ACTIVE",
        "weight": 30,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_2_HS_03_EX",
            "type": "HAYSTACK_PICK",
            "title": "Presentación • Selección 03 (Mi nombre es...)",
            "prompt": "Selecciona la frase correcta en Kichwa:",
            "payload": {
                "question": { "es": "Mi nombre es...", "ki": "Ñukapa shutimi..." },
                "haystack": ["Ñukapa shutimi", "Alli puncha", "Kan", "Pay", "Wasi", "Yana"],
                "correct": ["Ñukapa shutimi"]
            }
        }
    },

    {
        "step_id": "WAYRA_S1_2_DM_01",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Saludos y Presentación • 1.2 Emparejar saludos básicos",
        "activity": "UYARINA - Escuchar",
        "description": "Tu decisión es unir cada saludo en Kichwa con su significado en español. Esto te ayuda a reconocerlos rápido en la vida real.",
        "status": "ACTIVE",
        "weight": 40,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_2_DM_01_EX",
            "type": "DRAG_MATCH",
            "title": "Saludos • Emparejar 01",
            "prompt": "Empareja Kichwa con Español:",
            "payload": {
                "pairs": [
                    { "left": "Alli puncha", "right": "Buenos días" },
                    { "left": "Napaykuna", "right": "Hola / Saludos" },
                    { "left": "Alli", "right": "Bien / Bueno" }
                ]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_2_DM_02",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Saludos y Presentación • 1.2 Emparejar partes de presentación",
        "activity": "UYARINA - Escuchar",
        "description": "Estás armando una presentación. Tu decisión es emparejar palabras clave que se usan cuando dices tu nombre.",
        "status": "ACTIVE",
        "weight": 50,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_2_DM_02_EX",
            "type": "DRAG_MATCH",
            "title": "Presentación • Emparejar 02",
            "prompt": "Empareja correctamente:",
            "payload": {
                "pairs": [
                    { "left": "Ñuka", "right": "Yo" },
                    { "left": "shuti", "right": "nombre" },
                    { "left": "Ñukapa", "right": "de mí / mi" }
                ]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_2_DM_03",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Saludos y Presentación • 1.2 Emparejar frases rápidas",
        "activity": "UYARINA - Escuchar",
        "description": "Tu decisión es reconocer frases completas. Empareja cada frase en Kichwa con lo que significa en español.",
        "status": "ACTIVE",
        "weight": 60,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_2_DM_03_EX",
            "type": "DRAG_MATCH",
            "title": "Frases • Emparejar 03",
            "prompt": "Empareja Kichwa con Español:",
            "payload": {
                "pairs": [
                    { "left": "Alli puncha", "right": "Buenos días" },
                    { "left": "Ñukapa shutimi kan", "right": "Mi nombre es" },
                    { "left": "Allimi kani", "right": "Estoy bien" }
                ]
            }
        }
    },

    {
        "step_id": "WAYRA_S1_2_FB_01",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Saludos y Presentación • 1.2 Completar saludo (Buenos días)",
        "activity": "UYARINA - Escuchar",
        "description": "Completa la frase de saludo. No es conjugación: solo debes colocar el saludo exacto que corresponde a “Buenos días”.",
        "status": "ACTIVE",
        "weight": 70,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_2_FB_01_EX",
            "type": "FILL_BLANK",
            "title": "Completar • Saludo 01",
            "prompt": "Completa la frase con el saludo correcto:",
            "payload": {
                "text": "____, mashikuna.",
                "answer": "Alli puncha",
                "trim": true,
                "ignoreCase": true
            }
        }
    },
    {
        "step_id": "WAYRA_S1_2_FB_02",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Saludos y Presentación • 1.2 Completar saludo (Hola)",
        "activity": "UYARINA - Escuchar",
        "description": "Completa el inicio de una conversación. No es tiempo verbal: solo debes escribir el saludo correcto para decir “Hola / Saludos”.",
        "status": "ACTIVE",
        "weight": 80,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_2_FB_02_EX",
            "type": "FILL_BLANK",
            "title": "Completar • Saludo 02",
            "prompt": "Completa la frase con el saludo correcto:",
            "payload": {
                "text": "____.",
                "answer": "Napaykuna",
                "trim": true,
                "ignoreCase": true
            }
        }
    },
    {
        "step_id": "WAYRA_S1_2_FB_03",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Saludos y Presentación • 1.2 Completar presentación (Mi nombre es...)",
        "activity": "UYARINA - Escuchar",
        "description": "Completa la presentación. Aquí solo completas la parte fija “Mi nombre es…”. No es conjugación por tiempo: es una frase base de identidad.",
        "status": "ACTIVE",
        "weight": 90,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_2_FB_03_EX",
            "type": "FILL_BLANK",
            "title": "Completar • Presentación 03",
            "prompt": "Completa la frase con la parte correcta:",
            "payload": {
                "text": "____ ____ Killa kan.",
                "answer": "Ñukapa shutimi",
                "trim": true,
                "ignoreCase": true
            }
        }
    },

    {
        "step_id": "WAYRA_S1_2_MS_01",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Saludos y Presentación • 1.2 Selección múltiple • Solo saludos",
        "activity": "UYARINA - Escuchar",
        "description": "Tu decisión es identificar SOLO los saludos. Selecciona las palabras que sirven para saludar y evita palabras que no son saludos.",
        "status": "ACTIVE",
        "weight": 100,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_2_MS_01_EX",
            "type": "MULTI_SELECT",
            "title": "Multi • Identificar saludos 01",
            "prompt": "Selecciona las palabras que son saludos:",
            "payload": {
                "options": [
                    { "id": "a", "text": "Alli puncha" },
                    { "id": "b", "text": "Napaykuna" },
                    { "id": "c", "text": "Wasi" },
                    { "id": "d", "text": "Alli" }
                ],
                "correctIds": ["a", "b", "d"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_2_MS_02",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Saludos y Presentación • 1.2 Selección múltiple • Respuesta (Estoy bien)",
        "activity": "UYARINA - Escuchar",
        "description": "Te preguntan cómo estás. Tu decisión es seleccionar la frase que significa “Estoy bien” en Kichwa.",
        "status": "ACTIVE",
        "weight": 110,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_2_MS_02_EX",
            "type": "MULTI_SELECT",
            "title": "Multi • Respuesta 02 (Estoy bien)",
            "prompt": "Selecciona la opción correcta:",
            "payload": {
                "options": [
                    { "id": "a", "text": "Allimi kani" },
                    { "id": "b", "text": "Ñukapa shutimi" },
                    { "id": "c", "text": "Wasi" },
                    { "id": "d", "text": "Yaku" }
                ],
                "correctIds": ["a"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_2_MS_03",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Saludos y Presentación • 1.2 Selección múltiple • Armar presentación corta",
        "activity": "UYARINA - Escuchar",
        "description": "Tu objetivo es presentarte. Selecciona las piezas correctas que forman una presentación corta: “Yo / mi nombre / es”.",
        "status": "ACTIVE",
        "weight": 120,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_2_MS_03_EX",
            "type": "MULTI_SELECT",
            "title": "Multi • Partes de presentación 03",
            "prompt": "Selecciona las palabras que sirven para decir “Mi nombre es...” :",
            "payload": {
                "options": [
                    { "id": "a", "text": "Ñuka" },
                    { "id": "b", "text": "shuti" },
                    { "id": "c", "text": "kan" },
                    { "id": "d", "text": "Rumi" }
                ],
                "correctIds": ["a", "b", "c"]
            }
        }
    },

    {
        "step_id": "WAYRA_S1_2_MSI_01",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Saludos y Presentación • 1.2 Imagen • Elegir saludo (Buenos días)",
        "activity": "RIKSINA - Mirar",
        "description": "Mira la escena: es de mañana. Tu decisión es elegir el saludo correcto para ese momento del día.",
        "status": "ACTIVE",
        "weight": 130,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_2_MSI_01_EX",
            "type": "MULTI_SELECT_IMAGE",
            "title": "Imagen • Saludo 01 (Mañana)",
            "prompt": "Según la imagen, selecciona el saludo correcto:",
            "payload": {
                "image": "https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=60",
                "alt": "amanecer mañana",
                "showImageFirst": true,
                "options": [
                    { "id": "a", "text": "Alli puncha" },
                    { "id": "b", "text": "Napaykuna" },
                    { "id": "c", "text": "Ñukapa shutimi" }
                ],
                "correctIds": ["a"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_2_MSI_02",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Saludos y Presentación • 1.2 Imagen • Saludar al encontrar a alguien",
        "activity": "RIKSINA - Mirar",
        "description": "Ves a dos personas saludándose. Tu decisión es elegir la palabra que se usa para decir “Hola / Saludos”.",
        "status": "ACTIVE",
        "weight": 140,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_2_MSI_02_EX",
            "type": "MULTI_SELECT_IMAGE",
            "title": "Imagen • Saludo 02 (Hola)",
            "prompt": "Selecciona el saludo correcto:",
            "payload": {
                "image": "https://images.unsplash.com/photo-1520975958225-7f61d0a5f1e0?auto=format&fit=crop&w=1200&q=60",
                "alt": "personas saludando",
                "showImageFirst": true,
                "options": [
                    { "id": "a", "text": "Napaykuna" },
                    { "id": "b", "text": "Wasi" },
                    { "id": "c", "text": "Yaku" }
                ],
                "correctIds": ["a"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_2_MSI_03",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Saludos y Presentación • 1.2 Imagen • Presentarte (Mi nombre es...)",
        "activity": "RIKSINA - Mirar",
        "description": "La persona se está presentando. Tu decisión es elegir la frase base que se usa para decir “Mi nombre es…”.",
        "status": "ACTIVE",
        "weight": 150,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_2_MSI_03_EX",
            "type": "MULTI_SELECT_IMAGE",
            "title": "Imagen • Presentación 03 (Mi nombre es...)",
            "prompt": "Selecciona la frase correcta para presentarte:",
            "payload": {
                "image": "https://images.unsplash.com/photo-1520975693411-6d077f5f08b6?auto=format&fit=crop&w=1200&q=60",
                "alt": "persona hablando presentándose",
                "showImageFirst": true,
                "options": [
                    { "id": "a", "text": "Ñukapa shutimi" },
                    { "id": "b", "text": "Alli puncha" },
                    { "id": "c", "text": "Rumi" }
                ],
                "correctIds": ["a"]
            }
        }
    },

    {
        "step_id": "WAYRA_S1_2_OW_01",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Saludos y Presentación • 1.2 Ordenar saludo (Buenos días)",
        "activity": "UYARINA - Escuchar",
        "description": "Tu decisión es ordenar una frase de saludo tal como se dice naturalmente. Forma la frase completa sin cambiar palabras.",
        "status": "ACTIVE",
        "weight": 160,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_2_OW_01_EX",
            "type": "ORDER_WORDS",
            "title": "Ordenar • Saludo 01",
            "prompt": "Ordena la frase correctamente:",
            "payload": {
                "correctOrder": ["Alli", "puncha."],
                "items": ["puncha.", "Alli"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_2_OW_02",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Saludos y Presentación • 1.2 Ordenar saludo (Hola)",
        "activity": "UYARINA - Escuchar",
        "description": "Ordena la palabra o frase tal como se usa al saludar. Tu decisión es construir el saludo completo en el orden correcto.",
        "status": "ACTIVE",
        "weight": 170,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_2_OW_02_EX",
            "type": "ORDER_WORDS",
            "title": "Ordenar • Saludo 02 (Hola)",
            "prompt": "Ordena la frase correctamente:",
            "payload": {
                "correctOrder": ["Napaykuna."],
                "items": ["Napaykuna."]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_2_OW_03",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Saludos y Presentación • 1.2 Ordenar presentación (Mi nombre es...)",
        "activity": "UYARINA - Escuchar",
        "description": "Tu decisión es ordenar una presentación corta. Recuerda la estructura: primero “mi nombre”, luego el nombre y al final “es (kan)”.",
        "status": "ACTIVE",
        "weight": 180,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_2_OW_03_EX",
            "type": "ORDER_WORDS",
            "title": "Ordenar • Presentación 03",
            "prompt": "Ordena la frase de presentación en Kichwa:",
            "payload": {
                "correctOrder": ["Ñukapa", "shutimi", "Killa", "kan."],
                "items": ["kan.", "Killa", "Ñukapa", "shutimi"]
            }
        }
    }

];
