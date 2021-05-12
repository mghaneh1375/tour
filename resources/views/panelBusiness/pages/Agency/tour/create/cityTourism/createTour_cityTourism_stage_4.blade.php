@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>ویرایش تور: مرحله چهارم</title>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/tourCreation.css?v='.$fileVersions)}}"/>
    <script src="{{URL::asset('js/defualt/autosize.min.js')}}"></script>

    <style>
        @for($i = 0; $i < count($tourKind); $i++)
            #tourKind{{$tourKind[$i]->id}}:before{
                content: '\{{$tourKind[$i]->icon}}';
                /*font-family: shazdemosafer-tour;*/
                font-family: 'Shazde_Regular2' !important;
            }
        @endfor

        @foreach($tourDifficult as $difficult)

            #tourDifficult{{$difficult->id}}:before{
            content: '\{{$difficult->icon}}';
            font-family: 'Shazde_Regular2' !important;
        }

        @endforeach
    </style>

@endsection


@section('body')

    <div class="mainBackWhiteBody">
        <div class="head">ویرایش تور: مرحله چهارم</div>
        <div style="margin-top: 20px">
            <div class="whiteBox">
                <div id="tourKindChoseTitleTourCreation">
                    <span>نوع تور خود را مشخص کنید.</span>
                    <span onclick="$('#tourKindDescriptionModal').toggle()" style="cursor: pointer;">آیا نیازمند راهنمایی هستید؟</span>
                </div>
                <div class="inboxHelpSubtitle">انتخاب حداکثر سه گزینه مجاز می‌باشد</div>
                <div class="tourKindIconsTourCreation">
                    @foreach($tourKind as $kind)
                        @if($kind->name !== 'شهرگردی')
                            <div data-id="{{$kind->id}}"
                                 class="tourKind"
                                 onclick="chooseTourKind(this)"
                                 style="display: {{$kind->name == 'محلی' ? 'none': 'inline-block'}}; cursor: pointer;">

                                <div id="tourKind{{$kind->id}}" class="tourKindIcons"></div>
                                <div class="tourKindNames">{{$kind->name}}</div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="whiteBox">
                <div id="tourLevelChoseTitleTourCreation">
                    <span>درجه سختی تور خود را مشخص کنید.</span>
                    <span onclick="$('#tourDifficultDescriptionModal').toggle()" style="cursor: pointer;">آیا نیازمند راهنمایی هستید؟</span>
                </div>

                <div class="tourLevelIconsTourCreation">
                    @foreach($tourDifficult as $difficult)
                        <div>
                            <div id="tourDifficult{{$difficult->id}}"
                                 data-id="{{$difficult->id}}"
                                 class="tourLevelIcons {{$difficult->alone == 1 ? 'aloneDifficult' : ''}}"
                                 onclick="chooseDifficult(this)"></div>
                            <div>{{$difficult->name}}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="whiteBox">
                <div id="concentrationChoseTitleTourCreation">
                    <span>مناسب برای</span>
                    <span class="smallText">(حداکثر 2 مورد)</span>
                </div>
                <div class="inboxHelpSubtitle">اگر تور شما برای مخاطبان فوق مناسب است، آن را انتخاب کنید.</div>
                <div class="concentrationChoseTourCreation" style="width: 100%">
                    @foreach($tourFitFor as $fitFor)
                        <div class="col-md-3">
                            <input id="fitFor_{{$fitFor->id}}" type="checkbox" name="fitFor[]" value="{{$fitFor->id}}" onchange="checkTourFitForCount(this)"/>
                            <label for="fitFor_{{$fitFor->id}}">
                                <span></span>
                                {{$fitFor->name}}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="whiteBox">
                <div id="tourTypeChoseTitleTourCreation">
                    <span>تیپ خود را مشخص کنید.</span>
                    <span class="smallText">(حداکثر 3 مورد)</span>
                </div>
                <div class="inboxHelpSubtitle">تیپ گردشگران خود را با انتخاب حداکثر سه گزینه‌ی فوق، انتخاب نمایید.</div>
                <div class="tourTypeChoseChoseTourCreation">
                    @foreach($tourStyle as $style)
                        <div class="col-md-2">
                            <input id="tourStyle_{{$style->id}}" type="checkbox" name="style[]" value="{{$style->id}}" onchange="checkTourStyleCount(this)"/>
                            <label for="tourStyle_{{$style->id}}">
                                <span></span>
                                {{$style->name}}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="whiteBox ">
                <div class="boxTitlesTourCreation">چه همراه داشته باشیم</div>
                <div class="inboxHelpSubtitle">به مشتریان‌تان کمک کنید تا بدانند چه چیزی همراه داشته باشند. موارد ضروری مواردی است که حتماً باید همراه باشد و موارد پیشنهادی به تجربه‌‌ی بهتر کمک می‌کند.</div>
                <div class="inboxHelpSubtitle">ما لیست تمام موارد پیش‌بینی شده را در دسته‌بندی‌های مختلف آماده گرده‌ایم و شما تنها می‌بایست گزینه‌ی مورد نظر خود را گرفته و به داخل باکس مورد نظر خود بکشید.</div>
                <div>
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default equipmentSection">
                            <div class="panel-heading">
                                @for($i = 0; $i < count($mainEquipment); $i++)
                                    <div class="panel-title">
                                        <div id="mainEquipment{{$mainEquipment[$i]->id}}" class="{{$i == 0 ? 'selectTag' : ''}}" onclick="changeEquipment({{$mainEquipment[$i]->id}})">{{$mainEquipment[$i]->name}}</div>
                                    </div>
                                @endfor
                            </div>
                            @for($i = 0; $i < count($mainEquipment); $i++)
                                <div id="equipmentSection_{{$mainEquipment[$i]->id}}" class="panel-collapse collapse in" style="display: {{$i == 0 ? 'inline-block' : 'none' }}; padding-top: 0px;">
                                    <div class="title" style="text-align: center; font-weight: bold; margin-top: 10px; font-size: 19px;">{{$mainEquipment[$i]->name}}</div>
                                    <div class="panel-body">
                                        @foreach($mainEquipment[$i]->side as $item2)
                                            <div id="equipmentItem_{{$item2->id}}" class="draghere" data-id="{{$item2->id}}" draggable="true" ondragstart="drag(this)">{{$item2->name}}</div>
                                        @endforeach
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div id="necessaryItemsTourCreation" class="tourEquipmentItemsTourCreation essentialItemsTourCreation putDragSec" ondrop="drop('necessary')" ondragover="allowDrop(event)">
                        <span class="fullwidthDiv mg-bt-10">موارد ضروری</span>
                    </div>
                    <div id="suggestItemsTourCreation" class="tourEquipmentItemsTourCreation suggestionItemsTourCreation putDragSec" ondrop="drop('suggest')" ondragover="allowDrop(event)">
                        <span class="fullwidthDiv mg-bt-10">موارد پیشنهادی</span>
                    </div>
                </div>
            </div>

            <div class="whiteBox ">
                <div class="boxTitlesTourCreation">اگر عکسی دارید، آن را اضافه نمایید</div>
                <div class="inboxHelpSubtitle">اگر از تورهای پیشین خود با همین موضوع عکسی دارید حتماً آن را با مشتریان خود به اشتراک بگذارید</div>
                <div id="uploadImgDiv" class="fullwidthDiv">
                    <div id="picDiv0" style="display: inline-block; width: 23%; position: relative">
                        <input class="input-file" id="picsInput_0" name="pics[]" accept="image/*" type="file" onchange="readURL(this, 0);" style="display: none">
                        <div id="picHover_0" class="uploadHover hidden">
                            <div class="tickIcon hidden"></div>
                            <div class="warningIcon hidden"> اشکال در بارگذاری</div>
                            <div class="process">
                                <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                                <div class="processCounter">0%</div>
                            </div>
                            <div class="hoverInfos">
                                <div class="cancelButton closeIconWithCircle" onclick="deleteThisPic(0)" >
                                    حذف عکس
                                </div>
                            </div>
                        </div>

                        <label tabindex="0" for="picsInput_0" class="input-file-trigger" style="position: relative; width: 100%; margin: 0px;">
                            <div class="imgUploadsTourCreation imgAddDivTourCreation uploadImgCenter" style="width: 100%">
                                <div id="addPic0" class="addPicText" style="width: 100%">
                                    <img src="{{URL::asset('images/tourCreation/add.png')}}">
                                    <b>اضافه کنید</b>
                                </div>
                                <div id="showPic0" class="imgUploadsTourCreation hidden" style="width: 100%;">
                                    <img id="imgPic0" class="resizeImgClass" onload="fitThisImg(this)">
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="row submitAndPrevButton" style="padding: 15px;">
                <button class="btn nextStepBtnTourCreation" type="button" onclick="checkInput()">ثبت اطلاعات و رفتن به گام بعدی</button>
                <button class="btn nextStepBtnTourCreation goToPrevStep" type="button" onclick="goToPrevStep()" style="margin-right: auto">بازگشت به مرحله قبل</button>
            </div>
        </div>
    </div>
@endsection


@section('modals')
    <div id="picCardSample" style="display: none;">
        <div id="picDiv##index##" data-value="##index##" style="display: inline-block; width: 23%; position: relative">
            <input class="input-file" id="picsInput_##index##" type="file" accept="image/*" onchange="readURL(this, ##index##)" style="display: none">
            <div id="picHover_##index##" class="uploadHover hidden">
                <div class="tickIcon hidden"></div>
                <div class="warningIcon hidden"> اشکال در بارگذاری</div>
                <div class="process">
                    <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                    <div class="processCounter">0%</div>
                </div>
                <div class="hoverInfos">
                    <div class="cancelButton closeIconWithCircle" onclick="deleteThisPic(##index##)">حذف عکس</div>
                </div>
            </div>
            <label tabindex="##index##" for="picsInput_##index##" class="input-file-trigger" style="position: relative; width: 100%; margin: 0px;">
                <div class="imgUploadsTourCreation imgAddDivTourCreation uploadImgCenter" style="width: 100%">
                    <div id="addPic##index##" class="addPicText" style="width: 100%">
                        <img src="{{URL::asset('images/tourCreation/add.png')}}">
                        <b>اضافه کنید</b>
                    </div>
                    <div id="showPic##index##" class="imgUploadsTourCreation hidden" style="width: 100%;">
                        <img id="imgPic##index##" class="resizeImgClass" src="" onload="fitThisImg(this)">
                    </div>
                </div>
            </label>
        </div>
    </div>
@endsection

@section('script')
    <script defer src="{{URL::asset('js/uploadLargFile.js?v='.$fileVersions)}}"></script>

    <script>
        var tour = {!! $tour!!};
        var lastEquipment = '{{$mainEquipment[0]->id}}';
        var uploadedPics = {!! json_encode($tour->pics) !!};
        var tourPicUrl = '{{route("businessManagement.tour.store.pic")}}';

        var prevStageUrl = "{{route('businessManagement.tour.create.stage_3', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}";
        var nextStageUrl = "{{route('businessManagement.tour.create.stage_5', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}";
        var storeStageURL = "{{route('businessManagement.tour.store.stage_4')}}";

        var deleteTourPicUrl = '{{route("businessManagement.tour.delete.pic")}}';
    </script>

    <script defer src="{{URL::asset('BusinessPanelPublic/js/tour/create/cityTourism/cityTourism_stage_4.js?v='.$fileVersions)}}"></script>
@endsection

