<html>

<head>

    @include('layouts.topHeader')

    <style>
        body {
            font-family: IRANSansWeb;
            direction: rtl;
        }
    </style>

    <script>
        $(document).ready(function () {
            setTimeout(function () {
                document.location.href = '{{route('main')}}';
            }, 5000);
        });
    </script>
</head>

<body>
<div class="row">
    <div class="col-xs-12" style="margin-top: 50px">
        <center><img src="{{URL::asset('images/soon.gif')}}"></center>
    </div>
    <div class="col-xs-12" style="background-color: var(--koochita-light-green); color: white">
        <center style="padding: 30px">
            <h3>در حال حاضر این خدمت در دسترس نمی باشد.</h3>
            <h4>ما سخت تلاش می کنیم تا هرچه زودتر این صفحه آماده شود.</h4>
            <h4>تا این زمان شکیبا باشید.</h4>
        </center>
    </div>
</div>
</body>

</html>