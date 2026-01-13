<script src="{{ asset($resourcePathServer.'js/developers/UtilCustom.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/Utils.js')}}" type='text/javascript'></script>

<script>

    var $dataManager = <?php echo json_encode($dataManager) ?>;
</script>
<script>
    function initWhatsapp() {
        if ($dataManager.business && $dataManager.business.dataPhoneWhatsapp && $dataManager.business.dataPhoneWhatsapp.urlWhatsapp != '') {
            var urlWhatsapp = getUrlWhatsApp() + $dataManager.business.dataPhoneWhatsapp.urlWhatsapp;
            console.log(urlWhatsapp);
            $("#companyWhatsapp").attr("href", urlWhatsapp);
        }
    }
</script>

<script>

    $(function () {
            initWhatsapp();

        }
    );


</script>
