function initClinicalDocuments(){
    portletsInit();
    initGridsStep2();
}

function portletsInit() {
    var e;
    var elementInitName = "m_portlet_antecedent_by_history_clinic";
    toastr.options.showDuration = 1e3,
        (e = new mPortlet(elementInitName)).on("beforeCollapse", function (e) {

        }),
        e.on("afterCollapse", function (e) {

        }),
        e.on("beforeExpand", function (e) {

        }),
        e.on("afterExpand", function (e) {

        }),
        e.on("reload", function (e) {

        }),
        e.on("afterFullscreenOn", function (e) {

        }),
        e.on("afterFullscreenOff", function (e) {
            var t;
            toastr.warning("After fullscreen off event fired!"),
            (t = $(e.getBody()).find("> .m-scrollable")) && ((t = $(e.getBody()).find("> .m-scrollable")).css("height", t.data("original-height")),
                mUtil.scrollerUpdate(t[0]))
        });
    var nRegisterElement = mUtil.find(mUtil.get(elementInitName), "[m-portlet-tool=add-register]");
    nRegisterElement && mUtil.addEvent(nRegisterElement, "click", function (t) {

        newRegisterStep2("antecedent_by_history_clinic", "antecedentByHistoryClinic_form");
    });

    var e2;
    elementInitName = "m_portlet_clinical_by_history_clinic";
    toastr.options.showDuration = 1e3,
        (e2 = new mPortlet(elementInitName)).on("beforeCollapse", function (e) {
            setTimeout(function () {
                toastr.info("Before collapse event fired!")
            }, 100)
        }),
        e2.on("beforeExpand", function (e) {

        }),
        e2.on("afterExpand", function (e) {
            setTimeout(function () {
                toastr.warning("After expand event fired!")
            }, 2e3)
        }),
        e2.on("reload", function (e) {
            toastr.info("Leload event fired!"),
                mApp.block(e.getSelf(), {
                    overlayColor: "#ffffff",
                    type: "loader",
                    state: "accent",
                    opacity: .3,
                    size: "lg"
                }),
                setTimeout(function () {
                    mApp.unblock(e.getSelf())
                }, 2e3)
        }),
        e2.on("afterFullscreenOn", function (e) {
            toastr.warning("After fullscreen on event fired!");
            var t = $(e.getBody()).find("> .m-scrollable");
            t && (t.data("original-height", t.css("height")),
                t.css("height", "100%"),
                mUtil.scrollerUpdate(t[0]))
        }),
        e2.on("afterFullscreenOff", function (e) {
            var t;
            toastr.warning("After fullscreen off event fired!"),
            (t = $(e.getBody()).find("> .m-scrollable")) && ((t = $(e.getBody()).find("> .m-scrollable")).css("height", t.data("original-height")),
                mUtil.scrollerUpdate(t[0]))
        });

    var nRegisterElement = mUtil.find(mUtil.get(elementInitName), "[m-portlet-tool=add-register]");

    nRegisterElement && mUtil.addEvent(nRegisterElement, "click", function (t) {

        newRegisterStep2("clinical_by_history_clinic", "clinicalByHistoryClinic_form");
    });
}


function getFormPatientModal(action) {
    ajaxRequest(action, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {

            modal_patient.find('.container_modal').html('');
            modal_patient.find('.container_modal').html(data.html);
            form_patient = $("#patient_form");
            modal_patient.modal({
                show: true,
                backdrop: 'static',
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });


            // $('#details_portlet').hide();
            // list_patient = $("#container_patients");
            // list_patient.hide();
            // form_patient = $("#container_patient_form");
            // form_patient.html("");
            // form_patient.append(data.html);
            initPatientFormModal()
        }
    });

}