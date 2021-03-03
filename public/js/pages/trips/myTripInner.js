var selectedPlaceId = -1;

function changeClearCheckBox(from, to) {

    var val = $("#clearDateId").is(":checked");

    if(val == true) {
        $("#date_input_start_edit").val("");
        $("#date_input_end_edit").val("");
    }
    else {
        $("#date_input_start_edit").val(from);
        $("#date_input_end_edit").val(to);
    }

    val = $("#clearDateId_2").is(":checked");
}

function checkBtnDisable() {

    if($("#tripNameEdit").val() == "")
        $("#editBtn").addClass("disabled");
    else
        $("#editBtn").removeClass("disabled");
}

function sortBaseOnPlaceDate(sortMode) {
    document.location.href = tripPlaces + (sortMode === "DESC" ? "/ASC" : "/DESC");
}


var deletedUserId = null;
var deletedPlaceId = null;
var getSuggestionPlaceAjaxMyTripInner = null;
var searchResultPlacesMyTrip = [];
var fullPlaceInfoHtml = '';
var mapMarker = false;
var mapInInnerTrip = false;
var openId = 0;


var memberSample = $('#memberSample').html();
$('#memberSample').html('');

fullPlaceInfoHtml = $('#placeFullInfo').html();
$('#placeFullInfo').remove('');

function deleteTrip() {
    openWarning('آیا از پاک کردن سفر اطمینان دارید ؟', doDeleteTrip, 'بله پاک شود');
}

function doDeleteTrip() {
    $.ajax({
        type: 'POST',
        url: deleteTripInnerUrl,
        data: {
            _token: csrfTokenGlobal,
            tripId: tripId
        },
        success: response => {
            if(response == "ok")
                document.location.href = myTripUrlInInner;
        }
    });
}

function doAddNote() {
    openLoading();
    $.ajax({
        type: 'POST',
        url: addNoteUrlInInner,
        data: {
            _token: csrfTokenGlobal,
            tripId: tripId,
            note: $("#tripNote").val()
        },
        complete: closeLoading,
        success: response => {
            if(response == "ok") {
                closeMyModal('noteModal');
                showSuccessNotifi('یادداشت شما برای سفر با موفقیت ثبت شد', 'left', 'var(--koochita-blue)');
                $("#tripNotePElement").empty().append(($("#tripNote").val())).show();
            }
            else
                showSuccessNotifi('در ثبت یادداشت مشکلی پیش امده لطفا دوباره تلاش نمایید', 'left', 'red');
        },
        error: err => {
            showSuccessNotifi('در ثبت یادداشت مشکلی پیش امده لطفا دوباره تلاش نمایید', 'left', 'red');
        }
    });
}

function searchForPlacesInMyTripInner(_text){
    if(getSuggestionPlaceAjaxMyTripInner != null)
        getSuggestionPlaceAjaxMyTripInner.abort();

    $('#searchResultPlacesInMyTripInner').html('').hide();

    if(_text.trim().length > 1) {
        getSuggestionPlaceAjaxMyTripInner = $.ajax({
            type: 'POST',
            url: searchSuggestionInInnerUrl,
            data: {
                _token: csrfTokenGlobal,
                kindPlace: $('#kindPlaceInMyTrip').val(),
                text: _text
            },
            success: response => {
                response = JSON.parse(response);
                if (response.status == 'ok') {
                    searchResultPlacessMyTrip = response.result;
                    createSearchResultInMyTripInner(searchResultPlacessMyTrip);
                }
            }
        })
    }
}

function createSearchResultInMyTripInner(_result){
    var text = '';
    _result.forEach((item, index) => {
        text += `<div onclick="chooseSearchMyTrip(${index})">
                    <div>${item.name}</div>
                    <div style="color: #666666; font-size: 10px">${item.state}</div>
                </div>`
    });

    $('#addPlaceToTripKindId').html(text).show();
}

function chooseSearchMyTrip(_index){

    var sug = searchResultPlacessMyTrip[_index];
    $('#searchResultPlacess').html('').hide();
    openLoading();
    $.ajax({
        type: 'POST',
        url: addPlaceInInnerUrl,
        data: {
            _token: csrfTokenGlobal,
            tripId: tripId,
            kindPlaceId: sug.kindPlaceId,
            placeId: sug.placeId,
        },
        success: response => {
            if(response.status == 'ok') {
                showSuccessNotifi('محل مورد نظر به لیست سفر اضافه شد', 'left', 'var(--koochita-blue)');
                location.reload();
            }
            else{
                var errorText = '';
                closeLoading();
                if(response.status == 'notAccess')
                    errorText = 'شما دسترسی به تغییر محل های سفر ندارید.';
                else if(response.status == 'nok')
                    errorText = 'این محل در لیست سفر موجود می باشد';
                else
                    errorText = 'مشکلی در ثبت به وجود امده لطفا دوباره تلاش نمایید';

                showSuccessNotifi(errorText, 'left', 'red');
            }
        },
        error: err => {
            closeLoading();
            showSuccessNotifi('مشکلی در ثبت به وجود امده لطفا دوباره تلاش نمایید', 'left', 'red');
        }
    })
}

function deletePlace(tripPlaceId) {
    deletedPlaceId = tripPlaceId;
    openWarning('آیا از پاک کردن محل از برنامه سفر خود اطمینان دارید ؟', doDeleteTripPlace, 'بله پاک شود');
}

function doDeleteTripPlace() {
    openLoading();
    $.ajax({
        type: 'POST',
        url: deletePlaceInInnerUrl,
        data: {
            tripPlaceId: deletedPlaceId
        },
        success: response => {
            closeLoading();
            if(response.trim() == "ok"){
                showSuccessNotifi('محل مورد نظر از لیست سفر حذف شد', 'left', 'var(--koochita-blue)');
                $('#place_' + deletedPlaceId).remove();
            }
            else
                showSuccessNotifi('مشکلی در حذف محل پیش امده.', 'left', 'red');
        },
        error: err => {
            closeLoading();
            showSuccessNotifi('مشکلی در حذف محل پیش امده.', 'left', 'red');
        }
    });
}

function assignDateToPlace(tripPlaceId) {
    selectedPlaceId = tripPlaceId;
    var calendarOption = {
        numberOfMonths: 1,
        showButtonPanel: true,
        dateFormat: "yy/mm/dd"
    }

    if(tripInfo.from_.length != 0)
        calendarOption.minDate = tripInfo.from_;
    if(tripInfo.to_.length != 0)
        calendarOption.maxDate = tripInfo.to_;

    $('#date_input').datepicker(calendarOption);
    // $('#date_input_div').datepicker(calendarOption);
    openMyModal('addDateToPlaceModal');
}

function doAssignDateToPlace() {
    openLoading();
    if($("#date_input").val() != "") {
        $.ajax({
            type: 'post',
            url: assignDateToPlaceDir,
            data: {
                tripPlaceId: selectedPlaceId,
                date: $("#date_input").val()
            },
            success: response => {
                if(response === "ok") {
                    showSuccessNotifi('تاریخ به محل مورد نظر از اضافه شد', 'left', 'var(--koochita-blue)');
                    document.location.reload();
                }
                else{
                    closeLoading();
                    showSuccessNotifi('مشکلی در درخواست شما به وجود امده', 'left', 'red');
                    $("#errorText").empty().append("تاریخ مورد نظر در بازه ی سفر قرار ندارد");
                }
            },
            error: err => {
                closeLoading();
                showSuccessNotifi('مشکلی در درخواست شما به وجود امده', 'left', 'red');
            }
        });
    }
}

function showEditTrip(from, to) {

    $("#date_input_start_edit").datepicker({
        numberOfMonths: 1,
        showButtonPanel: true,
        dateFormat: "yy/mm/dd"
    }).val(from);
    $("#date_input_end_edit").datepicker({
        numberOfMonths: 1,
        showButtonPanel: true,
        dateFormat: "yy/mm/dd"
    }).val(to);

    $("#error").empty();
    openMyModal('editTripModal');
}

function editTrip() {

    date_input_start = $("#date_input_start_edit").val();
    date_input_end = $("#date_input_end_edit").val();
    tripName = $("#tripNameEdit").val();

    if( date_input_start != "" && date_input_end != "" && date_input_start > date_input_end ) {
        newElement = "<p class='color-red'>تاریخ پایان از تاریخ شروع باید بزرگ تر باشد</p>";
        $("#error").empty().append(newElement);
        showSuccessNotifi('تاریخ پایان از تاریخ شروع باید بزرگ تر باشد', 'left', 'red');
        return;
    }


    if(tripName.trim().length > 0) {
        openLoading();
        $.ajax({
            type: 'post',
            url: editTripDir,
            data: {
                'tripName': tripName,
                'dateInputStart' : date_input_start,
                'dateInputEnd' : date_input_end,
                'tripId' : tripId
            },
            success: function (response) {
                if(response == "ok") {
                    showSuccessNotifi('اطلاعات سفر شما با موفقیت تغییر یافت', 'left', 'var(--koochita-blue)');
                    document.location.reload();
                }
                else {
                    closeLoading();
                    showSuccessNotifi('در ویرایش اطلاعات سفر مشکلی پیش امده', 'left', 'red');
                }
            },
            error: function(err){
                closeLoading();
                showSuccessNotifi('در ویرایش اطلاعات سفر مشکلی پیش امده', 'left', 'red');
            }
        });
    }
    else
        showSuccessNotifi('نام برنامه سفر نمی تواند خالی باشد', 'left', 'red');

}

function showPlaceInfo(_id, _index) {
    var placeElement = $('#place_' + _id);
    var selectedPlace = null;
    tripPlacesInfo.forEach(item => {
        if(item.id == _id)
            selectedPlace = item;
    });

    $(".addCommentInput").val('');
    $(".placeSelectedId").val(0);
    $('.placeDetailsToggleBar').remove();
    $('.placeCard').removeClass('fullShow');


    if(selectedPlace != null && openId != _id){
        openId = _id;

        var placeInfo = selectedPlace.placeInfo;
        var width = $('#tripCardSection').width();
        var elemWidth = placeElement.width() + (2 * parseFloat(placeElement.css('padding').split('px')[0]));
        var countInRow = Math.floor(width/elemWidth);

        var nextCount = (countInRow - 1) - (_index % countInRow);
        var showAfter = placeElement;
        for(var i = 0; i < nextCount; i++) {
            nextElemes = showAfter.next();
            if(nextElemes.length == 0)
                break;
            showAfter = nextElemes
        }

        $(fullPlaceInfoHtml).insertAfter(showAfter[0]);

        $(".placeSelectedId").val(_id);

        placeElement.addClass('fullShow');

        var lat = placeInfo.x;
        var lng = placeInfo.y;

        if(lat && lng) {
            initMap(lat, lng, () => {
                yourPosition = L.marker([lat, lng]).addTo(mapInInnerTrip);
                mapInInnerTrip.setView([lat, lng], 16);
            });
            // setTimeout(function(){
            //     mapMarker = new google.maps.Marker({
            //         position: new google.maps.LatLng(placeInfo.x, placeInfo.y),
            //         map: mapInInnerTrip,
            //         title: placeInfo.name
            //     });
            // }, 200);
        }
        else
            $('#map_').hide();

        $('.placeName').text(placeInfo.name).attr('href', placeInfo.url);
        $('.moreInfoPic').attr('src', placeInfo.pic);

        if(placeInfo.address)
            $('.address').text(placeInfo.address);
        else if(placeInfo.dastresi)
            $('.address').text(placeInfo.dastresi);

        $('.reviewCount').text(placeInfo.review + ' نقد ');
        $('.rating').find('.ui_bubble_rating').addClass('bubble_' + placeInfo.rate + '0');
        $('.rightSec').find('.city').text(placeInfo.city + ' در ' + placeInfo.state);

        if(selectedPlace.comments.length == 0)
            $('.userComments').html('<div class="notRow"> برای این محل هیچ یادداشتی ثبت نشده است </div>');
        else
            createCommentsHtml(selectedPlace);
    }
    else
        openId = 0;
}

function createCommentsHtml(_selectedPlace){
    $('.userComments').empty();
    _selectedPlace.comments.map(item => {
        var userRows =  `<div class="userRow">
                            <div class="userInfo">
                               <div class="img">
                                   <img src="${item.userPic}" style="width: 100%;">
                               </div>
                               <div class="name">${item.username}</div>
                               <div class="date">${item.date}</div>`;

        if(item.yourComments == 1)
            userRows += `<div class="ui_button removeBtnTargetHelp_16" onclick="deleteComment(${item.id}, ${_selectedPlace.id})"></div>`;

        userRows += `</div>
                    <div class="text">${item.description}</div>
                    </div>`;

        $('.userComments').append(userRows)
    })
}

function addComment() {
    var inputs = $(".addCommentInput");
    var tripPlaceId = $(".placeSelectedId").val();
    var text = '';

    inputs.map(item => {
        if($(inputs[item]).val().trim() != '')
            text = $(inputs[item]).val();
    });

    if(text.trim() != '' && tripPlaceId != 0){
        openLoading();
        $.ajax({
            type: 'POST',
            url: addCommentDir,
            data: {
                tripPlaceId: tripPlaceId,
                comment: text.trim()
            },
            success: function (response) {
                closeLoading();
                $(".addCommentInput").val('');
                response = JSON.parse(response);
                if(response.status == "ok"){
                    tripPlacesInfo.forEach(item => {
                        if(item.id == tripPlaceId){
                            item.comments.unshift(response.result);
                            createCommentsHtml(item);
                            $('#tripCommentNumber'+tripPlaceId).show().text(item.comments.length + ' یادداشت ');
                        }
                    });
                    showSuccessNotifi('یادداشت شما با موفقیت ثبت شد.', 'left', 'var(--koochita-blue)');
                }
                else
                    showSuccessNotifi('در ثبت یادداشت مشکلی پیش امده لطفا دوباره تلاش نمایید', 'left', 'red');
            },
            error: function(err){
                closeLoading();
                showSuccessNotifi('در ثبت یادداشت مشکلی پیش امده لطفا دوباره تلاش نمایید', 'left', 'red');
            }
        });
    }
}

function deleteComment(_id, _placeId){
    $.ajax({
        type: 'POST',
        url: deleteCommentTripInInnerUrl,
        data: {
            _token: csrfTokenGlobal,
            id: _id
        },
        success: function(response){
            if(response == 'ok') {
                tripPlacesInfo.forEach(item => {
                    var index = -1;
                    if(item.id == _placeId){
                        item.comments.map((comment, _index) => {
                            if(comment.id == _id)
                                index = _index;
                        });
                        if(index != -1)
                            item.comments.splice(index, 1);
                        createCommentsHtml(item);
                    }
                });
                showSuccessNotifi('یادداشت شما با موفقیت حذف شد', 'left', 'var(--koochita-blue)');
            }
            else
                showSuccessNotifi('در حذف یادداشت مشکلی پیش امده لطفا دوباره تلاش نمایید', 'left', 'red');
        },
        error: function(err){
            showSuccessNotifi('در حذف یادداشت مشکلی پیش امده لطفا دوباره تلاش نمایید', 'left', 'red');
        }
    })
}

function initMap(x = 0, y = 0, _callBack = '') {
    // var mapOptions = {
    //     zoom: 14,
    //     center: new google.maps.LatLng(x, y), // New York
    //     styles: [
    //         {
    //             "featureType":"landscape",
    //             "stylers":[
    //                 {"hue":"#FFA800"},
    //                 {"saturation":0},
    //                 {"lightness":0},
    //                 {"gamma":1}
    //             ]}, {
    //             "featureType":"road.highway",
    //             "stylers":[
    //                 {"hue":"#53FF00"},
    //                 {"saturation":-73},
    //                 {"lightness":40},
    //                 {"gamma":1}
    //             ]},	{
    //             "featureType":"road.arterial",
    //             "stylers":[
    //                 {"hue":"#FBFF00"},
    //                 {"saturation":0},
    //                 {"lightness":0},
    //                 {"gamma":1}
    //             ]},	{
    //             "featureType":"road.local",
    //             "stylers":[
    //                 {"hue":"#00FFFD"},
    //                 {"saturation":0},
    //                 {"lightness":30},
    //                 {"gamma":1}
    //             ]},	{
    //             "featureType":"water",
    //             "stylers":[
    //                 {"hue":"#00BFFF"},
    //                 {"saturation":6},
    //                 {"lightness":8},
    //                 {"gamma":1}
    //             ]},	{
    //             "featureType":"poi",
    //             "stylers":[
    //                 {"hue":"#679714"},
    //                 {"saturation":33.4},
    //                 {"lightness":-25.4},
    //                 {"gamma":1}
    //             ]}
    //     ]
    // };
    // var mapElement = document.getElementById('map_');
    // mapInInnerTrip = new google.maps.Map(mapElement, mapOptions);


    mapInInnerTrip = L.map("map_", {
        minZoom: 1,
        maxZoom: 20,
        crs: L.CRS.EPSG3857,
        center: [x, y],
        zoom: 6
    });
    L.TileLayer.wmsHeader(
        "https://map.ir/shiveh",
        {
            layers: "Shiveh:Shiveh",
            format: "image/png",
            minZoom: 1,
            maxZoom: 20
        },
        [
            {
                header: "x-api-key",
                value: window.mappIrToken
            }
        ]
    ).addTo(mapInInnerTrip);

    if(typeof _callBack === 'function')
        _callBack();
}

function choosePlaceInfoTab(_kind, _element){
    var placeDetailsToggleBarElement  = $('.placeDetailsToggleBar');
    $('.tabSection').find('.active').removeClass('active');
    $(_element).addClass('active');
    placeDetailsToggleBarElement.find('.rightSec').removeClass('show');
    placeDetailsToggleBarElement.find('.leftSec').removeClass('show');

    if(_kind == 'info')
        placeDetailsToggleBarElement.find('.rightSec').addClass('show');
    else
        placeDetailsToggleBarElement.find('.leftSec').addClass('show');
}

function showMembers() {
    openMyModal('memberModal');
    if(tripMember.length == 0)
        $('#members').html(`<button class="ui_icon add-friend-fill inviteFBut" onclick="closeMyModal('memberModal'); openMyModal('inviteMember')">دعوت از دوستان</button>`);
    else{
        $('#members').empty();
        tripMember.map(item => {
            var memberElement = $(`#member_${item.id}`);
            var text = memberSample;
            var obj = Object.keys(item);

            for (var x of obj)
                text = text.replace(new RegExp(`##${x}##`, "g"), item[x]);

            $('#members').append(text);

            if(item.status == 1)
                memberElement.find('.loading').remove();

            if(item.editTrip == 1)
                $('#canEditTrip_' + item.id).prop('checked', 'true');
            if(item.editPlace == 1)
                $('#canEditPlace_' + item.id).prop('checked', 'true');
            if(item.editMember == 1)
                $('#canEditMember_' + item.id).prop('checked', 'true');

            if(item.owner == true){
                memberElement.find('.accessBut').remove();
                memberElement.find('.deleteBut').remove();
            }

        })
    }
}

function showThisUserAccess(_element){
    var hasRot = $('.rotate180');
    var card = $(_element).parent().parent();
    card.addClass('rotate180');
    setTimeout(function(){
        card.addClass('accessType');
    }, 200);

    hasRot.removeClass('rotate180');
    setTimeout(function(){
        hasRot.removeClass('accessType');
    }, 200);
}

function submitMemberAccess(_element, _id){
    openLoading();

    var canEditPlace = $('#canEditPlace_' + _id).prop('checked');
    var canEditMember = $('#canEditMember_' + _id).prop('checked');
    var canEditTrip = $('#canEditTrip_' + _id).prop('checked');

    $.ajax({
        type: 'POST',
        url: editUserAccessTripInInnerUrl,
        data: {
            _token: csrfTokenGlobal,
            uId: _id,
            tripId: tripId,
            editMember: canEditMember,
            editTrip: canEditTrip,
            editPlace: canEditPlace
    },
    success: function(response){
        closeLoading();
        response = JSON.parse(response);
        if(response.status == 'ok'){
            var hasRot = $('.rotate180');
            hasRot.removeClass('rotate180');
            setTimeout(function(){
                hasRot.removeClass('accessType');
            }, 200);

            tripMember.map(item => {
                if(item.id == _id){
                    item.editMember = response.result.editMember;
                    item.editTrip = response.result.editTrip;
                    item.editPlace = response.result.editPlace;
                }
            });
            showSuccessNotifi('تغییر دسترسی با موفقیت اعمال شد', 'left', 'var(--koochita-blue)');
        }
        else{
            showSuccessNotifi('تغییر دسترسی با مشکل مواجه شد', 'left', 'red');
        }
    },
    error: function(err){
        closeLoading();
        showSuccessNotifi('تغییر دسترسی با مشکل مواجه شد', 'left', 'red');
    }
});

}

function deleteMember(_id, _username) {
    deletedUserId = _id;
    openWarning('آیا می خواهید ' + _username + ' را از سفر خود حذف کنید؟', doDeleteMember, 'بله حذف شود');
}

function doDeleteMember() {
    openLoading();
    $.ajax({
        type: 'POST',
        url: deleteMemberFromTripInInnerUrl,
        data: {
            uId: deletedUserId,
            tripId: tripId
        },
        success: function (response) {
            if(response == "ok") {
                showSuccessNotifi('کاربر مورد نظر حذف شد', 'left', 'var(--koochita-blue)');
                document.location.reload();
            }
            else {
                closeLoading();
                showSuccessNotifi('در حذف کاربر مشکلی پیش امده', 'left', 'red');
            }
        },
        error: function(err){
            closeLoading();
            showSuccessNotifi('در حذف کاربر مشکلی پیش امده', 'left', 'red');
        }

    });
}

function resultInvite(_kind){
    openLoading();
    $.ajax({
        type: 'POST',
        url: InviteResultTripInInnerUrl,
        data: {
            _token: csrfTokenGlobal,
            kind: _kind,
            tripId: tripId
        },
        success: function(response){
            if(response == 'ok')
                location.reload();
            else {
                closeLoading();
                showSuccessNotifi('در ثبت درخواست مشکلی پیش امده', 'left', 'red');
            }
        },
        error: function(err){
            closeLoading();
            showSuccessNotifi('در ثبت درخواست مشکلی پیش امده', 'left', 'red');
        }
    })
}

function openUserMyTripSearch(_value){
    var inviteBody = $('#inviteMemberModalBody');
    inviteBody.addClass('openSearch');
    inviteBody.children().addClass('hidden');
    inviteBody.find('searchResult').removeClass('hidden');

    $('#inviteMemberModalSearchButton').children().addClass('hidden');
    $('#inviteMemberModalSearchButton').find('.iconClose').removeClass('hidden');
}

function closeUserMyTripSearch(_value){
    if(_value == 0)
        $('#myTripUserSearchInput').val('');

    if(_value == 0 || _value.length == 0) {
        $('#inviteMemberModalBody').removeClass('openSearch');
        $('#inviteMemberModalSearchButton').children().addClass('hidden');
        $('#inviteMemberModalSearchButton').find('.searchIcon').removeClass('hidden');
        $('#searchResultInviteMember').addClass('hidden');
    }
}

function searchForUserMyTrip(_value){
    $("#searchResultInviteMember").empty();
    if(_value.trim().length > 1) {
        var userSearchPlaceHolder = `<div class="peopleRow placeHolder">
                                           <div class="pic placeHolderAnime"></div>
                                           <div class="name placeHolderAnime resultLineAnim"></div>
                                           <div class="buttonP placeHolderAnime resultLineAnim"></div>
                                        </div>`;

        $("#searchResultInviteMember").html(userSearchPlaceHolder+userSearchPlaceHolder).removeClass('hidden');

        searchForUserCommon(_value)
            .then(response => createInviteMemberSearchResult(response.userName))
            .catch(err => console.error(err));
    }
}

function createInviteMemberSearchResult(_result){
    var text = '';
    if(_result.length == 0) {
        text =  `<div class="emptyPeople">
                   <img alt="noData" src="${notDataPicInInnerUrl}" >
                   <span class="text">هیچ کاربری ثبت نشده است</span>
                </div>`;
    }
    else {
        _result.map(item => {
            text += `<div class="peopleRow hoverChangeBack" onclick="chooseMemberForTrip(${item.id})" style="cursor: pointer;">
                                    <div class="pic">
                                        <img alt="کوچیتا، سامانه جامع گردشگری ایران" src="${item.pic}" class="resizeImgClass" style="width: 100%" onload="fitThisImg(this)">
                                    </div>
                                    <div class="name">${item.username}</div>
                                 </div>`;
        });
    }
    $(`#searchResultInviteMember`).html(text);
}

function chooseMemberForTrip(_userId){

    openLoading();
    $.ajax({
        type: 'POST',
        url: InviteMemberTripInInnerUrl,
        data: {
            _token: csrfTokenGlobal,
            friendId : _userId,
            tripId : tripId,
            editTrip : 0,
            editPlace : 0,
            editMember : 0
        },
        success: response => {
            closeLoading();
            if(response.status == "ok") {
                $('.choosenResult').addClass('hidden');
                $('#inviteId').val(0);
                $('#friendName').val('');
                $('#submitInvite').prop('disabled', false);
                $('#newCanEditTrip').prop('checked', false);
                $('#newCanEditPlace').prop('checked', false);
                $('#newCanEditMember').prop('checked', false);
                tripMember = response.result;
                showSuccessNotifi('دوست شما با موفقیت به سفر اضافه شد', 'left', 'var(--koochita-blue)');
                closeUserMyTripSearch(0);
                closeMyModal('inviteMember');
            }
            else if(response.status == "nok" || response.status == "nullTrip")
                showSuccessNotifi('در ثبت کاربر مشکلی پیش امده', 'left', 'red');
            else if(response.status == "notFindFriend")
                    showSuccessNotifi('کاربر مورد نظر یافت نشد', 'left', 'red');
            else if(response.status == "notAccess")
                    showSuccessNotifi('شما دسترسی به دعوت دیگران ندارید', 'left', 'red');
            else if(response.status == "nok1")
                    showSuccessNotifi('شما نمی توانید خود را دعوت کنید.', 'left', 'red');
            else if(response.status == "beforeRegistered")
                    showSuccessNotifi('کاربر مورد نظر عضو سفر می باشد', 'left', 'red');
            else
                showSuccessNotifi('در ثبت کاربر مشکلی پیش امده', 'left', 'red');
        },
        error: function(err){
            showSuccessNotifi('در ثبت کاربر مشکلی پیش امده', 'left', 'red');
            closeLoading();
        }
    });
}





var total;
var filters = [];
var hasFilter = false;
var topContainer;
var marginTop;
var helpWidth;
var greenBackLimit = 5;
var pageHeightSize = window.innerHeight;
var additional = [];
var indexes = [];

$(".nextBtnsHelp").click(function () {
    show(parseInt($(this).attr('data-val')) + 1, 1);
});

$(".backBtnsHelp").click(function () {
    show(parseInt($(this).attr('data-val')) - 1, -1);
});

$(".exitBtnHelp").click(function () {
    myQuit();
});

function myQuit() {
    clear();
    $(".dark").hide();
    enableScroll();
}

function setGreenBackLimit(val) {
    greenBackLimit = val;
}

function initHelp(t, sL, topC, mT, hW) {
    total = t;
    filters = sL;
    topContainer = topC;
    marginTop = mT;
    helpWidth = hW;

    if(sL.length > 0)
        hasFilter = true;

    $(".dark").show();
    show(1, 1);
}

function initHelp2(t, sL, topC, mT, hW, i, a) {
    total = t;
    filters = sL;
    topContainer = topC;
    marginTop = mT;
    helpWidth = hW;
    additional = a;
    indexes = i;

    if(sL.length > 0)
        hasFilter = true;

    $(".dark").show();
    show(1, 1);
}

function isInFilters(key) {

    key = parseInt(key);

    for(j = 0; j < filters.length; j++) {
        if (filters[j] == key)
            return true;
    }
    return false;
}

function getBack(curr) {

    for(i = curr - 1; i >= 0; i--) {
        if(!isInFilters(i))
            return i;
    }
    return -1;
}

function getFixedFromLeft(elem) {

    if(elem.prop('id') == topContainer || elem.prop('id') == 'PAGE') {
        return parseInt(elem.css('margin-left').split('px')[0]);
    }

    return elem.position().left +
        parseInt(elem.css('margin-left').split('px')[0]) +
        getFixedFromLeft(elem.parent());
}

function getFixedFromTop(elem) {

    if(elem.prop('id') == topContainer) {
        return marginTop;
    }

    if(elem.prop('id') == "PAGE") {
        return 0;
    }

    return elem.position().top +
        parseInt(elem.css('margin-top').split('px')[0]) +
        getFixedFromTop(elem.parent());
}

function getNext(curr) {

    curr = parseInt(curr);

    for(i = curr + 1; i < total; i++) {
        if(!isInFilters(i))
            return i;
    }
    return total;
}

function bubbles(curr) {

    if(total <= 1)
        return "";

    t = total - filters.length;
    newElement = "<div class='col-xs-12 position-relative'><div class='col-xs-12 bubbles pd-0 mg-rt-0' style='margin-left: " + ((400 - (t * 18)) / 2) + "px'>";

    for (i = 1; i < total; i++) {
        if(!isInFilters(i)) {
            if(i == curr)
                newElement += "<div class='isNotInFilterCurrent'></div>";
            else
                newElement += "<div class='isNotInFilter helpBubble' onclick='show(\"" + i + "\", 1)'></div>";
        }
    }

    newElement += "</div></div>";

    return newElement;
}

function clear() {

    $('.bubbles').remove();

    $(".targets").css({
        'position': '',
        'border': '',
        'padding': '',
        'background-color': '',
        'z-index': '',
        'cursor': '',
        'pointer-events': 'auto'
    });

    $(".helpSpans").addClass('hidden');
    $(".backBtnsHelp").attr('disabled', 'disabled');
    $(".nextBtnsHelp").attr('disabled', 'disabled');
}

function show(curr, inc) {

    clear();

    if(hasFilter) {
        while (isInFilters(curr)) {
            curr += inc;
        }
    }

    if(getBack(curr) <= 0) {
        $("#backBtnHelp_" + curr).attr('disabled', 'disabled');
    }
    else {
        $("#backBtnHelp_" + curr).removeAttr('disabled');
    }

    if(getNext(curr) > total - 1) {
        $("#nextBtnHelp_" + curr).attr('disabled', 'disabled');
    }
    else {
        $("#nextBtnHelp_" + curr).removeAttr('disabled');
    }

    if(curr < greenBackLimit) {
        $("#targetHelp_" + curr).css({
            'position': 'relative',
            'border': '5px solid #333',
            'padding': '10px',
            'background-color': 'var(--koochita-light-green)',
            'z-index': 1000001,
            'cursor': 'auto'
        });
    }
    else {
        $("#targetHelp_" + curr).css({
            'position': 'relative',
            'border': '5px solid #333',
            'padding': '10px',
            'background-color': 'white',
            'z-index': 100000001,
            'cursor': 'auto'
        });
    }

    var targetWidth = $("#targetHelp_" + curr).css('width').split('px')[0];

    var targetHeight = parseInt($("#targetHelp_" + curr).css('height').split('px')[0]);

    for(j = 0; j < indexes.length; j++) {
        if(curr == indexes[j]) {
            targetHeight += additional[j];
            break;
        }
    }

    if($("#targetHelp_" + curr).offset().top > 200) {
        $("html, body").scrollTop($("#targetHelp_" + curr).offset().top - 100);
        $("#helpSpan_" + curr).css({
            'left': $("#targetHelp_" + curr).offset().left + targetWidth / 2 - helpWidth / 2 + "px",
            'top': targetHeight + 120 + "px"
        }).removeClass('hidden').append(bubbles(curr));
    }
    else {
        $("#helpSpan_" + curr).css({
            'left': $("#targetHelp_" + curr).offset().left + targetWidth / 2 - helpWidth / 2 + "px",
            'top': ($("#targetHelp_" + curr).offset().top + targetHeight + 20) % pageHeightSize + "px"
        }).removeClass('hidden').append(bubbles(curr));
    }



    $(".helpBubble").on({

        mouseenter: function () {
            $(this).css('background-color', '#ccc');
        },
        mouseleave: function () {
            $(this).css('background-color', '#333');
        }

    });

    disableScroll();
}

// left: 37, up: 38, right: 39, down: 40,
// spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36

var keys = {37: 1, 38: 1, 39: 1, 40: 1};

function preventDefault(e) {
    e = e || window.event;
    if (e.preventDefault)
        e.preventDefault();
    e.returnValue = false;
}

function preventDefaultForScrollKeys(e) {
    if (keys[e.keyCode]) {
        preventDefault(e);
        return false;
    }
}

function disableScroll() {
    if (window.addEventListener) // older FF
        window.addEventListener('DOMMouseScroll', preventDefault, false);
    window.onwheel = preventDefault; // modern standard
    window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
    window.ontouchmove  = preventDefault; // mobile
    document.onkeydown  = preventDefaultForScrollKeys;
}

function enableScroll() {
    if (window.removeEventListener)
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
    window.onmousewheel = document.onmousewheel = null;
    window.onwheel = null;
    window.ontouchmove = null;
    document.onkeydown = null;
}

$(document).ready(function () {
    checkBtnDisable();
});
