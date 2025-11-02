var eventInvalid;
var rInvalid;
var msjErrorWizard = "There are some errors in your submission. Please correct them.";
var eValidateFrm, rWizardObj, iFrm = $("#m_form");
var elementSaveBtn = $(".m-form__actions");
var n;
var WizardDemo = function () {
    $("#m_wizard");

    return {
        init: function () {

            $("#m_wizard"),
                iFrm = $("#m_form"),
                (rWizardObj = new mWizard("m_wizard", {
                    startStep: 1,
                    manualStepForward: true
                })).on("beforeNext", function (r) {
                    console.log("beforeNext");
                    !0 !== eValidateFrm.form() && r.stop()
                }),
                rWizardObj.on("change", function (e) {
                    console.log("change");
                    mUtil.scrollTop()
                }),
                eValidateFrm = iFrm.validate({
                    ignore: ":hidden",
                    rules: getRulesRegister(),
                    messages: {
                        "account_communication[]": {
                            required: "You must select at least one communication option"
                        },
                        accept: {
                            required: "You must accept the Terms and Conditions agreement!"
                        }
                    },
                    invalidHandler: function (e, r) {
                        mUtil.scrollTop(),
                            swal({
                                title: "",
                                text: "There are some errors in your submission. Please correct them.",
                                type: "error",
                                confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                            })
                        if (e.invalid) {
                            $.each(e.invalid, function (index, value) {

                            });
                        }
                        mUtil.scrollTop(), swal({
                            title: "",
                            text: msjErrorWizard,
                            type: "error",
                            icon: "error",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        })
                    },
                    submitHandler: function (e) {
                        console.log("submitHandler");
                    }
                }),
                (n = elementSaveBtn.find('.btn-submit-save')).on("click", function (r) {
                    r.preventDefault(),
                    eValidateFrm.form() && (mApp.progress(n),
                        elementSaveBtn.ajaxSubmit({
                            success: function () {
                                mApp.unprogress(n)
                                    , swal({
                                    title: "",
                                    text: "The application has been successfully submitted!",
                                    type: "success",
                                    icon: "success",
                                    confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                                })
                            }
                        }))
                })
            $('.m-wizard__step-number').on("click", function (e) {
                console.log("r", e);
                stepCurrent = rWizardObj.getStep();
                stepXElement = $(this).parent().parent().attr("m-wizard-target");
                stepX = stepXElement.split("_")[4];

                // if (eValidateFrm.form()) {//verificar si sta bien
                //
                // }
            })
        }
    }
}();
jQuery(document).ready(function () {
    WizardDemo.init()
});

function getRulesRegister() {
    return {
        // ---history_clinic=step=1--
        patient_id: {required: !0},
        status: {required: !0},
        email: {required: !0},
        //step=2
        //medicalConsultationByPatient
        reason_consultation: {required: !0},
        // ---medicalConsultationByPatient--
        reason_consultation: {required: !0},
        "medical_consultation_has_patient[]": {required: !0},
        "antecedent_has_history_clinic[]": {required: !0},
        accept: {required: !0},
        //STEP FINAL
        accept2: {required: !0}
    };
}

function getMessagesRules() {
    return {
        "account_communication[]": {required: "You must select at least one communication option"},
        accept: {required: "You must accept the Terms and Conditions agreement!"}
    };
}

