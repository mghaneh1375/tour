<div id="koochitaUserSearchModal" class="modalBlackBack fullCenter followerModal" style="z-index: 9999;">
    <div class="modalBody" style="width: 400px; border-radius: 10px;">
        <div>
            <div onclick="closeMyModal('koochitaUserSearchModal')" class="iconClose closeModal"></div>
            <div id="koochitaUserSearchModalTitle" style="color: var(--koochita-light-green); font-size: 25px; font-weight: bold;"></div>
        </div>
        <div class="searchSec">
                <div class="inputSec">
                    <input type="text"
                           id="koochitaUserSearchModalInput"
                           onfocus="openKoochitaUserSearchInput(this.value)"
                           onfocusout="closeKoochitaUserSearchInput(this.value)"
                           onkeyup="searchForKoochitaUser(this.value)"
                           placeholder="دوستان خود را پیدا کنید...">
                    <div id="userKoochiatModalSearchButton" onclick="closeKoochitaUserSearchInput(0)">
                        <span class="searchIcon"></span>
                        <span class="iconClose hidden" style="cursor: pointer"></span>
                    </div>
                </div>
            </div>
        <div id="koochitaUserSearchModalBody" class="body">
            <div id="searchResultKoochitaUserInput" class="searchResultUserKoochitaModal"></div>
        </div>
    </div>
</div>



<script>
    var koochitaUserModalButtons = '';
    var koochitaUserModalSelectUser = '';

    function openKoochitaUserSearchModal(_title = '', _selectUserCallBack = '', _htmlButtons = ''){
        _title = _title == '' ? 'دوستان خود را پیدا کنید' : _title;
        koochitaUserModalButtons = _htmlButtons;
        koochitaUserModalSelectUser = _selectUserCallBack;

        $('#koochitaUserSearchModalTitle').text(_title);

        openMyModal('koochitaUserSearchModal');

        $('#koochitaUserSearchModalInput').val('');
        setTimeout(() => $('#koochitaUserSearchModalInput').focus(), 400);
    }

    function openKoochitaUserSearchInput(_value){
        var searchBody = $('#koochitaUserSearchModalBody');
        searchBody.addClass('openSearch');
        searchBody.children().addClass('hidden');
        searchBody.find('searchResultUserKoochitaModal').removeClass('hidden');

        $('#userKoochiatModalSearchButton').children().addClass('hidden');
        $('#userKoochiatModalSearchButton').find('.iconClose').removeClass('hidden');
    }

    function closeKoochitaUserSearchInput(_value){
        if(_value == 0)
            $('#koochitaUserSearchModalInput').val('');

        if(_value == 0 || _value.length == 0) {
            $('#koochitaUserSearchModalBody').removeClass('openSearch');
            $('#userKoochiatModalSearchButton').children().addClass('hidden');
            $('#userKoochiatModalSearchButton').find('.searchIcon').removeClass('hidden');
            $('#searchResultKoochitaUserInput').addClass('hidden');
        }
    }

    function searchForKoochitaUser(_value){
        $("#searchResultKoochitaUserInput").empty();
        if(_value.trim().length > 1) {
            var userSearchPlaceHolder = `<div class="peopleRow placeHolder">
                                                   <div class="pic placeHolderAnime"></div>
                                                   <div class="name placeHolderAnime resultLineAnim"></div>
                                                   <div class="buttonP placeHolderAnime resultLineAnim"></div>
                                                </div>`;

            $("#searchResultKoochitaUserInput").html(userSearchPlaceHolder+userSearchPlaceHolder).removeClass('hidden');

            searchForUserCommon(_value)
                .then(response => createUserKoochitaSearchResult(response.userName))
                .catch(err => console.error(err));
        }
    }

    function createUserKoochitaSearchResult(_result){
        let text = '';
        if(_result.length == 0) {
            text =  `<div class="emptyPeople">
                       <img alt="noData" src="{{URL::asset('images/mainPics/noData.png')}}" >
                       <span class="text">هیچ کاربری ثبت نشده است</span>
                     </div>`;
        }
        else {
            _result.map(item => {
                text += `<div class="peopleRow hoverChangeBack" onclick="chooseThisKoochitaUser(${item.id}, '${item.username}')" style="cursor: pointer;">
                            <div class="pic">
                                <img alt="کوچیتا، سامانه جامع گردشگری ایران" src="${item.pic}" class="resizeImgClass" style="width: 100%" onload="fitThisImg(this)">
                            </div>
                            <div class="name">${item.username}</div>
                            <div class="buttonP">${koochitaUserModalButtons}</div>
                         </div>`;
            });
        }
        $(`#searchResultKoochitaUserInput`).html(text);
    }

    function chooseThisKoochitaUser(_id, _username){
        closeKoochitaUserSearchInput(0);
        closeMyModal('koochitaUserSearchModal');
        if(typeof koochitaUserModalSelectUser === 'function')
            koochitaUserModalSelectUser(_id, _username);
    }


</script>
