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
                <center><img src="{{URL::asset('images/404.gif')}}"></center>
            </div>
            <div class="col-xs-12" style="background-color: var(--koochita-light-green); color: white">
                <center style="padding: 30px">
                    <h3>صفحه مورد نظر یافت نشد.</h3>
                    <h4>شما ظرف چند ثانیه به صفحه اصلی منتقل می گردید.</h4>
                    <h4 style="cursor: pointer" onclick="document.location.href = '{{route('main')}}'">www.shazdemosafer.com</h4>
                </center>
            </div>
        </div>
    </body>

</html>