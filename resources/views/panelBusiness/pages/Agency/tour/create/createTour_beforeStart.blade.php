@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>ایجاد تور</title>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/tourCreation.css?v='.$fileVersions)}}"/>

    <style>

        .selectEditCardSection{
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: center;
        }
        .selectEditCardSection .editCard{
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            border-radius: 15px;
            height: 170px;
            width: 165px;
            margin: 11px 10px;
            text-align: center;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            color: white;
            box-shadow: 1px 2px 3px 2px #00000073;
        }
        .selectEditCardSection .editCard.card1{
            background: linear-gradient(45deg, #0014ff, #0014ff75);
        }
        .selectEditCardSection .editCard.card2{
            background: linear-gradient(45deg, #ff00c8, #0014ff75);
        }
        .selectEditCardSection .editCard.card3{
            background: linear-gradient(45deg, #ff0000, #ff00c88a);
        }
        .selectEditCardSection .editCard.card4{
            background: linear-gradient(45deg, #ffb000, #ff0000d6);
        }
        .selectEditCardSection .editCard.card5{
            background: linear-gradient(45deg, #00ff4e, #0049ff);
        }
        .selectEditCardSection .editCard .icon{
            font-size: 3em;
            transition: .3s;
        }
        .selectEditCardSection .editCard .name{

        }
        .selectEditCardSection .editCard .name .stage{
            font-size: .6em;
        }
        .selectEditCardSection .editCard .name .text{
            font-weight: bold;
            font-size: .8em;
            margin-top: 8px;
        }

        .selectEditCardSection .editCard:hover .icon{
            transform: scale(1.1);
        }
    </style>
@endsection


@section('body')
    <div class="mainBackWhiteBody">
        <div class="head">ایجاد تور: پیش از شروع</div>
        <div style="margin-top: 20px">
            <div class="topDesc">
                <p>
                    ما برای جلب رضایت کاربرانمان اطلاعات کاملی را از شما درخواست می‌کنیم.
                    مسئولیت صحت اطلاعات وارد شده و یا کافی بودن آن برعهده‌ی شماست. اما پیشنهاد ما بر ارائه‌ی کامل و دقیق اطلاعات مطابق
                    مراحل گام به گام طراحی شده می‌باشد. توجه کنید تمام تلاش ما حمایت همزمان از ارائه‌دهنده و مصرف‌کننده می‌باشد و ارائه‌ی هرگونه
                    اطلاعات نادرست و یا ناقص به گونه‌ای که احتمال استفاده از آن برای تضییع حقوق مصرف‌کنندگان باشد از نظر ما مردود است.
                    با ارائه‌ی شفاف اطلاعات به حقوق یکدیگر احترام می‌گذاریم. ما هم تلاش خود را به کار بردیم تا با استفاده از داده‌های شما
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
                        <span>اگر با مرامنامه و قوانین و مقررات سایت موافق هستید، لطفاً اطلاعات لازم را آماده نموده و شروع نمایید.</span>
                        <span>نگران نباشید. شما همواره از طریق پروفایل خود امکان ادامه ایجاد تور را خواهید داشت. هر اطلاعاتی که وارد می‌کنید به صورت موقت ذخیره می‌شود مگر آن‌که هشداری مبنی بر عدم صحت آن دریافت کنید.</span>
                        <span>این فرآیند تقریباً مابین ... الی ... دقیقه زمان می‌برد.</span>
                    </div>
                    <button id="termsAndConditionBtn" class="btn nextStepBtnTourCreation" onclick="openChooseTourKindModal()">شروع کنید</button>

{{--                    <a href="{{route('businessManagement.tour.create.stage_1', ['business' => $businessIdForUrl, 'tourId' => 0])}}">--}}
{{--                        <button id="termsAndConditionBtn" class="btn nextStepBtnTourCreation" onclick="openChooseTourKindModal()">شروع کنید</button>--}}
{{--                    </a>--}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div id="selectKindTour" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" style="direction: rtl">
                    <div class="fullwidthDiv" style="display: flex; justify-content: space-between;">
                        <div class="addPlaceGeneralInfoTitleTourCreation">قصد ایجاد چه نوع توری دارید؟</div>
                        <button type="button" class="closee" data-dismiss="modal" style="border: none; background: none; float: left">&times;</button>
                    </div>
                    <div class="selectEditCardSection">
                        <div class="editCard card1" onclick="chooseTourKind('cityTourism')">
                            <div class="icon">
                                <i class="fa-light fa-car-building"></i>
                            </div>
                            <div class="name">
                                <div class="text">شهرگردی</div>
                            </div>
                        </div>
                        <div class="editCard card2" onclick="chooseTourKind('oneDay')">
                            <div class="icon">
                                <i class="fa-light fa-map-location-dot"></i>
                            </div>
                            <div class="name">
                                <div class="text">سفریک روزه(بدون اقامت)</div>
                            </div>
                        </div>
                        <div class="editCard card3" onclick="chooseTourKind('multiDay')">
                            <div class="icon">
                                <i class="fa-light fa-island-tropical"></i>
                            </div>
                            <div class="name">
                                <div class="text">سفر چند روزه</div>
                            </div>
                        </div>
                        <div class="editCard card4" onclick="chooseTourKind('package')">
                            <div class="icon">
                                <i class="fa-light fa-box-open-full"></i>
                            </div>
                            <div class="name">
                                <div class="text">پک بلیط و هتل</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer fullyCenterContent">
                    <button class="btn " data-dismiss="modal">بستن</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        function openChooseTourKindModal(){
            $('#selectKindTour').modal('show');
        }

        function chooseTourKind(_type){
            openLoading();
            location.href = '{{url("businessManagement/{$businessIdForUrl}/tour/create/stage_1/0")}}/'+_type;
        }
    </script>
@endsection

