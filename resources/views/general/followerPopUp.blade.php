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
    var ajaxForSearchFollowerUserModal = false;
    var ajaxForSearchFollowerUserModalCheckNumber = 0;
    var lastFollowerModalOpenPage = '';
    var getUserFollowerInPage = 0;
    var followerUserId = {{auth()->check() ? auth()->user()->id : 0}};
    var followerPlaceHolder =   '<div class="peopleRow placeHolder">\n' +
                                '   <div class="pic placeHolderAnime"></div>\n' +
                                '   <div class="name placeHolderAnime resultLineAnim"></div>\n' +
                                '   <div class="buttonP placeHolderAnime resultLineAnim"></div>\n' +
                                '</div>';

    var profileSetFollowerUrl_followerPopUp = '{{route("profile.setFollower")}}';
    var profileGetFollowerUrl_followerPopUp = '{{route("profile.getFollower")}}';
    var noDataPic_followerPopUp = '{{URL::asset('images/mainPics/noData.png')}}';
    var profileMsgPageUrl_followerPopUp = '{{url('profile/message')}}';
</script>
