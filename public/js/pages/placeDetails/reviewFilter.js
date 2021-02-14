var filterRateAns = [];
var filterMultiAns = [];
var reviewFilters = [];

function showStar(_star, _id){
    for(i = 1; i < 6; i++){
        if(i <= _star)
            $(`#filterStar_${i}_${_id}`).removeClass('starRatingGrey').addClass('starRatingGold');
        else
            $(`#filterStar_${i}_${_id}`).removeClass('starRatingGold').addClass('starRatingGrey');
    }

    var starText = $('#filterStarText_'+_id);

    if(_star == 1) starText.text('اصلا راضی نبودم');
    else if(_star == 2) starText.text('بد نبود');
    else if(_star == 3) starText.text('معمولی بود');
    else if(_star == 4) starText.text('خوب بود');
    else if(_star == 5) starText.text('عالی بود');
}

function removeStar( _id){
    var star = 1;
    if(filterRateAns[_id] != null)
        star = filterRateAns[_id];

    for(i = 1; i < 6; i++){
        if(i <= star)
            $(`#filterStar_${i}_${_id}`).removeClass('starRatingGrey').addClass('starRatingGold');
        else
            $(`#filterStar_${i}_${_id}`).removeClass('starRatingGold').addClass('starRatingGrey');
    }

    var starText = $('#filterStarText_'+_id);

    if(star == 1) starText.text('اصلا راضی نبودم');
    else if(star == 2) starText.text('بد نبود');
    else if(star == 3) starText.text('معمولی بود');
    else if(star == 4) starText.text('خوب بود');
    else if(star == 5) starText.text('عالی بود');
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
            kind: 'rate',
            id: _id,
            value: _star
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
