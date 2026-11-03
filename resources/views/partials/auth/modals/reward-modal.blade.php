<!-- ==========================================
     YAPITA - MODAL RECOMPENSA DE BIENVENIDA
========================================== -->

<div class="modal fade"
     id="yapitaRewardModal"
     tabindex="-1"
     aria-labelledby="yapitaRewardModalLabel"
     aria-hidden="true"
     data-bs-backdrop="static"
     data-bs-keyboard="false">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content yapita-reward-modal">

            <!-- BOTÓN CERRAR -->
            <button type="button"
                    class="btn-close yapita-reward-close"
                    data-bs-dismiss="modal"
                    aria-label="Cerrar">
            </button>

            <!-- IMAGEN DE RECOMPENSA -->
            <div class="yapita-reward-image-container">

                <img id="yapitaRewardImage"
                     src=""
                     alt="Recompensa Yapita"
                     class="yapita-reward-image">

            </div>

            <!-- CONTENIDO -->
            <div class="modal-body text-center">

                <div class="yapita-reward-badge">
                    🎉 ¡Bienvenido a Yapita!
                </div>

                <!-- NOMBRE USUARIO -->
                <h2 id="yapitaRewardUser"
                    class="yapita-reward-user">
                </h2>

                <!-- TÍTULO TAREA -->
                <h3 id="yapitaRewardTitle"
                    class="yapita-reward-title">
                </h3>

                <!-- SUBTÍTULO -->
                <p id="yapitaRewardSubtitle"
                   class="yapita-reward-subtitle">
                </p>

                <!-- PUNTOS -->
                <div class="yapita-reward-points">

                    <span class="yapita-reward-points-label">
                        HAS GANADO
                    </span>

                    <div class="yapita-reward-points-value">
                        +<span id="yapitaRewardPoints">0</span>
                    </div>

                    <span class="yapita-reward-points-text">
                        Yapitas
                    </span>

                </div>

                <!-- BOTÓN -->
                <button type="button"
                        class="btn yapita-reward-button"
                        data-bs-dismiss="modal">

                    ¡Genial! Continuar

                </button>

            </div>

        </div>

    </div>

</div>
