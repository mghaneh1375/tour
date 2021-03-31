
var safarnamehNewMainPic = null;
var getSuggestionPlaceAjax = null;
var searchResultPlacess = [];
var pickedPlaces = [];
var suggestionPlaces;
var safarnamehRandomCode = Math.floor(Math.random()*100000);

DecoupledEditor.create( document.querySelector('#safarnamehText'), {
    language: applicationLanguage_addSafarnameh,
    removePlugins: [ 'FontSize', 'MediaEmbed' ],
})
    .then( editor => {
        const toolbarContainer = document.querySelector( '.toolbar-container');
        toolbarContainer.prepend( editor.ui.view.toolbar.element );
        window.editor = editor;
        textEditor = editor;
        editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
            var data = { id: userId_addSafarnameh, code: safarnamehRandomCode };
            data = JSON.stringify(data);
            return new MyUploadAdapter( loader, storePicUrl_addSafarnameh, csrfTokenGlobal, data);
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
            type: 'POST',
            url: storeSafarnamehUrl_addSafarnameh,
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
        type: 'POST',
        url: getSafarnamehUrl_addSafarnameh,
        data: {
            _token: csrfTokenGlobal,
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
        type: 'POST',
        url: placeSuggestionSafarnamehUrl_addSafarnameh,
        data: {
            _token: csrfTokenGlobal,
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
    var sug = suggestionPlaces[_index];
    var inPick = false;
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
            type: 'POST',
            url: searchSuggSafarnamehUrl_addSafarnameh,
            data: {
                _token: csrfTokenGlobal,
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
    var text = '';
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
    var sug = searchResultPlacess[_index];
    var inPick = false;
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
