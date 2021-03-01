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
    var searchDir = '{{route('totalSearch')}}';
    var myLocationUrlMainSearch = "{{route('myLocation')}}";
    var placeListUrlMainSearch = "{{url('placeList')}}";
    @if(isset($localStorageData))
        localStorageData = {!! json_encode($localStorageData) !!}
    @endif

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
    }
    else
        console.log('your browser not support localStorage');
</script>

<script src="{{URL::asset('js/component/mainSearch.js?v='.$fileVersions)}}"></script>
