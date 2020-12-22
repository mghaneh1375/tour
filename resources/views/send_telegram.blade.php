
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
{{--<script src="{{URL::asset('js/jquery-1.9.1.min.js')}}"></script>--}}


<script>


    $(document).ready(function () {

        $.ajax({
            type: 'get',
            url: '{{$url}}',
            success: function (response) {
                alert(response);
            }
        });

    });

</script>