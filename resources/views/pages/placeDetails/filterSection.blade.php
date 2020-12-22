<style>

</style>

<div id="postFilters" class="col-xs-12 postsFiltersMainDiv" style="display: none">
    <div class="block_header">
        <h3 class="block_title">پست‌ها را دقیق‌تر ببینید </h3>
    </div>
    <div class="display-inline-block full-width font-size-15">
        تعداد
        <span id="reviewCountSearch">{{$reviewCount}}</span>
        پست،
        <span id="reviewCommentCount">{{$ansReviewCount}}</span>
        نظر و
        <span id="reviewUserCount">{{$userReviewCount}}</span>
        کاربر مختلف
    </div>
    <div class="filterHelpText">
        با استفاده از گزینه‌های زیر نتایج را محدودتر کرده و راحت‌تر مطلب مورد نظر خود را پیدا کنید
        <div class="showFiltersMenus display-none" onclick="showPostsFilterBar(this)">
            <span class="buttonName float-right">نمایش فیلترها</span>
            <span class="float-left position-relative width-50"></span>
        </div>
    </div>
    <div class="filterBarDivs">

        @foreach($multiQuestion as $key => $item)
            <div class="visitKindTypeFilter filterTypeDiv">
                <span class="float-right line-height-2">
                    {{$item->description}}
                </span>
                <span class="dark-blue font-weight-500 float-right line-height-2 mg-rt-5"
                      onclick="removeReviewFilter({{$item->id}}, 'multi')"
                      style="cursor: pointer">حذف فیلتر</span>
                <div class="clear-both"></div>
                <center>
                    @foreach($item->ans as $item2 )
                        <b id="ansMultiFilter_{{$item2->id}}" class="filterChoices" onclick="chooseMutliFilter({{$item->id}}, {{$item2->id}})">{{$item2->ans}}</b>
                    @endforeach
                </center>
            </div>
        @endforeach

        <div class="photoTypePostsFilter filterTypeDiv">
                                        <span class="float-right line-height-2">
                                            نمایش پست‌های دارای عکس
                                        </span>
            <span class="dark-blue font-weight-500 float-right line-height-2" onclick="removeReviewFilter(0, 'onlyPic')" style="cursor: pointer">حذف فیلتر</span>
            <div class="clear-both"></div>

            <center>
                <b id="onlyPic1" class="filterChoices" onclick="onlyPicVideo(1)">تنها دارای عکس</b>
                <b id="onlyPic2" class="filterChoices" onclick="onlyPicVideo(2)">تنها دارای فیلم</b>
                <b id="onlyPic3" class="filterChoices" onclick="onlyPicVideo(3)">تنها دارای متن بلند</b>
                <b id="onlyPic4" class="filterChoices" onclick="onlyPicVideo(4)">تنها دارای فیلم یا عکس</b>
            </center>
        </div>

        @foreach($rateQuestion as $index => $item)
            <div class="commentsRatesFilter filterTypeDiv">
                <span class="float-right line-height-2">
                    {{$item->description}}
                </span>
                <span class="dark-blue font-weight-500 float-right line-height-2 mg-rt-5" onclick="removeReviewFilter({{$item->id}}, 'rate')" style="cursor: pointer">حذف فیلتر</span>
                <div class="clear-both"></div>
                <center>
                    <div class="commentRatingsFiltersChoices">
                        <div class="display-inline-block full-width text-align-right mg-tp-10">
                            <div class="prw_rup prw_common_bubble_rating overallBubbleRating overallBubbleRatingGold full-width float-right">
                                {{--                                        <span class="ui_bubble_rating bubble_10 font-size-30 color-yellow"--}}
                                {{--                                              property="ratingValue" content="1" alt='1 of 5 bubbles'></span>--}}
                                <div class="ui_star_rating stars_10 font-size-25">
                                    <span id="filterStar_1_{{$item->id}}" class="starRatingGold" onmouseenter="showStar(1, {{$item->id}})" onmouseleave="removeStar({{$item->id}}, {{$index}})" onclick="selectFilterStar(1, {{$item->id}}, {{$index}})"></span>
                                    <span id="filterStar_2_{{$item->id}}" class="starRatingGrey" onmouseenter="showStar(2, {{$item->id}})" onmouseleave="removeStar({{$item->id}}, {{$index}})" onclick="selectFilterStar(2, {{$item->id}}, {{$index}})"></span>
                                    <span id="filterStar_3_{{$item->id}}" class="starRatingGrey" onmouseenter="showStar(3, {{$item->id}})" onmouseleave="removeStar({{$item->id}}, {{$index}})" onclick="selectFilterStar(3, {{$item->id}}, {{$index}})"></span>
                                    <span id="filterStar_4_{{$item->id}}" class="starRatingGrey" onmouseenter="showStar(4, {{$item->id}})" onmouseleave="removeStar({{$item->id}}, {{$index}})" onclick="selectFilterStar(4, {{$item->id}}, {{$index}})"></span>
                                    <span id="filterStar_5_{{$item->id}}" class="starRatingGrey" onmouseenter="showStar(5, {{$item->id}})" onmouseleave="removeStar({{$item->id}}, {{$index}})" onclick="selectFilterStar(5, {{$item->id}}, {{$index}})"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="filterStarText_{{$item->id}}" class="ratingTranslationDiv">اصلاً راضی نبودم</div>
                </center>
            </div>
        @endforeach

        <div class="searchFilter filterTypeDiv" style="display: flex; flex-direction: column;">
            <span class="float-right line-height-205" style="display: flex; align-items: center;">
                جست و جو کنید
                <span id="removeTextReviewSearch" class="dark-blue font-weight-500 float-right line-height-2 mg-rt-5" onclick="$('#reviewSearchInput').val(''); textSearch(); " style="cursor: pointer; display: none;">حذف فیلتر</span>
            </span>

            <div class="inputBoxSearchFilter inputBox">
                <input id="reviewSearchInput" class="inputBoxInput" type="text" placeholder="عبارت مورد نظر خود را جست و جو کنید" onchange="textSearch()">
                <button class="searchIcon" onclick="textSearch()"></button>
            </div>
        </div>

    </div>
</div>

<script>
    var filterRateAns = [];
    var filterMultiAns = [];
    var reviewFilters = [];

    function showStar(_star, _id){
        for(i = 1; i < 6; i++){
            if(i <= _star) {
                document.getElementById('filterStar_' + i + '_' + _id).classList.remove('starRatingGrey');
                document.getElementById('filterStar_' + i + '_' + _id).classList.add('starRatingGold');
            }
            else{
                document.getElementById('filterStar_' + i + '_' + _id).classList.remove('starRatingGold');
                document.getElementById('filterStar_' + i + '_' + _id).classList.add('starRatingGrey');
            }
        }

        var starText = document.getElementById('filterStarText_' + _id);
        switch (_star){
            case 1:
                starText.innerText = 'اصلا راضی نبودم';
                break;
            case 2:
                starText.innerText = 'بد نبود';
                break;
            case 3:
                starText.innerText = 'معمولی بود';
                break;
            case 4:
                starText.innerText = 'خوب بود';
                break;
            case 5:
                starText.innerText = 'عالی بود';
                break;

        }
    }

    function removeStar( _id){
        var star = 1;
        if(filterRateAns[_id] != null)
            star = filterRateAns[_id];

        for(i = 1; i < 6; i++){
            if(i <= star) {
                document.getElementById('filterStar_' + i + '_' + _id).classList.remove('starRatingGrey');
                document.getElementById('filterStar_' + i + '_' + _id).classList.add('starRatingGold');
            }
            else{
                document.getElementById('filterStar_' + i + '_' + _id).classList.remove('starRatingGold');
                document.getElementById('filterStar_' + i + '_' + _id).classList.add('starRatingGrey');
            }
        }

        var starText = document.getElementById('filterStarText_' + _id);
        switch (star){
            case 1:
                starText.innerText = 'اصلا راضی نبودم';
                break;
            case 2:
                starText.innerText = 'بد نبود';
                break;
            case 3:
                starText.innerText = 'معمولی بود';
                break;
            case 4:
                starText.innerText = 'خوب بود';
                break;
            case 5:
                starText.innerText = 'عالی بود';
                break;
        }
    }

    function selectFilterStar(_star, _id){
        filterRateAns[_id] = _star;

        var is = true;
        for(i = 0; i < reviewFilters.length; i++){
            if(reviewFilters[i] != null && reviewFilters[i]['kind'] == 'rate' && reviewFilters[i]['id'] == _id){
                is = false;
                reviewFilters[i]['value'] = _star;
                break;
            }
        }
        if(is) {
            reviewFilters[reviewFilters.length] = {
                'kind': 'rate',
                'id': _id,
                'value': _star
            };
        }

        doReviewFilter();
    }

    function chooseMutliFilter(_qId, _aId){

        if(filterMultiAns[_qId] != null)
            document.getElementById('ansMultiFilter_' + filterMultiAns[_qId]).classList.remove('filterChoosed');

        filterMultiAns[_qId] = _aId;
        document.getElementById('ansMultiFilter_' + _aId).classList.add('filterChoosed');

        var is = true;
        for(i = 0; i < reviewFilters.length; i++){
            if(reviewFilters[i] != null && reviewFilters[i]['kind'] == 'multi' && reviewFilters[i]['id'] == _qId){
                is = false;
                reviewFilters[i]['value'] = _aId;
                break;
            }
        }
        if(is){
            reviewFilters[reviewFilters.length] = {
                'kind' : 'multi',
                'id' : _qId,
                'value' : _aId
            }
        }

        doReviewFilter();
    }

    function removeReviewFilter(_id, _kind){
        if(_kind == 'rate'){
            filterRateAns[_id] = null;
        }
        else if(_kind == 'multi'){
            if(filterMultiAns[_id] != null)
                document.getElementById('ansMultiFilter_' + filterMultiAns[_id]).classList.remove('filterChoosed');

            filterMultiAns[_id] = null;
        }
        else if(_kind == 'onlyPic'){
            for(i = 1; i < 5; i++)
                document.getElementById('onlyPic' + i).classList.remove('filterChoosed')
        }


        for(i = 0; i < reviewFilters.length; i++){
            if(reviewFilters[i] != null && reviewFilters[i]['kind'] == _kind && reviewFilters[i]['id'] == _id){
                reviewFilters[i] = null;
                break;
            }
        }

        doReviewFilter();
    }

    function doReviewFilter(){
        reviewPage = 1;
        loadReviews();
    }

    function onlyPicVideo(_ans){
        for(i = 1; i < 5; i++)
            document.getElementById('onlyPic' + i).classList.remove('filterChoosed')

        document.getElementById('onlyPic' + _ans).classList.add('filterChoosed');
        var is = false;
        for(i = 0; i < reviewFilters.length; i++){
            if(reviewFilters[i] != null && reviewFilters[i]['kind'] == 'onlyPic' && reviewFilters[i]['id'] == 0){
                is = true;
                reviewFilters[i]['value'] = _ans;
                break;
            }
        }
        if(!is){
            reviewFilters[reviewFilters.length] = {
                'kind' : 'onlyPic',
                'id' : 0,
                'value' : _ans
            }
        }
        doReviewFilter();
    }

    function textSearch(){
        let textSearch = $('#reviewSearchInput').val();

        if(textSearch.trim().length == 0)
            $('#removeTextReviewSearch').hide();
        else
            $('#removeTextReviewSearch').show();

        var is = false;
        for(i = 0; i < reviewFilters.length; i++){
            if(reviewFilters[i] != null && reviewFilters[i]['kind'] == 'textSearch' && reviewFilters[i]['id'] == 0){
                is = true;
                reviewFilters[i]['value'] = textSearch;
                break;
            }
        }
        if(!is){
            reviewFilters[reviewFilters.length] = {
                'kind' : 'textSearch',
                'id' : 0,
                'value' : textSearch
            }
        }
        doReviewFilter();
    }

    function showPostsFilterBar(_element) {
        $('.filterBarDivs').toggle();
        $('.visitKindTypeFilter').toggleClass('border-none');

        if($(_element).find('.buttonName').text() == 'بستن منو'){
            $(_element).find('.buttonName').text('نمایش فیلترها');
        }
        else{
            $(_element).find('.buttonName').text('بستن منو');
        }
    }
</script>
