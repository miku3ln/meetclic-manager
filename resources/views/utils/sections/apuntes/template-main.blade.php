<div class="manager-modal" v-if="!managerRow.view">

    <div class="form-view-content">
        <div class="form-view-header">
            <h5 class="form-view-title"><?php echo '{{managerRow.data.value}}' ?></h5>
            <button type="button"

                    class="btn-close btn-close--modal" data-bs-dismiss="modal" aria-label="Close"
                    v-on:click="closeDataRow()"><span class="btn-close__icon">X</span></button>
        </div>
        <div class="form-view-body">
            <div v-if="managerRow.data.type==0">
                <section class="section--full-img">
                    <img class="img-full" v-bind:src="getUrlSource({source:managerRow.data.source})" alt="">

                </section>
            </div>
            <div class="manager-data-study" v-init-plugin-study="{managerRow:managerRow}">

            </div>
        </div>

    </div>

</div>
<input id="action-language_course_by_section-getAdmin" type="hidden"
       value="{{route('getApuntesAdmin',app()->getLocale())}}"/>
<section id="sec2" v-show="managerRow.view" class="section-grid">
    <div class="container--manager-dictionary">

        <div class="row">
            <div class="content-manager-grid">

                <div class="custom-scroll-admin-grid table-responsive">
                    <table
                        v-init-bootgrid="{id:'dictionary_by_words-grid',}"
                        id="dictionary_by_words-grid"
                        class=""

                    >
                        <thead>
                        <tr>
                            <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                            <th data-column-id="value" data-formatter="value">Apuntes</th>

                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
