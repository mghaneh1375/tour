<style>
    .placeBookMarkProfile{
        display: flex;
        justify-content: space-evenly;
        flex-wrap: wrap;
    }
    .placeBookMarkProfile > div{
        margin: 15px 0px;
        width: 300px;
    }
    @media (max-width: 767px) {
        .notPadding .pd-rt-0, .notPadding .pd-lt-0{
            padding: 0px;
        }
    }
</style>
<div class="userActivitiesQuestions">
    <div class="userProfilePostsFiltrationContainer">
        <div class="userProfilePostsFiltration questionSecTab">
            <span class="active" onclick="changeBookMarkShowKindInProfile('place', this)">اماکن</span>
            <span onclick="changeBookMarkShowKindInProfile('safarnameh', this)">سفرنامه</span>
            <span onclick="changeBookMarkShowKindInProfile('review', this)">پست</span>
        </div>
    </div>

    <div id="profileBMSection" class="userProfileQAndA">
        <div class="col-xs-12 notData hidden">
            <div class="pic">
                <img src="{{URL::asset('images/mainPics/noData.png')}}" style="width: 100%">
            </div>
            <div class="info">
                @if($myPage)
                    <div class="firstLine">
                        اینجا خالی است.هنوز نشان کرده ندارید...
                    </div>
                    <div class="sai">
                        جایی رو که دوست داری رو پیدا کن و
                        <button class="butt" onclick="openMainSearch(0) // in mainSearch.blade.php">نشانه گذاری کن</button>
                    </div>
                @endif
            </div>
        </div>

        <div class="row" style="width: 100%; margin: 0px;">
            <div id="profileBookMarkBody" class="col-md-12"></div>
        </div>
    </div>

</div>

<script>

    let bookMarkProfileKind = 'place';
    function getProfileBookMarks(){

        let pll = '';
        if(bookMarkProfileKind == 'place'){
            pll = getSuggestionPackPlaceHolder(); // in component.suggestionPack.blade.php
            pll = '<div id="placeBookMarkProfile" class="placeBookMarkProfile">' + pll + ' ' + pll + '</div>';
        }
        else if(bookMarkProfileKind == 'review'){
            pll = getReviewPlaceHolder(); // component.smallShowReview.blade.php
            text = '<div class="row">';
            text += '<div class="col-md-6 pd-rt-0">';
            text += pll;
            text += '</div>';
            text += '<div class="col-md-6 pd-lt-0">';
            text += pll;
            text += '</div>';
            text += '</div>';

            pll = text;
        }
        else if(bookMarkProfileKind == 'safarnameh'){
            pll = getSafaranmehPlaceHolderRow(); // component.safarnamehRow.blade.php
            pll += pll;
        }
        $('#profileBookMarkBody').html(pll);
        $('#profileBMSection').find('.notData').addClass('hidden');

        getMyBookMarkPromiseFunc().then(response => createBookMarkRow(response));
    }

    function createBookMarkRow(_result){
        let text = '';
        if(_result.length > 0){
            var bookMarkToShow = [];
            _result.map(item => {
                if(item.kind == bookMarkProfileKind)
                    bookMarkToShow.push(item);
            });
            if(bookMarkProfileKind == 'place') {
                $('#profileBookMarkBody').html('<div id="placeBookMarkProfile" class="placeBookMarkProfile"></div>');
                createSuggestionPack('placeBookMarkProfile', bookMarkToShow); //suggestionPack.blade.php
            }
            else if(bookMarkProfileKind == 'review'){
                var sec = ['', ''];
                bookMarkToShow.map((item, index) => sec[index % 2] += createSmallReviewHtml(item)/**in component.smallShowReview.blade.php**/);

                text = '<div class="row notPadding">';
                text += '<div class="col-md-6 pd-rt-0">';
                text += sec[0];
                text += '</div>';
                text += '<div class="col-md-6 pd-lt-0">';
                text += sec[1];
                text += '</div>';
                text += '</div>';
                $('#profileBookMarkBody').html(text);
            }
            else if(bookMarkProfileKind == 'safarnameh'){
                bookMarkToShow.map(item => {
                    item.editAble = false;
                    text += getSafarnamehRow(item); // in component.safarnamehRow.blade.php
                });
                $('#profileBookMarkBody').html(text);
            }
        }
        else{
            text = '';
            $('#profileBookMarkBody').html('');
            $('#profileBMSection').find('.notData').removeClass('hidden');
        }
    }

    function changeBookMarkShowKindInProfile(_kind, _elem){
        $(_elem).parent().find('.active').removeClass('active');
        $(_elem).addClass('active');
        bookMarkProfileKind = _kind;
        getProfileBookMarks();
    }
</script>