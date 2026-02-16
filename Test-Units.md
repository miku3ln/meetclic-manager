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

## 13. 📌 Conclusión

Este modelo está diseñado para:

- Sistemas educativos dinámicos
- Renderizado automático por tipo
- Integración con frontend flexible
- Extensión futura sin romper estructura

Es un modelo preparado para escalar como Duolingo, pero con arquitectura propia.
