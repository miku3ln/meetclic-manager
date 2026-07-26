<div class="modal fade"
     id="modalAppointmentDetail"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content appointment-detail">

            <div class="appointment-detail__header modal-header">

                <div>

                    <h4 class="appointment-detail__title"
                        id="appointmentTitle">
                    </h4>

                    <span class="appointment-detail__status badge"
                          id="appointmentStatus">
                    </span>

                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="appointment-detail__body modal-body">

                <div class="appointment-detail__grid">

                    <div class="appointment-detail__card">

                        <div class="appointment-detail__label">
                            Cliente
                        </div>

                        <div class="appointment-detail__value"
                             id="appointmentCustomer">
                        </div>

                    </div>

                    <div class="appointment-detail__card">

                        <div class="appointment-detail__label">
                            Responsable
                        </div>

                        <div class="appointment-detail__value"
                             id="appointmentResponsible">
                        </div>

                    </div>

                    <div class="appointment-detail__card">

                        <div class="appointment-detail__label">
                            Fecha de inicio
                        </div>

                        <div class="appointment-detail__value"
                             id="appointmentStart">
                        </div>

                    </div>

                    <div class="appointment-detail__card">

                        <div class="appointment-detail__label">
                            Fecha de finalización
                        </div>

                        <div class="appointment-detail__value"
                             id="appointmentEnd">
                        </div>

                    </div>

                    <div class="appointment-detail__card">

                        <div class="appointment-detail__label">
                            Duración
                        </div>

                        <div class="appointment-detail__value"
                             id="appointmentDuration">
                        </div>

                    </div>

                    <div class="appointment-detail__card">

                        <div class="appointment-detail__label">
                            Código
                        </div>

                        <div class="appointment-detail__value"
                             id="appointmentCode">
                        </div>

                    </div>

                    <div class="appointment-detail__card appointment-detail__card--full">

                        <div class="appointment-detail__label">
                            Ubicación
                        </div>

                        <div class="appointment-detail__value"
                             id="appointmentLocation">
                        </div>

                    </div>

                </div>

                <div class="appointment-detail__section">

                    <div class="appointment-detail__label">
                        Descripción
                    </div>

                    <div class="appointment-detail__text"
                         id="appointmentDescription">
                    </div>

                </div>

                <div class="appointment-detail__section">

                    <div class="appointment-detail__label">
                        Observaciones
                    </div>

                    <div class="appointment-detail__text"
                         id="appointmentNotes">
                    </div>

                </div>

            </div>

            <div class="appointment-detail__footer modal-footer">

                <button class="btn btn-warning"
                        id="btnChangeStatus">

                    Cambiar estado

                </button>

                <button class="btn btn-primary"
                        id="btnEditAppointment">

                    Editar

                </button>

                <button class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">

                    Cerrar

                </button>

            </div>

        </div>

    </div>

</div>
