<style>
    .followerModal .searchSec{
        width: 100%;
        margin-top: 10px;
        margin-bottom: 5px;
    }
    .followerModal .searchSec .inputSec{
        display: flex;
        align-items: center;
        background: #80808036;
        justify-content: center;
        border-radius: 13px;
    }
    .followerModal .searchSec .inputSec > input {
        width: 100%;
        border: none;
        padding: 0px 10px;
        background: none;
    }
    .followerModal .searchSec .inputSec > div {
        border: none;
        background: none;
        font-size: 20px;
        padding-left: 5px;
    }
</style>

<div id="followerModal" class="modalBlackBack fullCenter followerModal notCloseOnClick" style="z-index: 9999;">
    <div class="modalBody" style="width: 400px; border-radius: 10px;">
        <div onclick="closeMyModal('followerModal')" class="iconClose closeModal"></div>
        @if(auth()->check())
            <div class="searchSec">
                <div class="inputSec">
                    <input type="text"
                           id="followerModalSearchInput"
                           onfocus="openFollowerSearch(this.value)"
                           onfocusout="closeFollowerSearch(this.value)"
                           onkeyup="searchForFollowerUser(this.value)"
                           placeholder="دوستان خود را پیدا کنید...">
                    <div id="followerModalSearchButton" onclick="closeFollowerSearch(0)">
                        <span class="searchIcon"></span>
                        <span class="iconClose hidden" style="cursor: pointer;"></span>
                    </div>
                </div>
            </div>
        @endif
        <div id="followerModalHeaderTabs" class="header">
            <div class="resultFollowersTab selected" onclick="openFromInPageFollower('resultFollowers')">
                <span class="followerNumber" style="font-weight: bold;"></span>
                <span>follower</span>
            </div>
            <div id="ifYouCanSeeFollowing" class="resultFollowingTab hidden" onclick="openFromInPageFollower('resultFollowing')">
                <span class="followingNumber" style="font-weight: bold;">{{isset($authUserInfos->followingCount) ? $authUserInfos->followingCount : ''}}</span>
                <span>following</span>
            </div>
        </div>
        <div id="followerModalBody" class="body">
            <div id="searchResultFollower"></div>
            <div id="resultFollowers"></div>
            <div id="resultFollowing"></div>
        </div>
    </div>
</div>

<script>
    let ajaxForSearchFollowerUserModal = false;
    let ajaxForSearchFollowerUserModalCheckNumber = 0;
    let lastFollowerModalOpenPage = '';
    let getUserFollowerInPage = 0;
    let followerUserId = {{auth()->check() ? auth()->user()->id : 0}};
    let followerPlaceHolder =   '<div class="peopleRow placeHolder">\n' +
                                '   <div class="pic placeHolderAnime"></div>\n' +
                                '   <div class="name placeHolderAnime resultLineAnim"></div>\n' +
                                '   <div class="buttonP placeHolderAnime resultLineAnim"></div>\n' +
                                '</div>';

    openFromInPageFollower = _kind =>  openFollowerModal(_kind, getUserFollowerInPage);

    function openFollowerModal(_kind, _forWho = 0){
        lastFollowerModalOpenPage = _kind;
        if(_forWho != 0)
            getUserFollowerInPage = _forWho;

        if(followerUserId == _forWho)
            $('#ifYouCanSeeFollowing').removeClass('hidden');
        else
            $('#ifYouCanSeeFollowing').addClass('hidden');

        $('#followerModalBody').children().addClass('hidden');
        $(`#${_kind}`).removeClass('hidden');

        $(`.${_kind}Tab`).parent().find('.selected').removeClass('selected');
        $(`.${_kind}Tab`).addClass('selected');
        $('#'+_kind).html(followerPlaceHolder+followerPlaceHolder);

        let sendKind = '';
        if(_kind == 'resultFollowing')
            sendKind = 'following';
        else
            sendKind = 'follower';

        openMyModal('followerModal');
        $.ajax({
            type: 'post',
            url: '{{route("profile.getFollower")}}',
            data: {
                _token: '{{csrf_token()}}',
                id: _forWho,
                kind: sendKind
            },
            success: function(response){
                response = JSON.parse(response);
                if(response.status == 'ok') {
                    if(_kind == 'resultFollowers')
                        $('.followerNumber').text(response.result.length);
                    createFollower(_kind, response.result)
                };
            },
            // error: err => console.log(err)
        })
    }

    function createFollower(_Id, _follower){
        let text = '';
        if(_follower.length == 0) {
            text =  '<div class="emptyPeople">\n' +
                    '   <img alt="noData" src="{{URL::asset('images/mainPics/noData.png')}}" >\n' +
                    '   <span class="text">هیچ کاربری ثبت نشده است</span>\n' +
                    '</div>';
        }
        else {
            _follower.map(item => {
                let followed = '';
                if (item.followed == 1)
                    followed = 'followed';

                text += `<div class="peopleRow">
                            <a href="${item.url}" class="pic">
                                <img alt="کوچیتا، سامانه جامع گردشگری ایران" src="${item.pic}" class="resizeImgClass" style="width: 100%" onload="fitThisImg(this)">
                            </a>
                            <a href="${item.url}" class="name lessShowText">${item.username}</a>`;

                if (item.notMe == 1) {
                    text += '<div style="display: flex; margin-right: auto;">';
                    text += '   <a href="{{url('profile/message')}}?user='+item.username +'" class="sendMsgButton">ارسال پیام</a>\n';
                    text += '   <div class="button ' + followed + '"  onclick="followUser(this, ' + item.userId + ')"></div>\n';
                    text += '</div>';
                }

                text += '</div>';
            });
        }
        $('#'+_Id).html(text);
    }

    function openFollowerSearch(_value){
        $('#followerModalBody').children().addClass('hidden');
        $('#searchResultFollower').removeClass('hidden');
        $('#followerModalHeaderTabs').addClass('hidden');

        $('#followerModalBody').addClass('openSearch');
        $('#followerModalSearchButton').children().addClass('hidden');
        $('#followerModalSearchButton').find('.iconClose').removeClass('hidden');
    }

    function searchForFollowerUser(_value){
        if (ajaxForSearchFollowerUserModal != false) {
            ajaxForSearchFollowerUserModal.abort();
            ajaxForSearchFollowerUserModal = false;
        }

        $("#searchResultFollower").html('');
        if(_value.trim().length > 1) {
            $("#searchResultFollower").html(followerPlaceHolder+followerPlaceHolder);
            searchForUserCommon(_value)
                .then(response => createFollower('searchResultFollower', response.userName))
                .catch(err => console.error(err));
        }
        else
            $("#searchResultFollower").html('');
    }

    function closeFollowerSearch(_value){

        if(_value == 0)
            $('#followerModalSearchInput').val('');

        if(_value == 0 || _value.length == 0) {
            $('#followerModalBody').removeClass('openSearch');
            $('#followerModalSearchButton').children().addClass('hidden');
            $('#followerModalSearchButton').find('.searchIcon').removeClass('hidden');

            $('#' + lastFollowerModalOpenPage).removeClass('hidden');
            $('#followerModalHeaderTabs').removeClass('hidden');
            $('#searchResultFollower').addClass('hidden');
        }
    }

    function followUser(_elem, _id){
        if(!checkLogin())
            return;

        $.ajax({
            type: 'post',
            url: '{{route("profile.setFollower")}}',
            data: {
                _token: '{{csrf_token()}}',
                id: _id,
                // userPageId: userPageId
            },
            success: function(response){
                response = JSON.parse(response);
                if(response.status == 'store') {
                    $(_elem).addClass('followed');
                    showSuccessNotifi('شما به لیست دوستان افزوده شدید', 'left', 'var(--koochita-blue)');
                    $('.followerNumber').text(response.followerNumber);
                    $('.followingNumber').text(response.followingNumber);
                }
                else if(response.status == 'delete'){
                    $(_elem).removeClass('followed');
                    showSuccessNotifi('شما از لیست دوستان خارج شدید', 'left', 'red');
                    $('.followerNumber').text(response.followerNumber);
                    $('.followingNumber').text(response.followingNumber);
                }
            },
        })
    }

</script>
