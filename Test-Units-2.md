# 📘 Manual Técnico – Modelo de Base de Datos

## 🎯 Sistema de Ejercicios – Riksichishun

---

## 1. 📌 Introducción

Este documento describe el modelo de base de datos utilizado para gestionar los ejercicios interactivos del sistema *
*Riksichishun**.

El modelo permite:

- Organizar ejercicios por unidad y sección.
- Definir múltiples tipos de ejercicios (Drag, FillBlank, Hotspot, etc.).
- Configurar reglas dinámicas mediante JSON.
- Asociar términos y respuestas correctas.
- Integrar el diccionario lingüístico.
- Permitir escalabilidad y reutilización de contenido.

---

## 2. 🏗 Arquitectura General del Modelo

El flujo lógico del modelo es:

Unidad
↓
Sección
↓
Step (language_exercise_step)
↓
Ejercicio (language_exercise)
↓
Términos / Hotspots

### Relaciones principales

- `language_exercise_step (1) → (N) language_exercise`
- `language_exercise (1) → (N) language_exercise_term`
- `language_exercise (1) → (N) language_exercise_hotspot`
- `language_exercise_term (N) → (1) dictionary_by_words`
- `language_exercise_hotspot (N) → (1) dictionary_by_words`

---

## 3. 📚 Tabla: `language_exercise_step`

### 🎯 Propósito

Representa el **bloque pedagógico** dentro de una unidad y sección.

Es el contenedor estructural del ejercicio.

### 📌 Responsabilidades

- Determinar a qué unidad y sección pertenece.
- Definir el orden del step.
- Asociar configuración UI/UX.
- Controlar estado (`ACTIVE` / `INACTIVE`).

### 🔑 Campos Importantes

| Campo                                  | Descripción           |
|----------------------------------------|-----------------------|
| `id`                                   | Identificador único   |
| `step_code`                            | Código único del step |
| `language_course_unit_id`              | Unidad                |
| `language_course_unit_section_id`      | Sección               |
| `language_course_unit_section_item_id` | Item (opcional)       |
| `configuracion_ui_ux_id`               | Configuración visual  |
| `weight`                               | Orden                 |
| `status`                               | Estado                |
| `source`                               | Recurso asociado      |

### 🧠 Concepto Mental

> Es el contenedor estructural del ejercicio.

---

## 4. 📚 Tabla: `language_exercise`

### 🎯 Propósito

Define el ejercicio específico dentro del step.

Aquí se configura el tipo y comportamiento del ejercicio.

### 📌 Responsabilidades

- Definir tipo de ejercicio.
- Contener reglas de configuración (JSON).
- Asociar título e instrucciones.

### 🔑 Campos Importantes

| Campo           | Descripción                             |
|-----------------|-----------------------------------------|
| `id`            | Identificador                           |
| `step_id`       | Relación con step                       |
| `exercise_code` | Código único                            |
| `type`          | Tipo (`DRAG_MATCH`, `FILL_BLANK`, etc.) |
| `title`         | Título                                  |
| `prompt`        | Instrucción                             |
| `payload_json`  | Configuración dinámica                  |

### 🧠 Concepto Mental

> Aquí vive el motor y configuración del ejercicio.

---

## 5. 📚 Tabla: `language_exercise_term`

### 🎯 Propósito

Contiene la lógica de respuestas y piezas del ejercicio.

Aquí están las opciones, palabras, respuestas correctas y asociaciones.

### 📌 Responsabilidades

- Definir opciones.
- Definir respuestas correctas.
- Agrupar términos por pareja.
- Asociar palabras del diccionario.
- Definir orden visual.

### 🔑 Campos Importantes

| Campo                | Descripción                                          |
|----------------------|------------------------------------------------------|
| `exercise_id`        | A qué ejercicio pertenece                            |
| `role`               | `LEFT`, `RIGHT`, `OPTION`, `ANSWER`, `WORD`, `LABEL` |
| `term_side`          | `KICHWA`, `SPANISH`, `OTHER`                         |
| `group_index`        | Agrupación lógica                                    |
| `sort_order`         | Orden visual                                         |
| `dictionary_word_id` | Enlace al diccionario                                |
| `text_value`         | Texto                                                |
| `image_url`          | Imagen                                               |
| `is_correct`         | Indica si es correcta                                |
| `extra_json`         | Configuración adicional                              |

### 🧠 Concepto Mental

> Aquí viven las piezas del rompecabezas y la clave de corrección.

---

## 6. 📚 Tabla: `language_exercise_hotspot`

### 🎯 Propósito

Define puntos interactivos sobre imágenes.

### 📌 Responsabilidades

- Definir coordenadas.
- Determinar puntos correctos.
- Asociar palabra del diccionario.

### 🔑 Campos Importantes

| Campo                | Descripción            |
|----------------------|------------------------|
| `exercise_id`        | Relación con ejercicio |
| `hotspot_code`       | Código interno         |
| `x_pct`              | Posición X (%)         |
| `y_pct`              | Posición Y (%)         |
| `radius_pct`         | Radio (%)              |
| `label`              | Etiqueta               |
| `dictionary_word_id` | Enlace diccionario     |
| `is_correct`         | Correcto / Incorrecto  |

### 🧠 Concepto Mental

> Define zonas clickeables y su validación.

---

## 7. 🔄 Flujo de Ejecución en el Sistema

1. Se consulta `language_exercise_step`.
2. Se obtiene el `language_exercise` asociado.
3. Según `type`:
    - Se cargan `terms`
    - O se cargan `hotspots`
4. El frontend renderiza dinámicamente.
5. Se valida usando:
    - `is_correct`
    - `group_index`
6. Se registra progreso.

---

## 8. 📊 Tipos de Ejercicio Soportados

- `DRAG_MATCH`
- `FILL_BLANK`
- `HAYSTACK_PICK`
- `IMAGE_HOTSPOT_PICK`
- `MULTI_SELECT`
- `MULTI_SELECT_IMAGE`
- `ORDER_WORDS`

Cada tipo interpreta `language_exercise_term` de manera distinta.

---

## 9. 🧩 Cómo Funciona la Lógica Interna

### 🔹 DRAG_MATCH

- `LEFT` + `RIGHT`
- Mismo `group_index` = pareja correcta

### 🔹 MULTI_SELECT

- `role = OPTION`
- `is_correct = 1` marca correctas

### 🔹 FILL_BLANK

- `role = ANSWER`
- `is_correct = 1`

### 🔹 HOTSPOT

- Validación por `is_correct` en hotspots

---

## 10. 🛡 Reglas de Integridad

- Borrar Step → borra Exercises (`CASCADE`)
- Borrar Exercise → borra Terms y Hotspots (`CASCADE`)
- `dictionary_word_id` es opcional
- `exercise_code` y `step_code` son únicos

---

## 11. 🚀 Ventajas del Modelo

- ✅ Escalable
- ✅ Modular
- ✅ Separación de configuración y contenido
- ✅ Integrable con diccionario
- ✅ Soporta UI dinámica
- ✅ Compatible con arquitectura hexagonal

---

## 12. 🧠 Filosofía del Modelo

- **Step** = estructura pedagógica
- **Exercise** = motor de actividad
- **Term** = contenido + corrección
- **Hotspot** = interacción espacial

---


# 13. 📊 Tipos de Ejercicio Soportados (Vista Comparativa IA-Ready)

A continuación se presenta una matriz comparativa que explica cada tipo de ejercicio
desde 4 perspectivas:

- 🎯 Qué hace
- 🗃️ Cómo se representa en Base de Datos
- 📦 Ejemplo JSON (payload)
- 👁️ Cómo se ve para el usuario

---

| Tipo | 🎯 Qué Hace | 🗃️ Lógica en BD | 📦 Ejemplo JSON | 👁️ Cómo se Vería |
|------|-------------|----------------|----------------|----------------|
| `DRAG_MATCH` | Emparejar elementos izquierda-derecha | `role=LEFT` y `role=RIGHT` con mismo `group_index` | `{ "pairs":[{"left":"Imanalla?","right":"¿Cómo estás?"}] }` | Usuario arrastra "Imanalla?" hacia "¿Cómo estás?" |
| `FILL_BLANK` | Completar un espacio en blanco | `role=ANSWER`, `is_correct=1` | `{ "text":"Alli ____","ignoreCase":true }` | Texto: "Alli ____" → usuario escribe respuesta |
| `HAYSTACK_PICK` | Elegir palabra correcta dentro de un grupo | `role=OPTION`, `is_correct=1` | `{ "question":"Manzana","options":["apil","wasi"],"correct":["apil"] }` | Muestra varias palabras; usuario selecciona la correcta |
| `MULTI_SELECT` | Seleccionar múltiples opciones correctas | `role=OPTION`, varios `is_correct=1` | `{ "options":["Wasi","Maki"],"correctIds":["a","b"] }` | Casillas tipo checkbox |
| `MULTI_SELECT_IMAGE` | Igual que MULTI_SELECT pero con imagen contexto | Igual que MULTI_SELECT + imagen en payload | `{ "image":"frutas.jpg","options":[...],"correctIds":["a"] }` | Imagen arriba + opciones debajo |
| `ORDER_WORDS` | Ordenar palabras correctamente | `role=WORD` + validación por orden exacto | `{ "items":["Ñuka","apil"],"correctOrder":["Ñuka","miku","apil"] }` | Usuario reordena palabras arrastrando |
| `IMAGE_HOTSPOT_PICK` | Seleccionar zona correcta en imagen | `language_exercise_hotspot` con `is_correct=1` | `{ "image":"cuerpo.png","prompt":"Selecciona ñawi" }` | Imagen interactiva con puntos clickeables |

---

# 🔎 Explicación Técnica Resumida

## 🔹 DRAG_MATCH
- Se valida por coincidencia de `group_index`.
- No requiere `is_correct`.
- Debe haber mismo número de LEFT y RIGHT.

---

## 🔹 FILL_BLANK
- Validación por texto.
- Puede usar `ignoreCase` y `trim`.
- Puede aceptar múltiples respuestas si hay varias filas ANSWER.

---

## 🔹 HAYSTACK_PICK
- Selección única o múltiple.
- Validación por comparación de sets.
- Usa `is_correct`.

---

## 🔹 MULTI_SELECT
- Permite múltiples respuestas correctas.
- Validación exacta por conjunto.
- Requiere al menos un `is_correct=1`.

---

## 🔹 MULTI_SELECT_IMAGE
- Igual que MULTI_SELECT.
- Se añade imagen en `payload_json`.
- Puede usar `showImageFirst`.

---

## 🔹 ORDER_WORDS
- Validación por orden exacto.
- Comparar array final con `correctOrder`.
- No usar `is_correct`.

---

## 🔹 IMAGE_HOTSPOT_PICK
- Validación espacial.
- Usa tabla `language_exercise_hotspot`.
- Coordenadas obligatorias.
- Al menos un hotspot correcto.

---

# 📌 Regla General para IA

Si una IA genera ejercicios:

- Debe respetar la lógica de validación según `type`.
- No mezclar reglas entre tipos.
- Validar que los campos obligatorios estén presentes.
- Mantener coherencia entre payload y BD.

---

## 14. 📌 Conclusión

Este modelo está diseñado para:

- Sistemas educativos dinámicos
- Renderizado automático por tipo
- Integración con frontend flexible
- Extensión futura sin romper estructura


# 🔐 Contrato Formal de Validación por Tipo (IA-Ready)

Esta matriz define las reglas obligatorias y restricciones por cada `type`.

Una IA o backend debe validar estas reglas antes de aceptar un ejercicio.

---

| Tipo | ✅ Requiere | 🚫 Prohibido / No Usar | 🧠 Regla de Validación | 📌 Observaciones Técnicas |
|------|------------|------------------------|------------------------|--------------------------|
| `DRAG_MATCH` | - Mínimo 1 `LEFT`  <br> - Mínimo 1 `RIGHT` <br> - Mismo número de LEFT y RIGHT <br> - `group_index` obligatorio | - No usar `is_correct` | Coincidencia por `group_index` | Cada pareja correcta comparte mismo `group_index` |
| `FILL_BLANK` | - Mínimo 1 `ANSWER` <br> - `text` en payload_json | - No usar `group_index` | Comparación texto exacto (según reglas ignoreCase/trim) | Puede haber múltiples ANSWER válidos |
| `HAYSTACK_PICK` | - Mínimo 2 `OPTION` <br> - Al menos 1 `is_correct=1` | - No usar `group_index` | Comparación de selección vs conjunto correcto | Puede ser selección única o múltiple |
| `MULTI_SELECT` | - Mínimo 2 `OPTION` <br> - Al menos 1 `is_correct=1` | - No usar `group_index` | Validación por igualdad de conjuntos (sin importar orden) | Si usuario selecciona menos o más opciones → incorrecto |
| `MULTI_SELECT_IMAGE` | - Igual que MULTI_SELECT <br> - `image` obligatorio en payload_json | - No usar `group_index` | Igual que MULTI_SELECT | `image` define contexto visual |
| `ORDER_WORDS` | - `items` en payload_json <br> - `correctOrder` obligatorio | - No usar `is_correct` <br> - No usar `group_index` | Comparación exacta de orden | Orden debe coincidir exactamente |
| `IMAGE_HOTSPOT_PICK` | - Mínimo 1 hotspot <br> - Al menos 1 `is_correct=1` <br> - `x_pct` y `y_pct` obligatorios | - No usar `group_index` | Validación por coincidencia de hotspot correcto | Coordenadas deben estar en rango 0–100 |

---

# 🛡 Validaciones Globales Obligatorias

Estas reglas aplican a todos los tipos:

| Regla | Descripción |
|-------|------------|
| `exercise_code` único | No puede repetirse |
| `step_code` único | No puede repetirse |
| FK válidas | `step_id` debe existir |
| Cascade activo | Borrar step borra exercise |
| Coherencia payload | El JSON debe coincidir con el `type` |

---

# ⚠ Casos Inválidos Detectables por IA

| Caso | Motivo |
|------|--------|
| DRAG_MATCH con LEFT ≠ RIGHT | Estructura inconsistente |
| MULTI_SELECT sin correctos | Ejercicio imposible |
| FILL_BLANK sin ANSWER | No validable |
| ORDER_WORDS sin correctOrder | No se puede validar |
| HOTSPOT sin coordenadas | No renderizable |

---

# 🎯 Interpretación Formal

La validación siempre depende del `type`.

Regla universal:


Es un modelo preparado para escalar como Duolingo, pero con arquitectura propia.
