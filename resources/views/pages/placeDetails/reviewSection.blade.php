<div class="col-md-7 col-xs-12 pd-0 float-right postsMainDivInRegularMode">

    <div id="showReviewsMain"></div>

    <div id="reviewsPagination" class="col-xs-12 postsMainDivFooter position-relative" style="margin-top: 10px;">
        <div class="col-xs-4 font-size-13 line-height-2 text-align-right" style="display: flex; direction: rtl; margin-left: auto">
            صفحه
            <div id="reviewPagination" style="margin-right: 10px;"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteReviewsModal" role="dialog" style="direction: rtl">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{__('پاک کردن نقد')}}</h4>
            </div>
            <div class="modal-body">
                <p>آیا از حذف نقد خود اطمینان دارید؟ در صورت حذف عکس ها و فیلم ها افزوده شده پاک می شوند و قابل بازیابی نمی باشد.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('لغو')}}</button>
                <button type="button" class="btn btn-danger" onclick="doDeleteReviewByUser()">{{__('بله، حذف شود')}}</button>
            </div>
        </div>
    </div>
</div>

<script>
    var reviewPage = 1;
    var reviewPerPageIndex = 2;
    var loadShowReview = false;
    var firstTimeFilterShow = 1;
    var reviewPerPageNum = [3, 5, 10];

    function loadReviews(){
        $('#showReviewsMain').html(getReviewPlaceHolder()); //in smallShowReview.blade.php
        $.ajax({
            type: 'post',
            url: '{{route('getReviews')}}',
            data:{
                'placeId' : placeId,
                'kindPlaceId' : kindPlaceId,
                'count' : reviewPerPageNum[reviewPerPageIndex],
                'num' : reviewPage,
                'filters' : reviewFilters
            },
            success: function(response){
                document.getElementById('showReviewsMain').innerHTML = '';
                if(response == 'nok1') {
                    if(firstTimeFilterShow == 1){
                        document.getElementById('postFilters').style.display = 'none';
                        document.getElementById('reviewsPagination').style.display = 'none';
                        document.getElementById('advertiseDiv').style.display = 'none';
                    }

                    $('#pcPostButton').attr('href', '#editReviewPictures');
                    $('#pcPostButton').attr('onclick', 'newPostModal()');
                    $('#openPostPhone').attr('onclick', 'newPostModal()');
                }
                else{
                    response = JSON.parse(response);
                    allReviews = response[0];
                    reviewsCount = response[1];

                    if(reviewsCount < reviewPerPageNum[0] && firstTimeFilterShow == 1) {
                        document.getElementById('postFilters').style.display = 'none';
                        // document.getElementById('phoneReviewFilterHeader').style.display = 'none';
                    }
                    else
                        document.getElementById('postFilters').style.display = 'block';

                    firstTimeFilterShow = 0;

                    createReviewPagination(reviewsCount);
                    showReviews(allReviews);
                }
            }
        })
    }
    loadReviews();

    function showReviews(reviews){
        for(let i = 0; i < reviews.length; i++)
            showFullReviews({
                review: reviews[i],
                kind: 'append',
                sectionId : 'showReviewsMain'
            });
    }

    function changePerPage(_count){

        document.getElementById('reviewPerView' + reviewPerPageIndex).classList.remove('color-blue');
        document.getElementById('reviewPerView' + _count).classList.add('color-blue');
        reviewPerPageIndex = _count;
        reviewPage = 1;

        loadReviews();
    }

    function changeReviewPage(_page){
        $('html, body').animate({
            scrollTop: $("#showReviewsMain").offset().top
        }, 2000);
        reviewPage = _page;
        loadReviews();
    }

    function createReviewPagination(reviewsCount){
        var text = '';
        var page = Math.round(reviewsCount/reviewPerPageNum[reviewPerPageIndex]);

        createReviewPerPage();

        if(page >= 5){
            if(reviewPage == 1){
                text += '<span class="cursor-pointer color-blue mg-lt-5" onclick="changeReviewPage(1)" style="float: right">1</span>';
                text += '<span class="cursor-pointer mg-lt-5" onclick="changeReviewPage(2)" style="float: right">2</span>';
                text += '<span class="cursor-pointer mg-lt-5" onclick="changeReviewPage(3)" style="float: right">3</span>';
                text += '<span style="float: right"> >>> </span>';
                text += '<span class="cursor-pointer mg-lt-5" onclick="changeReviewPage(' + page + ')" style="float: right">' + page + '</span>';
            }
            else if(reviewPage == 2){
                text += '<span class="cursor-pointer mg-lt-5" onclick="changeReviewPage(1)" style="float: right">1</span>';
                text += '<span class="cursor-pointer color-blue mg-lt-5" onclick="changeReviewPage(2)" style="float: right">2</span>';
                text += '<span class="cursor-pointer mg-lt-5" onclick="changeReviewPage(3)" style="float: right">3</span>';
                text += '<span style="float: right"> >>> </span>';
                text += '<span class="cursor-pointer mg-lt-5" onclick="changeReviewPage(' + page + ')" style="float: right">' + page + '</span>';
            }
            else if(reviewPage == 3){
                text += '<span class="cursor-pointer mg-lt-5" onclick="changeReviewPage(1)" style="float: right">1</span>';
                text += '<span class="cursor-pointer mg-lt-5" onclick="changeReviewPage(2)" style="float: right">2</span>';
                text += '<span class="cursor-pointer color-blue mg-lt-5" onclick="changeReviewPage(3)" style="float: right">3</span>';
                text += '<span class="cursor-pointer mg-lt-5" onclick="changeReviewPage(4)" style="float: right">4</span>';
                if(page == 5)
                    text += '<span class="cursor-pointer mg-lt-5" onclick="changeReviewPage(5)" style="float: right">5</span>';
                else {
                    text += '<span style="float: right"> >>> </span>';
                    text += '<span class="cursor-pointer mg-lt-5" onclick="changeReviewPage(' + page + ')" style="float: right">' + page + '</span>';
                }
            }
            else{
                text += '<span class="cursor-pointer mg-lt-5" onclick="changeReviewPage(1)" style="float: right">1</span>';
                text += '<span style="float: right"> <<< </span>';

                if(reviewPage == page){
                    text += '<span class="cursor-pointer mg-lt-5" onclick="changeReviewPage(' + (reviewPage-2) + ')" style="float: right">' + (reviewPage-2) + '</span>';
                    text += '<span class="cursor-pointer mg-lt-5" onclick="changeReviewPage(' + (reviewPage-1) + ')" style="float: right">' + (reviewPage-1) + '</span>';
                    text += '<span class="cursor-pointer color-blue mg-lt-5" onclick="changeReviewPage(' + (reviewPage) + ')" style="float: right">' + (reviewPage) + '</span>';
                }
                else{
                    text += '<span class="cursor-pointer mg-lt-5" onclick="changeReviewPage(' + (reviewPage-1) + ')" style="float: right">' + (reviewPage-1) + '</span>';
                    text += '<span class="cursor-pointer color-blue mg-lt-5" onclick="changeReviewPage(' + (reviewPage) + ')" style="float: right">' + (reviewPage) + '</span>';
                    text += '<span class="cursor-pointer mg-lt-5" onclick="changeReviewPage(' + (reviewPage+1) + ')" style="float: right">' + (reviewPage+1) + '</span>';
                    if((page - reviewPage) == 2)
                        text += '<span class="cursor-pointer mg-lt-5" onclick="changeReviewPage(' + (reviewPage+2) + ')" style="float: right">' + (reviewPage+2) + '</span>';
                }

                if((page - reviewPage) >= 3){
                    text += '<span style="float: right"> >>> </span>';
                    text += '<span class="cursor-pointer mg-lt-5" onclick="changeReviewPage(' + page + ')" style="float: right">' + page + '</span>';
                }


            }
        }
        else{
            for (var i = 1; i <= page; i++){
                if(i == reviewPage)
                    text += '<span class="cursor-pointer color-blue mg-lt-5" onclick="changeReviewPage(' + i + ')" style="float: right">' + i + '</span>';
                else
                    text += '<span class="cursor-pointer mg-lt-5" onclick="changeReviewPage(' + i + ')" style="float: right">' + i + '</span>';
            }
        }

        document.getElementById('reviewPagination').innerHTML = text;
    }

    function createReviewPerPage(){

        var text = '';

        for(var i = 0; i < reviewPerPageNum.length; i++){
            if(i == reviewPerPageIndex)
                text += '<span id="reviewPerView' + i + '" class="mg-lt-5 cursor-pointer color-blue" onclick="changePerPage(' + i + ')">' + reviewPerPageNum[i] + '</span>';
            else
                text += '<span id="reviewPerView' + i + '" class="mg-lt-5 cursor-pointer" onclick="changePerPage(' + i + ')">' + reviewPerPageNum[i] + '</span>';

            if(i != (reviewPerPageNum.length - 1))
                text += '-';
        }

        // document.getElementById('showReviewPerPage').innerHTML = text;
    }

</script>
