@extends('pages.localShops.localShopLayout')

@section('head')
    <meta property="og:locale" content="fa_IR" />
    <meta property="og:type" content="website" />
    <meta name="title" content="کوچیتا | سامانه جامع گردشگری ایران و شبکه اجتماعی گردشگران" />
    <meta name='description' content='کوچیتا، سامانه جامع گردشگری ایران و شبکه اجتماعی گردشگران. اطلاعات اماکن و جاذبه ها، هتل ها، بوم گردی، ماجراجویی، آموزش سفر، فروشگاه صنایع‌دستی ، پادکست سفر' />
    <meta name='keywords' content='کوچیتا، هتل، تور ، سفر ارزان، سفر در ایران، بلیط، تریپ، نقد و بررسی، سفرنامه، کمپینگ، ایران گردی، آموزش سفر، مجله گردشگری، مسافرت، مسافرت داخلی, ارزانترین قیمت هتل ، مقایسه قیمت ، بهترین رستوران‌ها ، بلیط ارزان ، تقویم تعطیلات' />
    <meta name="twitter:image" content="{{URL::asset('images/mainPics/noPicSite.jpg')}}"/>
    <meta property="og:image" content="{{URL::asset('images/mainPics/noPicSite.jpg')}}"/>
    <meta property="og:image:secure_url" content="{{URL::asset('images/mainPics/noPicSite.jpg')}}"/>
    <meta property="og:image:width" content="550"/>
    <meta property="og:image:height" content="367"/>

    <style>
        label{
            margin: 0px;
        }
        div[class^="col-"]{
            float: right;
            margin-bottom: 45px;
        }
        .form-control{
            border: none;
            box-shadow: none;
            border-bottom: solid 1px #cacaca;
            border-radius: 0;
        }
        .form-control:focus{
            box-shadow: none;
            border-bottom: solid 2px var(--koochita-blue);
        }
        textarea.form-control{
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .sectionPages{
            padding-bottom: 60px;
        }
        @media (max-width: 991px) {
            div[class^="col-md"]{
                /*float: unset;*/
                width: 100%;
            }
        }
        @media (max-width: 767px) {
            .footerPhoneMenuBar.hideOnScreen{
                display: none;
            }
            div[class^="col-sm"]{
                /*float: unset;*/
                width: 100%;
            }
        }
    </style>


    <link rel="stylesheet" href="{{URL::asset('packages/clockPicker/bootstrap-clockpicker.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('packages/clockPicker/jquery-clockpicker.min.css')}}">

    <script defer src="{{URL::asset('packages/clockPicker/jquery-clockpicker.min.js')}}"></script>
    <script defer src="{{URL::asset('packages/clockPicker/bootstrap-clockpicker.min.js')}}"></script>
@endsection


@section('body')
    <div class="grayBackGround createPageMainBody">
        <div class="container">
            <div class="bodySec bodd row">
                <div class="col-sm-12 MainHeader">
                    <div>ثبت اطلاعات کسب و کار</div>
                    <div class="indicator">
                        <div class="squer level3"> بارگذاری عکس </div>
                        <div class="line level3" style="right: 49px;"></div>
                        <div class="squer level2"> اطلاعات تکمیلی </div>
                        <div class="line level2" style="left: 49px;"></div>
                        <div class="squer level1 selected"> اطلاعات اولیه </div>
                    </div>
                </div>

                <div class="sectionPages section1">
                    <div class="descInputSec col-sm-12">
                        <div class="descriptionText">شما در اینجا می توانید اطلاعات کسب و کار خود را وارد نمایید.</div>
                        <div class="descriptionText">توجه نمایید پر کردن تمامی اطلاعات این بخش ضروری می باشد.</div>
                        <div style="color: red; margin-top: 5px;">کامل کردن موارد ستاره دار اجباری است</div>
                    </div>
                    <div class="container" style="width: 100%;">
                        <input type="hidden" id="shopId" value="0">
                        <div class="row">
                            <div class="col-sm-6 form-group importantInput">
                                <label for="shopName">نام کسب و کار</label>
                                <input type="text" class="form-control mustFull" id="shopName" placeholder="نام کسب و کار خود را وارد نمایید...">
                            </div>
                            <div class="col-sm-6 form-group importantInput">
                                <label for="shopCategory">نوع کسب و کار</label>
                                <select class="form-control mustFull" id="shopCategory">
                                    <option disabled selected>نوع کسب و کار خود را مشخص کنید.</option>
                                    @foreach($localShopCategories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                    <option value="-1">دسته بندی موجود نیست</option>
                                </select>
                            </div>
                            <div class="col-sm-6 form-group importantInput">
                                <label for="shopPhone">شماره تماس</label>
                                <div class="descriptionText">کد شهر حتما وارد شود</div>
                                <input type="text" class="form-control mustFull" id="shopPhone" placeholder="021xxxxxxxx - 021xxxxxxxx">
                            </div>
                            <div class="col-sm-6 form-group importantInput">
                                <label for="shopCity" style="padding-top: 27px;">شهر</label>
                                <input type="text" class="form-control mustFull" id="shopCity" placeholder="نام شهر خود را وارد نمایید..." onclick="openSearchFindCity()" readonly>
                                <input type="hidden" id="shopCityId" value="0">
                            </div>
                            <div class="col-sm-12 form-group importantInput">
                                <label for="shopAddress">آدرس کسب و کار</label>
                                <input type="text" class="form-control mustFull" id="shopAddress" placeholder="آدرس کسب و کار خود را دقیق وارد نمایید...">
                            </div>
                            <div class="col-sm-12 form-group">
                                <label for="shopInPlace">نام محل کسب و کار</label>
                                <div class="descriptionText"> اگر کسب و کار شما داخل محل خاصی می باشد (مثلا پاساژ) ، نام محل را وارد نمایید.</div>
                                <input type="text" class="form-control" id="shopInPlace" placeholder="نام محل خاص را وارد نمایید...">
                                <input type="hidden" id="shopInPlaceId" value="0">
                            </div>
                            <div class="col-sm-12 form-group importantInput">
                                <label for="shopMap"> محل روی نقشه </label>
                                <div class="descriptionText">شما می توانید با کلیک روی نقشه محل مورد نظر را ثبت نمایید .</div>
                                <div class="shopMapInput">
                                    <div id="mapDiv" style="width: 100%; height: 100%"></div>
                                    <input type="hidden" id="shopLat" value="0">
                                    <input type="hidden" id="shopLng" value="0">
                                    <button class="myLocationButton" onclick="findMyLocation()">
                                        <img src="{{URL::asset('images/icons/myLocation.svg')}}">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sectionPages section2 hidden">
                    <div class="descriptionText">با پر کردن اطلاعات این بخش به مشتریان خود کمک کنید.</div>
                    <div class="container" style="width: 100%;">
                        <div class="row">
                            <div class="col-sm-12 headerRowInput">
                                ساعات کاری کسب و کار
                                <div class="checkboxDiv">
                                    <label for="allDay24">شبانه روزی هستم</label>
                                    <input type="checkbox" id="allDay24" onchange="iAm24Hour()">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="timeSection">
                                    <div id="inWeekDiv" class="timeRow">
                                        <div class="text">روز های هفته:</div>
                                        <div class="smTex">از ساعت </div>
                                        <div class="timePicker clockpicker">
                                            <input class="form-control" id="inWeekDayStart" type="text" placeholder="انتخاب کنید">
                                        </div>
                                        <div class="smTex">تا ساعت </div>
                                        <div class="timePicker clockpicker">
                                            <input class="form-control" id="inWeekDayEnd" type="text" placeholder="انتخاب کنید">
                                        </div>
                                    </div>
                                    <div id="closedBeforeDayDiv" class="timeRow">
                                        <div class="text">روز های قبل تعطیلی: </div>
                                        <div style="display: flex; align-items: center;">
                                            <div class="smTex">از ساعت </div>
                                            <div class="timePicker clockpicker">
                                                <input class="form-control" id="afterClosedDayStart" type="text" placeholder="انتخاب کنید">
                                            </div>
                                            <div class="smTex">تا ساعت </div>
                                            <div class="timePicker clockpicker">
                                                <input class="form-control" id="afterClosedDayEnd" type="text" placeholder="انتخاب کنید">
                                            </div>
                                        </div>

                                        <label class="openCloseInputDiv" for="afterClosedDayButton">
                                            <input type="checkbox" id="afterClosedDayButton" onchange="iAmClose(this)">
                                            <div class="openCloseInputShow"></div>
                                        </label>
                                    </div>
                                    <div id="closedDayDiv" class="timeRow">
                                        <div class="text">روز های تعطیلی: </div>

                                        <div style="display: flex; align-items: center;">
                                            <div class="smTex">از ساعت </div>
                                            <div class="timePicker clockpicker">
                                                <input class="form-control" id="closedDayStart" type="text" placeholder="انتخاب کنید">
                                            </div>
                                            <div class="smTex">تا ساعت </div>
                                            <div class="timePicker clockpicker">
                                                <input class="form-control" id="closedDayEnd" type="text" placeholder="انتخاب کنید">
                                            </div>
                                        </div>
                                        <label class="openCloseInputDiv" for="closedDayButton">
                                            <input type="checkbox" id="closedDayButton" onchange="iAmClose(this)">
                                            <div class="openCloseInputShow"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-sm-6 form-group">
                                <label for="shopWebSite">آدرس وب سایت</label>
                                <input type="text" class="form-control" id="shopWebSite" placeholder="اگر وب سایت دارید وارد نمایید...">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="shopInstagram">آدرس اینستاگرام</label>
                                <input type="text" class="form-control" id="shopInstagram" placeholder="اگر صفحه اینستاگرام دارید وارد نمایید...">
                            </div>
                            <div class="col-sm-12 form-group">
                                <label for="shopDescription">توضیحات</label>
{{--                                <div class="descriptionText">شما در این قسمت می توانید در مورد کسب و کار ، شغل و یا نوع فعالیت خود توضیحاتی بنویسید.</div>--}}
                                <textarea class="autoResizeTextArea form-control"
                                          id="shopDescription"
                                          placeholder="شما در این قسمت می توانید در مورد کسب و کار ، شغل و یا نوع فعالیت خود توضیحاتی بنویسید."></textarea>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="sectionPages section3 hidden">
                    <div class="container" style="width: 100%;">
                        <div class="row">
                            <div class="col-sm-12 headerRowInput">
                                بارگذاری عکس
                            </div>
                            <div class="col-md-12">
                                <div class="boldDescriptionText" style="color: var(--koochita-green);">اطلاعات کسب و کار شما با موفقیت ثبت شد</div>
                                <div class="descriptionText">شما در این بخش می توانید عکس هایی از کسب و کار و یا کسب کار خود قرار دهید تا مردم شما را بهتر بشناسند.</div>
                                <div id="uploadedSection" class="uploadPicSection">
                                    <div id="showUploadPicsSection" class="showUploadedFiles"></div>
                                    <div id="uploadPicInfoText" class="uploadPic">
                                        <img src="{{URL::asset('images/icons/uploadPic.png')}}">
                                        <div>عکس های خود را در اینجا قرار دهید </div>
                                        <div style="margin-top: 10px; font-weight: bold;"> و یا </div>
                                    </div>
                                    <label class="labelForClick" for="localShopPics">کلیک کنید</label>
                                </div>
                                <input type="file" accept="image/*" id="localShopPics" data-multiple-caption="{count} files selected" multiple style="display: none" onchange="uploadPicClickHandler(this)">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="submitSection">
                    <div class="container">
                        <div class="row">
                            <button id="nextButton" class="nextButton" onclick="goToPage(1)">ثبت و ادامه</button>
                            <button id="prevButton" class="prevButton hidden" onclick="goToPage(-1)">بازگشت</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection


@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCdVEd4L2687AfirfAnUY1yXkx-7IsCER0"></script>

    <script>
        var citySearchAjax = null;
        var currentPage = 1;
        var map;
        var marker = 0;
        var fileImages = [];
        var dropArea = document.getElementById('uploadedSection');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false)
        });
        dropArea.addEventListener('dragenter', () => $('#uploadedSection').addClass('highlight'), false);
        dropArea.addEventListener('dragleave', () => $('#uploadedSection').removeClass('highlight'), false);
        dropArea.addEventListener('dragover', () => $('#uploadedSection').addClass('highlight'), false);
        dropArea.addEventListener('drop', (e) => {
            let files = e.dataTransfer.files;
            ([...files]).forEach(createAndUploadFilePic);
        }, false);


        function openSearchFindCity(){
            createSearchInput(searchCity, 'نام شهر را وارد کنید.');
        }

        function searchCity(_element) {
            activeCityFilter = false;
            var value = _element.value;
            if(value.trim().length > 1){
                if(citySearchAjax != null)
                    citySearchAjax.abort();

                citySearchAjax = $.ajax({
                    type: 'post',
                    url: "{{route('searchForCity')}}",
                    data: {
                        _token: '{{csrf_token()}}',
                        key: value
                    },
                    success: function (response) {
                        if(response.length == 0)
                            return;
                        response = JSON.parse(response);
                        var newElement = "";
                        response.map(item => {
                            newElement += `<div onclick="chooseThisCity('${item.cityName}', ${item.id})"><div class="icons location spIcons"></div>
                                                                        <p class="suggest cursor-pointer font-weight-700" style="margin: 0px">شهر ${item.cityName}</p>
                                                                        <p class="suggest cursor-pointer stateName">${item.stateName}</p>
                                                                    </div>`;
                        });
                        setResultToGlobalSearch(newElement);
                    }
                });
            }
            else
                clearGlobalResult();
        }

        function chooseThisCity(_val, _id) {
            $('#shopCityId').val(_id);
            $('#shopCity').val(_val);
            $('#shopCity').addClass('correctInput');
            $('#shopCity').removeClass('wrongInput');
            closeSearchInput();
        }

        function initMap(){
            var mapOptions = {
                zoom: 5,
                center: new google.maps.LatLng(32.42056639964595, 54.00537109375),

                styles: [{
                    "featureType": "landscape",
                    "stylers": [{"hue": "#FFA800"}, {"saturation": 0}, {"lightness": 0}, {"gamma": 1}]
                }, {
                    "featureType": "road.highway",
                    "stylers": [{"hue": "#53FF00"}, {"saturation": -73}, {"lightness": 40}, {"gamma": 1}]
                }, {
                    "featureType": "road.arterial",
                    "stylers": [{"hue": "#FBFF00"}, {"saturation": 0}, {"lightness": 0}, {"gamma": 1}]
                }, {
                    "featureType": "road.local",
                    "stylers": [{"hue": "#00FFFD"}, {"saturation": 0}, {"lightness": 30}, {"gamma": 1}]
                }, {
                    "featureType": "water",
                    "stylers": [{"hue": "#00BFFF"}, {"saturation": 6}, {"lightness": 8}, {"gamma": 1}]
                }, {
                    "featureType": "poi",
                    "stylers": [{"hue": "#679714"}, {"saturation": 33.4}, {"lightness": -25.4}, {"gamma": 1}]
                }]
            };
            var mapElementSmall = document.getElementById('mapDiv');
            map = new google.maps.Map(mapElementSmall, mapOptions);

            google.maps.event.addListener(map, 'click', event => getLat(event.latLng));
        }

        function getLat(location){
            if(marker != 0)
                marker.setMap(null);
            marker = new google.maps.Marker({
                position: location,
                map: map,
            });
            $('#shopLat').val(location.lat());
            $('#shopLng').val(location.lng());
        }

        initMap();

        function findMyLocation() {
            if (navigator.geolocation)
                navigator.geolocation.getCurrentPosition((position) => {
                    var coordination = position.coords;
                    if(marker != 0)
                        marker.setMap(null);
                    marker = new google.maps.Marker({
                        position:  new google.maps.LatLng(coordination.latitude, coordination.longitude),
                        map: map,
                    });
                    map.setCenter({
                        lat : coordination.latitude,
                        lng : coordination.longitude
                    });
                    map.setZoom(16);

                    $('#shopLat').val(coordination.latitude);
                    $('#shopLng').val(coordination.longitude);
                });
            else
                console.log("Geolocation is not supported by this browser.");
        }

        function goToPage(_step, _isSubmitedLocalShop = false){
            if(currentPage == 1 && _step == -1)
                return;

            if(currentPage == 3 && _step == 1){
                openLoading();
                window.location.href = '{{url('/business/show')}}/'+$('#shopId').val();
            }
            else if(currentPage == 1 && _step == 1 && !checkStepOne())
                return;
            else if(currentPage == 2 && _step == 1 && checkStepOne() && !_isSubmitedLocalShop){
                doStoreLocalShop();
                return;
            }

            $('.indicator .level'+currentPage).removeClass('selected');

            currentPage += _step;

            for(var i = 1; i <= currentPage; i++)
                $('.indicator .level'+i).addClass('selected');

            if(currentPage == 1)
                $('#prevButton').addClass('hidden');
            else
                $('#prevButton').removeClass('hidden');

            $('.sectionPages').addClass('hidden');
            $('.sectionPages.section'+currentPage).removeClass('hidden');
        }

        function checkStepOne(){
            var name = $('#shopName').val();
            var phone = $('#shopPhone').val();
            var category = $('#shopCategory').val();
            var cityId = $('#shopCityId').val();
            var address = $('#shopAddress').val();
            var lat = $('#shopLat').val();
            var lng = $('#shopLng').val();
            var errorText = '';

            if(name.trim().length < 2) {
                errorText += '<li>پر کردن نام کسب و کار اجباری است</li>';
                $('#shopName').addClass('wrongInput');
            }
            else{
                $('#shopName').addClass('correctInput').removeClass('wrongInput');
            }

            if(category == null) {
                errorText += '<li>نوع کسب و کار خود را مشخص کنید</li>';
                $('#shopCategory').addClass('wrongInput');
            }
            else{
                $('#shopCategory').addClass('correctInput').removeClass('wrongInput');
            }

            if(phone.trim().length < 2){
                errorText += '<li>نوشتن شماره تماس برای کسب و کار اجباری است</li>';
                $('#shopPhone').addClass('wrongInput');
            }
            else{
                $('#shopPhone').addClass('correctInput').removeClass('wrongInput');
            }

            if(cityId == 0){
                errorText += '<li>انتهاب شهر اجباری است</li>';
                $('#shopCity').addClass('wrongInput');
            }
            else{
                $('#shopCity').addClass('correctInput').removeClass('wrongInput');
            }

            if(address == 0) {
                errorText += '<li>نوشتن آدرس کسب و کار اجباری است</li>';
                $('#shopAddress').addClass('wrongInput');
            }
            else{
                $('#shopAddress').addClass('correctInput').removeClass('wrongInput');
            }

            if(lat == 0 || lng == 0)
                errorText += '<li>مشخص کردن محل کسب و کار روی نقشه اجباری است.</li>';

            if(errorText == '')
                return true;
            else{
                errorText = `<ul>${errorText}</ul>`;
                openErrorAlert(errorText);
                return false;
            }

        }

        function doStoreLocalShop(){
            var dataToSend = {
                _token: '{{csrf_token()}}',
                id: $('#shopId').val(),
                name: $('#shopName').val(),
                phone: $('#shopPhone').val(),
                category: $('#shopCategory').val(),
                cityId: $('#shopCityId').val(),
                address: $('#shopAddress').val(),
                lat: $('#shopLat').val(),
                lng: $('#shopLng').val(),
                inPlaceId: $('#shopInPlaceId').val(),
                inPlace: $('#shopInPlace').val(),
                website: $('#shopWebSite').val(),
                instagram: $('#shopInstagram').val(),
                description: $('#shopDescription').val(),

                closedDayStart: $('#closedDayStart').val(),
                closedDayEnd: $('#closedDayEnd').val(),
                afterClosedDayStart: $('#afterClosedDayStart').val(),
                afterClosedDayEnd: $('#afterClosedDayEnd').val(),
                inWeekDayStart: $('#inWeekDayStart').val(),
                inWeekDayEnd: $('#inWeekDayEnd').val(),

                fullOpen: $('#allDay24').prop('checked'),
                afterClosedDayButton: $('#afterClosedDayButton').prop('checked'),
                closedDayButton: $('#closedDayButton').prop('checked'),
            };

            openLoading();
            $.ajax({
                type: 'post',
                url: '{{route('localShop.store')}}',
                data: dataToSend,
                success: response => {
                    closeLoading();
                    if(response.status == 'ok'){
                        $('#shopId').val(response.result);
                        showSuccessNotifi('کسب و کار شما با موفقیت ثبت شد.', 'left', 'var(--koochita-blue)');
                        goToPage(1, true)
                    }
                },
                error: err => {
                    closeLoading();
                }
            })
        }

        $(window).ready(() => {
            $('.clockpicker').clockpicker({
                donetext: 'تایید',
                autoclose: true,
            });
            autosize($('.autoResizeTextArea'))
        });

        function iAm24Hour(){
            isChecked = $('#allDay24').prop('checked');
            if(isChecked){
                $('#inWeekDiv').addClass('hidden');
                $('#closedBeforeDayDiv').addClass('hidden');
            }
            else{
                $('#inWeekDiv').removeClass('hidden');
                $('#closedBeforeDayDiv').removeClass('hidden');
            }
        }

        function iAmClose(_element){
            var isChecked = $(_element).prop('checked');
            if(isChecked){
                $(_element).parent().addClass('checked');
                $(_element).parent().prev().addClass('hidden');
            }
            else{
                $(_element).parent().removeClass('checked');
                $(_element).parent().prev().removeClass('hidden');
            }
        }

        function preventDefaults (e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function uploadPicClickHandler(_input){
            if(_input.files && _input.files[0])
                createAndUploadFilePic(_input.files[0]);
            $(_input).val('');
        }

        function createAndUploadFilePic(_files) {
            var reader = new FileReader();
            reader.onload = e => {
                var index = fileImages.push({
                    file: _files,
                    image: e.target.result,
                    savedFile: '',
                    uploaded: -1,
                    code: Math.floor(Math.random()*1000)
                });
                createNewImgUploadCard(index-1);
                uploadQueuePictures();
            };
            reader.readAsDataURL(_files);
        }

        function createNewImgUploadCard(_index){
            if(_index == 0)
                $('#uploadPicInfoText').addClass('hidden');

            var file = fileImages[_index];
            var text = `<div id="uplaodedImg_${file.code}" class="uploadFileCard">
                            <div class="img">
                                <img src="${file.image}" class="resizeImgClass" onload="fitThisImg(this)">
                            </div>
                            <div class="absoluteBackground tickIcon"></div>
                            <div class="absoluteBackground warningIcon"> اشکال در بارگذاری</div>
                            <div class="absoluteBackground process">
                                <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                                <div class="processCounter">0%</div>
                            </div>
                            <div class="hoverInfos">
                                <div class="cancelButton closeIconWithCircle" onclick="deleteThisUploadedImage(${file.code})" >
                                     حذف عکس
                                </div>
                            </div>
                        </div>`;
            $('#showUploadPicsSection').append(text);
        }

        var uploadPicAjax = null;
        var uploadProcess = false;
        var cancelThisImg = false;
        function uploadQueuePictures() {
            if(uploadProcess == false){
                uploadProcess = true;
                var uploadIndex = null;
                fileImages.map((item, index) => {
                    if(item.uploaded == -1 && uploadIndex == null)
                        uploadIndex = index;
                });

                if(uploadIndex != null) {
                    var uFile = fileImages[uploadIndex];
                    uFile.uploaded = 0;
                    $('#uplaodedImg_' + uFile.code).addClass('process');

                    var formData = new FormData();
                    formData.append('localShopId', $('#shopId').val());
                    formData.append('pic', uFile.file);

                    uploadPicAjax = $.ajax({
                        type: 'post',
                        url: '{{route("localShop.store.pics")}}',
                        data: formData,
                        processData: false,
                        contentType: false,
                        xhr: function () {
                            var xhr = new XMLHttpRequest();
                            xhr.upload.onprogress = e => {
                                if (e.lengthComputable) {
                                    var percent = Math.round((e.loaded / e.total) * 100);
                                    $('#uplaodedImg_' + uFile.code).find('.processCounter').text(percent + '%');
                                }
                            };
                            return xhr;
                        },
                        success: response => {
                            uploadProcess = false;
                            if (response.status == 'ok') {
                                $('#uplaodedImg_' + uFile.code).removeClass('process');
                                $('#uplaodedImg_' + uFile.code).addClass('done');
                                uFile.uploaded = 1;
                                uFile.savedFile = response.result;
                                uploadQueuePictures();
                                if(cancelThisImg) {
                                    doDeletePicServer(uploadIndex);
                                    cancelThisImg = false;
                                }
                            }
                            else{
                                $('#uplaodedImg_' + uFile.code).removeClass('process');
                                $('#uplaodedImg_' + uFile.code).addClass('error');
                                uFile.uploaded = -2;
                            }
                        },
                        error: err => {
                            uploadProcess = false;
                            $('#uplaodedImg_' + uFile.code).removeClass('process');
                            $('#uplaodedImg_' + uFile.code).addClass('error');
                            uFile.uploaded = -2;
                        }
                    })
                }
                else
                    uploadProcess = false;
            }
        }

        function deleteThisUploadedImage(_code){
            var index = null;
            for(var i = 0; i < fileImages.length; i++){
                if(fileImages[i].code == _code){
                    index = i;
                    break;
                }
            }

            if(index != null){
                if(fileImages[index].uploaded == 0){
                    cancelThisImg = true;
                }
                else if(fileImages[index].uploaded == -1 || fileImages[index].uploaded == -2){
                    fileImages.splice(index, 1);
                    $('#uplaodedImg_'+_code).remove();
                }
                else if(fileImages[index].uploaded == 1)
                    doDeletePicServer(index);
            }

            if(fileImages.length == 0)
                $('#uploadPicInfoText').removeClass('hidden');
        }

        function doDeletePicServer(_index){
            var file = fileImages[_index];
            $.ajax({
                type: 'delete',
                url: '{{route('localShop.store.delete')}}',
                data: {
                    _token: '{{csrf_token()}}',
                    fileName: file.savedFile,
                    localShopId: $('#shopId').val(),
                },
                success: response => {
                    if(response.status == 'ok'){
                        $('#uplaodedImg_'+file.code).remove();
                        fileImages.splice(index, 1);
                    }
                },
            })
        }

        $(window).ready(() => {
            $('.mustFull').on('change', e => {
                var target = e.target;
                if(target.value.trim().length > 0){
                    $(target).addClass('correctInput');
                    $(target).removeClass('wrongInput');
                }
                else{
                    $(target).removeClass('correctInput');
                    $(target).addClass('wrongInput');
                }
            })
        })

    </script>

@endsection
