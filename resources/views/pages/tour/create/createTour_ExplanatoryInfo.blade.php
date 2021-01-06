@extends('pages.tour.create.layout.createTour_Layout')

@section('head')


    <style>

        @for($i = 0; $i < count($tourKind); $i++)
        #tourKind{{$tourKind[$i]->id}}:before{
            content: '\{{$tourKind[$i]->icon}}';
            /*font-family: shazdemosafer-tour;*/
            font-family: 'Shazde_Regular2' !important;
        }
        @endfor

        .tourKind:hover{
            background: var(--koochita-light-green);
        }

        .tourLevelIcons::before{
            width: 100%;
            display: flex;
            font-weight: normal;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }
        .tourLevelIcons{
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            cursor: pointer;
        }
        .tourLevelIcons:hover{
            background: var(--koochita-light-green);
            color: white;
        }
        .tourKindIcons:hover{
            background: var(--koochita-light-green);
        }
        @foreach($tourDifficult as $difficult)

            #tourDifficult{{$difficult->id}}:before{
                content: '\{{$difficult->icon}}';
                font-family: 'Shazde_Regular2' !important;
            }

        @endforeach

        .uploadHover{
            position: absolute;
            top: 0px;
            right: 0px;
            width: 100%;
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9;
            background: #00000069;
        }
        .uploadHover .tickIcon{
            color: lime;
            font-size: 85px;
            border: solid 10px;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .uploadHover .warningIcon{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: var(--koochita-yellow);
        }
        .uploadHover .warningIcon:before{
            font-size: 60px;
            font-weight: normal;
        }
        .uploadHover .process{
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        .uploadHover .process .processCounter{
            position: absolute;
            font-size: 22px;
            color: white;
        }


        .uploadHover .hoverInfos{
            position: absolute;
            top: 0px;
            right: 0px;
            display: none;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            z-index: 999;
            background: #000000b0;
            color: red;
            cursor: pointer;
        }
        .uploadHover .hoverInfos .cancelButton{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-size: 22px;
        }
        .uploadHover .hoverInfos .cancelButton:before{
            font-size: 55px;
        }
        .uploadHover:hover .hoverInfos{
            display: flex;
        }
    </style>

@endsection

@section('body')

    @include('pages.tour.create.layout.createTour_Header', ['createTourStep' => 6])

    <div class="ui_container">

        <div class="whiteBox">
            <div id="tourKindChoseTitleTourCreation">
                <span>نوع تور خود را مشخص کنید.</span>
                <span onclick="$('#tourKindDescriptionModal').toggle()" style="cursor: pointer;">آیا نیازمند راهنمایی هستید؟</span>
            </div>
            <div class="tourKindIconsTourCreation">
                @foreach($tourKind as $kind)
                    <div data-id="{{$kind->id}}"
                         class="tourKind"
                         onclick="chooseTourKind(this)"
                         style="display: {{$kind->name == 'محلی' ? 'none': 'inline-block'}}; cursor: pointer;">

                        <div id="tourKind{{$kind->id}}" class="tourKindIcons"></div>
                        <div class="tourKindNames">{{$kind->name}}</div>
                    </div>
                @endforeach
            </div>
            <div class="inboxHelpSubtitle">انتخاب بیش از یک گزینه مجاز می‌باشد</div>
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
            <div class="inboxHelpSubtitle">انتخاب گزینه‌های
                @foreach($tourDifficult as $item)
                    @if($item->alone == 0)
                        {{$item->name}} ,
                    @endif
                @endforeach
                با گزینه‌های دیگر مجاز
                می‌باشد.
            </div>
        </div>

        <div class="whiteBox">
            <div id="concentrationChoseTitleTourCreation">تمرکز خود را مشخص کنید.</div>
            <div class="concentrationChoseTourCreation">
                @foreach($tourFocus as $focus)
                    <div class="col-xs-2">
                        <input id="focus_{{$focus->id}}" type="checkbox" name="focus[]" value="{{$focus->id}}"/>
                        <label for="focus_{{$focus->id}}">
                            <span></span>
                            {{$focus->name}}
                        </label>
                    </div>
                @endforeach
            </div>
            <div class="inboxHelpSubtitle">از بین گزینه‌های فوقمواردی را که بهتر تمرکز تور شما را بیان می‌کند،انتخاب نمایید.</div>
        </div>

        <div class="whiteBox">
            <div id="tourTypeChoseTitleTourCreation">تیپ خود را مشخص کنید.</div>
            <div class="tourTypeChoseChoseTourCreation">
                @foreach($tourStyle as $style)
                    <div class="col-xs-2">
                        <input id="tourStyle_{{$style->id}}" type="checkbox" name="style[]" value="{{$style->id}}"/>
                        <label for="tourStyle_{{$style->id}}">
                            <span></span>
                            {{$style->name}}
                        </label>
                    </div>
                @endforeach
            </div>
            <div class="inboxHelpSubtitle">تیپ گردشگران خود را با انتخاب یک یا چند گزینه‌ی فوق، انتخاب نمایید.</div>
        </div>

        <div class="whiteBox ">
            <div class="boxTitlesTourCreation">معرفی کلی</div>
            <div class="inboxHelpSubtitle">در کمتر از 100 کلمه تور خود را به طور کلی توصیف کنید</div>
            <div class="inputBox fullwidthDiv height-150">
                <textarea id="mainDescription" class="inputBoxInput fullwidthDiv text-align-right full-height" placeholder="متن خود را وارد کنید"></textarea>
            </div>
        </div>

        <div class="whiteBox ">
            <div class="boxTitlesTourCreation">نکات کلیدی</div>
            <div class="inboxHelpSubtitle">حداکثر چهار نکته را به عنوان نکات کلیدی و مزیت اصلی تور خود بیان کنید.</div>
            <div class="inputBox fullwidthDiv height-50 mg-5-0">
                <input type="text" class="inputBoxInput fullwidthDiv text-align-right full-height line-height-3" name="sideDescription[]" placeholder="نکته‌ی اول - حداکثر 30 کلمه"/>
            </div>
            <div class="inputBox fullwidthDiv height-50 mg-5-0">
                <input type="text" class="inputBoxInput fullwidthDiv text-align-right full-height line-height-3" name="sideDescription[]" placeholder="نکته‌ی دوم - حداکثر 30 کلمه"/>
            </div>
            <div class="inputBox fullwidthDiv height-50 mg-5-0">
                <input type="text" class="inputBoxInput fullwidthDiv text-align-right full-height line-height-3" name="sideDescription[]" placeholder="نکته‌ی سوم - حداکثر 30 کلمه"/>
            </div>
            <div class="inputBox fullwidthDiv height-50 mg-5-0">
                <input type="text" class="inputBoxInput fullwidthDiv text-align-right full-height line-height-3" name="sideDescription[]" placeholder="نکته‌ی چهارم - حداکثر 30 کلمه"/>
            </div>
        </div>

        <div class="whiteBox ">
            <div class="boxTitlesTourCreation">چه انتظاری داشته باشیم</div>
            <div class="inboxHelpSubtitle">به صورت کاملاً شفاف به مشتریان‌تان بگویید از توز شما چه انتظاری داشته باشند و با چه چیزی روبرو می‌شوند - حداکثر 50 کلمه</div>
            <div class="inputBox fullwidthDiv height-150">
                <textarea id="textExpectation" class="inputBoxInput fullwidthDiv text-align-right full-height" placeholder="متن خود را وارد کنید"></textarea>
            </div>
        </div>

        <div class="whiteBox ">
            <div class="boxTitlesTourCreation">اطلاعات اختصاصی</div>
            <div class="inboxHelpSubtitle">هر نوع اطلاعاتی که مختص تور شماست و دوست دارید مشتریان‌تان آن را بدانند در حداکثر 150 کلمه وارد نمایید</div>
            <div class="inputBox fullwidthDiv height-150">
                <textarea id="specialInformation" class="inputBoxInput fullwidthDiv text-align-right full-height" placeholder="متن خود را وارد کنید"></textarea>
            </div>
        </div>

        <div class="whiteBox ">
            <div class="boxTitlesTourCreation">پیشنهادات شما برای سفر بهتر</div>
            <div class="inboxHelpSubtitle">هرنوع پیشنهاد، پیش‌نیاز، درخواست و یا مطلب اضافه‌ای که در صورت رعایت از سوی مشتران شما می‌تواندتضمین‌کننده‌ی تجربه‌ی بهتری باشد را وارد نمایید</div>
            <div class="inputBox fullwidthDiv height-150">
                <textarea id="opinionText" class="inputBoxInput fullwidthDiv text-align-right full-height" placeholder="متن خود را وارد کنید"></textarea>
            </div>
        </div>

        <div class="whiteBox ">
            <div class="boxTitlesTourCreation">محدودیت‌های سفر</div>
            <div class="inboxHelpSubtitle"> هر نوع محدودیت که مشتریان شما در طول تور با ان مواجه می‌شوند و مجبور به رعایت آن می‌باشند را وارد نمایید</div>
            <div class="inputBox fullwidthDiv height-150">
                <textarea id="tourLimit" class="inputBoxInput fullwidthDiv text-align-right full-height" placeholder="متن خود را وارد کنید"></textarea>
            </div>
        </div>

        <div class="whiteBox ">
            <div class="boxTitlesTourCreation">چه همراه داشته باشیم</div>
            <div class="inboxHelpSubtitle">به مشتریان‌تان کمک کنید تا بدانند چه چیزی همراه داشته باشند. موارد ضروری مواردی است که حتماً باید همراه باشد و موارد پیشنهادی به تجربه‌‌ی بهتر کمک می‌کند.</div>
            <div class="inboxHelpSubtitle">ما لیست تمام موارد پیش‌بینی شده را در دسته‌بندی‌های مختلف آماده گرده‌ایم و شما تنها می‌بایست گزینه‌ی مورد نظر خود را گرفته و به داخل باکس مورد نظر خود بکشید.</div>
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
                        <div id="equipmentSection_{{$mainEquipment[$i]->id}}" class="panel-collapse collapse in" style="display: {{$i == 0 ? 'inline-block' : 'none' }}">
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

        <div class="whiteBox">
            <div class="boxTitlesTourCreation">شرایط کنسلی</div>
            <div class="inboxHelpSubtitle">شرایط کنسلی تور خود را به اطلاع مسافران خود برسانید.</div>
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
                <div class="inboxHelpSubtitle" style="width: 100%">در این صورت شرایط آن را توضیح دهید.</div>
                <div class="inputBox cancellingSituationTourCreation height-250">
                    <textarea id="cancelDescription" class="inputBoxInput fullwidthDiv text-align-right full-height" placeholder="متن خود را وارد کنید"></textarea>
                </div>
            </div>
        </div>

        <div class="row" style="padding: 15px;">
            <button class="btn nextStepBtnTourCreation" type="button" onclick="checkInput()">گام بعدی</button>
        </div>
    </div>

    <div id="picCardSample" style="display: none;">
        <div id="picDiv##index##" data-value="##index##" style="display: inline-block; width: 23%; position: relative">
            <input class="input-file" id="picsInput_##index##" type="file" accept="image/*" onchange="readURL(this, ##index##);" style="display: none">
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

    <script defer src="{{URL::asset('js/uploadLargFile.js')}}"></script>

    <script>
        var tour = {!! $tour !!};
        var lastEquipment = '{{$mainEquipment[0]->id}}';
        var selectedEquipment = tour.euipment;
        var dragedElementId = 0;

        var storeData = {
            levels: tour.levels,
            kinds: tour.kinds,
            focus: tour.focus,
            style: tour.style,
            equipment: selectedEquipment,
            mainDescription: tour.description,
            textExpectation: tour.textExpectation,
            specialInformation: tour.specialInformation,
            opinion: tour.opinion,
            tourLimit: tour.tourLimit,
            sideDescription: tour.sideDescription,

            isCancelAbel: tour.cancelAble,
            cancelDescription: tour.cancelDescription,
        };

        $(window).ready(() => {
            autosize($('textarea'));

            fillInputs();
        });

        function fillInputs(){
            $('#mainDescription').val(storeData.mainDescription);
            $('#textExpectation').val(storeData.textExpectation);
            $('#specialInformation').val(storeData.specialInformation);
            $('#opinionText').val(storeData.opinion);
            $('#tourLimit').val(storeData.tourLimit);
            $('#cancelDescription').val(storeData.cancelDescription);

            var sideDesc = $('input[name="sideDescription[]"]');
            for(var i = 0; i < sideDesc.length; i++)
                $(sideDesc[i]).val(storeData.sideDescription[i]);

            storeData.equipment.necessary.map(item => {
                dragedElementId = item;
                drop('necessary')
            });
            storeData.equipment.suggest.map(item => {
                dragedElementId = item;
                drop('suggest')
            });


            storeData.kinds.map(item => $(`#tourKind${item}`).parent().click());
            storeData.levels.map(item => $(`#tourDifficult${item}`).click());
            storeData.focus.map(item => $(`#focus_${item}`).prop('checked', true));
            storeData.style.map(item => $(`#tourStyle_${item}`).prop('checked', true));

            $(`input[name="isCancelAbel"][value="${storeData.isCancelAbel}"]`).click();
        }

        var allowDrop = ev => ev.preventDefault();
        var drag = _element => dragedElementId = $(_element).attr('data-id');

        var changeCancelAble = _value => $('#cancelDiv').css('display', _value == 1 ? 'block' : 'none');
        var chooseTourKind = _element => $(_element).toggleClass('chooseTourKind');

        function drop(_kind) {
            if(dragedElementId != 0){
                var element = $(`#equipmentItem_${dragedElementId}`);
                var html = `<div data-id="${dragedElementId}" class="lessShowText" onclick="deleteEquipment(this, '${_kind}')">${element.text()}</div>`;

                selectedEquipment[_kind].push(dragedElementId);
                $(`#${_kind}ItemsTourCreation`).append(html);

                element.addClass('hidden');
                dragedElementId = 0;
            }
        }

        function chooseDifficult(_element){
            if($(_element).hasClass('aloneDifficult'))
                $('.aloneDifficult').removeClass('chooseTourKind');

            $(_element).toggleClass('chooseTourKind');
        }

        function changeEquipment(_id){
            document.getElementById('equipmentSection_' + lastEquipment).style.display = 'none';
            document.getElementById('equipmentSection_' + _id).style.display = 'inline-block';

            document.getElementById('mainEquipment' + lastEquipment).classList.remove('selectTag');
            document.getElementById('mainEquipment' + _id).classList.add('selectTag');

            lastEquipment = _id;
        }

        function deleteEquipment(_element, _kind){
            var id = $(_element).attr('data-id');
            var index = selectedEquipment[_kind].indexOf(id);
            if(index > -1)
                selectedEquipment[_kind].splice(index, 1);

            $(`#equipmentItem_${id}`).removeClass('hidden');
            $(_element).remove();
        }

        function checkInput(_mainStore = true){
            storeData = {
                levels: [],
                kinds: [],
                focus: [],
                style: [],
                equipment: selectedEquipment,
                mainDescription: $('#mainDescription').val(),
                textExpectation: $('#textExpectation').val(),
                specialInformation: $('#specialInformation').val(),
                opinion: $('#opinionText').val(),
                tourLimit: $('#tourLimit').val(),
                sideDescription: [],

                isCancelAbel: $('input[name="isCancelAbel"]:checked').val(),
                cancelDescription: $('#cancelDescription').val(),
            };

            var levelsElements = $('.tourLevelIcons.chooseTourKind');
            var kindsElements = $('.tourKind.chooseTourKind');
            var focus = $('input[name="focus[]"]:checked');
            var style = $('input[name="style[]"]:checked');

            for(var i = 0; i < levelsElements.length; i++)
                storeData.levels.push($(levelsElements[i]).attr('data-id'));

            for(i = 0; i < kindsElements.length; i++)
                storeData.kinds.push($(kindsElements[i]).attr('data-id'));

            for(i = 0; i < focus.length; i++)
                storeData.focus.push($(focus[i]).val());

            for(i = 0; i < style.length; i++)
                storeData.style.push($(style[i]).val());

            var sideDescription = $('input[name="sideDescription[]"]');
            for(i = 0; i < sideDescription.length; i++)
                storeData.sideDescription.push($(sideDescription[i]).val());

            if(_mainStore)
                doStore();
            else
                localStorage.setItem('stageFiveTourCreation_{{$tour->id}}', JSON.stringify(storeData));
        }

        function doStore(){
            openLoading();

            $.ajax({
                type: 'POST',
                url : '{{route("tour.create.stage.five.store")}}',
                data:{
                    _token: '{{csrf_token()}}',
                    tourId: '{{$tour->id}}',
                    data: JSON.stringify(storeData)
                },
                complete: closeLoading,
                success: response =>{
                    if(response.status == 'ok') {
                        localStorage.removeItem('stageFiveTourCreation_{{$tour->id}}');
                        location.reload();
                    }
                }
            })
        }


        function doLastUpdate(){
            storeData = JSON.parse(lastData);
            fillInputs();
        }

        var lastData = localStorage.getItem('stageFiveTourCreation_{{$tour->id}}');
        if(!(lastData == false || lastData == null))
            openWarning('بازگرداندن اطلاعات قبلی', doLastUpdate, 'بله قبلی را ادامه می دهم');
        setInterval(() => checkInput(false), 5000);
    </script>


    <script>
        var uploadedPics = {!! json_encode($tour->pics) !!};
        var uploadProcess = false;
        var uploadProcessId = null;
        var tourPicUrl = '{{route("tour.create.store.pics")}}';
        var picQueue = [];
        var picInput = 1;
        var picCardSample = $('#picCardSample').html();
        $('#picCardSample').remove();


        console.log(uploadedPics);

        function readURL(input, _index) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                var text = picCardSample;
                text = text.replace(new RegExp('##index##', 'g'), picInput);

                $('#picHover_'+_index).removeClass('hidden');
                $('#showPic'+_index).removeClass('hidden');
                $('#addPic'+_index).addClass('hidden');
                picInput++;

                reader.onload = e => {
                    $('#imgPic' + _index).attr('src', e.target.result);
                    $('#uploadImgDiv').append(text);
                };
                reader.readAsDataURL(input.files[0]);

                picQueue.push({
                    id: _index,
                    uploadedName: '',
                    process: 0,
                });
                checkUpload();
            }
        }

        function checkUpload(){
            var index = null;
            if(!uploadProcess){
                picQueue.forEach((item, _index) => {
                    if(item.process == 0 && index == null) {
                        item.process = 1;
                        index = _index;
                    }
                });

                if(index != null) {
                    uploadProcess = true;
                    uploadProcessId = picQueue[index].id;

                    var file = document.getElementById(`picsInput_${uploadProcessId}`).files;
                    uploadLargeFile(tourPicUrl, file[0], {tourId: '{{$tour->id}}'}, uploadPicResult);
                }
            }
        }

        function uploadPicResult(_status,  _fileName = ''){
            var element = $(`#picHover_${uploadProcessId}`);
            var porcIndex = null;
            picQueue.map((item, index) => {
                if(item.id == uploadProcessId && porcIndex == null)
                    porcIndex = index;
            });
            if(_status == 'done') {
                picQueue[porcIndex].process = 2;
                element.find('.process').addClass('hidden');
                element.find('.tickIcon').removeClass('hidden');
                picQueue[porcIndex].uploadedName = _fileName;

                uploadProcessId = null;
                uploadProcess = false;

                checkUpload();
            }
            else if(_status == 'error') {
                picQueue[porcIndex].process = -1;
                element.find('.process').addClass('hidden');
                element.find('.warningIcon').removeClass('hidden');
                uploadProcessId = null;
                uploadProcess = false;
                setTimeout(checkUpload, 200);
            }
            else if(_status == 'cancelUpload'){
                element.find('.process').addClass('hidden');
                $('#picDiv'+uploadProcessId).remove();
                picQueue.splice(porcIndex, 1);
                uploadProcessId = null;
                uploadProcess = false;
                setTimeout(checkUpload, 200);
            }
            else if(_status == 'queue')
                setTimeout(checkUpload, 200);
            else{
                picQueue[porcIndex].uploadedName = _fileName;
                element.find('.processCounter').text(_status + '%');
            }
        }

        function deleteThisPic(_id) {
            if(uploadProcessId == _id)
                cancelLargeUploadedFile();
            else{
                var deleteIndex = null;
                var deleteId = null;
                picQueue.map((item, index) => {
                   if(item.id == _id) {
                       deleteIndex = index;
                       deleteId = item.id;
                   }
                });
                if(deleteIndex != null){
                    $('#picDiv'+deleteId).remove();
                    if(picQueue[deleteIndex].process == 2)
                        deletedUploadedPic(picQueue[deleteIndex].uploadedName);
                    picQueue.splice(deleteIndex, 1);
                }
            }
        }

        function deletedUploadedPic(_fileName){
            $.ajax({
                type: 'POST',
                url: '{{route("tour.create.store.delete")}}',
                data: {
                    _token: '{{csrf_token()}}',
                    tourId: '{{$tour->id}}',
                    fileName: _fileName,
                }
            })
        }

        uploadedPics.map((item, index) => {
            var text = picCardSample;
            text = text.replace(new RegExp('##index##', 'g'), picInput);
            $('#uploadImgDiv').append(text);
            picInput++;

            picQueue.push({
                id: index,
                uploadedName: item.pic,
                process: 2,
            });

            $('#showPic'+index).removeClass('hidden');
            $('#addPic'+index).addClass('hidden');
            $('#imgPic'+index).attr('src', item.url);

            var element = $('#picHover_'+index);
            element.removeClass('hidden');
            element.find('.process').addClass('hidden');
            element.find('.tickIcon').removeClass('hidden');

        })
    </script>
@endsection
