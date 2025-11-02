<script type="text/x-template" id="gallery-template">
    <div>

        <b-container class="bv-example-row">
            <div class="content-row-manager-buttons">
                <button
                        v-if="!managerMenuConfig.view"
                        type="button"
                        class="btn "
                        :class="{'btn-success':!showManager,'btn-danger':showManager}"
                        v-on:click="_viewManager(showManager?2:1)">
                    <?php echo "{{showManager?'Regresar':'Nuevo'}}"?>
                </button>


                <button v-if="showManager " type="button"
                        :disabled="!validateForm()"
                        class="btn btn-success" v-on:click="_saveGallery()">
                    <?php echo "{{lblBtnSave}}"?>
                </button>



                <div class="content-manager-buttons-grid" v-if="managerMenuConfig.view && !showManager">

                    <a
                            v-init-tool-tip
                            v-for="(menu, key) in managerMenuConfig.menuCurrent"
                            @click="_managerMenuGrid(key, menu)"
                            class="content-manager-buttons-grid__a "
                            data-toggle="tooltip"
                            data-placement="top"
                            v-bind:id="'a-menu-'+menu.rowId"
                            v-bind:data-original-title="<?php echo "menu['title']" ?>">
                        <i
                                v-bind:class="<?php echo "menu['icon']" ?>"></i>
                    </a>
                </div>

            </div>
        </b-container>
        <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">



            <table id="gallery-grid"
                   class=""

            >
                <thead>
                <tr>
                    <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                    <th data-column-id="description" data-formatter="description">Descripción</th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="content-form" v-show="showManager">

            <b-form id="galleryForm" v-on:submit.prevent="_submitForm">
                <input v-model="modelGallery.attributes.id" type="hidden" name="Gallery[id]">
                <input v-model="modelGallery.attributes.business_id" type="hidden" name="Gallery[business_id]">

                <b-container class="bv-example-row">

                    <div class="manager-gallery">


                        <b-row>
                            <b-col lg="6">
                                <div class="form-group"
                                     :class="getClassErrorForm('status',$v.modelGallery.attributes.status)">
                                    <label class="form__label col-md-4" v-html='getLabelForm("status")' ></label>
                                    <div class="content col-md-8">
                                        <input
                                                v-model.trim="$v.modelGallery.attributes.status.$model"
                                                type="checkbox"
                                                name="Gallery[status]"
                                                class="form-control m-input"
                                               @change="_setValueForm('status', $event.target.value)"
                                        >
                                    </div>
                                    <div class="message ">

                                    </div>
                                </div>

                            </b-col>
                        </b-row>
                        <div class="row">

                            <div class="col col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="content-box-image content-box-preview" @click="_uploadDataImage">
                                    <img class="content-box-image__preview" id="preview-gallery-src">
                                    <div>

                                        <input
                                                type="file"
                                                id="file_upload_gallery"
                                                class="hidden"
                                                name="Gallery[file_upload_gallery]"
                                        >
                                    </div>
                                </div>
                                <div class="progress-gallery-image not-view">
                                    <div class="progress__bar"></div>
                                    <div class="progress__percent">0%</div>
                                </div>
                            </div>
                        </div>
                        <b-row>

                            <b-col lg="6">
                                <div class="form-group"
                                     :class="getClassErrorForm('title',$v.modelGallery.attributes.title)">
                                    <label class="form__label " v-html='getLabelForm("title")' ></label>

                                    <div class="content ">

                                        <input
                                                v-model.trim="$v.modelGallery.attributes.title.$model"
                                                type="text"
                                                class="form-control m-input"
                                                name="Gallery[title]"
                                                @change="_setValueForm('title', $event.target.value)"
                                                v-focus-select
                                        >
                                    </div>
                                    <div class="message ">
                                        <b-form-invalid-feedback
                                                :state="!$v.modelGallery.attributes.title.$error">
                                            <span v-if="!$v.modelGallery.attributes.title.required">
                                <?php  echo "{{modelGallery.structure.title.required.msj}}"?>
                            </span>
                                            <span v-if="!$v.modelGallery.attributes.title.minLength">
                                <?php  echo "Valor minimo debe de ser 4"?>
                            </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col lg="6">
                                <div class="form-group"
                                     :class="getClassErrorForm('subtitle',$v.modelGallery.attributes.subtitle)">
                                    <label class="form__label " v-html='getLabelForm("subtitle")' ></label>

                                    <div class="content ">

                                        <input
                                                v-model.trim="$v.modelGallery.attributes.subtitle.$model"
                                                type="text"
                                                class="form-control m-input"
                                                name="Routes[subtitle]"
                                                @change="_setValueForm('subtitle', $event.target.value)"
                                                v-focus-select
                                        >
                                    </div>
                                    <div class="message ">
                                        <b-form-invalid-feedback
                                                :state="!$v.modelGallery.attributes.subtitle.$error">
                                            <span v-if="!$v.modelGallery.attributes.subtitle.required">
                                <?php  echo "{{modelGallery.structure.subtitle.required.msj}}"?>
                            </span>
                                            <span v-if="!$v.modelGallery.attributes.subtitle.minLength">
                                <?php  echo "Valor minimo debe de ser 4"?>
                            </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col lg="12">
                                <div class="form-group"
                                     :class="getClassErrorForm('description',$v.modelGallery.attributes.description)"
                                >
                                    <label class="form__label " v-html='getLabelForm("description")' ></label>
                                    <div class="content ">

                                        <textarea
                                                v-model.trim="$v.modelGallery.attributes.description.$model"
                                                name="Routes[description]"
                                                class="form-control m-input"
                                               @change="_setValueForm('description', $event.target.value)"
                                                v-focus-select

                                        ></textarea>
                                    </div>
                                    <div class="message ">
                                        <b-form-invalid-feedback
                                                :state="!$v.modelGallery.attributes.description.$error">
                                            <span v-if="!$v.modelGallery.attributes.description.required">
                                <?php  echo "{{modelGallery.structure.description.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>
                    </div>


                </b-container>

            </b-form>
        </div>

    </div>

</script>
<script type="text/x-template" id="carousel-template">
    <div>
        <b-carousel
                id="carousel1"
                style="text-shadow: 1px 1px 2px #333;"
                controls
                indicators
                background="#ababab"
                :interval="4000"
                img-width="1024"
                img-height="480"
                v-model="slide"
                @sliding-start="onSlideStart"
                @sliding-end="onSlideEnd"
        >

            <div v-for="item in items">
                <!-- Text slides with image -->
                <div v-if="item.type === 'caption'">
                    <b-carousel-slide
                            v-bind:caption="item.caption"
                            v-bind:text="item.text"
                            v-bind:img-src="item.src"
                    />
                </div>
                <!-- Slides with custom text -->
                <div v-if="item.type === 'custom-text'">

                    <b-carousel-slide
                            v-bind:img-src="item.src"
                    >
                        <h1><?php echo "{{item.text}}";?></h1>
                    </b-carousel-slide>
                </div>

                <!-- Slides with image only -->
                <div v-if="item.type === 'image'">

                    <b-carousel-slide
                            v-bind:img-src="item.src"
                    />
                </div>
                <!-- Slides with img slot -->
                <!-- Note the classes .d-block and .img-fluid to prevent browser default image alignment -->
                <div v-if="item.type === 'slot'">
                    <b-carousel-slide>
                        <img
                                v-bind:slot="item.slot"
                                v-bind:class="item.class"
                                v-bind:width="item.width"
                                v-bind:height="item.height"
                                v-bind:src="item.src"
                                v-bind:alt="item.alt"
                        />
                    </b-carousel-slide>
                </div>
                <!-- Slide with blank fluid image to maintain slide aspect ratio -->
                <div v-if="item.type === 'aspect-ratio'">
                    <b-carousel-slide
                            img-blank
                            v-bind:img-alt="item.alt"
                            v-bind:caption="item.caption"
                    >
                        <p class="p--text-carousel">
                            <?php echo "{{item.text}}";?>
                        </p>
                    </b-carousel-slide>
                </div>
            </div>

        </b-carousel>
        <p class="mt-4">
            Slide #: <?php echo "{{ slide }}" ?><br/>
            Sliding: <?php echo "{{ sliding }}" ?>
            migu3ln: <?php echo "{{ migu3ln }}" ?>
        </p>
    </div>
</script>
<!-- template for the modal component -->
<script type="text/x-template" id="modal-template">
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">

                    <div class="modal-header">
                        <slot name="header">
                            default header
                        </slot>
                        <button type="button" aria-label="Close" @click="$emit('close')" class="close">×
                        </button>
                    </div>

                    <div class="modal-body">
                        <slot name="body">
                            default body
                        </slot>
                    </div>

                    <div class="modal-footer">
                        <slot name="footer">

                            <button class="modal-default-button not-view" @click="$emit('close')"
                                    id="close-modal">
                                OK
                            </button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</script>
