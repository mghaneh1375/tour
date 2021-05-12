@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>ویرایش تور: مرحله پایانی</title>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/tourCreation.css?v='.$fileVersions)}}"/>
@endsection


@section('body')

    <div class="mainBackWhiteBody">
        <div class="head">ویرایش تور: مرحله پایانی</div>
        <div class="whiteBox">
            <div>تمامی اطلاعات تور شما با موفقیت ثبت گردید و در حال بررسی می‌باشد.</div>
            <div>
                شما می‌توانید وضعیت تور خود را پیش از انتظار و پس از آن از داخل پنل کاربری خود و تحت عنوان
                <a href="{{route('businessManagement.tour.list', ['business' => $tour->businessId])}}">لیست تورها</a>
                بررسی نمایید.
            </div>
            <div>
                اگر در پروسه‌ی بررسی تور مشکلی پیش بیاید شما را در جریان می‌گذاریم.
            </div>
            <div>
                کد شناسایی تور:
                <span dir="ltr">{{$tour->codeNumber}}</span>
            </div>
            <div>
                با تشکر از شما
            </div>
            <a href="{{route('tour.show', ['code' => $tour->code])}}" style="display: flex;">
                <button id="goToProfile" class="btn float-left">پیش نمایش صفحه تور</button>
            </a>
        </div>
    </div>
@endsection


@section('modals')

@endsection




@section('script')

@endsection

