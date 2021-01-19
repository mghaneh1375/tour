<?php $placeMode = "ticket";
$state = "تهران";
$kindPlaceId = 10; ?>

<!DOCTYPE html>
<html>
<head>
    @include('layouts.topHeader')
    {{--@include('layouts.phonePopUp')--}}
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/home_rebranded.css?v=4')}}"/>
    <title>صفحه اصلی</title>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/long_lived_global_legacy_2.css?v=2')}}"/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/masthead-saves.css?v=2')}}'/>
    <link rel='stylesheet' type='text/css' media='screen, print'
          href='{{URL::asset('css/theme2/hr_north_star.css?v=2')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/icons.css?v=1')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/passStyle.css?v=1')}}'/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/tourCreation.css?v=1')}}"/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/abbreviations.css?v=1')}}"/>

    <style>
        .uploadImgCenter{
            cursor: pointer;
            display: flex;
            justify-content: center;
            width: 100%;
            flex-direction: column;
            align-items: center;
        }
    </style>

</head>

<body id="BODY_BLOCK_JQUERY_REFLOW"
      class=" r_map_position_ul_fake ltr domn_en_US lang_en long_prices globalNav2011_reset rebrand_2017 css_commerce_buttons flat_buttons sitewide xo_pin_user_review_to_top track_back">

<div id="PAGE" class="filterSearch redesign_2015 non_hotels_like desktop scopedSearch">
    @include('layouts.placeHeader')
    <div class="ppr_rup ppr_priv_hr_atf_north_star_nostalgic">

        <div class="atf_header_wrapper">
            <div class="atf_header ui_container is-mobile full_width">

                <div class="ppr_rup ppr_priv_location_detail_header relative-position">
                    <h1 id="HEADING" property="name">
                        <b class="tourCreationMainTitle">شما در حال ایجاد یک تور جدید هستید</b>
                    </h1>
                    <div class="tourAgencyLogo circleBase type2"></div>
                    <b class="tourAgencyName">آژانس ستاره طلایی</b>
                </div>
            </div>
        </div>

        <div class="atf_meta_and_photos_wrapper">
            <div class="atf_meta_and_photos ui_container is-mobile easyClear">
                <div class="prw_rup darkGreyBox tourDetailsMainFormHeading">
                    <b class="formName">اطلاعات توضیحی</b>
                    <div class="tourCreationStepInfo">
                        <span>
                            گام
                            <span>5</span>
                            از
                            <span>6</span>
                        </span>
                        <span>
                            آخرین ویرایش
                            <span>
                                {{$tour->lastUpdate}}
                            </span>
                            <span>
                                {{$tour->lastUpdateTime}}
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="tourDetailsMainForm6thStepMainDiv" class="Hotel_Review prodp13n_jfy_overflow_visible lightGreyBox">
        <form method="post" action="{{route('tour.create.stage.five.store')}}" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <input type="hidden" name="tourId" value="{{$tour->id}}">

            <div class="ui_container">
                <div class="menu ui_container whiteBox whiteBoxSpecificInfo">
                    <div class="boxTitlesTourCreation">
                        معرفی کلی
                    </div>
                    <div class="inboxHelpSubtitle">
                        در کمتر از 100 کلمه تور خود را به طور کلی توصیف کنید
                    </div>
                    <div class="inputBox fullwidthDiv height-150">
                        <textarea class="inputBoxInput fullwidthDiv text-align-right full-height" name="mainDescription" placeholder="متن خود را وارد کنید"></textarea>
                    </div>
                </div>
            </div>
            <div class="ui_container">
                <div class="menu ui_container whiteBox whiteBoxSpecificInfo">
                    <div class="boxTitlesTourCreation">
                        نکات کلیدی
                    </div>
                    <div class="inboxHelpSubtitle">
                        حداکثر چهار نکته را به عنوان نکات کلیدی و مزیت اصلی تور خود بیان کنید.
                    </div>
                    <div class="inputBox fullwidthDiv height-50 mg-5-0">
                        <textarea class="inputBoxInput fullwidthDiv text-align-right full-height line-height-3" name="sideDescription[]" type="text" placeholder="نکته‌ی اول - حداکثر 30 کلمه"></textarea>
                    </div>
                    <div class="inputBox fullwidthDiv height-50 mg-5-0">
                        <textarea class="inputBoxInput fullwidthDiv text-align-right full-height line-height-3" name="sideDescription[]" type="text" placeholder="نکته‌ی دوم - حداکثر 30 کلمه"></textarea>
                    </div>
                    <div class="inputBox fullwidthDiv height-50 mg-5-0">
                        <textarea class="inputBoxInput fullwidthDiv text-align-right full-height line-height-3" name="sideDescription[]" type="text" placeholder="نکته‌ی سوم - حداکثر 30 کلمه"></textarea>
                    </div>
                    <div class="inputBox fullwidthDiv height-50 mg-5-0">
                        <textarea class="inputBoxInput fullwidthDiv text-align-right full-height line-height-3" name="sideDescription[]" type="text" placeholder="نکته‌ی چهارم - حداکثر 30 کلمه"></textarea>
                    </div>
                </div>
            </div>
            <div class="ui_container">
                <div class="menu ui_container whiteBox whiteBoxSpecificInfo">
                    <div class="boxTitlesTourCreation">
                        چه انتظاری داشته باشیم
                    </div>
                    <div class="inboxHelpSubtitle">
                        به صورت کاملاً شفاف به مشتریان‌تان بگویید از تور شما چه انتظاری داشته باشند و با چه چیزی روبرو می‌شوند - حداکثر 50 کلمه
                    </div>
                    <div class="inputBox fullwidthDiv height-150">
                        <textarea class="inputBoxInput fullwidthDiv text-align-right full-height" name="textExpectation" placeholder="متن خود را وارد کنید"></textarea>
                    </div>
                </div>
            </div>
            <div class="ui_container">
                <div class="menu ui_container whiteBox whiteBoxSpecificInfo">
                    <div class="boxTitlesTourCreation">
                        اطلاعات اختصاصی
                    </div>
                    <div class="inboxHelpSubtitle">
                        هر نوع اطلاعاتی که مختص تور شماست و دوست دارید مشتریان‌تان آن را بدانند در حداکثر 150 کلمه وارد نمایید
                    </div>
                    <div class="inputBox fullwidthDiv height-150">
                        <textarea class="inputBoxInput fullwidthDiv text-align-right full-height" name="specialInformation" placeholder="متن خود را وارد کنید"></textarea>
                    </div>
                </div>
            </div>
            <div class="ui_container">
                <div class="menu ui_container whiteBox whiteBoxSpecificInfo">
                    <div class="boxTitlesTourCreation">
                        پیشنهادات شما برای سفر بهتر
                    </div>
                    <div class="inboxHelpSubtitle">
                        هرنوع پیشنهاد، پیش‌نیاز، درخواست و یا مطلب اضافه‌ای که در صورت رعایت از سوی مشتران شما می‌تواندتضمین‌کننده‌ی تجربه‌ی بهتری باشد را وارد نمایید
                    </div>
                    <div class="inputBox fullwidthDiv height-150">
                        <textarea class="inputBoxInput fullwidthDiv text-align-right full-height" name="opinion" placeholder="متن خود را وارد کنید"></textarea>
                    </div>
                </div>
            </div>
            <div class="ui_container">
                <div class="menu ui_container whiteBox whiteBoxSpecificInfo">
                    <div class="boxTitlesTourCreation">
                        محدودیت‌های سفر
                    </div>
                    <div class="inboxHelpSubtitle">
                        هر نوع محدودیت که مشتریان شما در طول تور با ان مواجه می‌شوند و مجبور به رعایت آن می‌باشند را وارد نمایید
                    </div>
                    <div class="inputBox fullwidthDiv height-150">
                        <textarea class="inputBoxInput fullwidthDiv text-align-right full-height" name="tourLimit" placeholder="متن خود را وارد کنید"></textarea>
                    </div>
                </div>
            </div>
            <div class="ui_container">
                <div class="menu ui_container whiteBox whiteBoxSpecificInfo">
                    <div class="boxTitlesTourCreation">
                        چه همراه داشته باشیم
                    </div>
                    <div class="inboxHelpSubtitle">
                        به مشتریان‌تان کمک کنید تا بدانند چه چیزی همراه داشته باشند. موارد ضروری مواردی است که حتماً باید همراه باشد و موارد پیشنهادی به تجربه‌‌ی بهتر کمک می‌کند.
                    </div>
                    <div class="inboxHelpSubtitle">
                        ما لیست تمام موارد پیش‌بینی شده را در دسته‌بندی‌های مختلف آماده گرده‌ایم و شما تنها می‌بایست گزینه‌ی مورد نظر خود را گرفته و به داخل باکس مورد نظر خود بکشید.
                    </div>
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                @for($i = 0; $i < count($mainEquipment); $i++)
                                    <h4 class="panel-title">
                                        <a id="mainEquipment{{$mainEquipment[$i]->id}}" class="{{$i == 0 ? 'selectTag' : ''}}" onclick="changeEquipment({{$mainEquipment[$i]->id}})" style="cursor: pointer">{{$mainEquipment[$i]->name}}</a>
                                    </h4>
                                @endfor
                            </div>
                            @for($i = 0; $i < count($mainEquipment); $i++)
                                <div id="equipment{{$mainEquipment[$i]->id}}" class="panel-collapse collapse in" style="display: {{$i == 0 ? 'inline-block' : 'none' }}">
                                    <div class="panel-body">
                                        @foreach($mainEquipment[$i]->side as $item2)
                                            <div class="draghere">{{$item2->name}}</div>
                                        @endforeach
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div id="essentialItemsTourCreation" class="tourEquipmentItemsTourCreation">
                        <span class="fullwidthDiv mg-bt-10">
                            موارد ضروری
                        </span>
                        <div>
                            کپسول اطفای حریق
                        </div>
                        <div>
                            جعبه آچار
                        </div>
                    </div>
                    <div id="suggestionItemsTourCreation" class="tourEquipmentItemsTourCreation">
                        <span class="fullwidthDiv mg-bt-10">
                            موارد پیشنهادی
                        </span>
                        <div>
                            جعبه آچار
                        </div>
                    </div>
                </div>
            </div>
            <div class="ui_container">
                <div class="menu ui_container whiteBox whiteBoxSpecificInfo">
                    <div class="boxTitlesTourCreation">
                        اگر عکسی دارید، آن را اضافه نمایید
                    </div>
                    <div class="inboxHelpSubtitle">
                        اگر از تورهای پیشین خود با همین موضوع عکسی دارید حتماً آن را با مشتریان خود به اشتراک بگذارید
                    </div>
                    <div id="uploadImgDiv" class="fullwidthDiv">

                        <div id="picDiv0" style="display: inline-block; width: 23%">
                            <input class="input-file" id="pics0" name="pics[]" type="file" onchange="readURL(this, 0);" style="display: none">
                            <label tabindex="0" for="pics0" class="input-file-trigger" style="position: relative; width: 100%;">
                                <center class="imgUploadsTourCreation imgAddDivTourCreation uploadImgCenter" >
                                    <div id="addPic0" style="width: 100%">
                                        <div class="fullwidthDiv">
                                            <img src="{{URL::asset('images/tourCreation/add.png')}}">
                                        </div>
                                        <b>اضافه کنید</b>
                                    </div>
                                    <div id="showPic0" class="imgUploadsTourCreation" style="width: 100%; display: none;">
                                        <img id="imgPic0" >
                                        <button type="button" class="deleteBtnImgTourCreation" onclick="deletePicFunc(0)">
                                            <img src="{{URL::asset("images/tourCreation/delete.png")}}">
                                        </button>
                                    </div>
                                </center>
                            </label>
                        </div>

                    </div>
                </div>
            </div>
            <div class="ui_container">
                <div class="menu ui_container whiteBox">
                    <div class="boxTitlesTourCreation">
                        <span>شرایط کنسلی</span>
                    </div>
                    <div class="inboxHelpSubtitle">
                        شرایط کنسلی تور خود را به اطلاع مسافران خود برسانید.
                    </div>
                    <div class="tourGuiderQuestions mg-tp-15">
                        <span>آیا تور شما دارای کنسلی می‌باشد؟</span>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary">
                                <input type="radio" name="isCancelAbel" value="0" onchange="changeCancelAble(this.value)">خیر
                            </label>
                            <label class="btn btn-secondary active">
                                <input type="radio" name="isCancelAbel" value="1" onchange="changeCancelAble(this.value)" checked>بلی
                            </label>
                        </div>
                    </div>
                    <div id="cancelDiv">
                        <div class="inboxHelpSubtitle">
                            در این صورت یا شرایط آن را توضیح دهید و یا از ساختار پیش‌فرض استفاده نمایید و اگر ترجیح می‌دهید از هر دو.
                        </div>
                        <div class="inputBox cancellingSituationTourCreation height-250">
                            <textarea class="inputBoxInput fullwidthDiv text-align-right full-height" name="cancelDescription" placeholder="متن خود را وارد کنید"></textarea>
                        </div>

                        {{--<div class="cancellingSituationTourCreation optionalCancellingTourCreation">--}}
                            {{--<b class="fullwidthDiv mg-bt-5">عودت تمام هزینه</b>--}}
                            {{--<span class="mg-lt-6">کنسل نمودن قبل از</span>--}}
                            {{--<div class="inputBox deadlineText">--}}
                                {{--<input class="inputBoxInput" type="text" placeholder="عدد">--}}
                            {{--</div>--}}
                            {{--<div class="btn-group btn-group-toggle mg-lt-6" data-toggle="buttons">--}}
                                {{--<label class="btn btn-secondary">--}}
                                    {{--<input type="radio" name="options" id="option1" autocomplete="off">ساعت--}}
                                {{--</label>--}}
                                {{--<label class="btn btn-secondary active">--}}
                                    {{--<input type="radio" name="options" id="option2" autocomplete="off" checked>روز--}}
                                {{--</label>--}}
                            {{--</div>--}}
                            {{--<span>مانده به شروع تور</span>--}}
                        {{--</div>--}}
                        {{--<div class="cancellingSituationTourCreation optionalCancellingTourCreation relative-position">--}}
                            {{--<div class="fullwidthDiv mg-bt-5">--}}
                                {{--<b class="inline-block">عودت بخشی از هزینه</b>--}}
                                {{--<span class="inline-block addingCancellingOption">در صورت نیاز اضافه کنید</span>--}}
                            {{--</div>--}}
                            {{--<span class="mg-lt-6">کنسل نمودن قبل از</span>--}}
                            {{--<div class="inputBox deadlineText">--}}
                                {{--<input class="inputBoxInput" type="text" placeholder="عدد">--}}
                            {{--</div>--}}
                            {{--<div class="btn-group btn-group-toggle mg-lt-6 mg-rt-6" data-toggle="buttons">--}}
                                {{--<label class="btn btn-secondary">--}}
                                    {{--<input type="radio" name="options" id="option1" autocomplete="off">ساعت--}}
                                {{--</label>--}}
                                {{--<label class="btn btn-secondary active">--}}
                                    {{--<input type="radio" name="options" id="option2" autocomplete="off" checked>روز--}}
                                {{--</label>--}}
                            {{--</div>--}}
                            {{--<span class="mg-lt-6">مانده به شروع تور</span>--}}
                            {{--<div class="inputBox deadlineText width-50">--}}
                                {{--<input class="inputBoxInput" type="text" placeholder="جریمه %">--}}
                            {{--</div>--}}
                            {{--<span class="glyphicon glyphicon-plus addOrRemoveCancellingOption"></span>--}}
                            {{--<span class="glyphicon glyphicon-minus addOrRemoveCancellingOption"></span>--}}
                        {{--</div>--}}
                        {{--<div class="cancellingSituationTourCreation optionalCancellingTourCreation mg-tp-30">--}}
                            {{--<div class="fullwidthDiv mg-bt-5">--}}
                                {{--<b class="inline-block">عدم عودت پول</b>--}}
                                {{--<span class="inline-block addingCancellingOption">یک یا چند گزینه</span>--}}
                            {{--</div>--}}
                            {{--<div class="fullwidthDiv">--}}
                                {{--<input ng-model="sort" type="checkbox" id="c01" value="rate"/>--}}
                                {{--<label for="c01">--}}
                                    {{--<span></span>--}}
                                {{--</label>--}}
                                {{--<span id="">--}}
                                {{--پس از تهیه ی بلیط سفر--}}
                            {{--</span>--}}
                            {{--</div>--}}
                            {{--<div class="fullwidthDiv">--}}
                                {{--<input ng-model="sort" type="checkbox" id="c61" value="rate"/>--}}
                                {{--<label for="c61">--}}
                                    {{--<span></span>--}}
                                {{--</label>--}}
                                {{--<span id="">--}}
                                {{--پس از اخذ ویزا--}}
                            {{--</span>--}}
                            {{--</div>--}}
                            {{--<div class="fullwidthDiv">--}}
                                {{--<input ng-model="sort" type="checkbox" id="c71" value="rate"/>--}}
                                {{--<label for="c71" class="float-right">--}}
                                    {{--<span></span>--}}
                                {{--</label>--}}
                                {{--<span class="mg-lt-6 float-right">کنسل نمودن قبل از</span>--}}
                                {{--<div class="inputBox deadlineText float-right">--}}
                                    {{--<input class="inputBoxInput" type="text" placeholder="عدد">--}}
                                {{--</div>--}}
                                {{--<div class="btn-group btn-group-toggle mg-lt-6 mg-rt-6" data-toggle="buttons">--}}
                                    {{--<label class="btn btn-secondary">--}}
                                        {{--<input type="radio" name="options" id="option1" autocomplete="off">ساعت--}}
                                    {{--</label>--}}
                                    {{--<label class="btn btn-secondary active">--}}
                                        {{--<input type="radio" name="options" id="option2" autocomplete="off" checked>روز--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                                {{--<span class="mg-lt-6">مانده به شروع تور</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                    </div>
                </div>
            </div>
            <div class="ui_container">
                <button type="submit" id="goToSixthStep" class="btn nextStepBtnTourCreation">گام بعدی</button>
            </div>
        </form>
    </div>

    @include('layouts.footer.layoutFooter')
</div>
<script>

    var lastEquipment = '{{$mainEquipment[0]->id}}';
    var deletePic = "{{URL::asset('images/tourCreation/delete.png')}}";
    var addPic = "{{URL::asset('images/tourCreation/add.png')}}";
    var isCancelAbel = 1;
    var picInput = 1;
    var picStatus = [0];

    function changeEquipment(_id){
        document.getElementById('equipment' + lastEquipment).style.display = 'none';
        document.getElementById('equipment' + _id).style.display = 'inline-block';

        document.getElementById('mainEquipment' + lastEquipment).classList.remove('selectTag');
        document.getElementById('mainEquipment' + _id).classList.add('selectTag');

        lastEquipment = _id;
    }

    function changeCancelAble(_value){
        isCancelAbel = _value;

        if(isCancelAbel == 1)
            document.getElementById('cancelDiv').style.display = 'block';
        else
            document.getElementById('cancelDiv').style.display = 'none';
    }

    function readURL(input, _index) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var text = '<div id="picDiv' + picInput + '" style="display: inline-block; width: 23%"><input class="input-file" id="pics' + picInput + '" name="pics[]" type="file" onchange="readURL(this, ' + picInput + ');" style="display: none">\n' +
                '                        <label tabindex="0" for="pics' + picInput + '" class="input-file-trigger" style="position: relative; width: 100%;">\n' +
                '                            <center class="imgUploadsTourCreation imgAddDivTourCreation uploadImgCenter" >\n' +
                '                                <div id="addPic' + picInput + '" style="width: 100%">\n' +
                '                                    <div class="fullwidthDiv">\n' +
                '                                        <img src="' + addPic + '">\n' +
                '                                    </div>\n' +
                '                                    <b>اضافه کنید</b>\n' +
                '                                </div>\n' +
                '                                <div id="showPic' + picInput + '" class="imgUploadsTourCreation" style="width: 100%; display: none;">\n' +
                '                                    <img id="imgPic' + picInput + '" src="">\n' +
                '                                    <button type="button" class="deleteBtnImgTourCreation" onclick="deletePicFunc(' + picInput + ')">\n' +
                '                                        <img src="' + deletePic + '">\n' +
                '                                    </button>\n' +
                '                                </div>\n' +
                '                            </center>\n' +
                '                        </label></div>';

            document.getElementById('addPic' + _index).style.display = 'none';
            document.getElementById('showPic' + _index).style.display = 'block';

            reader.onload = function (e) {
                $('#imgPic' + _index)
                    .attr('src', e.target.result);
                if(picStatus[_index] == 0) {
                    $('#uploadImgDiv').append(text);
                    picStatus[_index] = 1;
                    picStatus[picInput] = 0;
                    picInput++;
                }
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function deletePicFunc(_index){
        $('#picDiv' + _index).remove();
    }
</script>
</body>
</html>
