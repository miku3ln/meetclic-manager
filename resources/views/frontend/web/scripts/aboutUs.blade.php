<script>
    function isValidated(elements, captcha) {
        var results, errors = 0;

        if (elements.length) {
            for (var j = 0; j < elements.length; j++) {

                var $input = $(elements[j]);
                if ((results = $input.regula('validate')).length) {
                    for (k = 0; k < results.length; k++) {
                        errors++;
                        $input.siblings(".form-validation").text(results[k].message).parent().addClass("has-error");
                    }
                } else {
                    $input.siblings(".form-validation").text("").parent().removeClass("has-error")
                }
            }

            if (captcha) {
                if (captcha.length) {
                    return validateReCaptcha(captcha) && errors === 0
                }
            }

            return errors === 0;
        }
        return true;
    }
    isNoviBuilder = window.xMode;
    // RD Mailform
    var plugins = {
        rdMailForm: $(".rd-mailform")
    };
    var form;
    var inputs;
    var captcha;
    var captchaFlag;
    var captchaToken;

    function initFormContactUs() {

        var formNameSelector = "#contact-form";
        var customerPage = 'Contáctanos :'+'{{ $dataManagerPage['nameBusiness'] }}';
        if (plugins.rdMailForm.length) {
            var i, j, k,
                msg = {
                    'MF000': 'Successfully sent!',
                    'MF001': 'Recipients are not set!',
                    'MF002': 'Form will not work locally!',
                    'MF003': 'Please, define email field in your form!',
                    'MF004': 'Please, define type of your form!',
                    'MF254': 'Something went wrong with PHPMailer!',
                    'MF255': 'Aw, snap! Something went wrong.'
                };

            for (i = 0; i < plugins.rdMailForm.length; i++) {
                var $form = $(plugins.rdMailForm[i]),
                    formHasCaptcha = false;

                $form.attr('novalidate', 'novalidate').ajaxForm({
                    data: {
                        "form-type": $form.attr("data-form-type") || "contact",
                        "counter": i
                    },
                    beforeSubmit: function(arr, $form, options) {
                        if (isNoviBuilder)
                            return;

                        form = $(plugins.rdMailForm[this.extraData.counter]),
                            inputs = form.find("[data-constraints]"),
                            output = $("#" + form.attr("data-form-output")),
                            captcha = form.find('.recaptcha'),
                            captchaFlag = true;

                        output.removeClass("active error success");
                        var validateForm = isValidated(inputs, captcha);
                        if (validateForm) {
                            form.addClass('form-in-process');
                            var dataSend = $(formNameSelector).serializeArray().reduce(function(obj,
                                item) {
                                obj[item.name] = item.value;
                                return obj;
                            }, {});
                            dataSend['customerPage'] = customerPage;
                            var typePage = 0;
                            var business_id = '{{ $dataManagerPage['business_id'] }}';
                            dataSend['typePage'] = typePage;
                            dataSend['business_id'] = business_id;
                            $routeUrl = '{{ route('sendMailEducation') }}';
                            ajaxRequest($routeUrl, {
                                type: 'POST',
                                data: dataSend,
                                beforeSend: function() {
                                    if (output.hasClass("snackbars")) {
                                        output.html(
                                            '<p><span class="icon text-middle fa fa-circle-o-notch fa-spin icon-xxs"></span><span>Enviando..</span></p>'
                                        );
                                        output.addClass("active");
                                    }
                                },
                                blockElement: '.contact-form-wrapper', //opcional: es para bloquear el elemento
                                loading_message: "{{ __('contact-us.form.message.loading') }}",
                                error_message: "{{ __('contact-us.form.message.error') }}",
                                success_message: "{{ __('contact-us.form.message.success') }}",
                                success_callback: function(response) {

                                        output = $("#" + form.attr("data-form-output"));
                                        select = form.find('select');
                                    if (response.success) {
                                        output.addClass("active succes");
                                        form
                                            .addClass('success')
                                            .removeClass('form-in-process');
                                    } else {
                                        output.addClass("active error");
                                    }



                                    output.html(
                                        ' <p class="snackbars-left"><span class="icon icon-xxs mdi mdi-alert-outline text-middle"></span><span>' +
                                            response.msj + '</span></p>');

                                    $(formNameSelector).trigger("reset");
                                    setTimeout(function() {
                                        output.removeClass("active");
                                    }, 3500);


                                }
                            });



                        } else {
                            return false;
                        }
                    },
                    error: function(result) {

                    },
                    success: function(result) {
                        console.log(result);

                        if (isNoviBuilder)
                            return;



                        if (formHasCaptcha) {
                            grecaptcha.reset();
                        }

                        result = result.length === 5 ? result : 'MF255';
                        output.text(msg[result]);

                        if (result === "MF000") {
                            if (output.hasClass("snackbars")) {
                                output.html(
                                    '<p><span class="icon text-middle mdi mdi-check icon-xxs"></span><span>' +
                                    msg[result] + '</span></p>');
                            } else {
                                output.addClass("active success");
                            }
                        } else {

                        }

                        form.clearForm();

                        if (select.length) {
                            select.select2("val", "");
                        }

                        form.find('input, textarea').trigger('blur');

                        setTimeout(function() {
                            output.removeClass("active error success");
                            form.removeClass('success');
                        }, 3500);
                    }
                });
            }
        }
    }

    function ajaxRequest(url, params, hasFileUpload) {
        var type = params.hasOwnProperty("type") ? params.type : 'GET';
        var blockElement = params.hasOwnProperty("blockElement") ? params.blockElement : null;
        var data = params.hasOwnProperty("data") ? params.data : [];
        var error_message = params.hasOwnProperty("error_message") ? params.error_message :
            'Ha ocurrido un error durante la petición, inténtelo nuevamente.';
        var loading_message = params.hasOwnProperty("loading_message") ? params.loading_message : 'Cargando...';
        var contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
        var processData = true;
        if (typeof hasFileUpload !== 'undefined' && hasFileUpload) {
            contentType = false;
            processData = false;

            var formData = new FormData();

            Object.entries(data).forEach(([key, value]) => {
                formData.append(key, value);
            });
            data = formData;
        }
        var tokenInformation = $('meta[name="csrf-token"]').attr('content');
        var paramsConfig = {

            url: url,
            type: type,
            dataType: 'json',
            data: data,
            contentType: contentType,
            processData: processData,
            headers: {
                'X-CSRF-TOKEN': tokenInformation
            },
            beforeSend: function(jqXHR, settings) {
                if (params.hasOwnProperty("beforeSend")) {
                    params.beforeSend(jqXHR, settings);
                }
            },
            error: function(data) {

                if (params.hasOwnProperty("error_callback")) {
                    params.error_callback(data);
                }
            },
            success: function(data) {

                if (params.hasOwnProperty("success_callback")) {
                    params.success_callback(data);
                }
            },
            complete: function() {

                if (params.hasOwnProperty("complete_callback")) {
                    params.complete_callback();
                }
            }
        }
        $.ajax(paramsConfig);
    }


    $(function() {
        initFormContactUs();
    });

</script>
