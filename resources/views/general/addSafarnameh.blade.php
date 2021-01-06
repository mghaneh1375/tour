
<script src="{{asset('js/ckeditor5/ckeditor5.js')}}"></script>
<script src="{{asset('js/ckeditor5/ckeditorUpload.js')}}"></script>

<div id="newSafarnameh" class="modalBlackBack" style="z-index: 9999;">
    <div class="newSafarnamehSection">
        <input type="hidden" id="newSafarnamehId" value="0">
        <div class="nsHeader">
            <h3 id="newSafarnamehModalHeader" class="text">نوشتن سفرنامه</h3>
            <div class="iconClose" onclick="closeNewSafarnameh()"></div>
        </div>
        <div class="nsContenet">
            <div class="row">
                <div class="form-group">
                    <label for="safarnamehTitle">برای سفرنامت یک عنوان بنویسید</label>
                    <input id="newSafarnamehTitle" type="text" class="form-control" placeholder="عنوان سفرنامه">
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="safarnamehSummery">می تونی یه خلاصه از سفرنامت تو 100 کاراکتر بنویسی (اختیاری)</label>
                    <textarea id="safarnamehSummery" class="form-control" rows="1" placeholder="خلاصه سفرنامه"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="safarnamehText" class="inputLabel">متن سفرنامت رو اینجا بنویس</label>
                    <div class="toolbar-container"></div>
                    <div id="safarnamehText" class="textEditor"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="safarnamehTags">برای سفرنامه خود برچسب بگذارید</label>
                    <input type="text" id="safarnamehTag1" class="form-control" placeholder="برچسب اول" style="margin-bottom: 10px">
                    <input type="text" id="safarnamehTag2" class="form-control" placeholder="برچسب دوم" style="margin-bottom: 10px">
                    <input type="text" id="safarnamehTag3" class="form-control" placeholder="برچسب سوم">
                </div>
                <div class="col-md-6 form-group" style="display: flex; flex-direction: column;">
                    <label>خب یه عکس خوب هم از سفرنامت
                        {{--                        <button class="addPlaceButton" onclick="$('#safarnamehPicInput').click()">--}}
                        {{--                            انتخاب عکس--}}
                        {{--                        </button>--}}
                    </label>
                    <input type="file" id="safarnamehPicInput" accept="image/*" style="display: none" onchange="changeNewPicSafarnameh(this)">
                    <label for="safarnamehPicInput" class="newSafarnamehImgSection">
                        <div class="notPicSafarnameh">
                            <span class="plus2" style="font-size: 40px; line-height: 20px;"></span>
                            <span>افزودن عکس </span>
                        </div>
                        <img alt="addSafarnameh" id="newSafarnamehPic"  style=" height: 120px; display: none">
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="form-group" style="display: flex; flex-direction: column;">
                    <label>
                        محل های مرتبط به سفرنامه خود را انتخاب کنید.
                        <button class="addPlaceButton" onclick="openSuggestion()">
                            افزودن محل جدید
                        </button>
                    </label>
                </div>
                <div class="pickPlaces ourSuggestionMainPage" style="max-height: 1000vh"></div>
            </div>

            <div class="row newSafarnamehFooter">
                <div style="width: 100%; padding: 0px 30px;">
                    <ul id="newSafarnamehError" style="color: red"></ul>
                </div>
                <div>
                    <button class="backSafarnameh" onclick="closeNewSafarnameh()">{{__('بستن')}}</button>
                    <button class="btn btn-success submitSafarnameh" style="background: var(--koochita-green)" onclick="storeSafarnameh()">ثبت</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="placeSuggestionModal" class="modalBlackBack" style="z-index: 10000;">
    <div class="placeSuggestionBody">
        <div class="iconClose closeSuggestionModal" onclick="closeSuggestion()"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 form-group placeSuggKind">
                    <label for="kindPlace">نوع محل را مشخص کنید.</label>
                    <select id="kindPlace" class="form-control" onchange="$('#searchResultPlacess').hide(); $('#placeName').val('')">
                        <option value="state">استان</option>
                        <option value="city">شهر</option>
                        <option value="village">روستا</option>
                        <option value="boomgardies">بوم گردی</option>
                        <option value="amaken">اماکن</option>
                        <option value="restaurant">رستوران</option>
                        <option value="hotels">هتل</option>
                        <option value="majara">طبیعت گردی</option>
                        <option value="sogatSanaies">صنایع دستی و سوغات</option>
                        <option value="mahaliFood">غذا</option>
                    </select>
                </div>
                <div class="col-md-8 form-group">
                    <label> نام محل</label>
                    <input type="text" id="placeName" class="form-control" onkeyup="searchForPlaces(this.value)">
                    <div id="searchResultPlacess" class="searchResultPlacess"></div>
                </div>
            </div>

            <div class="row" style="padding: 10px">
                <div id="pickPlacesTitle" style="font-size: 20px; font-weight: bold">انتخاب شده ها</div>
                <div class="pickPlaces ourSuggestion"></div>
            </div>

            <div class="row" style="margin: 10px; border-top: solid 1px #cccccc; padding-top: 5px;">
                <div class="ourSuggestionShow" style="font-size: 20px; font-weight: bold">پیشنهادهای ما</div>
                <div id="ourSuggestion" class="ourSuggestion ourSuggestionShow" style="max-height: 20vh"></div>
                {{--                    <div class="showAllSuggestion ourSuggestionShow" onclick="showAllSuggestionFunc()">مشاهده تمام پیشنهادها</div>--}}
            </div>
            <div class="row" style="text-align: center">
                <button class="submitSarnamehButton" onclick="closeSuggestion()">{{__('ثبت')}}</button>
            </div>
        </div>
    </div>
</div>

<script>
    let safarnamehNewMainPic = null;
    let getSuggestionPlaceAjax = null;
    let searchResultPlacess = [];
    let pickedPlaces = [];
    let suggestionPlaces;

    DecoupledEditor.create( document.querySelector('#safarnamehText'), {
        language: '{{app()->getLocale()}}',
        removePlugins: [ 'FontSize', 'MediaEmbed' ],
    })
        .then( editor => {
            const toolbarContainer = document.querySelector( '.toolbar-container');
            toolbarContainer.prepend( editor.ui.view.toolbar.element );
            window.editor = editor;
            textEditor = editor;
            editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
                let data = {
                    id: '{{auth()->user()->id}}',
                };
                data = JSON.stringify(data);
                return new MyUploadAdapter( loader, '{{route("safarnameh.storePic")}}', '{{csrf_token()}}', data);
            };

        } )
        .catch( err => {
            console.error( err.stack );
        });

    function openNewSafarnameh(){
        if(checkLogin()) {
            if($('#newSafarnamehId').val() != 0)
                emptySafarnamehModal();

            openMyModal('newSafarnameh') // forAllPages.blade.php
        }
    }

    function emptySafarnamehModal(){
        $('#newSafarnamehModalHeader').text('نوشتن سفرنامه');
        window.editor.setData('');
        $('#newSafarnamehId').val(0);
        $('#newSafarnamehTitle').val('');
        $('#safarnamehSummery').val('');

        $('.notPicSafarnameh').show();
        $('#newSafarnamehPic').hide();
        $('#newSafarnamehPic').attr('src', '#');

        $('#safarnamehTag1').val('');
        $('#safarnamehTag2').val('');
        $('#safarnamehTag3').val('');

        safarnamehNewMainPic = null;
        getSuggestionPlaceAjax = null;
        searchResultPlacess = [];
        pickedPlaces = [];
        createPickPlace();
    }

    function changeNewPicSafarnameh(input){
        if(input.files && input.files[0])
            cleanImgMetaData(input, function(imgDataURL, _file){
                safarnamehNewMainPic = _file;
                $('.notPicSafarnameh').hide();
                $('#newSafarnamehPic').show();
                $('#newSafarnamehPic').attr('src', imgDataURL);
            });
    }

    function storeSafarnameh(){
        var formDa = new FormData();
        var title = $('#newSafarnamehTitle').val();
        var summery = $('#safarnamehSummery').val();
        var newSafarnamehId = $('#newSafarnamehId').val();
        var text = window.editor.getData();
        var tags = [];
        var error = false;

        $('#newSafarnamehError').html('');
        if(title.trim().length < 2){
            $('#newSafarnamehError').append('<li>انتخاب عنوان برای سفرنامه الزامی است.</li>');
            error = true;
        }
        if(safarnamehNewMainPic == null && newSafarnamehId == 0){
            $('#newSafarnamehError').append('<li>انتخاب عکس برای سفرنامه الزامی است.</li>');
            error = true;
        }
        if(text.trim().length < 10){
            $('#newSafarnamehError').append('<li>نوشتن متن برای سفرنامه الزامی است.</li>');
            error = true;
        }

        if(!error) {
            openLoading();
            tags.push($('#safarnamehTag1').val());
            tags.push($('#safarnamehTag2').val());
            tags.push($('#safarnamehTag3').val());


            formDa.append('id', newSafarnamehId);
            formDa.append('title', title);
            formDa.append('summery', summery);
            formDa.append('text', text);
            formDa.append('tags', tags);
            formDa.append('pic', safarnamehNewMainPic);
            formDa.append('placePick', JSON.stringify(pickedPlaces));

            $.ajax({
                type: 'post',
                url: '{{route('safarnameh.store')}}',
                data: formDa,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response == 'ok') {
                        showSuccessNotifi('سفرنامه شما با موفقیت ثبت شد.', 'left', 'var(--koochita-blue)');
                        location.reload();
                    }
                    else {
                        showSuccessNotifi('در ثبت سفرنامه مشکلی پیش امده لطفا دوباره تلاش نمایید.', 'left', 'red');
                        closeLoading();
                    }
                },
                error: function (err) {
                    showSuccessNotifi('در ثبت سفرنامه مشکلی پیش امده لطفا دوباره تلاش نمایید.', 'left', 'red');
                    closeLoading();
                }
            })
        }
    }

    function editSafarnameh(_id){
        openLoading();
        $.ajax({
            type: 'post',
            url: '{{route("safarnameh.get")}}',
            data: {
                _token: '{{csrf_token()}}',
                id: _id
            },
            success: function(response){
                closeLoading();
                response = JSON.parse(response);
                if(response.status == 'ok'){
                    $('#newSafarnamehModalHeader').text('ویرایش سفرنامه');
                    openMyModal('newSafarnameh'); // forAllPages.blade.php
                    createEditSafarnameh(response.result);
                }
                else
                    showSuccessNotifi('در ویرایش سفرنامه مشکلی پیش امده لطفا دوباره تلاش نمایید.', 'left', 'red');
            },
            error: function(err){
                closeLoading();
                showSuccessNotifi('در ویرایش سفرنامه مشکلی پیش امده لطفا دوباره تلاش نمایید.', 'left', 'red');
            }
        });
    }

    function createEditSafarnameh(_result){
        window.editor.setData(_result.description);

        $('#newSafarnamehId').val(_result.id);
        $('#newSafarnamehTitle').val(_result.title);
        $('#safarnamehSummery').val(_result.summery);

        $('.notPicSafarnameh').hide();
        $('#newSafarnamehPic').show();
        $('#newSafarnamehPic').attr('src', _result.pic);

        if(_result.tags[0])
            $('#safarnamehTag1').val(_result.tags[0]);
        if(_result.tags[1])
            $('#safarnamehTag2').val(_result.tags[1]);
        if(_result.tags[2])
            $('#safarnamehTag3').val(_result.tags[2]);

        pickedPlaces = _result.places;
        createPickPlace();
    }

    function closeNewSafarnameh(){
        closeMyModal('newSafarnameh'); // forAllPages.blade.php
    }

    function openSuggestion(){
        openMyModal('placeSuggestionModal'); // forAllPages.blade.php
        getSuggestionPlace();
        createPickPlace();
    }

    function closeSuggestion(){
        closeMyModal('placeSuggestionModal'); // forAllPages.blade.php
    }

    function getSuggestionPlace(){
        $.ajax({
            type: 'post',
            url: '{{route("profile.safarnameh.placeSuggestion")}}',
            data: {
                _token: '{{csrf_token()}}',
                text: window.editor.getData(),
            },
            success: function(response){
                suggestionPlaces = JSON.parse(response).result;
                createSuggestion(suggestionPlaces);
            },
            error: function(err){

            }
        })
    }

    function createSuggestion(_result){
        text = '';
        _result.forEach((item, index) => {
            text += '<div id="place_' + item.id + '" class="suggEach" onclick="chooseThisSuggestion(' + index + ')">\n' +
                '    <div class="suggPic">\n' +
                '        <img alt="کوچیتا، سامانه جامع گردشگری ایران" src="' + item.pic + '" style="height: 100%">\n' +
                '    </div>\n' +
                '    <div class="suggInfo">\n' +
                '        <div style="font-size: 12px; color: #666666;">' + item.kindPlaceName + '</div>\n' +
                '        <div style="font-weight: bold">' + item.name + '</div>\n' +
                '        <div class="suggInfoState">' + item.state + '</div>\n' +
                '    </div>\n' +
                '</div>';
        });
        $('#ourSuggestion').html(text);

        if(_result.length == 0)
            $('.ourSuggestionShow').hide();
        else
            $('.ourSuggestionShow').show();
    }

    function createPickPlace(){
        if(pickedPlaces.length == 0)
            $('#pickPlacesTitle').hide();
        else
            $('#pickPlacesTitle').show();

        text = '';
        pickedPlaces.forEach((item, index) => {
            text += '<div id="place_' + item.id + '" class="suggEach">\n' +
                '    <div class="iconClose deletePickPlace" onclick="deleteFromPickPlace(' + index + ')"></div>' +
                '    <div class="suggPic">\n' +
                '        <img alt="کوچیتا، سامانه جامع گردشگری ایران" src="' + item.pic + '" style="height: 100%">\n' +
                '    </div>\n' +
                '    <div class="suggInfo">\n' +
                '        <div style="font-size: 12px; color: #666666;">' + item.kindPlaceName + '</div>\n' +
                '        <div style="font-weight: bold">' + item.name + '</div>\n' +
                '        <div class="suggInfoState">' + item.state + '</div>\n' +
                '    </div>\n' +
                '</div>';
        });
        $('.pickPlaces').html(text);
    }

    function chooseThisSuggestion(_index){
        let sug = suggestionPlaces[_index];
        let inPick = false;
        pickedPlaces.forEach((item, index) => {
            if(item.kindPlaceId == sug.kindPlaceId && item.placeId == sug.placeId)
                inPick = true;
        });
        if(!inPick)
            pickedPlaces.push(sug);

        createPickPlace();
    }

    function deleteFromPickPlace(_index){
        pickedPlaces.splice(_index, 1);
        createPickPlace();
    }

    function showAllSuggestionFunc(){
        $('#ourSuggestion').toggleClass('showFullSuggestion');
    }

    function searchForPlaces(_text){
        if(getSuggestionPlaceAjax != null)
            getSuggestionPlaceAjax.abort();

        $('#searchResultPlacess').html('');
        $('#searchResultPlacess').hide();

        if(_text.trim().length > 1) {
            getSuggestionPlaceAjax = $.ajax({
                type: 'post',
                url: '{{route("searchSuggestion")}}',
                data: {
                    _token: '{{csrf_token()}}',
                    kindPlace: $('#kindPlace').val(),
                    text: _text
                },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.status == 'ok') {
                        searchResultPlacess = response.result;
                        createSearchResult(searchResultPlacess);
                    }
                }
            })
        }
    }

    function createSearchResult(_result){
        let text = '';
        _result.forEach((item, index) => {
            text += '<div onclick="chooseSearch(' + index + ')">\n' +
                '   <div>' + item.name + '</div>\n' +
                '   <div style="color: #666666; font-size: 10px">' + item.state + '</div>\n' +
                '</div>'
        });

        $('#searchResultPlacess').html(text);
        $('#searchResultPlacess').show();
    }

    function chooseSearch(_index){
        let sug = searchResultPlacess[_index];
        let inPick = false;
        pickedPlaces.forEach((item, index) => {
            if(item.kindPlaceId == sug.kindPlaceId && item.placeId == sug.placeId)
                inPick = true;
        });
        if(!inPick)
            pickedPlaces.push(sug);

        $('#searchResultPlacess').html('');
        $('#searchResultPlacess').hide();

        createPickPlace();
    }
</script>
