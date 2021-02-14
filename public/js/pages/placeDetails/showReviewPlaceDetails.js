var reviewPage = 1;
var reviewPerPageIndex = 2;
var loadShowReview = false;
var firstTimeFilterShow = 1;
var reviewPerPageNum = [3, 5, 10];

function loadReviews(){
    $('#showReviewsMain').html(getReviewPlaceHolder()); //in smallShowReview.blade.php
    $.ajax({
        type: 'POST',
        url: getReviewForPlaceDetailsUrl,
        data:{
            _token: csrfTokenGlobal,
            placeId : placeId,
            kindPlaceId : kindPlaceId,
            count : reviewPerPageNum[reviewPerPageIndex],
            num : reviewPage,
            filters : reviewFilters
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
}

$(window).ready(() => {
    loadReviews();
});
