var PRONOMBRES_PERSONALES = [
    {
        "step_id": "WAYRA_S1_1_HS_01",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Identidad • 1.1 Pronombres Singulares • Elegir (Yo)",
        "activity": "UYARINA - Escuchar",
        "description": "Eres una persona aprendiendo Kichwa. Tu decisión es identificar qué palabra en Kichwa significa “Yo” y seleccionarla dentro del grupo.",
        "status": "ACTIVE",
        "weight": 10,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_1_HS_01_EX",
            "type": "HAYSTACK_PICK",
            "title": "Pronombres singulares • Selección 01 (Yo)",
            "prompt": "Selecciona el pronombre correcto en Kichwa:",
            "payload": {
                "question": {"es": "Yo", "ki": "Ñuka"},
                "haystack": ["Ñuka", "Kan", "Pay", "Wasi", "Yaku", "Allpa"],
                "correct": ["Ñuka"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_1_HS_02",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Identidad • 1.1 Pronombres Singulares • Elegir (Tú)",
        "activity": "UYARINA - Escuchar",
        "description": "Tu decisión es reconocer qué palabra en Kichwa significa “Tú”. Analiza las opciones y selecciona la correcta.",
        "status": "ACTIVE",
        "weight": 20,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_1_HS_02_EX",
            "type": "HAYSTACK_PICK",
            "title": "Pronombres singulares • Selección 02 (Tú)",
            "prompt": "Selecciona el pronombre correcto en Kichwa:",
            "payload": {
                "question": {"es": "Tú", "ki": "Kan"},
                "haystack": ["Pay", "Kan", "Ñuka", "Maki", "Killa"],
                "correct": ["Kan"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_1_HS_03",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Identidad • 1.1 Pronombres Singulares • Elegir (Él/Ella)",
        "activity": "UYARINA - Escuchar",
        "description": "Tu decisión es identificar el pronombre de tercera persona. Selecciona qué palabra en Kichwa significa “Él/Ella”.",
        "status": "ACTIVE",
        "weight": 30,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_1_HS_03_EX",
            "type": "HAYSTACK_PICK",
            "title": "Pronombres singulares • Selección 03 (Él/Ella)",
            "prompt": "Selecciona el pronombre correcto en Kichwa:",
            "payload": {
                "question": {"es": "Él / Ella", "ki": "Pay"},
                "haystack": ["Kan", "Ñukanchik", "Pay", "Rumi", "Yana"],
                "correct": ["Pay"]
            }
        }
    },

    {
        "step_id": "WAYRA_S1_1_DM_01",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Identidad • 1.1 Pronombres Singulares • Emparejar",
        "activity": "UYARINA - Escuchar",
        "description": "Eres una persona que debe tomar decisiones de correspondencia. Une cada pronombre en Kichwa con su significado en español.",
        "status": "ACTIVE",
        "weight": 40,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_1_DM_01_EX",
            "type": "DRAG_MATCH",
            "title": "Pronombres singulares • Emparejar 01",
            "prompt": "Empareja Kichwa con Español:",
            "payload": {
                "pairs": [
                    {"left": "Ñuka", "right": "Yo"},
                    {"left": "Kan", "right": "Tú"},
                    {"left": "Pay", "right": "Él/Ella"}
                ]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_1_DM_02",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Identidad • 1.1 Pronombres Singulares • Emparejar (Refuerzo)",
        "activity": "UYARINA - Escuchar",
        "description": "Decide la correspondencia correcta. Arrastra y une cada pronombre con su traducción.",
        "status": "ACTIVE",
        "weight": 50,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_1_DM_02_EX",
            "type": "DRAG_MATCH",
            "title": "Pronombres singulares • Emparejar 02",
            "prompt": "Empareja correctamente:",
            "payload": {
                "pairs": [
                    {"left": "Ñuka", "right": "Yo"},
                    {"left": "Pay", "right": "Él/Ella"}
                ]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_1_DM_03",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Identidad • 1.1 Pronombres Singulares • Emparejar (Enfoque: Tú / Él)",
        "activity": "UYARINA - Escuchar",
        "description": "Tu decisión es emparejar correctamente segunda y tercera persona. Une cada palabra con su significado.",
        "status": "ACTIVE",
        "weight": 60,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_1_DM_03_EX",
            "type": "DRAG_MATCH",
            "title": "Pronombres singulares • Emparejar 03",
            "prompt": "Empareja correctamente:",
            "payload": {
                "pairs": [
                    {"left": "Kan", "right": "Tú"},
                    {"left": "Pay", "right": "Él/Ella"}
                ]
            }
        }
    },

    {
        "step_id": "WAYRA_S1_1_FB_01",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Identidad • 1.1 Completar • Presente 1ra persona (-ni)",
        "activity": "UYARINA - Escuchar",
        "description": "Debes completar con el pronombre correcto. La conjugación 'rantini' está en presente con terminación -ni (1ra persona). ¿Quién realiza la acción? (Yo).",
        "status": "ACTIVE",
        "weight": 70,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_1_FB_01_EX",
            "type": "FILL_BLANK",
            "title": "Completar • Presente 01 (-ni)",
            "prompt": "Completa la oración con el pronombre correcto:",
            "payload": {
                "text": "____ rantini.",
                "answer": "Ñuka",
                "trim": true,
                "ignoreCase": true
            }
        }
    },
    {
        "step_id": "WAYRA_S1_1_FB_02",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Identidad • 1.1 Completar • Presente 2da persona (-nki)",
        "activity": "UYARINA - Escuchar",
        "description": "Completa con el pronombre correcto. 'rantinki' usa la terminación -nki (2da persona). Tu decisión es elegir el pronombre para 'Tú'.",
        "status": "ACTIVE",
        "weight": 80,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_1_FB_02_EX",
            "type": "FILL_BLANK",
            "title": "Completar • Presente 02 (-nki)",
            "prompt": "Completa la oración con el pronombre correcto:",
            "payload": {
                "text": "____ rantinki.",
                "answer": "Kan",
                "trim": true,
                "ignoreCase": true
            }
        }
    },
    {
        "step_id": "WAYRA_S1_1_FB_03",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Identidad • 1.1 Completar • Presente 3ra persona (-n)",
        "activity": "UYARINA - Escuchar",
        "description": "Completa con el pronombre correcto. 'rantin' usa terminación -n (3ra persona). Tu decisión es elegir el pronombre de 'Él/Ella'.",
        "status": "ACTIVE",
        "weight": 90,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_1_FB_03_EX",
            "type": "FILL_BLANK",
            "title": "Completar • Presente 03 (-n)",
            "prompt": "Completa la oración con el pronombre correcto:",
            "payload": {
                "text": "____ rantin.",
                "answer": "Pay",
                "trim": true,
                "ignoreCase": true
            }
        }
    },

    {
        "step_id": "WAYRA_S1_1_MS_01",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Identidad • 1.1 Selección múltiple • Pronombres singulares",
        "activity": "UYARINA - Escuchar",
        "description": "Eres una persona que debe identificar categorías. Tu decisión es seleccionar SOLO los pronombres singulares y evitar palabras que no son pronombres.",
        "status": "ACTIVE",
        "weight": 100,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_1_MS_01_EX",
            "type": "MULTI_SELECT",
            "title": "Multi • Identificar pronombres singulares",
            "prompt": "Selecciona los pronombres singulares:",
            "payload": {
                "options": [
                    {"id": "a", "text": "Ñuka"},
                    {"id": "b", "text": "Kan"},
                    {"id": "c", "text": "Pay"},
                    {"id": "d", "text": "Wasi"}
                ],
                "correctIds": ["a", "b", "c"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_1_MS_02",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Identidad • 1.1 Selección múltiple • Significado de Kan",
        "activity": "UYARINA - Escuchar",
        "description": "Tu decisión es elegir el significado correcto. 'Kan' es un pronombre: selecciona su traducción correcta en español.",
        "status": "ACTIVE",
        "weight": 110,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_1_MS_02_EX",
            "type": "MULTI_SELECT",
            "title": "Multi • Traducción (Kan)",
            "prompt": "Selecciona la traducción correcta de 'Kan':",
            "payload": {
                "options": [
                    {"id": "a", "text": "Yo"},
                    {"id": "b", "text": "Tú"},
                    {"id": "c", "text": "Él"},
                    {"id": "d", "text": "Casa"}
                ],
                "correctIds": ["b"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_1_MS_03",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Identidad • 1.1 Selección múltiple • Significado de Pay",
        "activity": "UYARINA - Escuchar",
        "description": "Debes tomar una decisión de traducción: selecciona el significado correcto de 'Pay' en español.",
        "status": "ACTIVE",
        "weight": 120,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_1_MS_03_EX",
            "type": "MULTI_SELECT",
            "title": "Multi • Traducción (Pay)",
            "prompt": "Selecciona la traducción correcta de 'Pay':",
            "payload": {
                "options": [
                    {"id": "a", "text": "Nosotros"},
                    {"id": "b", "text": "Él/Ella"},
                    {"id": "c", "text": "Tú"},
                    {"id": "d", "text": "Agua"}
                ],
                "correctIds": ["b"]
            }
        }
    },

    {
        "step_id": "WAYRA_S1_1_MSI_01",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Identidad • 1.1 Imagen • Pronombre (Yo)",
        "activity": "RIKSINA - Mirar",
        "description": "Mira la imagen y toma una decisión: si la persona habla de sí misma, selecciona el pronombre correcto (Yo).",
        "status": "ACTIVE",
        "weight": 130,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_1_MSI_01_EX",
            "type": "MULTI_SELECT_IMAGE",
            "title": "Imagen • Elegir pronombre (Yo)",
            "prompt": "Selecciona el pronombre correcto según la situación:",
            "payload": {
                "image": "https://images.unsplash.com/photo-1500648767791-00dcc994a43e",
                "alt": "persona señalándose",
                "showImageFirst": true,
                "options": [
                    {"id": "a", "text": "Ñuka"},
                    {"id": "b", "text": "Kan"},
                    {"id": "c", "text": "Pay"}
                ],
                "correctIds": ["a"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_1_MSI_02",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Identidad • 1.1 Imagen • Pronombre (Tú)",
        "activity": "RIKSINA - Mirar",
        "description": "Mira la imagen y decide: cuando alguien señala a otra persona, el pronombre correcto es 'Tú'. Selecciónalo en Kichwa.",
        "status": "ACTIVE",
        "weight": 140,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_1_MSI_02_EX",
            "type": "MULTI_SELECT_IMAGE",
            "title": "Imagen • Elegir pronombre (Tú)",
            "prompt": "Selecciona el pronombre correcto para la situación:",
            "payload": {
                "image": "https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e",
                "alt": "persona señalando a otra",
                "showImageFirst": true,
                "options": [
                    {"id": "a", "text": "Kan"},
                    {"id": "b", "text": "Ñuka"},
                    {"id": "c", "text": "Pay"}
                ],
                "correctIds": ["a"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_1_MSI_03",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Identidad • 1.1 Imagen • Pronombre (Él/Ella)",
        "activity": "RIKSINA - Mirar",
        "description": "Observa a la tercera persona en la imagen. Tu decisión es seleccionar el pronombre de 'Él/Ella' en Kichwa.",
        "status": "ACTIVE",
        "weight": 150,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_1_MSI_03_EX",
            "type": "MULTI_SELECT_IMAGE",
            "title": "Imagen • Elegir pronombre (Él/Ella)",
            "prompt": "Selecciona el pronombre correcto:",
            "payload": {
                "image": "https://images.unsplash.com/photo-1494790108377-be9c29b29330",
                "alt": "persona tercera",
                "showImageFirst": true,
                "options": [
                    {"id": "a", "text": "Kan"},
                    {"id": "b", "text": "Pay"},
                    {"id": "c", "text": "Ñuka"}
                ],
                "correctIds": ["b"]
            }
        }
    },

    {
        "step_id": "WAYRA_S1_1_OW_01",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Identidad • 1.1 Ordenar • Pronombre + Verbo (Yo)",
        "activity": "UYARINA - Escuchar",
        "description": "Tu decisión es ordenar la estructura básica del Kichwa: primero va el pronombre y luego el verbo. Forma la oración correctamente.",
        "status": "ACTIVE",
        "weight": 160,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_1_OW_01_EX",
            "type": "ORDER_WORDS",
            "title": "Ordenar • Estructura básica 01",
            "prompt": "Ordena la oración respetando Pronombre + Verbo:",
            "payload": {
                "correctOrder": ["Ñuka", "kani."],
                "items": ["kani.", "Ñuka"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_1_OW_02",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Identidad • 1.1 Ordenar • Pronombre + Verbo (Tú)",
        "activity": "UYARINA - Escuchar",
        "description": "Ordena la oración usando la estructura Pronombre + Verbo. Recuerda: 'Kan' = Tú y el verbo va después.",
        "status": "ACTIVE",
        "weight": 170,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_1_OW_02_EX",
            "type": "ORDER_WORDS",
            "title": "Ordenar • Estructura básica 02",
            "prompt": "Ordena la oración correctamente:",
            "payload": {
                "correctOrder": ["Kan", "kanki."],
                "items": ["kanki.", "Kan"]
            }
        }
    },
    {
        "step_id": "WAYRA_S1_1_OW_03",
        "unidad_seccion_id": 1,
        "unidad_id": 1,
        "configuracion_ui_ux_id": 1,
        "title": "WAYRA • Identidad • 1.1 Ordenar • Pronombre + Verbo (Él/Ella)",
        "activity": "UYARINA - Escuchar",
        "description": "Tu decisión es ordenar correctamente: pronombre de tercera persona + verbo. Recuerda: 'Pay' es Él/Ella.",
        "status": "ACTIVE",
        "weight": 180,
        "source": "",
        "exercise": {
            "exercise_id": "WAYRA_S1_1_OW_03_EX",
            "type": "ORDER_WORDS",
            "title": "Ordenar • Estructura básica 03",
            "prompt": "Ordena la oración correctamente:",
            "payload": {
                "correctOrder": ["Pay", "kan."],
                "items": ["kan.", "Pay"]
            }
        }
    }
];
