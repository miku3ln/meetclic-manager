function getStringParamsGet(params) {
    var dataParams = params['dataParams'];
    var recursiveDecoded = decodeURIComponent($.param(dataParams));
    return recursiveDecoded;
}

$(function () {
    var elementSelector = '#whatsapp-contact__a';
    var dataBusiness = $(elementSelector).attr('data');

    if (typeof (dataBusiness) != 'undefined') {
        var text = $(elementSelector).attr('text');
        dataBusiness = JSON.parse(dataBusiness);
        var phone = '+' + dataBusiness.phone_code + '' + dataBusiness.phone_value;
        var dataParams = {
            phone: phone,
            text: text,
        };
        $hrefCurrent = getUrlContactWhatsApp({dataParams: dataParams});
        $(elementSelector).attr('href',$hrefCurrent);
    }
});
