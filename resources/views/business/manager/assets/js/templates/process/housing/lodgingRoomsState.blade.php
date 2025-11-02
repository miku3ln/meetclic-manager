<script type="text/x-template" id="lodging-rooms-state-template">

    <div>
        <b-modal
            hide-footer
            id="modal-lodging-rooms-state"
            ref="refLodgingRoomsStateModal"
            size="xl"
        <?php echo '@show="_showModal"' ?>
            <?php echo '@hidden="_hideModal"' ?>

            <?php echo '@ok="_saveModal"' ?>
        >
            <template slot="modal-title">


                <label v-html="labelsConfig.title"></label>
            </template>
            <div id="manager-modal">


                <div v-if="allowProcess">
                    <b-container fluid>

                        <div class="content-row-manager-buttons">

                            <button
                                v-if="showManager"
                                type="button"
                                class="btn "
                                :class="{'btn-success':!showManager,'btn-danger':showManager}"
                                v-on:click="_viewManager(showManager?2:1)">
                                <?php echo "{{showManager?'Regresar':'Nuevo'}}"?>
                            </button>


                            <button v-if="showManager" type="button"
                                    :disabled="!validateForm()"
                                    class="btn btn-success " v-on:click="_saveModel()">
                                <?php echo "{{lblBtnSave}}"?>
                            </button>
                        </div>

                        <tabs @change="_tapManager" v-if="!showManager">
                            <tab :key="tab.value" v-bind:id="'tab-manager-'+tab.value" v-bind:title="tab.text"
                                 v-for="(tab,index) in lodgingRoomLevelsManager.lodgingRoomLevelsData" class="manager-tabs">
                                <div v-if="lodgingRoomLevelsManager.loading">
                                    Cargando.....
                                </div>
                                <div v-else>


                                    <b-col md="12" v-if="lodgingRoomLevelsManager.data.length==0">
                                        <alert type="warning"><b>Advertencia!</b> No existe resultados.</alert>
                                    </b-col>
                                    <div v-else>
                                        <b-row>
                                            <b-col class="sm-6--full" md="3" v-if="filters.status=='ALL'">
                                                <div class="card card--statistics card--total-rooms">
                                                    <div class="card-content">
                                                        <div class="card-body">
                                                            <div class="media d-flex">
                                                                <div class="align-self-top">
                                                                    <i class="fas fa-bed warning font-large-4"></i>
                                                                </div>
                                                                <div class="media-body text-right align-self-bottom ">
                                                                    <span
                                                                        class="d-block mb-1 font-medium-1"><?php echo '{{staticsLodgingRooms.total.label}}' ?></span>
                                                                    <h1 class="warning"><?php echo ' {{staticsLodgingRooms.total.count}}' ?></h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </b-col>
                                            <b-col class="sm-6--full" md="3"
                                                   v-if="filters.status=='CLEANING' || filters.status=='ALL'">
                                                <div class="card card--statistics card--cleaning">
                                                    <div class="card-content">
                                                        <div class="card-body">
                                                            <div class="media d-flex">
                                                                <div class="align-self-top">
                                                                    <i class="fas fa-bed info font-large-4"></i>
                                                                </div>
                                                                <div class="media-body text-right align-self-bottom ">
                                                                    <span
                                                                        class="d-block mb-1 font-medium-1"><?php echo '{{staticsLodgingRooms.cleaning.label}}' ?></span>
                                                                    <h1 class="info"><?php echo ' {{staticsLodgingRooms.cleaning.count}}' ?></h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </b-col>
                                            <b-col class="sm-6--full" md="3"
                                                   v-if="filters.status=='OCCUPIED' || filters.status=='ALL'">
                                                <div class="card card--statistics card--occupied">
                                                    <div class="card-content">
                                                        <div class="card-body">
                                                            <div class="media d-flex">
                                                                <div class="align-self-top">
                                                                    <i class="fas fa-bed danger font-large-4"></i>
                                                                </div>
                                                                <div class="media-body text-right align-self-bottom ">
                                                                    <span
                                                                        class="d-block mb-1 font-medium-1"><?php echo '{{staticsLodgingRooms.occupied.label}}' ?></span>
                                                                    <h1 class="danger"><?php echo ' {{staticsLodgingRooms.occupied.count}}' ?></h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </b-col>
                                            <b-col class="sm-6--full" md="3"
                                                   v-if="filters.status=='FREE' || filters.status=='ALL'">
                                                <div class="card card--statistics card--free">
                                                    <div class="card-content">
                                                        <div class="card-body">
                                                            <div class="media d-flex">
                                                                <div class="align-self-top">
                                                                    <i class="fas fa-bed success font-large-4"></i>
                                                                </div>
                                                                <div class="media-body text-right align-self-bottom ">
                                                                    <span
                                                                        class="d-block mb-1 font-medium-1"><?php echo '{{staticsLodgingRooms.free.label}}' ?></span>
                                                                    <h1 class="success"><?php echo ' {{staticsLodgingRooms.free.count}}' ?></h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </b-col>
                                        </b-row>
                                        <b-row>
                                            <b-col class="sm-12--full" md="4"
                                                   v-for="(room,i) in  lodgingRoomLevelsManager.data">
                                                <div class="card card--cleaning pointer" v-if="room.status=='CLEANING'"
                                                     v-on:click="_cleaner(room)">
                                                    <div class="card-content">
                                                        <div class="card-body">
                                                            <div class="media d-flex">
                                                                <div class="align-self-top">
                                                                    <i class="fas fa-bed icon-opacity info font-large-4"></i>
                                                                </div>
                                                                <div class="media-body text-right align-self-bottom ">
                                                                    <span
                                                                        class="d-block mb-1 font-medium-1"><?php echo '{{room.lodging_type_of_room}}' ?></span>
                                                                    <h1 class="info"><?php echo ' Cuarto #{{room.room_number}}' ?></h1>
                                                                    <span class="info ">Limpieza</span>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card card--occupied" v-if="room.status=='OCCUPIED'">
                                                    <div class="card-content">
                                                        <div class="card-body">
                                                            <div class="media d-flex">
                                                                <div class="align-self-top">
                                                                    <i class="fas fa-lock icon-opacity danger font-large-4"></i>
                                                                </div>
                                                                <div class="media-body text-right align-self-bottom ">
                                                                    <span
                                                                        class="d-block mb-1 font-medium-1"><?php echo '{{room.lodging_type_of_room}}' ?></span>
                                                                    <h1 class="danger"><?php echo ' Cuarto #{{room.room_number}}' ?></h1>
                                                                    <span class="danger ">Ocupado</span>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card card--free" v-if="room.status=='FREE'">
                                                    <div class="card-content">
                                                        <div class="card-body">
                                                            <div class="media d-flex">
                                                                <div class="align-self-top">
                                                                    <i class="fas fa-bed icon-opacity success font-large-4"></i>
                                                                </div>
                                                                <div class="media-body text-right align-self-bottom ">
                                                                    <span
                                                                        class="d-block mb-1 font-medium-1"><?php echo '{{room.lodging_type_of_room}}' ?></span>
                                                                    <h1 class="success"><?php echo ' Cuarto #{{room.room_number}}' ?></h1>
                                                                    <span class="success ">Libre</span>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </b-col>
                                        </b-row>

                                    </div>


                                </div>


                            </tab>

                            <form slot="nav-right">
                                <div class="row" v-show="!showManager">
                                    <div class="col col-md-12">
                                        <select v-model.trim="filters.status"
                                                class="form-control m-input"

                                                @change="_status(filters.status)"
                                        >
                                            <option v-for="(typeRow,index) in statusManager"
                                                    v-bind:value="typeRow.id"><?php echo '{{typeRow.text}}' ?></option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </tabs>
                    </b-container>
                    <?php ?>
                    <div class="content-manager-grid">

                        <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager"
                             id="manager-grid-rooms">


                            <table id="lodging-type-of-room-by-price-reception-grid"
                                   class=""
                                   v-initGridManager="{initGridManager:initGridManager,thisCurrent:this}"
                            >
                                <thead>
                                <tr>
                                    <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                                    <th data-column-id="description" data-formatter="description">Descripción</th>

                                </tr>
                                </thead>
                            </table>


                        </div>
                        <div class="content-form" v-if="showManager">

                            <b-form id="LodgingForm" v-on:submit.prevent="_submitForm">

                                <input v-model="model.attributes.id" type="hidden"

                                       v-bind:id="getNameAttribute('id')"
                                       v-bind:name="getNameAttribute('id')"
                                >
                                <alert type="warning">
                                    <b>Esta a punto de terminar la Limpieza !</b>
                                    <h1 v-text="model.attributes.lodging_type_of_room_id_data.text"></h1>
                                    <b><?php echo 'Cuarto # {{model.attributes.room_number}}' ?></b>
                                </alert>


                            </b-form>
                        </div>


                    </div>
                </div>
                <div v-if="!allowProcess">

                    <b-col md="12">
                        <alert type="warning"><b>Advertencia!</b> Configure Habitaciones.</alert>
                    </b-col>

                </div>


                <button type="button"
                        class="btn btn-danger "
                        v-on:click="_cancel()"
                >
                    <?php echo "{{labelsConfig.buttons.cancel}}"?>
                </button>

            </div>

        </b-modal>


    </div>

</script>
