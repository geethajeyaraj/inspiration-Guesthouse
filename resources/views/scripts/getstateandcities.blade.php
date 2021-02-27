
<script>
    $(document).ready(function () {

              $('#country').change(function () {
            var cid = $(this).val();
            if (cid) {
                $.ajax({
                    type: "get",
                    url: "{{ url('get_states') }}/" + cid,
                    success: function (res) {
                        if (res) {
                            $("#state").empty();
                            $("#city").empty();
                            $("#state").append('<option>Select State</option>');
                            $("#city").append('<option>Select City</option>');

                            $.each(res, function (key, value) {
                                $("#state").append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                        }
                    }

                });
            }
        });


        $('#state').change(function () {
            var sid = $(this).val();
            if (sid) {
                $.ajax({
                    type: "get",
                    url: "{{ url('get_cities') }}/" + sid,
                    success: function (res) {
                        if (res) {
                            $("#city").empty();
                            $("#city").append('<option>Select City</option>');

                            $.each(res, function (key, value) {
                                $("#city").append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                        }
                    }

                });
            }
        })

    });

    </script>
    