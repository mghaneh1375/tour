@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>ایجاد تور</title>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/tourCreation.css?v='.$fileVersions)}}"/>
@endsection


@section('body')

    <div class="mainBackWhiteBody">
        <div class="head">ایجاد تور: پیش از شروع</div>
        <div style="margin-top: 20px">
            <div class="topDesc">
                <p>
                    ما برای جلب رضایت کاربرانمان اطلاعات کاملی را از شما درخواست می‌کنیم.
                    مسئولیت صحت اطلاعات وارد و یا کافی بودن آن برعهده‌ی شماست. اما پیشنهاد ما بر ارائه‌ی کامل و دقیق اطلاعات مطابق
                    مراحل گام به گام طراحی شده می‌باشد. توجه کنید تمام تلاش ما حمایت همزمان از ارائه‌دهنده و مصرف‌کننده می‌باشد و ارائه‌ی هرگونه
                    اطلاعات نادرست و یا ناقض به گونه‌ای که احتمال استفاده از آن برای تضییع حقوق مصرف‌کنندگان باشد از نظر ما مردود است.
                    با ارائه‌ی شفاف اطلاعات به حقوق یکدیگر حترام می‌گذاریم. ما هم تلاش خود را به کتر بردیم تا با استفاده از داده‌های شما
                    انتخاب کاربران را آگاهانه‌تر نماییم. خواهشمندیم به مرام‌نامه‌ی ما احترام بگذارید و تا حد امکان اطلاعاتی جامع، کامل و دقیق ارائه دهید.
                </p>
                <p>
                    برای مشاهده‌ی صفحه‌ی قوانین و مقررات
                    <a href="#">اینجا</a>
                    را کلیک کنید.
                </p>
                <p>
                    برای مشاهده‌ی صفحه‌ی ارائه‌دهدگان دیگر
                    <a href="#">اینجا</a>
                    را کلیک کنید.
                </p>
            </div>

            <div class="bottomDesc">
                <div class="menu ui_container whiteBox" id="termsAndConditionAcceptBox">
                    <div id="termsAndConditionText">
                        <span>اگر با مرامنامه‌ی ما و قوانین و مقررات سایت هستید، لطفاً اطلاعات لازم را آماده نموده و شروع نمایید.</span>
                        <span>نگران نباشید. شما همواره از طریق پروفایل خود امکان ادامه ایجاد تور را خواهید داشت. هر اطلاعاتی که وارد می‌کنید به صورت موقت ذخیره می‌شود مگر آن‌که هشداری مبنی بر عدم صحت آن دریافت کنید.</span>
                        <span>این فرآیند تقریباً مابین ... الی ... دقیقه زمان می‌برد.</span>
                    </div>
                    <a href="{{route('businessManagement.tour.create.stage_1', ['business' => $businessIdForUrl, 'tourId' => 0])}}">
                        <button id="termsAndConditionBtn" class="btn nextStepBtnTourCreation">شروع کنید</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

