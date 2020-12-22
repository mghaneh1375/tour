<html>
<head>

    <style>

        @font-face {
            font-weight: normal;
            font-style: normal;
            font-family: 'IRANSansWeb';
            src: url('{{URL::asset('fonts/theme2/IRANSansWeb.eot')}}');
            src: url('{{URL::asset('fonts/theme2/IRANSansWeb.eot')}}') format('embedded-opentype'), url('{{URL::asset('fonts/theme2/IRANSansWeb.woff2')}}') format('woff2'), url('{{URL::asset('fonts/theme2/IRANSansWeb.woff')}}') format('woff'), url('{{URL::asset('fonts/IRANSansWeb.ttf')}}');
        }

        .main {
            direction: rtl;
            font-family: IRANSansWeb;
            /*padding: 70px;*/
            overflow-x: hidden;
        }

        .text{
            margin-left: auto;
            margin-right: auto;
            width: 200px;
        }

        .big_element {
            margin-left: auto;
            margin-right: auto;
            margin-top: 50px;
            width: 50%;
            text-align: justify;
            border: 5px dashed black
        }

        .line {
            width: 70%;
            height: 2px;
            border-bottom: 2px solid var(--koochita-light-green);
            margin-right: auto;
            margin-left: auto;
        }

    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script>

        var tripPlaces = {!! json_encode($tripPlaces) !!};

        function init() {
            var mapOptions = {
                zoom: 14,
                center: new google.maps.LatLng(40.6700, -73.9400), // New York
                styles: [
                    {
                    "featureType":"landscape",
                    "stylers":[
                        {"hue":"#FFA800"},
                        {"saturation":0},
                        {"lightness":0},
                        {"gamma":1}
                    ]}, {
                    "featureType":"road.highway",
                    "stylers":[
                        {"hue":"#53FF00"},
                        {"saturation":-73},
                        {"lightness":40},
                        {"gamma":1}
                    ]},	{
                    "featureType":"road.arterial",
                    "stylers":[
                        {"hue":"#FBFF00"},
                        {"saturation":0},
                        {"lightness":0},
                        {"gamma":1}
                    ]},	{
                    "featureType":"road.local",
                    "stylers":[
                        {"hue":"#00FFFD"},
                        {"saturation":0},
                        {"lightness":30},
                        {"gamma":1}
                    ]},	{
                    "featureType":"water",
                    "stylers":[
                        {"hue":"#00BFFF"},
                        {"saturation":6},
                        {"lightness":8},
                        {"gamma":1}
                    ]},	{
                    "featureType":"poi",
                    "stylers":[
                        {"hue":"#679714"},
                        {"saturation":33.4},
                        {"lightness":-25.4},
                        {"gamma":1}
                    ]}
                ]
            };
            var mapElement = document.getElementById('map');
            var map = new google.maps.Map(mapElement, mapOptions);
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(40.6700, -73.9400),
                map: map,
                title: 'Shazdemosafer!'
            });
        }
    </script>
</head>

<body onload="window.print()" class="main">

    <div>
    <div class="text">
        <img style="width: 200px; margin-top: 20px" src="{{URL::asset('images/icons/KOFAV0.svg')}}">
    </div>
    <h2 style="text-align: center">{{$trip->name}}</h2>

    @if($trip->from_ != "" && $trip->to_ != "")
        <h4 style="text-align: center">تاریخ شروع : {{formatDate($trip->from_)}}</h4>
        <h4 style="text-align: center">تاریخ پایان : {{formatDate($trip->to_)}}</h4>
    @endif

    <h4 style="text-align: center">{{$trip->owner->username}}</h4>
    @foreach($trip->members as $tripMember)
        <h4 style="text-align: center">{{$tripMember->username}}</h4>
    @endforeach

    <div class="line"></div>

    @if($trip->note != "")
        <div style="margin-top: 10px">
            <p style="text-align: center">{{$trip->note}}</p>
        </div>

        <div class="line"></div>
    @endif

    <?php $i = 0; ?>

    @foreach($tripPlaces as $tripPlace)

        <div style="margin-top: 20px; width: 100%">

            @if($tripPlace->date == "")
                <p style="text-align: center">بدون تاریخ</p>
            @else
                <p style="text-align: center">{{convertStringToDate($tripPlace->date)}}</p>
            @endif

            <div style="width: 100%">
                <img style="width: 200px; float: right; height: 200px; margin-right: 50px" src="{{$tripPlace->pic}}">
                {{--<div style="float: right; margin-right: 50px">--}}
                <div style="max-width: 450px; margin-right: 30px; margin-left: 0; float: right">
                    <span>{{$tripPlace->name}}</span><br/>
                    <span>{{$tripPlace->address}}</span><br/>
                    {{--<span>{{$tripPlace->point}}</span><br/>--}}
                    <span>{{$tripPlace->city}}</span><br/>
                    <span>{{$tripPlace->state}}</span><br/>
                </div>
            </div>

            <div style="clear: both"></div>


            @if(isset($tripPlace->x) && isset($tripPlace->y))
                <center style="margin-top: 20px">
                    <img src="https://maps.googleapis.com/maps/api/staticmap?center={{$tripPlace->x}},{{$tripPlace->y}}&scale=2&zoom=15&size=600x300&maptype=roadmap&markers=color:red%7Clabel:C%7C{{$tripPlace->x}},{{$tripPlace->y}}&key=AIzaSyDpeBLW4SWeWuDKKAT0uF7bATx8T2rEiXE" style=" width: 600px; height: 300px">
                </center>
            @endif
            <div style="width: 100%; clear: both; margin-top: 10px; border-bottom: 2px solid #636363">

                @if(count($tripPlace->comments) == 0)
                    <p style="text-align: center">یادداشتی موجود نیست</p>
                @endif

                @foreach($tripPlace->comments as $comment)
                    <p style="text-align: center"><span>{{$comment->uId}}</span> <span>میگه: </span><span>{{$comment->description}}</span></p>
                @endforeach
            </div>

        </div>

        <?php $i++; ?>

    @endforeach
</div>

    <footer style="width: 100%; margin-top: 10px; padding: 20px; position: relative">
        <img src="{{URL::asset('images/yellowBack.png')}}" style="position: absolute; width: 100%; height: 200px">
        <p style="position: absolute; width: 90%; left: 5%; right: auto; text-align: center; top: 80px">شما از قابلیت سفرهای من سایت کوچیتا استفاده کرده اید.</p>
        <p style="position: absolute; width: 90%; left: 5%; right: auto; text-align: center; top: 130px">
            در صورت نیاز به اطلاعات بیشتر به سایت
            <a href="{{route('home')}}">koochita.com</a>
            مراجعه نمایید.
        </p>
    </footer>
</body>
</html>