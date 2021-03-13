var koochitaUserSearchResults = [];
var koochitaUserSearchModalInputElement = $('#koochitaUserSearchModalInput');
var userKoochiatModalSearchButtonElement = $('#userKoochiatModalSearchButton');
var searchResultKoochitaUserInputElement = $('#searchResultKoochitaUserInput');

function openKoochitaUserSearchModal(_title = '', _selectUserCallBack = '', _htmlButtons = ''){
    _title = _title == '' ? 'دوستان خود را پیدا کنید' : _title;
    koochitaUserModalButtons = _htmlButtons;
    koochitaUserModalSelectUser = _selectUserCallBack;

    $('#koochitaUserSearchModalTitle').text(_title);

    openMyModal('koochitaUserSearchModal');

    koochitaUserSearchModalInputElement.val('');
    setTimeout(() => koochitaUserSearchModalInputElement.focus(), 400);
}

function openKoochitaUserSearchInput(_value){
    var searchBody = $('#koochitaUserSearchModalBody');
    searchBody.addClass('openSearch');
    searchBody.children().addClass('hidden');
    searchBody.find('searchResultUserKoochitaModal').removeClass('hidden');

    userKoochiatModalSearchButtonElement.children().addClass('hidden');
    userKoochiatModalSearchButtonElement.find('.iconClose').removeClass('hidden');
}

function closeKoochitaUserSearchInput(_value){
    if(_value == 0)
        koochitaUserSearchModalInputElement.val('');

    if(_value == 0 || _value.length == 0) {
        $('#koochitaUserSearchModalBody').removeClass('openSearch');
        userKoochiatModalSearchButtonElement.children().addClass('hidden');
        userKoochiatModalSearchButtonElement.find('.searchIcon').removeClass('hidden');
        searchResultKoochitaUserInputElement.addClass('hidden');
    }
}

function searchForKoochitaUser(_value){
    searchResultKoochitaUserInputElement.empty();
    if(_value.trim().length > 1) {
        var userSearchPlaceHolder = `<div class="peopleRow placeHolder">
                                                   <div class="pic placeHolderAnime"></div>
                                                   <div class="name placeHolderAnime resultLineAnim"></div>
                                                   <div class="buttonP placeHolderAnime resultLineAnim"></div>
                                                </div>`;

        searchResultKoochitaUserInputElement.html(userSearchPlaceHolder+userSearchPlaceHolder).removeClass('hidden');

        searchForUserCommon(_value)
            .then(response => createUserKoochitaSearchResult(response.userName))
            .catch(err => console.error(err));
    }
}

function createUserKoochitaSearchResult(_result){
    koochitaUserSearchResults = _result;
    let text = '';
    if(koochitaUserSearchResults.length == 0) {
        text =  `<div class="emptyPeople">
                       <img alt="noData" src="${noDataKoochitaPicUrl_userKoochitaSearch}">
                       <span class="text">هیچ کاربری ثبت نشده است</span>
                     </div>`;
    }
    else {
        koochitaUserSearchResults.map((item, index) => {
            text += `<div class="peopleRow hoverChangeBack" onclick="chooseThisKoochitaUser(${index})" style="cursor: pointer;">
                            <div class="pic">
                                <img alt="کوچیتا، سامانه جامع گردشگری ایران" src="${item.pic}" class="resizeImgClass" style="width: 100%" onload="fitThisImg(this)">
                            </div>
                            <div class="name">${item.username}</div>
                            <div class="buttonP">${koochitaUserModalButtons}</div>
                         </div>`;
        });
    }
    searchResultKoochitaUserInputElement.html(text);
}

function chooseThisKoochitaUser(_index){
    var user = koochitaUserSearchResults[_index];
    closeKoochitaUserSearchInput(0);
    closeMyModal('koochitaUserSearchModal');
    if(typeof koochitaUserModalSelectUser === 'function')
        koochitaUserModalSelectUser(user.id, user.username, user.pic);
}

var searchInUserAjax;
async function searchForUserCommon(_value){
    var findUserPromise = new Promise((myResolve, myReject) => {
        if(searchInUserAjax != null)
            searchInUserAjax.abort();

        searchInUserAjax = $.ajax({
            type: 'GET',
            url: window.searchInUserUrl+'?username='+_value.trim(),
            success: response => {
                if(response.status == 'ok')
                    myResolve(response.result);
                else
                    myReject(response.status);
            },
        })
    });
    return await findUserPromise;
}

