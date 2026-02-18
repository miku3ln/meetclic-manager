<div class="container--manager-number-convert">
    <div class="row">
        <div class="col-md-8">
            <div class="mc-dict__bar">
                <div class="mc-dict__bar-left">
                    <span class="mc-dict__badge-icon">🔢</span>
                    <div class="mc-dict__titlebox">
                        <div class="mc-dict__title">Convertidor Kichwa ↔ Número</div>
                        <div class="mc-dict__subtitle">Ingresa un valor y obtén palabra, pronunciación y
                            didáctica.
                        </div>
                    </div>
                </div>

                <!-- Toggle -->
                <div class="mc-dict__bar-right">
                    <div class="mc-dict__toggle" role="group" aria-label="Tipo de entrada">
                        <button
                            type="button"
                            class="mc-dict__toggle-btn"
                            :class="{ 'mc-dict__toggle-btn--active': modelChange.type === 'numeric' }"
                            @click="setType('numeric')"
                        >
                            Números
                        </button>
                        <button
                            type="button"
                            class="mc-dict__toggle-btn"
                            :class="{ 'mc-dict__toggle-btn--active': modelChange.type === 'kichwa' }"
                            @click="setType('kichwa')"
                        >
                            Kichwa
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <!-- Input row -->
            <div class="mc-dict__row">
                <div class="mc-dict__inputwrap">
                    <input
                        class="mc-dict__input"
                        :type="modelChange.type === 'kichwa'?'text':'number'"
                        v-model.trim="modelChange.value"
                        :placeholder="placeholderText"
                        @keyup.enter="onConvertNumberKichwa()"
                    />
                </div>

                <button class="mc-dict__btn" type="button" @click="onConvertNumbersKichwa()" :disabled="isLoading">
                    <span v-if="!isLoading">Convertir</span>
                    <span v-else>Cargando...</span>
                </button>
            </div>

        </div>

        <div class="col-md-6">
            <div v-if="lastResponse && !lastResponse.success" class="mc-dict__alert mc-dict__alert--error">
                <span class="mc-dict__alert-ico">⚠️</span>
                <span class="mc-dict__alert-text"><?php echo '{{ lastResponse.message}}' ?></span>
            </div>

            <!-- Card (solo si ok) -->
            <div v-if="lastResponse && lastResponse.success" class="mc-dict__card">
                <!-- header -->
                <div class="mc-dict__card-head">
                    <div class="mc-dict__card-icon">📘</div>

                    <div class="mc-dict__card-titlebox">
                        <div class="mc-dict__word">
                            <?php echo '{{ cardTitleWord }}' ?>
                        </div>
                        <div class="mc-dict__word-sub">
          <span class="mc-dict__chip">
           <?php echo '  {{ cardSubInfo }}' ?>
          </span>
                        </div>
                    </div>

                    <div class="mc-dict__card-input">
                        <input class="mc-dict__miniinput" type="text" :value="modelChange.value" disabled/>
                    </div>
                </div>

                <div class="mc-dict__divider"></div>

                <!-- Pronunciación -->
                <div class="mc-dict__section">
                    <div class="mc-dict__section-title">
                        <span class="mc-dict__section-ico">🔊</span>
                        <span>Pronunciación</span>
                    </div>

                    <div class="mc-dict__list">
                        <div
                            v-for="(p, idx) in pronunciations"
                            :key="'p-'+idx"
                            class="mc-dict__list-item"
                        >
                            <span class="mc-dict__linklike"> <?php echo '{{ p.value }}' ?></span>
                            <span class="mc-dict__muted">( <?php echo '{{ p.type }}' ?>)</span>
                            <span
                                class="mc-dict__muted mc-dict__muted--block"> <?php echo '{{ p.descripcion }}' ?></span>
                        </div>
                    </div>
                </div>

                <!-- Didáctica -->
                <div class="mc-dict__section">
                    <div class="mc-dict__section-title">
                        <span class="mc-dict__section-ico">📌</span>
                        <span>Didáctica</span>
                    </div>

                    <div class="mc-dict__text">
                        <div class="mc-dict__kv">
                            <span class="mc-dict__kv-k">Scope:</span>
                            <span class="mc-dict__kv-v"> <?php echo '{{ didacticScopeText }}' ?></span>
                        </div>
                        <div class="mc-dict__kv">
                            <span class="mc-dict__kv-k">Uso:</span>
                            <span class="mc-dict__kv-v"> <?php echo '{{ didacticText }}' ?></span>
                        </div>
                    </div>
                </div>

                <!-- Detalles adicionales -->
                <div class="mc-dict__section not-view">
                    <div class="mc-dict__section-title">
                        <span class="mc-dict__section-ico">ℹ️</span>
                        <span>Detalles adicionales</span>
                    </div>

                    <div class="mc-dict__text">
                        <div class="mc-dict__kv">
                            <span class="mc-dict__kv-k">Entrada:</span>
                            <span
                                class="mc-dict__kv-v"> <?php echo '{{ lastResponse.data.input.type }}' ?></span>
                        </div>
                        <div class="mc-dict__kv">
                            <span class="mc-dict__kv-k">Resultado:</span>
                            <span class="mc-dict__kv-v"> <?php echo '{{ cardResultText }}' ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
