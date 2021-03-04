<div class="rating">
    <div class="block_header">
        <div class="titlesPlaceDetail">
            <h3 class="block_title">{{__('امتیاز کاربران')}} </h3>
        </div>
    </div>
</div>
<div class="ratingBoxDetails" style="margin-top: 15px;">
    <a class="seeAllReviews autoResize" href="#REVIEWS"></a>
    <div class="prw_rup prw_common_bubble_rating overallBubbleRating" onclick="openRateBoxForPlace()" style="cursor: pointer; text-align: center">
        <span class="ui_bubble_rating bubble_{{$avgRate}}0 font-size-28 placeRateStars" property="ratingValue" content="{{$avgRate}}"></span>
    </div>
    <div class="prw_rup prw_common_ratings_histogram_overview overviewHistogram" style="width: 80%; direction: rtl; margin-top: 15px;">
        <ul class="ratings_chart">
            <li class="chart_row highlighted ">
                <span class="row_label row_cell">عالی</span>
                <span class="row_bar row_cell">
                    <span class="bar">
                        <span class="fill rateLine5" style="width: {{ceil($rates['5'] * 100 / $total)}}%;"></span>
                    </span>
                </span>
                <span class="row_count row_cell ratePercent5">{{ceil($rates['5'] * 100 / $total)}}%</span>
            </li>
            <li class="chart_row ">
                <span class="row_label row_cell">خوب</span>
                <span class="row_bar row_cell">
                    <span class="bar">
                        <span class="fill rateLine4" style="width:{{ceil($rates['4'] * 100 / $total)}}%;"></span>
                    </span>
                </span>
                <span class="row_count row_cell ratePercent4">{{ceil($rates['4'] * 100 / $total)}}%</span>
            </li>
            <li class="chart_row ">
                <span class="row_label row_cell">معمولی</span>
                <span class="row_bar row_cell">
                    <span class="bar">
                        <span class="fill rateLine3" style="width:{{ceil($rates['3'] * 100 / $total)}}%;"></span>
                    </span>
                </span>
                <span class="row_count row_cell ratePercent3">{{ceil($rates['3'] * 100 / $total)}}%</span>
            </li>
            <li class="chart_row ">
                <span class="row_label row_cell">ضعیف</span>
                <span class="row_bar row_cell">
                    <span class="bar">
                        <span class="fill rateLine2" style="width:{{ceil($rates['2'] * 100 / $total)}}%;"></span>
                    </span>
                </span>
                <span class="row_count row_cell ratePercent2">{{ceil($rates['2'] * 100 / $total)}}%</span>
            </li>
            <li class="chart_row">
                <span class="row_label row_cell">خیلی بد</span>
                <span class="row_bar row_cell">
                    <span class="bar">
                        <span class="fill rateLine1" style="width:{{ceil($rates['1'] * 100 / $total)}}%;"></span>
                    </span>
                </span>
                <span class="row_count row_cell ratePercent1">{{ceil($rates['1'] * 100 / $total)}}%</span>
            </li>
        </ul>
    </div>
</div>
