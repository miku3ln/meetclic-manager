
function validacionCampoMaximoRating() {
//    alert('validacion del rating');
    $('span.bold:contains("Rating")').siblings('span.editable').on('save', function (e, params) {

        if (params.newValue == 6) {
            $(this).parent('.nsy_field_type').siblings('ol').children().children('input').attr('max', '10');
        }
        if (params.newValue == 5) {
            $(this).parent('.nsy_field_type').siblings('ol').children().children('input').attr('max', '100');
        }


    });
}

//function clickSpanRating(){
//    $('span.bold:contains("Rating")').siblings('span.editable').click(function(){alert("click");
//    validacionCampoMaximoRating();
//    })
//}

function ValidacionToggle(id, status) {
    if (status) {
        $('#' + id).show('slow');
        $('#' + id).addClass('required');
    } else {
        $('#' + id).hide('slow');
        $('#' + id).removeClass('required');
        $('#' + id).removeClass('error');
        $('#' + id).siblings('label.error').remove();
    }

}

function ocultarRating() {
    var field = $('span.bold[data-bind="text: formated_type"]:contains("Rating")');
    field.parent().siblings('.nsy_add_option').hide();
//    field.parent().siblings('.nsy_add_option').siblings('ol').children('li').children('a').remove();

    $.each(field, function () {
        var campo = $(this).parent().siblings('.nsy_add_option').siblings('ol').children('li').children('input');
        campo.attr('placeholder', 'Calificación maxima');
        console.log(campo);
//        campo.get(0).type = 'number';
//        campo.attr('min', '1');
//        if ($(this).siblings('.editable').text() === 'Dropdown')
//        {
//            campo.attr('max', '100');
//        } else
//        {
//            campo.attr('max', '10');
//        }
    });

}

var data_html = "";

function data(id) {
    data_gestion = {id: id};
    var url_gestion = "askwer/askwerForm/generatDataForm/";
    var data_gestion = data_gestion;
    var params_gestion = {
        url: url_gestion, //accion dond vamos a realizar la gestion
        data: data_gestion, //paramatros para realizar l proceso
        beforeCall: function () {//funcion antes d ejecutarse el procesos
            console.log("empezar");
//  
        },
        successCall: function (data) {

            data_html = data.html;
        },
        errorCall: function (data) {


        },
    };
  /*  gestionInformacion(params_gestion);*/
}