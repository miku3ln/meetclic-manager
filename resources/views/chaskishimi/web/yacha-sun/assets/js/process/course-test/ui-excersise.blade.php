<!-- assets/v5/js/app/ui.exerciseView.js -->
<script>
    /**
     * Exercise View (MEJORADO SIN DAÑAR)
     * ✅ Mantiene tu lógica
     * ✅ Usa mcToastShow con ui-ux (si viene en step.ui_ux.flutter_config.toast o defaults)
     * ✅ Detecta fin de módulo:
     *    - allStepsPassed(): todos PASSED (OK total)
     *    - allStepsDone(): todos DONE (PASSED o FAILED)
     * ✅ Cuando termina (según regla), muestra toast final + evento global
     * ✅ Sigue notificando a stepsbar con mc:progress:changed
     */
    (function () {
        window.MC = window.MC || {};

        const { APP, ensureStepProgress, saveProgress, getGateIndex, isStepDone } = MC.state;
        const { normStr } = MC.utils;
        const { resolveSource } = MC.source;
        const { logEvent } = MC.logger;
        const { mountExercise } = MC.router;

        function renderExercise(step, onStepChange) {
            const root = document.getElementById("mcExerciseRoot");
            root.innerHTML = "";

            const ex = step.exercise;
            if (!ex || !ex.type) {
                root.innerHTML = `<div class="mc-chip mc-chip--bad">Este step no tiene exercise definido.</div>`;
                APP.api = null;
                return;
            }

            const prog = ensureStepProgress(step);
            const exPayload = ex.payload || {};
            const sourceResolved = resolveSource(step, exPayload);

            function updateAttemptsUI() {
                $("#mcAttemptsVal").text(prog.attempts ?? 0);
                $("#mcAttemptsMax").text(prog.attemptsMax ?? 3);
            }

            // ✅ notifica barra superior (COMPACT) y lista (VERTICAL)
            function notifyProgressChanged() {
                try { $(document).trigger("mc:progress:changed"); } catch (e) {}
                try {
                    if (MC.uiStepsList && typeof MC.uiStepsList.refreshCompactUI === "function") {
                        MC.uiStepsList.refreshCompactUI();
                    }
                } catch (e) {}
            }

            // =========================================================
            // ✅ NUEVO: UI/UX helper para Toast (sin romper si no existe)
            // - Busca configuración en step.ui_ux.flutter_config.toast
            // - Si no existe, usa defaults
            // =========================================================
            function getToastDefaults() {
                const cfg = step?.ui_ux?.flutter_config || step?.ui_ux?.config || step?.ui_ux || {};
                const toastCfg = cfg?.toast || cfg?.ui_toast || {};
                return {
                    success: {
                        type: toastCfg?.success?.type || "success",
                        icon: toastCfg?.success?.icon || "🎉",
                        title: toastCfg?.success?.title || "¡Lo lograste!",
                        msg: toastCfg?.success?.msg || "Felicidades, sigue al siguiente ejercicio."
                    },
                    error: {
                        type: toastCfg?.error?.type || "danger",
                        icon: toastCfg?.error?.icon || "❌",
                        title: toastCfg?.error?.title || "Inténtalo de nuevo",
                        msg: toastCfg?.error?.msg || "Respuesta incorrecta. Sigue intentando."
                    },
                    completed: {
                        type: toastCfg?.completed?.type || "success",
                        icon: toastCfg?.completed?.icon || "🏁",
                        title: toastCfg?.completed?.title || "¡Módulo completado!",
                        msg: toastCfg?.completed?.msg || "Terminaste todos los steps."
                    },
                    perfect: {
                        type: toastCfg?.perfect?.type || "success",
                        icon: toastCfg?.perfect?.icon || "🏆",
                        title: toastCfg?.perfect?.title || "¡Perfecto!",
                        msg: toastCfg?.perfect?.msg || "Completaste todos los steps en OK."
                    }
                };
            }

            function showToast(kind, override = {}) {
                const d = getToastDefaults();
                const base = d[kind] || d.success;
                const payload = { ...base, ...override };
                try { mcToastShow(payload); } catch (e) {}
            }

            // =========================================================
            // ✅ NUEVO: Detectar fin del módulo
            // - "OK total" = todos PASSED
            // - "Terminado" = todos DONE (PASSED o FAILED)
            // =========================================================
            function allStepsPassed() {
                const steps = APP.data?.steps || [];
                if (!steps.length) return false;
                return steps.every(s => ensureStepProgress(s).status === "PASSED");
            }

            function allStepsDone() {
                const steps = APP.data?.steps || [];
                if (!steps.length) return false;
                return steps.every(s => isStepDone(s));
            }

            function onModuleCompleted(mode /* "DONE" | "PASSED" */) {
                // DONE: todos terminaron (PASSED+FAILED)
                // PASSED: todos OK
                if (mode === "PASSED") {
                    showToast("perfect");
                } else {
                    showToast("completed");

                    const ans = APP.api.getAnswer();
                    finishSectionData({
                        data:{
                            answerData:ans
                        }
                    })
                }

                // Evento global (por si quieres abrir modal, ir a unidad siguiente, etc.)
                try {
                    $(document).trigger("mc:module:completed", [{
                        mode,
                        totalSteps: (APP.data?.steps || []).length,
                        unitId: APP.data?.unit_id,
                        unitSectionId: APP.data?.unit_section_id
                    }]);
                } catch (e) {}
            }

            // ✅ regla que usas para “ya terminó”
            // Cambia a "PASSED" si quieres 100% solo cuando todos sean PASSED
            const MODULE_DONE_RULE = "DONE"; // "DONE" | "PASSED"

            function checkModuleCompletion() {
                if (MODULE_DONE_RULE === "PASSED") {
                    if (allStepsPassed()) onModuleCompleted("PASSED");
                    return;
                }
                if (allStepsDone()){
                    onModuleCompleted("DONE");
                };
            }

            // =========================================================
            // UI Render
            // =========================================================
            const top = document.createElement("div");
            top.className = "mc-ex__top";
            top.innerHTML = `
      <div class="mc-ex__meta">
        <h3 class="mc-ex__metaTitle">${normStr(step.title)}</h3>
        <div class="mc-ex__metaSub">
          <div><strong>${normStr(step.activity)}</strong></div>
          <div>${normStr(step.description)}</div>
          <div style="margin-top:6px;">
            <span class="mc-chip mc-chip--info">Tipo: <strong>${normStr(ex.type)}</strong></span>
            <span class="mc-chip">
              Intentos: <strong id="mcAttemptsVal">${prog.attempts}</strong>/<strong id="mcAttemptsMax">${prog.attemptsMax}</strong>
            </span>
          </div>

          ${sourceResolved ? `
            <div class="mc-audio">
              <audio class="mc-audio__player" controls preload="none" src="${sourceResolved}"></audio>
              <div class="mc-audio__src" title="${sourceResolved}">${sourceResolved}</div>
            </div>
          ` : ``}
        </div>
      </div>

      <div class="errors">
        <div id="mcExResult" class="mc-ex__result" style="display:none;"></div>
      </div>

      <div class="mc-ex__controls">
        <button class="mc-btn mc-btn--primary" id="mcBtnVerify">Verificar</button>
        <button class="mc-btn" id="mcBtnShowAnswer">🧾 Ver respuesta (JSON)</button>
        <button class="mc-btn" id="mcBtnShowHistory">📜 Historial step</button>
      </div>
    `;
            root.appendChild(top);

            updateAttemptsUI();

            const stage = document.createElement("div");
            stage.className = "mc-ex__stage";
            stage.innerHTML = `
      <div class="mc-ex__prompt">${normStr(ex.prompt || "Resuelve:")}</div>
      <div id="mcExStage"></div>
    `;
            root.appendChild(stage);

            const ansBox = document.createElement("div");
            ansBox.className = "mc-ex__stage";
            ansBox.style.display = "none";
            ansBox.innerHTML = `
      <div class="mc-ex__prompt">Respuesta del usuario (JSON)</div>
      <textarea class="mc-loader__textarea" id="mcUserAnswerBox" style="min-height:130px;"></textarea>
    `;
            root.appendChild(ansBox);

            const histBox = document.createElement("div");
            histBox.className = "mc-ex__stage";
            histBox.style.display = "none";
            histBox.innerHTML = `
      <div class="mc-ex__prompt">Historial del step (máx. 250 eventos)</div>
      <textarea class="mc-loader__textarea" id="mcUserHistoryBox" style="min-height:150px;"></textarea>
    `;
            root.appendChild(histBox);

            // Mount exercise
            const mount = document.getElementById("mcExStage");
            APP.api = mountExercise(mount, ex);

            // Rehidratar con lastAnswer
            try {
                if (APP.api && typeof APP.api.setAnswer === "function" && prog.lastAnswer) {
                    APP.api.setAnswer(prog.lastAnswer);
                }
            } catch (e) {
                console.warn("UI restore failed:", e);
            }

            $("#mcBtnShowAnswer").off("click").on("click", () => {
                if (!APP.api) return;
                const ans = APP.api.getAnswer();
                ansBox.style.display = ansBox.style.display === "none" ? "block" : "none";
                $("#mcUserAnswerBox").val(JSON.stringify(ans, null, 2));
            });

            $("#mcBtnShowHistory").off("click").on("click", () => {
                histBox.style.display = histBox.style.display === "none" ? "block" : "none";
                $("#mcUserHistoryBox").val(JSON.stringify(prog.history || [], null, 2));
            });

            $("#mcBtnVerify").off("click").on("click", () => {
                if (!APP.api) return;

                // Bloqueo si ya está resuelto
                if (prog.status !== "IN_PROGRESS") {
                    const msg = prog.status === "PASSED"
                        ? "Este step ya está aprobado ✅."
                        : `Este step ya está marcado como NO PASADO ❌ (${prog.attemptsMax} intentos).`;

                    $("#mcExResult").show()
                        .removeClass("is-ok is-bad")
                        .addClass(prog.status === "PASSED" ? "is-ok" : "is-bad")
                        .text(msg);

                    updateAttemptsUI();
                    notifyProgressChanged();
                    logEvent(step, { action: "VERIFY_BLOCKED_ALREADY_DONE" });

                    // ✅ NUEVO: si por alguna razón ya estaba todo terminado
                    checkModuleCompletion();
                    return;
                }

                const answer = APP.api.getAnswer();
                const result = APP.api.check();

                prog.verifiedCount += 1;
                prog.lastAnswer = answer;
                prog.lastResult = result;
                logEvent(step, { action: "VERIFY", ok: !!result.ok, answer, result });

                const $res = $("#mcExResult");
                $res.show().toggleClass("is-ok", !!result.ok).toggleClass("is-bad", !result.ok);

                if (result.ok) {
                    // ✅ Toast usando UI/UX (si existe) o defaults
                    showToast("success");

                    prog.status = "PASSED";
                    saveProgress();
                    updateAttemptsUI();
                    notifyProgressChanged();

                    $res.text("✅ Correcto. Pasas al siguiente.");
                    logEvent(step, { action: "STEP_PASSED" });

                    // ✅ NUEVO: comprobar si terminó el módulo
                    checkModuleCompletion();

                    const nextGate = getGateIndex();
                    if (nextGate !== APP.activeIndex) onStepChange(nextGate);
                    return;
                }

                // Incorrecto
                prog.attempts += 1;
                updateAttemptsUI();

                const left = Math.max(0, prog.attemptsMax - prog.attempts);

                if (prog.attempts >= prog.attemptsMax) {
                    prog.status = "FAILED";
                    saveProgress();
                    updateAttemptsUI();
                    notifyProgressChanged();

                    // ✅ Toast error (UI/UX si existe)
                    showToast("error", {
                        msg: `Llegaste a ${prog.attemptsMax} intentos. Este step queda NO PASADO y puedes continuar.`
                    });

                    $res.text(`❌ Incorrecto. Llegaste a ${prog.attemptsMax} intentos. Este step queda NO PASADO y puedes continuar.`);
                    logEvent(step, { action: "STEP_FAILED_MAX_ATTEMPTS" });

                    // ✅ NUEVO: comprobar si terminó el módulo (DONE incluye FAILED)
                    checkModuleCompletion();

                    const nextGate = getGateIndex();
                    if (nextGate !== APP.activeIndex) onStepChange(nextGate);
                    return;
                }

                saveProgress();
                notifyProgressChanged();

                // ✅ Toast error suave (si quieres)
                // showToast("error", { msg: `Te quedan ${left} intento(s).` });

                $res.text(`❌ Incorrecto. Te quedan ${left} intento(s).`);
                logEvent(step, { action: "STEP_ATTEMPT_FAILED", attempts: prog.attempts, left });
            });

            // Si ya estaba resuelto, mostrar estado
            if (isStepDone(step)) {
                const msg = prog.status === "PASSED"
                    ? "✅ Este step ya está aprobado."
                    : "❌ Este step quedó NO PASADO (3 intentos). Puedes continuar.";

                $("#mcExResult").show()
                    .removeClass("is-ok is-bad")
                    .addClass(prog.status === "PASSED" ? "is-ok" : "is-bad")
                    .text(msg);

                updateAttemptsUI();
                notifyProgressChanged();

                // ✅ NUEVO: comprobar si al entrar ya terminó el módulo
                checkModuleCompletion();
            }
        }

        MC.uiExerciseView = { renderExercise };
    })();
</script>
