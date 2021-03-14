@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>مرحله ششم</title>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/tourCreation.css?v='.$fileVersions)}}"/>
@endsection


@section('body')

    <div class="mainBackWhiteBody">
        <div class="head">ایجاد تور: مرحله پایانی</div>
        <div class="whiteBox">
            <div>
                <span>تمامی اطلاعات تور شما با موفقیت ثبت گردید و در حال بررسی می‌باشد. شما می‌توانید وضعیت تور خود را پیش از انتظار و پس از آن از داخل پنل کاربری خود و تحت عنوان مدیریت کسب‌ و کار بررسی نمایید. اگر در پروسه‌ی بررسی تور مشکلی پیش بیاید شما را در جریان می‌گذاریم.</span>
                <span>کد شناسایی تور: _____-______-____</span>
                <span>با تشکر از شما</span>
            </div>
            <a href="{{route('tour.show', ['code' => $tour->code])}}" style="display: flex;">
                <button id="goToProfile" class="btn float-left">رفتن به صفحه تور</button>
            </a>
        </div>
    </div>
@endsection


@section('modals')

@endsection




@section('script')

@endsection

