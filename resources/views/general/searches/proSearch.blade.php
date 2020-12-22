<script>

    var destY, m = -1, destX;
    var selectedElement;
    var filters = [];
    var bodyRect;
    var windowW;
    var elemRect;
    var selectedVal;
    var selectedIdx;
    var selectedText;
    var searchInCity = "{{route('searchForCity')}}";
    var activeCityFilter = false;
    var searchInPlacesDir = '{{route('proSearch')}}';
    var compareList = [];

    function movement() {

        xy = selectedElement.getBoundingClientRect();

        offset = xy.top;
        offset2 = xy.left;

        if(offset >= destY)
            return movement2();

        offset += 2.8;

        selectedElement.style.left = offset2 + 1.2 * m + "px";
        selectedElement.style.top = offset + "px";

        return setTimeout("movement()", 1);
    }

    function movement2() {

        xy = selectedElement.getBoundingClientRect();

        if(xy.left >= destX) {
            $("#elevator").remove();
            $("#" + selectedVal).removeClass('hidden');
            return;
        }
        selectedElement.style.left = xy.left + 2.8 + "px";

        return setTimeout("movement2()", 1);
    }
    
    function addToFilter(cityId) {

        val = $("#GEO_SCOPED_SEARCH_INPUT").val();

        for(i = 0; i < filters.length; i++) {
            if(filters[i] == "cityFilterDest_" + cityId)
                return;
        }

        $("#currentCity").empty().append("شما در حال حاضر در شهر " + val + " هستید.").css('margin' , 'margin: 10px 0 5px !important;');
        val = ' مشاهده نتایج ' + val;
        $("#searchKeyCity").empty().append(val);
        $('#addToFilterCityBtn').css('display', 'block');

        offset  = elemRect.top;
        offset2 = elemRect.left;
        newFilter = "<div id='elevator' style=' top: " + offset + "px; left: " + offset2 + "px'><div>" + val + "</div></div>";
        $("#searchspan").append(newFilter);

        destX = windowW * 0.7 - (filters.length % 3 * 110) - document.getElementById('filterDiv').getBoundingClientRect().left;
        marginTop = Math.floor(filters.length / 3) * 40;
        newElement = "<div class='hidden cityFiltersProSearch' id='cityFilterDest_" + cityId + "' style='left: " + (destX - 115) + "px;'><div><span class='glyphicon glyphicon-remove' onclick='removeFilter(\"cityFilterDest_" + cityId + "\")'></span><span'>" + val + "</span></span></div></div>";
        $("#filters").append(newElement);

        selectedElement = document.getElementById("elevator");
        selectedVal = "cityFilterDest_" + cityId;
        filters[filters.length] = selectedVal;

        movement();
    }

    function addToFilter2(val) {

        destX = windowW * 0.8 - (filters.length * 110) - document.getElementById('filterDiv').getBoundingClientRect().left;
        newElement = "<div onclick='removeFilter(\"" + val + "\")' class='selectedFiltersProSearch' id='selectedFilter_" + val + "' style='left: " + destX + "px;'></div>";
        $("#filters").append(newElement);
        selectedVal = 'selectedFilter_' + val;
        filters[filters.length] = selectedVal;
        movement3();
    }

    function movement3() {

        w = $("#" + selectedVal).css('width').split('px')[0];

        if(w >= 100) {
            newElement = "<div class='mg-tp-35 color-black rotate-text'>" + selectedText + "</div>";
            $("#" + selectedVal).append(newElement);
            counter = 0;
            for(j = 0; j < compareList.length; j++) {
                if(compareList[j].id != -1)
                    counter++;
            }
            if(counter == 2) {
                $("#compare").removeClass('hidden');
            }
            return;
        }
        w++;

        $("#" + selectedVal).css('width', w + "px").css('height', w + "px");
        setTimeout('movement3()', 1);
    }
    
    function removeFilter(val) {

        selectedIdx = -1;

        for(i = 0; i < filters.length; i++) {
            if(filters[i] == val) {
                selectedIdx = i;
                filters.splice(i, 1);
            }
        }

        $("#" + val).remove();

        if(selectedIdx != -1 && selectedIdx != filters.length) {
            if(selectedIdx == 2)
                shiftLeft(1);
            else
                shiftRight(1);
        }

    }

    function searchInPlaces(_element) {

        var value = _element.value;

        if(value.trim().length > 1){
            cities = [];
            for(i = 0; i < filters.length; i++) {
                cities[i] = filters[i].split('_')[1];
            }

            if(cities.length == 0)
                cities = -1;


            hotelFilter = ($("#hotelFilter").attr('data-val') == 'off') ? 0 : 1;
            amakenFilter = ($("#amakenFilter").attr('data-val') == 'off') ? 0 : 1;
            restuarantFilter = ($("#restaurantFilter").attr('data-val') == 'off') ? 0 : 1;
            majaraFilter = ($("#majaraFilter").attr('data-val') == 'off') ? 0 : 1;
            sogatSanaieFilter = ($("#sogatSanaieFilter").attr('data-val') == 'off') ? 0 : 1;
            mahaliFoodFilter = ($("#mahaliFoodFilter").attr('data-val') == 'off') ? 0 : 1;
            boomgardyFilter = ($("#boomgardyFilter").attr('data-val') == 'off') ? 0 : 1;


            $.ajax({
                type: 'post',
                url: searchInPlacesDir,
                data: {
                    'key':  value,
                    'hotelFilter': hotelFilter,
                    'amakenFilter': amakenFilter,
                    'restaurantFilter': restuarantFilter,
                    'majaraFilter': majaraFilter,
                    'sogatSanaieFilter': sogatSanaieFilter,
                    'mahaliFoodFilter': mahaliFoodFilter,
                    'selectedCities': cities,
                    'mode': 'city'
                },
                success: function (response) {
                    $("#resultPlace").empty();

                    if(response.length == 0)
                        return;

                    response = JSON.parse(response);

                    newElement = "";
                    for(i = 0; i < response.length; i++) {

                        if(response[i].kindPlace == 'هتل')
                            icon = '<div class="icons hotelIcon spIcons"></div>';
                        else if(response[i].kindPlace == 'رستوران')
                            icon = '<div class="icons restaurantIcon spIcons"></div>';
                        else if(response[i].kindPlace == 'اماکن')
                            icon = '<div class="icons touristAttractions spIcons"></div>';
                        else if(response[i].kindPlace == 'ماجرا')
                            icon = '<div class="icons adventure spIcons"></div>';
                        else if(response[i].kindPlace == 'غذای محلی')
                            icon = '<div class="icons traditionalFood spIcons"></div>';
                        else if(response[i].kindPlace == 'صنایع سوغات')
                            icon = '<div class="icons souvenirIcon spIcons"></div>';
                        else
                            icon = '<div class="icons touristAttractions spIcons"></div>';

                        newElement += '<div style="padding: 5px 20px; display: flex">' +
                                        '   <a href="' + response[i]['url'] + '" style="width: 80%; color: black;">' +
                                        '       <div>' +
                                                    icon +
                                            '       <p class="suggest cursor-pointer font-weight-700" id="suggest_1" style="margin: 0px; display: inline-block;">' + response[i].name + '</p>' +
                                            '       <p class="suggest cursor-pointer stateName" id="suggest_1">' + response[i].stateName + ' در ' + response[i].cityName + '</p>' +
                                        '       </div>\n' +
                                        '   </a>' +
                                        '   <div style="display: flex; align-items: center">' +
                                        '       <button class="btn btn-success" style="float: left; padding: 2px 15px; border-radius: 8px;"  onclick="addToCompareList(\'' + response[i].kindPlaceId + '\', \'' + response[i].id + '\', \'' + response[i].name + '\')"> مقایسه </button>' +
                                        '       <a href="' + response[i]['url'] + '">' +
                                        '          <button class="btn btn-danger" style="float: left; padding: 2px 15px; border-radius: 8px; margin-right: 15px"> مشاهده </button>' +
                                        '       </a>' +
                                        '   </div>' +
                                        '</div>';
                    }

                    setResultToGlobalSearch(newElement);
                }
            });
        }
        else
            clearGlobalResult();
    }

    function removeFromCompareList(idx) {

        if(idx > 4 || idx < 0)
            return;

        $("#compare_" + idx + "_plus_div").removeClass('hidden');
        $("#compare_" + idx + "_text").empty().addClass('hidden').removeClass('rotate-text');
        $("#compare_" + idx + "_pic").addClass('hidden');
        $("#removeDiv_" + idx).addClass('hidden');
        compareList[idx - 1] = {'id': -1, 'kindPlaceId': -1 };
        counter = 0;
        for(j = 0; j < compareList.length; j++) {
            if(compareList[j].id != -1)
                counter++;
        }
        if(counter < 2) {
            $("#compare").addClass('hidden');
        }
    }

    function addToCompareList(kindPlaceId, id, name) {

        closeSearchInput();

        for(i = 0; i < compareList.length; i++) {
            if(compareList[i].id == id)
                return;
        }

        idx = -1;

        for(i = 0; i < compareList.length; i++) {
            if(compareList[i].id == -1) {
                idx = i + 1;
                break;
            }
        }

        if(idx == -1) {
            if(compareList.length + 1 > 4)
                idx = 4;
            else
                idx = compareList.length + 1;
        }

        selectedText = name;
        selectedVal = "compare_" + idx + "_bubble";

        compareList[idx - 1] = {'id': id, 'kindPlaceId': kindPlaceId};


        $.ajax({
            type: 'post',
            url: '{{route('getPlacePic')}}',
            data: {
                'placeId': id,
                'kindPlaceId': kindPlaceId
            },
            success: function (response) {
                $("#compare_" + idx + "_plus_div").addClass('hidden');
                $("#compare_" + idx + "_text").css('background-color', "#dddddd").empty().append(name).removeClass('hidden').addClass('rotate-text');
                $("#compare_" + idx + "_pic").css('background', "url('" + response + "')").css('background-size', "contain").css('background-repeat', "no-repeat").removeClass('hidden');
                $("#removeDiv_" + idx).removeClass('hidden');

                counter = 0;
                for(j = 0; j < compareList.length; j++) {
                    if(compareList[j].id != -1)
                        counter++;
                }
                if(counter < 2)
                    $("#compare").addClass('hidden');
                else
                    $("#compare").removeClass('hidden');
            }
        });

//        movement3();
    }

    function shiftRight(val) {

        if(val == 110) {

            if(selectedIdx >= filters.length)
                return;
            selectedIdx++;
            if(selectedIdx == 2)
                return shiftLeft(1);
            return shiftRight(1);
        }

        val++;
        currLeft = $("#" + filters[selectedIdx]).css('left').split('px')[0];
        currLeft++;

        $("#" + filters[selectedIdx]).css('left', currLeft + "px");

        setTimeout("shiftRight('" + val + "')", 1);
    }

    function shiftTop(val) {

        if(val == 40) {

            if(selectedIdx >= filters.length)
                return;
            selectedIdx++;
            return shiftRight(1);
        }

        val++;
        currTop = $("#" + filters[selectedIdx]).css('top').split('px')[0];
        currTop--;

        $("#" + filters[selectedIdx]).css('top', currTop + "px");

        setTimeout("shiftTop('" + val + "')", 1);
    }

    function shiftLeft(val) {

        if(val == 220) {
            return shiftTop(1);
        }

        val++;
        currLeft = $("#" + filters[selectedIdx]).css('left').split('px')[0];
        currLeft--;

        $("#" + filters[selectedIdx]).css('left', currLeft + "px");

        setTimeout("shiftLeft('" + val + "')", 1);
    }

    function destroyBalloon() {

        w = $("#" + selectedVal).css('width').split('px')[0];

        if(w <= 5) {
            $("#" + selectedVal).remove();
            if(selectedIdx >= 0)
                shiftRight(1);
            return;
        }
        w--;

        $("#" + selectedVal).css('width', w + "px").css('height', w + "px");
        setTimeout('destroyBalloon()', 1);
    }
    
    function searchCity(_element) {

        activeCityFilter = false;
        var value = _element.value;

        if(value.trim().length > 1){
            $.ajax({
                type: 'post',
                url: searchInCity,
                data: {
                    'key':  value
                },
                success: function (response) {

                    $("#resultCity").empty();

                    if(response.length == 0)
                        return;

                    response = JSON.parse(response);

                    var newElement = "";

                    for(i = 0; i < response.length; i++) {
                        newElement += '<div onclick="setCityName(\'' + response[i].cityName + '\', \'' + response[i].id + '\')"><div class="icons location spIcons"></div>' +
                                     '<p class="suggest cursor-pointer font-weight-700" id="suggest_1" style="margin: 0px">شهر ' + response[i].cityName + '</p>' +
                                     '<p class="suggest cursor-pointer stateName" id="suggest_1">' + response[i].stateName + '</p></div>';
                    }
                    setResultToGlobalSearch(newElement);
                }
            });
        }
        else
            clearGlobalResult();
    }

    var cityChoose = 0;
    function setCityName(val, id) {
        closeSearchInput();
        cityChoose = val;
        activeCityFilter = true;
        $("#GEO_SCOPED_SEARCH_INPUT2").val('');
        $("#GEO_SCOPED_SEARCH_INPUT").val(val);
        addToFilter(id);

    }

    function goTo(kind = '') {

        if(kind == 'cityPage' && cityChoose != 0){
            window.location.href = '{{url("cityPage/city")}}/' + cityChoose;
            return ;
        }

        if(!activeCityFilter || $("#GEO_SCOPED_SEARCH_INPUT").val() == "")
            return;

        hotel = restaurant = amaken = majara = soghat = mahaliFood = sanaye = false;
        counter = 0;

        if($("#amakenFilter").attr("data-val") == "on") {
            amaken = true;
            counter++;
        }

        if($("#hotelFilter").attr("data-val") == "on") {
            hotel = true;
            counter++;
        }

        if($("#restaurantFilter").attr("data-val") == "on") {
            restaurant = true;
            counter++;
        }

        if($("#majaraFilter").attr("data-val") == "on") {
            majara = true;
            counter++;
        }

        if($("#sogatSanaieFilter").attr("data-val") == "on") {
            soghat = true;
            counter++;
        }

        if($("#mahaliFoodFilter").attr("data-val") == "on") {
            mahaliFood = true;
            counter++;
        }

        if(counter == 0) {
            alert("یکی رو انتخاب کن");
            return;
        }

        if(counter > 1) {
            alert("فقط یکی رو انتخاب کن");
            return;
        }

        if(hotel) {
            document.location.href = "{{route('home')}}" + '/hotelList/' + $("#GEO_SCOPED_SEARCH_INPUT").val() + '/city';
        }
        else if(amaken) {
            document.location.href = "{{route('home')}}" + '/amakenList/' + $("#GEO_SCOPED_SEARCH_INPUT").val() + '/city';
        }
        else if(restaurant) {
            document.location.href = "{{route('home')}}" + '/restaurantList/' + $("#GEO_SCOPED_SEARCH_INPUT").val() + '/city';
        }
        else if(majara) {
            document.location.href = "{{route('home')}}" + '/majaraList/' + $("#GEO_SCOPED_SEARCH_INPUT").val() + '/state';
        }
        else if(soghat) {
            document.location.href = "{{route('home')}}" + '/adab-list/' + $("#GEO_SCOPED_SEARCH_INPUT").val() + '/soghat';
        }
        else if(mahaliFood) {
            document.location.href = "{{route('home')}}" + '/adab-list/' + $("#GEO_SCOPED_SEARCH_INPUT").val() + '/mahaliFood';
        }
        else if(sanaye) {
            document.location.href = "{{route('home')}}" + '/adab-list/' + $("#GEO_SCOPED_SEARCH_INPUT").val() + '/sanaye';
        }

    }

    function compare() {

        if(compareList.length > 1) {

            url = "";
            allow = true;

            for(i = 0; i < compareList.length; i++) {

                if(compareList[i].id == -1)
                    continue;

                if(allow) {
                    allow = false;
                    url += compareList[i].id + "/" + compareList[i].kindPlaceId;
                }
                else
                    url += "/" + compareList[i].id + "/" + compareList[i].kindPlaceId;
            }
            document.location.href = "{{route('home')}}" + "/showAllPlaces/" + url;
        }
    }
    
</script>


<div id="searchspan" class="ui_modal fullwidth no_padding ppr_rup ppr_priv_masthead_search">
    <div class="body_text">
        <div class="search_overlay_content ui_container">
            <div id="DUAL_SEARCH_LOADER_CONTAINER" class="dual_search_loader_container">
                <div class="dual_search_loader_overlay"></div>
                <div class="dual_search_loader_visual">
                    <div class="ui_spinner"></div>
                </div>
            </div>

            <div class="row mg-tp-50" id="mainDivProSearch">
                @if(isset($locationName['name']))
                    <div class="col-xs-12 boxOfWhereIsHere">
                        شما در حال حاضر در
                        <div id="nameOfWhereIsHere">{{$locationName['name']}}</div>
                        هستید
                    </div>
                @endif

{{--                <div class="col-xs-2"></div>--}}
                <div class="col-xs-12 whereMainDiv">
                    <div class="col-xs-7">
                        <div class="boxOfCityNameProSearch">
                            <div id="textOfWhere">در کجا</div>
                            <div class="where_with_highlight enterCityNameProSearch">
                                <input id="GEO_SCOPED_SEARCH_INPUT" class="text geoScopeInput" onclick="openSearchFindCity()"
                                       value="" placeholder="نام شهر را وارد کنید" autocomplete="off" type="text" readonly>
                            </div>
                        </div>
                        <p id="currentCity"></p>
                        <div id="resultCity" class="data_holder"></div>
                    </div>
                    <div class="col-xs-5 whereSearchBtnMainDiv">
                        <div id="addToFilterCityBtn" class="inner" onclick="goTo('cityPage')" style="display: none;">
                            <span id="searchKeyCity"></span>
                        </div>
                    </div>
                </div>
{{--                <div class="col-xs-2"></div>--}}

                <div class="clear-both"></div>

{{--                <div class="col-xs-2"></div>--}}
                <div class="col-xs-12 pd-0" id="dividerUpBoxProSearch"></div>
{{--                <div class="col-xs-2"></div>--}}

                <div class="clear-both"></div>

{{--                <div class="col-xs-2"></div>--}}
                <div class="col-xs-12 pd-0">
                    <div class="col-xs-12 destinationMainDiv">
                        <div class="col-xs-5 pd-0">
                            <div class="boxOfCityNameProSearch">
                                <div id="textOfWhere2">به کجا</div>
                                <div class="where_with_highlight enterCityNameProSearch">
                                    <input id="GEO_SCOPED_SEARCH_INPUT2" class="text geoScopeInput" onclick="openSearchFindPlace()"
                                           value="" placeholder="نام مکان را وارد کنید. (به وسیله فانوس ها جستجو را محدود کنید.)" type="text" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-7 boxOfLamps">
                            <?php
                                $onLampImg = URL::asset('images/on_lamp.gif');
                                $offLampImg = URL::asset('images/off_lamp.png');
                            ?>

                            <div class='ui_input_checkbox' style="cursor: pointer;">
                                <img data-val="{{(isset($kindPlaceId) && ($kindPlaceId == 1 || $kindPlaceId == 0)) || !isset($kindPlaceId) ? 'on' : 'off'}}" class="lantern" id="amakenFilter" width="40px" height="80px" src="{{(isset($kindPlaceId) && ($kindPlaceId == 1 || $kindPlaceId == 0)) || !isset($kindPlaceId) ? $onLampImg : $offLampImg}}">
                                <div>اماکن</div>
                            </div>
                            <div class='ui_input_checkbox' style="cursor: pointer;">
                                <img data-val="{{(isset($kindPlaceId) && ($kindPlaceId == 4 || $kindPlaceId == 0)) || !isset($kindPlaceId) ? 'on' : 'off'}}" class="lantern" id="hotelFilter" width="40px" height="80px" src="{{(isset($kindPlaceId) && ($kindPlaceId == 4 || $kindPlaceId == 0)) || !isset($kindPlaceId) ? $onLampImg : $offLampImg}}">
                                <div>هتل</div>
                            </div>
                            <div class='ui_input_checkbox' style="cursor: pointer;">
                                <img data-val="{{(isset($kindPlaceId) && ($kindPlaceId == 3 || $kindPlaceId == 0)) || !isset($kindPlaceId) ? 'on' : 'off'}}" class="lantern" id="restaurantFilter" width="40px" height="80px" src="{{(isset($kindPlaceId) && ($kindPlaceId == 3 || $kindPlaceId == 0)) || !isset($kindPlaceId) ? $onLampImg : $offLampImg}}">
                                <div>رستوران</div>
                            </div>
                            <div class='ui_input_checkbox' style="cursor: pointer;">
                                <img data-val="{{(isset($kindPlaceId) && ($kindPlaceId == 6 || $kindPlaceId == 0)) || !isset($kindPlaceId)  ? 'on' : 'off'}}" class="lantern" id="majaraFilter" width="40px" height="80px" src="{{(isset($kindPlaceId) && ($kindPlaceId == 6 || $kindPlaceId == 0)) || !isset($kindPlaceId) ? $onLampImg : $offLampImg}}">
                                <div>طبیعت‌گردی</div>
                            </div>
                            <div class='ui_input_checkbox' style="cursor: pointer;">
                                <img data-val="{{(isset($kindPlaceId) && ($kindPlaceId == 10 || $kindPlaceId == 0)) || !isset($kindPlaceId)  ? 'on' : 'off'}}" class="lantern" id="sogatSanaieFilter" width="40px" height="80px" src="{{(isset($kindPlaceId) && ($kindPlaceId == 10 || $kindPlaceId == 0)) || !isset($kindPlaceId) ? $onLampImg : $offLampImg}}">
                                <div>صنایع‌دستی</div>
                            </div>
                            <div class='ui_input_checkbox' style="cursor: pointer;">
                                <img data-val="{{(isset($kindPlaceId) && ($kindPlaceId == 10 || $kindPlaceId == 0)) || !isset($kindPlaceId)  ? 'on' : 'off'}}" class="lantern" id="sogatSanaieFilter" width="40px" height="80px" src="{{(isset($kindPlaceId) && ($kindPlaceId == 10 || $kindPlaceId == 0)) || !isset($kindPlaceId) ? $onLampImg : $offLampImg}}">
                                <div>سوغات</div>
                            </div>
                            <div class='ui_input_checkbox' style="cursor: pointer;">
                                <img data-val="{{(isset($kindPlaceId) && ($kindPlaceId == 11 || $kindPlaceId == 0)) || !isset($kindPlaceId)  ? 'on' : 'off'}}" class="lantern" id="mahaliFoodFilter" width="40px" height="80px" src="{{(isset($kindPlaceId) && ($kindPlaceId == 11 || $kindPlaceId == 0)) || !isset($kindPlaceId) ? $onLampImg : $offLampImg}}">
                                <div>غذا محلی</div>
                            </div>
                        </div>
{{--                        <div id="dividerCenterBoxProSearch"></div>--}}
                    </div>
                    {{--<div class="col-xs-12" id="filterDiv">--}}
                        {{--<div id="filters" class="position-relative"></div>--}}
                    {{--</div>--}}
                </div>

                <div class="clear-both"></div>

                <div class="col-xs-12 pd-0 compareDivsMainDiv">
                    <div class="col-xs-12 boxOfMainDivCompareProSearch">
                        @for($i = 1; $i < 5; $i++)
                            <div id="mainDivCompareProSearch">
                                <div>
                                    <span id="removeDiv_{{$i}}" onclick="removeFromCompareList('{{$i}}')" class="hidden glyphicon glyphicon-remove"></span>
                                    <div id="compare_{{$i}}_text" class="hidden center"></div>
                                    <div id="compare_{{$i}}_pic" class="hidden center"></div>
                                    <div id="compare_{{$i}}_plus_div">منتظر انتخاب</div>
                                </div>
                            </div>
                        @endfor
                    </div>
                    <div class="col-xs-12" id="mainDivCompareProSearchBtn">
                        <button id="compare" onclick="compare()" class="btn btn-primary hidden">شروع مقایسه</button>
                    </div>
                </div>
            </div>
{{--            <div id="myCloseBtn" class="hidden" onclick="closeInFireFox()" draggable="true" ondragend="dropMenu(event)" ondrop="dropMenu(event)" ondrag="dragging(event)"></div>--}}
        </div>
    </div>
    <div class="ui_close_x" id="close_span_search"></div>
</div>

<script>
     var onImage = "{{URL::asset('images/on_lamp.gif')}}";
     var offImage = "{{URL::asset('images/off_lamp.png')}}";


     $('#close_span_search').click(function(e) {
         $('#searchspan').animate({height: '0vh'});
         $("#myCloseBtn").addClass('hidden');
     });

     $('#openSearch').click(function(e) {
         $("#myCloseBtn").removeClass('hidden');
         $('#searchspan').animate({height: '100vh'});
     });

    function openProSearch() {
            $("#myCloseBtn").removeClass('hidden');
            $('#searchspan').animate({height: '100vh'});
    }

    function closeInFireFox() {
        if(navigator.userAgent.toLowerCase().indexOf('firefox') > -1){
            $("#searchspan").css('height', "0vh");
            $("#myCloseBtn").addClass('hidden');
        }
    }

    function dropMenu(event) {

        // if(event.clientY < 0.7 * window.innerHeight) {
        //     $("#searchspan").css('height', "0vh");
        //     $("#myCloseBtn").addClass('hidden');
        // }
        // else
        //     $("#searchspan").css('height', "100vh");
    }

    // function dragging(event) {
    //     $("#searchspan").css('height', event.clientY + "px");
    // }

    $(".lantern").click(function () {
        if($(this).attr('data-val') == "off") {
            id = $(this).attr('id');
            $(this).attr('data-val', "on");
            $("#" + id).attr('src', '{{URL::asset('images/on_lamp.gif')}}');
        }
        else {
            $(this).attr('data-val', "off");
            id = $(this).attr('id');
            $("#" + id).attr('src', '{{URL::asset('images/off_lamp.png')}}');
        }
        searchInPlaces();
    });

    function changeFilter(_place, _element){
    //     var imageElements = $(_element).children().first();
    //     var status = imageElements.attr('data-val');
    //     if(status == 'off'){
    //         imageElements.attr('data-val', 'on');
    //         imageElements.attr('src', onImage);
    //     }
    //     if(status == 'on'){
    //         imageElements.attr('data-val', 'on');
    //         imageElements.attr('src', onImage);
    //     }
    }

    function openSearchFindCity(){
        createSearchInput('searchCity', 'نام شهر را وارد کنید.');
    }

    function openSearchFindPlace(){
        createSearchInput('searchInPlaces', 'نام مکان مورد نظر را وارد کنید.');
    }
</script>