<div id="koochitaUserSearchModal" class="modalBlackBack fullCenter followerModal" style="z-index: 10000;">
    <div class="modalBody" style="width: 400px; border-radius: 10px;">
        <div>
            <div onclick="closeMyModalBP('koochitaUserSearchModal')" class="iconClose closeModal"></div>
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
    var searchUserUrl = '{{route("findUser")}}';
    var koochitaUserModalButtons = '';
    var koochitaUserModalSelectUser = '';
    var noDataKoochitaPicUrl_userKoochitaSearch = "{{URL::asset('images/mainPics/noData.png')}}";
</script>

<script src="{{URL::asset('BusinessPanelPublic/js/component/userKoochitaSearchBP.js?v='.$fileVersions)}}"></script>
