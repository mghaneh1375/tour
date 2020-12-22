var rateStar= [
    '<span class="ui_bubble_rating bubble_10 font-size-16"\n' +
    '                                                          property="ratingValue" content="1"\n' +
    '                                                          alt="1 of 5 bubbles"></span>',

    '<span class="ui_bubble_rating bubble_20 font-size-16"\n' +
    '                                                          property="ratingValue" content="2"\n' +
    '                                                          alt="2 of 5 bubbles"></span>',
    '<span class="ui_bubble_rating bubble_30 font-size-16"\n' +
    '                                                          property="ratingValue" content="3"\n' +
    '                                                          alt="3 of 5 bubbles"></span>',
    '<span class="ui_bubble_rating bubble_40 font-size-16"\n' +
    '                                                          property="ratingValue" content="4"\n' +
    '                                                          alt=\'4 of 5 bubbles\'></span>',
    '<span class="ui_bubble_rating bubble_50 font-size-16"\n' +
    '                                                          property="ratingValue" content="5"\n' +
    '                                                          alt=\'5 of 5 bubbles\'></span>'
];
var isTransport = 1;
var isMeal = 1;

function transportTour(_value){
    if(_value == 0){
        document.getElementById('sDiv').style.display = 'none';
        document.getElementById('eDiv').style.display = 'none';
    }
    else{
        document.getElementById('sDiv').style.display = 'inline-block';
        document.getElementById('eDiv').style.display = 'inline-block';
    }

    isTransport = _value;
}

function openMultiSelect(){
    if(multiIsOpen){
        $('#multiselect').hide();
        multiIsOpen = false;
    }
    else{
        $('#multiselect').show();
        multiIsOpen = true;
    }
}

function chooseMultiSelect(_id){
    var choose = 0;
    var text = '';

    for(i = 0; i < transports.length; i++){
        if(transports[i].id == _id){
            choose = transports[i];
            break;
        }
    }

    if(choose != 0){
        document.getElementById('multiSelectTransport_' + choose.id).style.display = 'none';
    }

    text = '<div id="selectedMulti_' + choose.id + '" class="transportationKindChosenOnes col-xs-2">\n' + choose.name +
        '<span class="glyphicon glyphicon-remove" onclick="removeMultiSelect(' + choose.id + ')"></span>\n' +
        '</div>';
    $('#multiSelected').append(text);


    if(chooseSideTransport.includes(0)){
        index = chooseSideTransport.indexOf(0);
        chooseSideTransport[index] = choose.id;
    }
    else{
        chooseSideTransport[chooseSideTransport.length] = choose.id;
    }

    document.getElementById('sideTransport').value = JSON.stringify(chooseSideTransport);
}

function removeMultiSelect(_id){
    $('#selectedMulti_' + _id).remove();
    document.getElementById('multiSelectTransport_' + _id).style.display = 'block';

    if(chooseSideTransport.includes(_id)){
        index = chooseSideTransport.indexOf(_id);
        chooseSideTransport[index] = 0;
    }

    document.getElementById('sideTransport').value = JSON.stringify(chooseSideTransport);
}

function isMealsChange(_value){
    if(_value == 1)
        document.getElementById('mealsDiv').style.display = 'block';
    else
        document.getElementById('mealsDiv').style.display = 'none';

    isMeal = _value;
}

function findRestaurant(_id){
    restaurantCity = _id;
    cleanRestaurantSearch();

    for(i = 0; i < city.length; i++){
        if(city[i].id == _id){
            restaurantCity = city[i];
            break;
        }
    }

    $.ajax({
        type: 'post',
        url: searchRestaurantURL,
        data: {
            '_token' : _token,
            'cityId' : _id
        },
        success: function(response){
            restaurantList = JSON.parse(response)
        }
    })
}

function showRestaurantList(_value){
    var text = '';
    restaurantInSearch = [];

    if(_value != '' && _value != ' ' && _value != '   ') {
        text += '<li class="searchHover" style="color: blue;"> "' + _value + '"را اضافه کنید.</li>';
        for (i = 0; i < restaurantList.length; i++) {
            if (restaurantList[i].name.includes(_value)) {
                restaurantInSearch[restaurantInSearch.length] = restaurantList[i];
                text += '<li class="searchHover" onclick="chooseRestaurant(' + restaurantList[i].id + ')">' + restaurantList[i].name + '</li>';
            }
        }
        document.getElementById('restaurantResult').innerHTML = text;
    }
    else{
        document.getElementById('restaurantResult').innerHTML = '';
    }
}

function chooseRestaurant(_id){

    var text = '';
    var mainText = '';

    for(i = 0; i < restaurantInSearch.length; i++){
        if(restaurantInSearch[i].id == _id){

            if(restaurantChoose.includes(0)){
                index = restaurantChoose.indexOf(0);
                restaurantChoose[index] = restaurantInSearch[i].id;

            }
            else{
                restaurantChoose[restaurantChoose.length] = restaurantInSearch[i].id;
            }
            document.getElementById('restaurantList').value = JSON.stringify(restaurantChoose);

            text = '<div id="chooseRestaurant_' + restaurantInSearch[i].id + '"><div class="inputBoxGeneralInfo inputBox InlineTourInputBoxes position-relative">\n' +
                '<div class="inputBoxTextGeneralInfo inputBoxText width-30per">\n' +
                '<div>\n' +
                'استان\n' +
                '</div>\n' +
                '</div>\n' +
                '<input class="inputBoxInput text-align-right width-70per pd-rt-10" type="text" value="' + restaurantState.name + '" readonly>\n' +
                '</div>\n' +
                '<div class="inputBoxGeneralInfo inputBox InlineTourInputBoxes position-relative">\n' +
                '<div class="inputBoxTextGeneralInfo inputBoxText width-30per">\n' +
                '<div>\n' +
                'شهر\n' +
                '</div>\n' +
                '</div>\n' +
                '<input class="inputBoxInput text-align-right width-70per pd-rt-10" type="text" value="' + restaurantCity.name + '" readonly>\n' +
                '</div>\n' +
                '<div class="inputBoxGeneralInfo inputBox InlineTourInputBoxes position-relative">\n' +
                '<div class="inputBoxTextGeneralInfo inputBoxText width-30per">\n' +
                '<div>\n' +
                'نام رستوران\n' +
                '</div>\n' +
                '</div>\n' +
                '<input class="inputBoxInput text-align-right width-70per pd-rt-10" type="text" value="' + restaurantInSearch[i].name + '" readonly>\n' +
                '</div>\n' +
                '<div class="popUpButtons display-inline-block">\n' +
                '<div class="display-inline-block">\n' +
                '<button id="closeNewDestinationTourCreation" onclick="cancelRestaurant(' + restaurantInSearch[i].id + ')">\n' +
                '<img src="' + closePic + '">\n' +
                '</button>\n' +
                '</div>\n' +
                '</div></div>';

            mainText =  '                                <div id="mainShowRestaurant_' + restaurantInSearch[i].id + '" class="addTourPlacesTourCreation col-xs-4">\n' +
                '                                    <div class=" col-xs-5">\n' +
                '                                        <div class="addTourPlacesPicTourCreation circleBase type2">' +
                '                                               <img src="' + restaurantInSearch[i].pic + '" style="width: 100%; height: 100%; border-radius: 50%">' +
                '                                          </div>\n' +
                '                                    </div>\n' +
                '                                    <div class="addTourPlacesNameTourCreation col-xs-7">\n' +
                '                                        <a href="' + homeRoute + '/restaurant-details/' + restaurantInSearch[i].id + '/' + restaurantInSearch[i].name + '" target="_blank"><b>' + restaurantInSearch[i].name + '</b></a>\n' +
                '                                        <div class="prw_rup prw_common_bubble_rating overallBubbleRating addTourPlacesRateTourCreation">\n' +
                rateStar[restaurantInSearch[i].rate[1]-1] +
                // '                                            <span>2 نقد</span>\n' +
                '                                        </div>\n' +
                '                                        <div class="inline-block">\n' +
                '                                            استان: ' + restaurantState.name + '\n' +
                '                                        </div>\n' +
                '                                    </div>\n' +
                '                                </div>\n';

            $('#restaurantChoose').append(text);
            $('#restaurantChooseMain').append(mainText);

            break;
        }
    }
}

function cancelRestaurant(_id){
    index = restaurantChoose.indexOf(_id);
    restaurantChoose[index] = 0;

    $('#mainShowRestaurant_' + _id).remove();
    $('#chooseRestaurant_' + _id).remove();

    document.getElementById('restaurantList').value = JSON.stringify(restaurantChoose);
}

function cleanRestaurantSearch(){
    document.getElementById('restaurantResult').innerHTML = '';
    document.getElementById('inputSearchRestaurant').value = '';
}

function showCityList(_value){
    var text = '';
    cityInSearch = [];

    if(_value != '' && _value != ' ' && _value != '   ') {
        text += '<li class="searchHover" style="color: blue;"> "' + _value + '"را اضافه کنید.</li>';
        for (i = 0; i < city.length; i++) {
            if (city[i].name.includes(_value)) {
                cityInSearch[cityInSearch.length] = cityInSearch[i];
                text += '<li class="searchHover" onclick="chooseCity(' + city[i].id + ')">' + city[i].name + '</li>';
            }
        }
        document.getElementById('cityResult').innerHTML = text;
    }
    else{
        document.getElementById('cityResult').innerHTML = '';
    }
}

function chooseCity(_id){

    var text = '';
    var mainText = '';

    for(i = 0; i < city.length; i++){
        if(city[i].id == _id){

            if(cityChoose.includes(0)){
                index = cityChoose.indexOf(0);
                cityChoose[index] = cityChoose[i].id;

            }
            else{
                cityChoose[cityChoose.length] = city[i].id;
            }
            document.getElementById('cityList').value = JSON.stringify(cityChoose);

            text = '<div id="chooseCity_' + city[i].id + '"><div class="inputBoxGeneralInfo inputBox InlineTourInputBoxes position-relative">\n' +
                '<div class="inputBoxTextGeneralInfo inputBoxText width-30per">\n' +
                '<div>\n' +
                'استان\n' +
                '</div>\n' +
                '</div>\n' +
                '<input class="inputBoxInput text-align-right width-70per pd-rt-10" type="text" value="' + state.name + '" readonly>\n' +
                '</div>\n' +
                '<div class="inputBoxGeneralInfo inputBox InlineTourInputBoxes position-relative">\n' +
                '<div class="inputBoxTextGeneralInfo inputBoxText width-30per">\n' +
                '<div>\n' +
                'شهر\n' +
                '</div>\n' +
                '</div>\n' +
                '<input class="inputBoxInput text-align-right width-70per pd-rt-10" type="text" value="' + city[i].name + '" readonly>\n' +
                '</div>\n' +
                '<div class="popUpButtons display-inline-block">\n' +
                '<div class="display-inline-block">\n' +
                '<button id="closeNewDestinationTourCreation" onclick="cancelCity(' + city[i].id + ')">\n' +
                '<img src="' + closePic + '">\n' +
                '</button>\n' +
                '</div>\n' +
                '</div></div>';

            mainText =  '                                <div id="mainShowCity_' + city[i].id + '" class="addTourPlacesTourCreation col-xs-4">\n' +
                '                                    <div class=" col-xs-5">\n' +
                '                                        <div class="addTourPlacesPicTourCreation circleBase type2">' +
                '                                               <img src="' + city[i].pic + '" style="width: 100%; height: 100%; border-radius: 50%">' +
                '                                          </div>\n' +
                '                                    </div>\n' +
                '                                    <div class="addTourPlacesNameTourCreation col-xs-7">\n' +
                '                                        <a href="' + homeRoute + '/cityPage/' + city[i].name + '" target="_blank"><b>' + city[i].name + '</b></a>\n' +
                '                                        <div class="inline-block">\n' +
                '                                            استان: ' + state.name + '\n' +
                '                                        </div>\n' +
                '                                    </div>\n' +
                '                                </div>\n';

            $('#cityChoose').append(text);
            $('#cityChooseMain').append(mainText);

            break;
        }
    }
}

function cancelCity(_id){
    index = cityChoose.indexOf(_id);
    cityChoose[index] = 0;

    $('#mainShowCity_' + _id).remove();
    $('#chooseCity_' + _id).remove();

    document.getElementById('cityList').value = JSON.stringify(cityChoose);
}

function cleanCitySearch(){
    document.getElementById('cityResult').innerHTML = '';
    document.getElementById('inputSearchCity').value = '';
}

function findAmaken(_id){
    amakenCity = _id;
    cleanAmakenSearch();

    for(i = 0; i < city.length; i++){
        if(city[i].id == _id){
            amakenCity = city[i];
            break;
        }
    }

    $.ajax({
        type: 'post',
        url: searchAmakenURL,
        data: {
            '_token' : _token,
            'cityId' : _id
        },
        success: function(response){
            amakenList = JSON.parse(response);
        }
    })
}

function showAmakenList(_value){
    var text = '';
    amakenInSearch = [];

    if(_value != '' && _value != ' ' && _value != '   ') {
        text += '<li class="searchHover" style="color: blue;"> "' + _value + '"را اضافه کنید.</li>';
        for (i = 0; i < amakenList.length; i++) {
            if (amakenList[i].name.includes(_value)) {
                amakenInSearch[amakenInSearch.length] = amakenList[i];
                text += '<li class="searchHover" onclick="chooseAmaken(' + amakenList[i].id + ')">' + amakenList[i].name + '</li>';
            }
        }
        document.getElementById('amakenResult').innerHTML = text;
    }
    else{
        document.getElementById('amakenResult').innerHTML = '';
    }
}

function chooseAmaken(_id){

    var text = '';
    var mainText = '';

    for(i = 0; i < amakenInSearch.length; i++){
        if(amakenInSearch[i].id == _id){

            if(amakenChoose.includes(0)){
                index = amakenChoose.indexOf(0);
                amakenChoose[index] = amakenInSearch[i].id;
            }
            else{
                amakenChoose[amakenChoose.length] = amakenInSearch[i].id;
            }
            document.getElementById('amakenList').value = JSON.stringify(amakenChoose);

            text = '<div id="chooseAmaken_' + amakenInSearch[i].id + '"><div class="inputBoxGeneralInfo inputBox InlineTourInputBoxes position-relative">\n' +
                '<div class="inputBoxTextGeneralInfo inputBoxText width-30per">\n' +
                '<div>\n' +
                'استان\n' +
                '</div>\n' +
                '</div>\n' +
                '<input class="inputBoxInput text-align-right width-70per pd-rt-10" type="text" value="' + amakenState.name + '" readonly>\n' +
                '</div>\n' +
                '<div class="inputBoxGeneralInfo inputBox InlineTourInputBoxes position-relative">\n' +
                '<div class="inputBoxTextGeneralInfo inputBoxText width-30per">\n' +
                '<div>\n' +
                'شهر\n' +
                '</div>\n' +
                '</div>\n' +
                '<input class="inputBoxInput text-align-right width-70per pd-rt-10" type="text" value="' + amakenCity.name + '" readonly>\n' +
                '</div>\n' +
                '<div class="inputBoxGeneralInfo inputBox InlineTourInputBoxes position-relative">\n' +
                '<div class="inputBoxTextGeneralInfo inputBoxText width-30per">\n' +
                '<div>\n' +
                'نام مکان\n' +
                '</div>\n' +
                '</div>\n' +
                '<input class="inputBoxInput text-align-right width-70per pd-rt-10" type="text" value="' + amakenInSearch[i].name + '" readonly>\n' +
                '</div>\n' +
                '<div class="popUpButtons display-inline-block">\n' +
                '<div class="display-inline-block">\n' +
                '<button id="closeNewDestinationTourCreation" onclick="cancelAmaken(' + amakenInSearch[i].id + ')">\n' +
                '<img src="' + closePic + '">\n' +
                '</button>\n' +
                '</div>\n' +
                '</div></div>';

            mainText =  '                                <div id="mainShowAmaken_' + amakenInSearch[i].id + '" class="addTourPlacesTourCreation col-xs-4">\n' +
                '                                    <div class=" col-xs-5">\n' +
                '                                        <div class="addTourPlacesPicTourCreation circleBase type2">' +
                '                                               <img src="' + amakenInSearch[i].pic + '" style="width: 100%; height: 100%; border-radius: 50%">' +
                '                                          </div>\n' +
                '                                    </div>\n' +
                '                                    <div class="addTourPlacesNameTourCreation col-xs-7">\n' +
                '                                        <a href="' + homeRoute + '/amaken-details/' + amakenInSearch[i].id + '/' + amakenInSearch[i].name + '" target="_blank"><b>' + amakenInSearch[i].name + '</b></a>\n' +
                '                                        <div class="prw_rup prw_common_bubble_rating overallBubbleRating addTourPlacesRateTourCreation">\n' +
                rateStar[amakenInSearch[i].rate[1]-1] +
                // '                                            <span>2 نقد</span>\n' +
                '                                        </div>\n' +
                '                                        <div class="inline-block">\n' +
                '                                            استان: ' + amakenState.name + '\n' +
                '                                        </div>\n' +
                '                                    </div>\n' +
                '                                </div>\n';

            $('#amakenChoose').append(text);
            $('#amakenChooseMain').append(mainText);

            break;
        }
    }
}

function cancelAmaken(_id){
    index = amakenChoose.indexOf(_id);
    amakenChoose[index] = 0;

    $('#mainShowAmaken_' + _id).remove();
    $('#chooseAmaken_' + _id).remove();

    document.getElementById('amakenList').value = JSON.stringify(amakenChoose);
}

function cleanAmakenSearch(){
    document.getElementById('amakenResult').innerHTML = '';
    document.getElementById('inputSearchAmaken').value = '';
}

function checkInputs(){

    var error = false;
    var error_text = '';

    if(isTransport){
        var sTransport = document.getElementById('sTransport').value;
        var eTransport = document.getElementById('eTransport').value;
        var sTime = document.getElementById('sTime').value;
        var eTime = document.getElementById('eTime').value;
        var sAddress = document.getElementById('sAddress').value;
        var eAddress = document.getElementById('eAddress').value;
        var sLat = document.getElementById('sLat').value;
        var eLat = document.getElementById('eLat').value;
        var sLng = document.getElementById('sLng').value;
        var eLng = document.getElementById('eLng').value;

        if(sTransport == 0 ){
            error = true;
            error_text += '<li>لطفا وسیله نقلیه ی رفت را مشخص کنید.</li>';
            document.getElementById('sTransportDiv').classList.add('errorClass');
        }
        else
            document.getElementById('sTransportDiv').classList.remove('errorClass');

        if(eTransport != -1) {
            if (eTransport == 0) {
                error = true;
                error_text += '<li>لطفا وسیله نقلیه ی برگشت را مشخص کنید.</li>';
                document.getElementById('eTransportDiv').classList.add('errorClass');
            }
            else
                document.getElementById('eTransportDiv').classList.remove('errorClass');
        }

        if(sTime == null || sTime == ''){
            error = true;
            error_text += '<li>لطفا ساعت حرکت رفت را مشخص کنید.</li>';
            document.getElementById('sTimeDiv').classList.add('errorClass');
        }
        else
            document.getElementById('sTimeDiv').classList.remove('errorClass');

        if(eTime == null || eTime == ''){
            error = true;
            error_text += '<li>لطفا ساعت حرکت برگشت را مشخص کنید.</li>';
            document.getElementById('eTimeDiv').classList.add('errorClass');
        }
        else
            document.getElementById('eTimeDiv').classList.remove('errorClass');

        if(sAddress == null || sAddress == ''){
            error = true;
            error_text += '<li>لطفا محل حرکت رفت را مشخص کنید.</li>';
            document.getElementById('sAddressDiv').classList.add('errorClass');
        }
        else
            document.getElementById('sAddressDiv').classList.remove('errorClass');

        if(eAddress == null || eAddress == ''){
            error = true;
            error_text += '<li>لطفا محل حرکت برگشت را مشخص کنید.</li>';
            document.getElementById('eAddressDiv').classList.add('errorClass');
        }
        else
            document.getElementById('eAddressDiv').classList.remove('errorClass');

        if(sLat == 0 || sLng == 0){
            error = true;
            error_text += '<li>لطفا محل حرکت را روی نقشه مشخص کنید.</li>';
            document.getElementById('sPosition').classList.add('errorClass');
        }
        else
            document.getElementById('sPosition').classList.remove('errorClass');

        if(eLng == 0 || eLat == 0){
            error = true;
            error_text += '<li>لطفا محل برگشت را روی نقشه مشخص کنید.</li>';
            document.getElementById('ePosition').classList.add('errorClass');
        }
        else
            document.getElementById('ePosition').classList.remove('errorClass');

    }

    if(chooseSideTransport.length == 0){
        error = true;
        error_text += '<li>لطفا وسیله نقلیه ی فرعی را مشخص کنید.</li>';
        document.getElementById('mainClassificationOfTransportationInputDiv').classList.add('errorClass');
    }
    else{
        e = 0;
        for(i = 0; i < chooseSideTransport.length; i++){
            if(chooseSideTransport[i] != 0){
                e = 1;
                break;
            }
        }
        if(e == 0){
            error = true;
            error_text += '<li>لطفا وسیله نقلیه ی فرعی را مشخص کنید.</li>';
            document.getElementById('mainClassificationOfTransportationInputDiv').classList.add('errorClass');
        }
        else
            document.getElementById('mainClassificationOfTransportationInputDiv').classList.remove('errorClass');
    }

    if(isMeal == 1){
        if(!document.getElementById('c56').checked && !document.getElementById('c57').checked && !document.getElementById('c58').checked && !document.getElementById('c59').checked){
            error = true;
            error_text += '<li>لطفا نوع وعده غذایی را مشخص کنید.</li>';
        }
    }

    if(error){
        var text = '<div class="alert alert-danger alert-dismissible">\n' +
            '            <button type="button" class="close" data-dismiss="alert" style="float: left">&times;</button>\n' +
            '            <ul id="errorList">\n' + error_text +
            '            </ul>\n' +
            '        </div>';
        document.getElementById('errorDiv').style.display = 'block';
        document.getElementById('errorDiv').innerHTML = text;

        setTimeout(function(){
            document.getElementById('errorDiv').style.display = 'none';
        }, 5000);
    }
    else{
        document.getElementById('errorDiv').style.display = 'none';

        $('#form').submit();
    }

}

$(window).on('click', function (e) {
    var target = $(e.target), article;

    if( multiIsOpen  && !target.is('.optionMultiSelect') && !target.is('#multiSelected')){
        openMultiSelect();
    }
});

