{{--<div class="userProfilePostsFiltrationContainer">--}}
{{--    <div class="userProfilePostsFiltration">--}}
{{--        <span class="active" onclick="changeSortPost('new', this)">جدیدترین‌ها</span>--}}
{{--        <span onclick="changeSortPost('top', this)">بهترین‌ها</span>--}}
{{--        <span onclick="changeSortPost('hot', this)">داغ‌ترین‌ها</span>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="postsMainDivInSpecificMode col-xs-12">

    <div id="notData" class="col-xs-12 notData hidden">
        <div class="pic">
            <img src="{{URL::asset('images/mainPics/noData.png')}}" style="width: 100%">
        </div>
        <div class="info">
            @if($myPage)
                <div class="firstLine">
                    اینجا خالی است.هنوز پستی نگذاشتید...
                </div>
                <div class="sai">
                    جایی رو که دوست داری رو پیدا کن و
                    <button class="butt" onclick="openMainSearch(0) // in mainSearch.blade.php">نظرتو بگو</button>
                </div>
            @else
                <div class="firstLine">
                    اینجا خالی است. {{$user->username}} هنوز پستی نگذاشته...
                </div>
            @endif
        </div>
    </div>

    <div id="leftPostSection" class="postsLeftDivInSpecificMode col-xs-6"></div>
    <div id="rightPostSection" class="postsRightDivInSpecificMode col-xs-6"></div>
</div>

<script>
    let reviewSort = 'new';
    let allReviews = [];

    function getReviewsUserReview(){
        $('#leftPostSection').html('');
        $('#rightPostSection').html('');

        setSmallReviewPlaceHolder('leftPostSection'); // in component.smallShowReview.blade.php
        setSmallReviewPlaceHolder('rightPostSection'); // in component.smallShowReview.blade.php

        let data;
        if(userPageId == 0)
            data = {
                _token: '{{csrf_token()}}',
                sort: reviewSort
            };
        else
            data = {
                _token: '{{csrf_token()}}',
                userId: userPageId, // in mainProfile.blade.php
                sort: reviewSort
            };

        $('#notData').addClass('hidden');
        $.ajax({
            type: 'post',
            url: '{{route("profile.getUserReviews")}}',
            data: data,
            success: function(response){
                response = JSON.parse(response);
                if(response.status == 'ok'){
                    allReviews = response.result;

                    $('#leftPostSection').html('');
                    $('#rightPostSection').html('');
                    createReviews();
                }
            },
            error: function(err){
                console.log(err);
            }
        })
    }

    function createReviews(){
        let odd = true;

        if(allReviews.length == 0){
            $('#notData').removeClass('hidden');
            return;
        }
        allReviews.forEach(item => {
            text = createSmallReviewHtml(item); // in component.smallShowReview.blade.php;

            if(odd)
                $('#leftPostSection').append(text);
            else
                $('#rightPostSection').append(text);

            odd = !odd;
        });
    }

    function changeSortPost(_kind, _element){
        $(_element).parent().find('.active').removeClass('active');
        $(_element).addClass('active');
        reviewSort = _kind;
        getReviewsUserReview()
    }

</script>
