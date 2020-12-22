<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex" />
    <meta name="googlebot" content="noindex">

    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/fonts.css')}}' media="all"/>

    <title>صفحه مورد نظر یافت نشد</title>

    <style>
        body{
            margin: 0px;
        }
        .fullBody{
            width: 100%;
            height: 100vh;
            background: #f9bf3c;
            overflow: hidden;
        }
        .fullBody img{
            margin: 0px auto;
            display: flex;
            max-height: 75vh;
        }
        .fullBody .text{
            text-align: center;
            color: white;
            font-size: 30px;
            direction: rtl;
            font-family: IRANSans;
        }
        .fullBody a{
            width: 100%;
            text-align: center;
            font-size: 30px;
            text-decoration: none;
            color: red;
            font-family: 'IRANSansWeb';
            margin: 0px auto;
            display: block;
        }
    </style>
</head>
<body>
    <div class="fullBody">
        <img src="{{URL::asset('images/mainPics/errors/500Error.webp')}}">
        <div class="text" style="margin-top: 10px;">اوووووپپپپسسسس</div>
        <div class="text" style="font-size: 23px;">ببخشید یه مشکلی پیش امده</div>
    </div>
</body>
</html>