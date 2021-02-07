@if(\App::getLocale() == 'en')
    <link rel="stylesheet" href="{{URL::asset('css/ltr/mainSearch.css?v='.$fileVersions)}}">
@endif

<style>
    .mainSearchResultRow{
        color: black;
        display: block;
        padding: 1px 5px;
        cursor: pointer;
        transition: .3s;
    }
    .mainSearchResultRow:hover{
        color: black;
        background-color: #F2F2F2;
        border-radius: 5px;
    }
</style>

<div id="searchPane" class="searchPaneDiv hidden">
    <span class="statePane editTags searchPanes">
        <div id="searchDivForScroll" class="prw_rup prw_search_typeahead spSearchDivForScroll">
            <div class="ui_picker">
                <div class="typeahead_align ui_typeahead full-width display-flex" style="font-size: 20px">

                    <div id="firstPanSearchText" class="spGoWhere">{{__('به کجا')}}</div>
                    <input onkeyup="searchMain(event, this.value)" type="text" id="mainSearchInput" class="typeahead_input" placeholder="{{__('دوست دارید سفر کنید؟')}}"/>
                    <input type="hidden" id="kindPlaceIdForMainSearch" value="0">
                    <input type="hidden" id="placeId">

                </div>
                <div class="spBorderBottom"></div>
                <div class="mainContainerSearch">
                    <div id="result" class="data_holder searchPangResultSection hidden">
                        <div id="mainSearchResult" style="display:none;"></div>
                        <div id="placeHolderResult" style="display: none;">
                            <div style="margin-bottom: 40px">
                                <div class="resultLineAnim placeHolderAnime"></div>
                                <div class="resultLineAnim placeHolderAnime" style="width: 30%"></div>
                            </div>
                            <div>
                                <div class="resultLineAnim placeHolderAnime"></div>
                                <div class="resultLineAnim placeHolderAnime" style="width: 30%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="visitSuggestionDiv">
                            <div class="visitSuggestionText">{{__('بازدید های اخیر شما')}}</div>

                            <div id="recentlyRowMainSearch" class="visitSuggestion4Box recentlyRowMainSearch"></div>
                        </div>
                </div>

            </div>
        </div>
        <div class="iconFamily iconClose closeSearchPan" onclick="$('#searchPane').addClass('hidden');"></div>
    </span>
</div>

<script>
    var recentlyMainSearchSample = `
        <div class="prw_rup prw_shelves_rebrand_poi_shelf_item_widget spBoxOfSuggestion">
            <div class="mainSearchpoi">
                <div class="prw_rup prw_common_thumbnail_no_style_responsive prw_common_thumbnail_no_style_responsive22">
                    <div class="prv_thumb has_image" style="height: 100%">
                        <div class="image_wrapper spImageWrapper landscape landscapeWide mainSearchImgTop">
                            <img src="##mainPic##" alt="##name##" class="image" style="height: 100%">
                        </div>
                    </div>
                </div>
                <a href="##redirect##" class="textsOfRecently">
                    <div class="detail direction-rtl" style="width: 100%;">
                        <div class="textsOfRecently_text">##name##</div>
                    </div>
                </a>
            </div>
        </div>`;

</script>


<script>

    var mainSearchAjax = null;
    var numOfMainSearchResult = 0;
    var searchDir = '{{route('totalSearch')}}';
    var lastTimeMainSearch = 0;
    var localStorageData = 0;
    @if(isset($localStorageData))
        localStorageData = {!! json_encode($localStorageData) !!}
    @endif


    function openMainSearch(_kindPlaceId){
        var fpst;
        var pn;
        var countryIcon = '';

        showLastPages();

        switch (_kindPlaceId){
            case 0:
                fpst = '{{__('به کجا')}}';
                pn = '{{__('دوست دارید سفر کنید؟')}}';
                break;
            case 1:
                fpst = '{{__('کدام جاذبه')}}';
                pn = '{{__('را می‌خواهید تجربه کنید؟')}}';
                countryIcon = 'touristAttractions';
                break;
            case 3:
                fpst = '{{__('در کدام رستوران')}}';
                pn = '{{__('دوست دارید غذا بخورید؟')}}';
                countryIcon = 'restaurantIcon';
                break;
            case 4:
                fpst = '{{__('در کدام هتل')}}';
                pn = '{{__('دوست دارید اقامت کنید؟')}}';
                countryIcon = 'hotelIcon';
                break;
            case 6:
                fpst = '{{__(' کدام ماجرا')}}';
                pn = '{{__('دوست دارید تجربه کنید؟')}}';
                countryIcon = 'adventureIcon';
                break;
            case 10:
                fpst = '{{__('کدام صنایع‌دستی یا سوغات')}}';
                pn = '{{__('را دوست دارید بشناسید؟')}}';
                countryIcon = 'souvenirIcon';
                break;
            case 11:
                fpst = '{{__('کدام غذای محلی')}}';
                pn = '{{__('را می‌خواهید تجربه کنید؟')}}';
                countryIcon = 'traditionalFood';
                break;
            case 12:
                fpst = '{{__('کدام بوم گردی')}}';
                pn = '{{__('دوست دارید اقامت کنید؟')}}';
                countryIcon = 'boomIcon';
                break;
        }

        $('#kindPlaceIdForMainSearch').val(_kindPlaceId);
        $('#firstPanSearchText').text(fpst);
        $('#mainSearchInput').attr('placeholder', pn);

        $('#searchPane').removeClass('hidden');
        $('#mainSearchInput').val('');
        $('#mainSearchInput').focus();

        myLocation = '<a href="{{route('myLocation')}}" class="mainSearchResultRow"><div class="icons location spIcons"></div>\n';
        myLocation += "<p class='suggest cursor-pointer' style='margin: 0px'>اطراف من</p></a>";

        if(_kindPlaceId == 0) {
            $('#result').removeClass('hidden');
            $('#mainSearchResult').show();
            $("#mainSearchResult").html(myLocation);
        }
        else{
            newElement = '<a href="{{url('placeList/')}}/' + _kindPlaceId + '/country" class="mainSearchResultRow"><div class="icons ' + countryIcon + ' spIcons"></div>\n';
            newElement += "<p class='suggest cursor-pointer' style='margin: 0px'>همه جای ایران</p></a>";
            // newElement += myLocation;

            $('#result').removeClass('hidden');
            $('#mainSearchResult').show();
            $("#mainSearchResult").html(newElement);
        }


    };

    function redirect() {
        "" != $("#placeId").val() && (document.location.href = $("#placeId").val())
    }

    function searchMain(e, val = '') {
        if (val == '')
            val = $("#mainSearchInput").val();

        var kindPlaceId = $('#kindPlaceIdForMainSearch').val();

        $(".suggest").css("background-color", "transparent").css("padding", "0").css("border-radius", "0");
        if (null == val || "" == val || val.length < 2) {
            $('#result').addClass('hidden');
            $("#mainSearchResult").empty();
        }
        else {
            var scrollVal = $("#searchDivForScroll").scrollTop();

            if (13 == e.keyCode && -1 != currIdx) {
                $("#placeId").val(suggestions[currIdx].url);
                return redirect();
            }

            if (13 == e.keyCode && -1 == currIdx && suggestions.length > 0) {
                $("#placeId").val(suggestions[0].url);
                return redirect();
            }

            if (40 == e.keyCode) {
                if (currIdx + 1 < suggestions.length) {
                    currIdx++;
                    $("#searchDivForScroll").scrollTop(scrollVal + 25);
                }
                else {
                    currIdx = 0;
                    $("#searchDivForScroll").scrollTop(0);
                }

                if (currIdx >= 0 && currIdx < suggestions.length) {
                    $("#suggest_" + currIdx).css("background-color", "#dcdcdc").css("padding", "10px").css("border-radius", "5px");
                }

                return;
            }
            if (38 == e.keyCode) {
                if (currIdx - 1 >= 0) {
                    currIdx--;
                    $("#searchDivForScroll").scrollTop(scrollVal - 25);
                }
                else {
                    currIdx = suggestions.length - 1;
                    $("#searchDivForScroll").scrollTop(25 * suggestions.length);
                }

                if (currIdx >= 0 && currIdx < suggestions.length)
                    $("#suggest_" + currIdx).css("background-color", "#dcdcdc").css("padding", "10px").css("border-radius", "5px");
                return;
            }

            $('#result').removeClass('hidden');
            $('#placeHolderResult').show();
            $('#mainSearchResult').hide();

            if ("ا" == val[0]) {
                for (val2 = "آ", i = 1; i < val.length; i++) val2 += val[i];
                if(mainSearchAjax != null)
                    mainSearchAjax.abort();

                numOfMainSearchResult++;
                mainSearchAjax = $.ajax({
                    type: "post",
                    url: searchDir,
                    data: {
                        kindPlaceId: kindPlaceId,
                        num: numOfMainSearchResult,
                        key: val,
                        key2: val2,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        let check = JSON.parse(response);
                        if(check[2] == numOfMainSearchResult)
                            createSearchResponse(response);
                    }
                })
            }
            else {
                numOfMainSearchResult++;
                if(mainSearchAjax != null)
                    mainSearchAjax.abort();

                mainSearchAjax = $.ajax({
                    type: "post",
                    url: searchDir,
                    data: {
                        kindPlaceId: kindPlaceId,
                        num: numOfMainSearchResult,
                        key: val,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        let check = JSON.parse(response);
                        if(check[2] == numOfMainSearchResult)
                            createSearchResponse(response);
                    }
                });
            }
        }
    }

    function createSearchResponse(response){
        var placeListUrl = '{{url('placeList')}}';
        let newElement = "";
        let searchText = $('#mainSearchInput').val();
        var kindPlaceId = $('#kindPlaceIdForMainSearch').val();

        if(searchText.trim().length < 3){
            $('#result').addClass('hidden');
            $('#placeHolderResult').hide();
            $('#mainSearchResult').hide();
            return;
        }

        if (response.length == 0) {
            $('#placeHolderResult').hide();
            $('#mainSearchResult').hide();
            newElement = "{{__('موردی یافت نشد')}}";
            $("#placeId").val("");
            return;
        }

        currIdx = -1;
        var resutl = JSON.parse(response);
        suggestions = resutl[1];

        response = resutl[1];
        if(lastTimeMainSearch == 0 || lastTimeMainSearch <= resutl[0]) {
            lastTimeMainSearch = resutl[0];

            response.map(item => {
                var url = '';
                var name1 = '';
                var name2 = '';

                if (item.mode == "state") {
                    url = kindPlaceId == 0 ? item.url : placeListUrl + `/${kindPlaceId}/state/${item.targetName}`;
                    name1 = 'استان '+item.targetName;
                }
                else if (item.mode == "city") {
                    url = kindPlaceId == 0 ? item.url : placeListUrl + `/${kindPlaceId}/city/${item.targetName}`;
                    name1 = 'شهر '+item.targetName;
                    name2 = item.stateName;
                }
                else {
                    url = item.url;
                    name1 = item.targetName;
                    name2 = item.cityName+' در '+item.stateName;
                }

                newElement += `<a href="${url}" class="mainSearchResultRow">
                                        <div class="icons ${window.mainIconsPlaces[item.mode].icon  } spIcons"></div>
                                        <p class='suggest cursor-pointer' style='margin: 0px'>${name1}</p>
                                        <p class='suggest cursor-pointer stateName'>${name2}</p>
                                    </a>`;
            });

            response.length != 0 ? $('#result').removeClass('hidden') : $('#result').addClass('hidden');

            $("#mainSearchResult").empty().append(newElement);
            $('#placeHolderResult').hide();
            $('#mainSearchResult').show();
        }
    }

    if (typeof(Storage) !== "undefined") {
        var lastPages;

        lastPages = localStorage.getItem('lastPages');
        lastPages = JSON.parse(lastPages);

        if(localStorageData != 0){
            if(lastPages != null) {
                for(i = 0; i < lastPages.length; i++){
                    if(lastPages[i]['redirect'] == localStorageData['redirect']){
                        lastPages.splice(i, 1);
                    }
                }
                lastPages.unshift(localStorageData);
                if (lastPages.length == 9)
                    lastPages.pop();
            }
            else {
                lastPages = [];
                lastPages.unshift(localStorageData);
            }

            localStorage.setItem('lastPages', JSON.stringify(lastPages));
        }
    } else
        console.log('your browser not support localStorage');


</script>
