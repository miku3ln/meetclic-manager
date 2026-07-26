<script>
    function checkAvailabilityByBusiness(params) {
        $.ajax({
            url: "{{route("check-availability-by-business")}}",
            type: 'POST',
            data: params.data,
            success: function (response) {
                if (response.success) {
                    console.log(
                        response.data
                    );

                }


            },


            error: function (xhr) {


                console.log(
                    xhr.responseJSON
                );


            }


        });
    }
    function getAvailabilityByDate(params) {
        $.ajax({
            url: "{{route("business-by-appointment-information")}}",
            type: 'POST',
            data: params.data,
            success: function (response) {
                if (response.success) {
                    console.log(
                        response.data
                    );

                }


            },


            error: function (xhr) {


                console.log(
                    xhr.responseJSON
                );


            }


        });
    }
</script>
