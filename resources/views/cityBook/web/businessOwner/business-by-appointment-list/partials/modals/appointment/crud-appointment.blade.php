<div class="modal fade" id="modalAppointmentCreate">

    <div class="modal-dialog">

        <div class="modal-content">


            <div class="modal-header">

                <h5 class="modal-title">
                    Nueva cita
                </h5>


                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body">


                <form id="formAppointment">
                    <div class="row g-4">


                        <!-- CLIENTE -->
                        <div class="col-lg-12">

                            <div class="invoice-field">

                                <label class="invoice-field__label">
                                    Tipo  *

                                </label>


                                <select
                                    id="appointmentType"
                                    class="form-select invoice-field__control required">
                                </select>


                            </div>

                        </div>
                    </div>
                    <div class="row g-4">


                        <!-- CLIENTE -->
                        <div class="col-lg-12">

                            <div class="invoice-field">

                                <label class="invoice-field__label">
                                    Cliente *

                                </label>


                                <select
                                    id="managerCustomer"
                                    class="form-select invoice-field__control required">
                                </select>


                            </div>

                        </div>
                    </div>

                    <input type="hidden"
                           id="appointmentDate">
                    <div class="mb-3">

                        <label class="form-label">
                            Hora inicio *
                        </label>


                        <div id="startTime"></div>


                    </div>


                    <div class="mb-3">

                        <label  class="form-label">
                            Código *
                        </label>

                        <input type="text"
                               class="form-control required"
                               id="code">

                    </div>


                    <div class="mb-3">

                             <label  class="form-label">
                            Título *
                        </label>

                        <input type="text"
                               class="form-control required"
                               id="title">

                    </div>


                    <div class="mb-3">

                             <label  class="form-label">
                            Descripción *
                        </label>

                        <textarea class="form-control required"
                                  id="description">

                        </textarea>

                    </div>


                    <div class="mb-3">

                             <label  class="form-label">
                            Ubicación *
                        </label>

                        <input type="text"
                               class="form-control required"
                               id="location">

                    </div>


                    <div class="mb-3">

                             <label  class="form-label">
                            Notas *
                        </label>

                        <textarea class="form-control required"
                                  id="notes">

                        </textarea>

                    </div>


                </form>


            </div>


            <div class="modal-footer">


                <button class="btn btn-secondary"
                        data-bs-dismiss="modal">

                    Cancelar

                </button>


                <button class="btn btn-primary"
                        id="btnSaveAppointment">

                    Guardar

                </button>


            </div>


        </div>

    </div>

</div>
