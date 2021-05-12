@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>مرحله چهارم</title>
    <link rel="stylesheet" href="{{URL::asset('css/theme2/bootstrap-datepicker.css')}}">
    <script src="{{URL::asset("js/bootstrap-datepicker.js")}}"></script>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/tourCreation.css?v='.$fileVersions)}}"/>

    <style>
        .verifyBtnTourCreation{
            left: 100px;
            background-color: var(--koochita-light-green);
            bottom: 13px;
            cursor: pointer;
        }

        .tourOtherPrice{
            border-bottom: solid 1px lightgray;
            padding: 20px 0px;
            margin-bottom: 0;
            position: relative;
        }
        .deleteButton{
            position: absolute;
            left: 15px;
            background: var(--koochita-red);
            padding: 4px 15px;
            border-radius: 10px;
            top: 20%;
            cursor: pointer;
            color: white;
        }
        .newPriceButton{
            background: var(--koochita-blue);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px;
            margin-top: 20px;
            box-shadow: 1px 1px 4px 1px grey;
            cursor: pointer;
        }

        .forceHidden{
            display: none !important;
        }

        select option:disabled{
            background: lightgrey;
        }


        .dayToDiscountRow{
            display: flex;
            align-items: center;
        }
        .dayToDiscountRow .textSec{
            align-items: center;
            display: flex;
            margin: 0px 10px;
        }
        .dayToDiscountRow .dayInput{
            width: 100px;
            background: #ebebeb;
            padding: 3px 0px;
            margin: 0px 10px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            text-align: center;
        }

    </style>
@endsection


@section('body')

    <div class="mainBackWhiteBody">
        <div class="head">ایجاد تور: مرحله چهارم</div>
        <div style="margin-top: 20px">
            <div class="whiteBox" style="display: flex; flex-direction: column;">
                <div class="col-md-12">
                    <div class="boxTitlesTourCreation">قیمت پایه</div>
                    <div class="inboxHelpSubtitle">قیمت پایه‌ی تور قیمتی است که فارغ از هرگونه امکانات اضافه بدست آمده است و کمترین قیمتی است که کاربران می‌توانند تور را با آن خریداری نمایند. اگر برخی امکانات قیمت تور را تغییر می‌دهد، آن‌ها را در قسمت‌های بعدی وارد نمایید.</div>
                    <div class="tourBasicPriceTourCreation col-md-6" style="display: flex; align-items: center">
                        <div class="inputBoxTour col-md-10">
                            <div class="inputBoxText">
                                <div class="importantFieldLabel">قیمت پایه</div>
                            </div>
                            <input class="inputBoxInput" id="tourCost" type="text" placeholder="ریال" onkeyup="$(this).val(numberWithCommas(this.value))">
                        </div>
                        <div id="tourInsuranceConfirmation" class="col-md-10 pd-0" style="margin-right: 25px;">
                            <span>آیا تور شما دارای بیمه می‌باشد؟</span>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary active">
                                    <input type="radio" name="isInsurance" value="1" checked>بلی
                                </label>
                                <label class="btn btn-secondary">
                                    <input type="radio" name="isInsurance" value="0">خیر
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <div class="inboxHelpSubtitle">اگر تور شما به ازای سن های مختلف قیمت متفاوتی دارد، در زیر می توانید قیمت ها را به ازای سن تعریف کنید.</div>
                    <div id="pricesSection" class="fullyCenterContent" style="display: flex; flex-direction: column;"></div>

                    <div class="fullyCenterContent">
                        <button class="newPriceButton" onclick="createNewPriceRow()">افزودن قیمت جدید</button>
                    </div>
                </div>
                {{--            <div class="tourTicketKindTourCreation col-md-6">--}}
                {{--                <div class="inputBoxTour col-md-10" >--}}
                {{--                    <div class="inputBoxText">--}}
                {{--                        <div>--}}
                {{--                            نوع بلیط--}}
                {{--                            <span>*</span>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <div class="select-side">--}}
                {{--                        <i class="glyphicon glyphicon-triangle-bottom"></i>--}}
                {{--                    </div>--}}
                {{--                    <select id="ticketKind" class="inputBoxInput styled-select">--}}
                {{--                        <option value="fast">بلیط با امکان رزرو سریع</option>--}}
                {{--                        <option value="call">بلیط نیازمند تماس با ارایه دهنده</option>--}}
                {{--                    </select>--}}
                {{--                </div>--}}
                {{--                <div class="col-md-10 pd-0">--}}
                {{--                    <span class="inboxHelpSubtitleBlue">نیاز به راهنمایی دارید؟</span>--}}
                {{--                </div>--}}
                {{--            </div>--}}
            </div>

            <div class="whiteBox">
                <div class="boxTitlesTourCreation">امکانات اضافه</div>
                <div class="inboxHelpSubtitle">سایر امکاناتی که شما در تور با دریافت هزینه‌ی اضافه ارئه می‌دهید را وارد نمایید.</div>
                <div style="position: relative">
                    <div id="featuresDiv"></div>
                    <button type="button"  class="tourMoreFacilityDetailsBtn verifyBtnTourCreation" onclick="createFeatureRow()">
                        <img src="{{URL::asset("images/tourCreation/approve.png")}}">
                    </button>
                </div>
            </div>

            <div class="whiteBox">
                <div class="fullwidthDiv">
                    <div class="boxTitlesTourCreation">تخفیف خرید گروهی</div>
                    <div class="inboxHelpSubtitle">تخفیف‌های گروهی به خریداران ظرفیت‌های بالا اعمال می‌شود. شما می‌توانید با تعیین بازه‌های متفاوت تخفیف‌های متفاوتی اعمال نمایید.</div>
                    <div id="groupDiscountDiv"></div>
                </div>
            </div>

            <div class="whiteBox">
                <div class="fullwidthDiv">
                    <div class="boxTitlesTourCreation">تخفیف های لحظه اخری</div>
                    <div id="lastDayesDiscounts" style="display: flex; flex-direction: column;"></div>
                    <div class="fullyCenterContent">
                        <button class="newPriceButton" onclick="addLastDayDiscount()">افزودن تخفیف لحظه آخری</button>
                    </div>
                </div>
            </div>


            <div class="row fullyCenterContent" style="padding: 15px;">
                <button class="btn nextStepBtnTourCreation" type="button" onclick="checkInput()">گام بعدی</button>
                <button class="btn nextStepBtnTourCreation goToPrevStep" type="button" onclick="goToPrevStep()">بازگشت به مرحله قبل</button>
            </div>
        </div>
    </div>
@endsection

@section('modals')

    <div id="featureRowSample" style="display: none">
        <div id="features_##index##" data-index="##index##" class="row featuresRow">
            <div class="inputBoxTour float-right col-md-2" >
                <input id="featureName_##index##" class="inputBoxInput moreFacilityInputs" type="text" placeholder="نام">
            </div>
            <div class="inputBoxTour float-right col-md-3 mg-rt-10" >
                <input id="featureDesc_##index##" class="inputBoxInput moreFacilityInputs" type="text" placeholder="توضیحات" maxlength="250">
            </div>
            <div class="inputBoxTour float-right col-md-3 mg-rt-10 relative-position" >
                <input id="featureCost_##index##" class="inputBoxInput moreFacilityInputs" type="text" placeholder="ریال" onkeyup="$(this).val(numberWithCommas(this.value))">
                <div class="inboxHelpSubtitle" style="position: absolute; top: 100%;">میزان افزایش قیمت را وارد نمایید.</div>
            </div>

            <div class="col-md-2" style="text-align: left; position: relative">
                <div class="deleteButton" style="position: relative; bottom: 0; left: 0; top: 0; width: 50px;" onclick="deleteFeatureRow(##index##)">
                    <i class="fa-light fa-trash-can"></i>
                </div>
{{--                <button type="button" class="tourMoreFacilityDetailsBtn deleteBtnTourCreation">--}}
{{--                    <i class="fa-light fa-trash-can"></i>--}}
{{--                </button>--}}
            </div>
        </div>
    </div>

    <div id="discountSample" style="display: none">
        <div id="groupDiscount_##index##" data-index="##index##" class="col-md-12 pd-0 discountrow" style="display: flex">
            <div class="inputBox discountLimitationWholesale float-right">
                <div class="inputBoxText">
                    <div class="importantFieldLabel">بازه‌ی تخفیف</div>
                </div>
                <input id="disCountFrom_##index##" class="inputBoxInput startDisCountNumber" type="number" placeholder="از" onkeyup="checkDiscount(##index##, this.value, 0)" onchange="checkAllDiscount()">
                <div class="inputBoxText">
                    <div>الی</div>
                </div>
                <input id="disCountTo_##index##" class="inputBoxInput endDisCountNumber" type="number" placeholder="تا" onkeyup="checkDiscount(##index##, this.value, 1)" onchange="checkAllDiscount()">
                <div class="inputBoxText">
                    <div class="importantFieldLabel">درصد تخفیف</div>
                </div>
                <input id="disCountCap_##index##" class="inputBoxInput no-border-imp" type="number" placeholder="درصد تخفیف">
            </div>
            <div class="inline-block mg-tp-12 mg-rt-10">
                <button type="button" class="wholesaleDiscountLimitationBtn verifyBtnTourCreation confirmDisCountButton" onclick="createDisCountCard()">
                    <img src="{{URL::asset("images/tourCreation/approve.png")}}">
                </button>
                <button type="button" class="wholesaleDiscountLimitationBtn deleteBtnTourCreation deleteDisCountButton hidden" onclick="deleteDisCountCard(##index##)">
                    <img src="{{URL::asset("images/tourCreation/delete.png")}}">
                </button>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script>
        var tour = {!! $tour!!};
        var prevStageUrl = "{{route('businessManagement.tour.create.stage_3', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}";
        var nextStageUrl = "{{route('businessManagement.tour.create.stage_5', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}";
        var storeStageFourURL = "{{route('businessManagement.tour.store.stage_4')}}";

        var sideMenuAdditional = {
            title: 'ویرایش تور',
            sub: [
                {
                    title: 'اطلاعات اولیه',
                    icon: '<i class="fa-duotone fa-info"></i>',
                    url: "{{route('businessManagement.tour.create.stage_1', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}",
                },
                {
                    title: 'برنامه سفر',
                    icon: '<i class="fa-duotone fa-calendar-pen"></i>',
                    url: "{{route('businessManagement.tour.create.stage_2', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}",
                },
                {
                    title: 'اطلاعات برگزاری',
                    icon: '<i class="fa-duotone fa-plane-tail"></i>',
                    url: "{{route('businessManagement.tour.create.stage_3', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}",
                },
                {
                    title: 'اطلاعات مالی',
                    icon: '<i class="fa-duotone fa-sack-dollar"></i>',
                    url: "{{route('businessManagement.tour.create.stage_4', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}",
                    selected: 1
                },
                {
                    title: 'اطلاعات اضافی',
                    icon: '<i class="fa-duotone fa-clipboard-list-check"></i>',
                    url: "{{route('businessManagement.tour.create.stage_5', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}",
                },
            ]
        };
        createNewMenuSideBar(sideMenuAdditional);
    </script>

    <script src="{{URL::asset('BusinessPanelPublic/js/tour/create/tourCreate_stage_4.js?v='.$fileVersions)}}"></script>
@endsection
