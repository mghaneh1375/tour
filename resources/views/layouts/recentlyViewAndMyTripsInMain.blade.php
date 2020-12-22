
<script>
    var getRecentlyPath = '{{route('recentlyViewed')}}';

    function recentlyViews(uId, containerId) {

        $("#" + containerId).empty();

        $.ajax({
            type: 'post',
            url: getRecentlyPath,
            data: {
                uId: uId
            },
            success: function (response) {

                response = JSON.parse(response);

                for(i = 0; i < response.length; i++) {
                    element = "<div>";
                    element += "<a class='masthead-recent-card' id='masthead-recent-card-recent-view' target='_self' href='" + response[i].placeRedirect + "'>";
                    element += "<div class='media-left' id='media-left-recent-view'>";
                    element += "<div class='thumbnail' style='background-image: url(" + response[i].placePic + ");'></div>";
                    element += "</div>";
                    element += "<div class='content-right' style='text-align: right'>";
                    element += "<div class='poi-title'>" + response[i].placeName + "</div>";
                    element += "<div class='rating'>";

                    element += "<div class='ui_bubble_rating bubble_" + response[i].placeRate + "0'></div>";

                    element += "<br/>" + response[i].placeReviews + " نقد ";
                    element += "</div>";
                    element += "<div class='geo'>" + response[i].placeCity + "/ " + response[i].placeState + "</div>";
                    element += "</div>";
                    element += "</a></div>";

                    $("#" + containerId).append(element);
                }

            }
        });
    }
</script>


<link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/recentlyViewAndMyTripsInMain.css?v=1')}}' />

<script>
    function getRecentlyViews(containerId) {
        $("#" + containerId).empty();

        $.ajax({
            type: 'post',
            url: getRecentlyPath,
            success: function (response) {

                response = JSON.parse(response);

                for(i = 0; i < response.length; i++) {
                    element = "<div>";
                    element += "<a class='masthead-recent-card' style='text-align: right !important;' target='_self' href='" + response[i].placeRedirect + "'>";
                    element += "<div class='media-left' style='padding: 0 12px !important; margin: 0 !important;'>";
                    element += "<div class='thumbnail' style='background-image: url(" + response[i].placePic + ");'></div>";
                    element += "</div>";
                    element += "<div class='content-right'>";
                    element += "<div class='poi-title'>" + response[i].placeName + "</div>";
                    element += "<div class='rating'>";

                    if (response[i].placeRate == 5)
                        element += "<div class='ui_bubble_rating bubble_50'></div>";
                    else if (response[i].placeRate == 4)
                        element += "<div class='ui_bubble_rating bubble_40'></div>";
                    else if (response[i].placeRate == 3)
                        element += "<div class='ui_bubble_rating bubble_30'></div>";
                    else if (response[i].placeRate == 2)
                        element += "<div class='ui_bubble_rating bubble_20'></div>";
                    else
                        element += "<div class='ui_bubble_rating bubble_10'></div>";

                    element += "<br/>" + response[i].placeReviews + " نقد ";
                    element += "</div>";
                    element += "<div class='geo'>" + response[i].placeCity + "/ " + response[i].placeState + "</div>";
                    element += "</div>";
                    element += "</a></div>";

                    $("#" + containerId).append(element);
                }

            }
        });
    }

    function showRecentlyViews(element) {
        if( $("#my-trips-not").is(":hidden")){
            hideAllTopNavs();
            $("#my-trips-not").show();
            getRecentlyViews(element);
        }
        else
            hideAllTopNavs();
    }

    $(document).ready(function() {

        $('.notification-bell').click(function(e) {
            if( $("#alert").is(":hidden")) {
                hideAllTopNavs();
                $("#alert").show();
            }
            else
                hideAllTopNavs();
        });
    });

</script>
