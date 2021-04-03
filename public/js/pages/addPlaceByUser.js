
let marker = null;
let map = null;
let selectedCategory = null;
let isPlace = true;
let tryToGetFeatures = 3;
let newPlaceId = 0;
let currentSteps = 1;

nowMaterialRow = 1;
numMaterialRow = 3;


function initMap() {
    // var mapOptions = {
    //     center: {lat: 32.427908, lng: 53.688046},
    //     zoom: 5,
    //     styles: [
    //         {
    //             "featureType": "landscape",
    //             "stylers": [{"hue": "#FFA800"}, {"saturation": 0}, {"lightness": 0}, {"gamma": 1}]
    //         }, {
    //             "featureType": "road.highway",
    //             "stylers": [{"hue": "#53FF00"}, {"saturation": -73}, {"lightness": 40}, {"gamma": 1}]
    //         }, {
    //             "featureType": "road.arterial",
    //             "stylers": [{"hue": "#FBFF00"}, {"saturation": 0}, {"lightness": 0}, {"gamma": 1}]
    //         }, {
    //             "featureType": "road.local",
    //             "stylers": [{"hue": "#00FFFD"}, {"saturation": 0}, {"lightness": 30}, {"gamma": 1}]
    //         }, {
    //             "featureType": "water",
    //             "stylers": [{"hue": "#00BFFF"}, {"saturation": 6}, {"lightness": 8}, {"gamma": 1}]
    //         }]
    // };
    //
    // map = document.getElementById('map');
    // map = new google.maps.Map(map, mapOptions);
    // google.maps.event.addListener(map, 'click', function(event) {
    //     getLat(event.latLng);
    // });

    if(map == null) {
        map = L.map("mapDiv", {
            minZoom: 1,
            maxZoom: 20,
            crs: L.CRS.EPSG3857,
            center: [32.427908, 53.688046],
            zoom: 5
        }).on('click', e => getLat(e.latlng));

        L.TileLayer.wmsHeader(
            "https://map.ir/shiveh",
            {
                layers: "Shiveh:Shiveh",
                format: "image/png",
                minZoom: 1,
                maxZoom: 20
            },
            [{header: "x-api-key", value: window.mappIrToken}]
        ).addTo(map);
    }

    let lat = 0;
    let lng = 0;
    let zoom = 10;
    let cityId = $('#cityId').val();

    var numbers = /^[0-9]+$/;

    if(cityId != 0 && cityId.match(numbers)){
        for(city of cities){
            if(city['id'] == cityId){
                lat = city['x'];
                lng = city['y'];
                zoom = 10;
                break;
            }
        }
    }
    else if(cityId != 0 && !cityId.match(numbers)){
        $numsss = 0;
        for(city of cities){
            if(city['x'] != 0 && city['y'] != 0){
                lat += city['x'];
                lng += city['y'];
                $numsss++;
            }
        }
        lat /= $numsss;
        lng /= $numsss;
        zoom = 8;
    }

    if(lat != 0 && lng != 0)
        map.setView([lat, lng], zoom);

    if($('#lng').val() != 0 && $('#lat').val())
        setNewMarker();
}

function getLat(_location){
    $('#lat').val(_location.lat);
    $('#lng').val(_location.lng);
    setNewMarker();
}

function setNewMarker(){
    if(marker != null)
        map.removeLayer(marker);
    var latLng = [$('#lat').val(), $('#lng').val()];
    marker = L.marker(latLng).addTo(map);
    map.setView(latLng, 15);
}

function openMap(){
    $('#mapModal').modal('show');
    setTimeout(initMap, 500);
}

function getMyLocation(){
    if (navigator.geolocation)
        navigator.geolocation.getCurrentPosition(position => getLat({lat: position.coords.latitude, lng: position.coords.longitude}));
    else
        console.log("Geolocation is not supported by this browser.");
}


let cities = null;
function changeState(_value){
    $('#cityId').val(0);
    $('#cityName').val('');

    if($('#noneState'))
        $('#noneState').remove();

    openLoading();
    $.ajax({
        type: 'post',
        url: searchInCityUrl,
        data:{
            _token: csrfTokenGlobal,
            stateId: _value,
        },
        complete: closeLoading,
        success: function(response){
            try{
                cities = JSON.parse(response);
                createSearchInput(findCity, 'شهر مورد نظر را وارد کنید...');
            }
            catch (e) {
                console.log(e)
            }
        },
    })
}

function findCity(_element){
    let result = '';
    let likeCity = [];
    let value = _element.value;

    valeu = value.trim();
    if(value.length > 1){
        for(city of cities){
            if(city.name.indexOf(value) > -1)
                likeCity.push(city);
        }

        likeCity.forEach(item => {
            let cityKind = item.isVillage == 0 ? 'شهر' : 'روستا';

            result += `<div onclick="selectCity(this)" class="resultSearch" cityId="${item.id}">
                            <p class="suggest cursor-pointer font-weight-700" id="suggest_1" style="margin: 0px">${cityKind} ${item.name}</p>
                        </div>`;
        });

        if(result == ''){
            result = `<div onclick="selectCity(this)" class="resultSearch" cityId="-1">
                        <p class="suggest cursor-pointer font-weight-700" id="suggest_1" style="margin: 0px; color: blue; font-size: 20px !important;">
                             <span id="newCityName">${value}</span>
                             <span>را اضافه کن</span>
                        </p>
                      </div>`;
        }

        setResultToGlobalSearch(result);
    }
    else
        setResultToGlobalSearch('');
}

function selectCity(_element){
    closeSearchInput();
    let id = $(_element).attr('cityId');
    let name;
    if(id == -1) {
        name = $("#newCityName").text();
        id = name;
    }
    else
        name = $(_element).children().first().text();

    $('#cityName').val(name);
    $('#cityId').val(id);
}

function chooseCity(){
    if(cities == null)
        openWarning('ابتدا استان خود را مشخص کنید.');
    else
        createSearchInput(findCity ,'شهر خود را وارد کنید...');
}


function selectCategory (elem, _categoryIndex){

    $($('.choosedCategory')[0]).removeClass('choosedCategory');
    $(elem).addClass('choosedCategory');

    selectedCategory = categories[_categoryIndex];
    location.href = location.origin + location.pathname + '#' + selectedCategory.kind;
    $('#nextStep').attr('disabled', false);

    $('.selectCategoryDiv').removeClass('hidden');

    let headerCategoryIconTag = $('.headerCategoryIcon');

    categories.forEach(item => headerCategoryIconTag.removeClass(item['icon']));
    headerCategoryIconTag.addClass(selectedCategory['icon']);
    $('.headerCategoryName').text(selectedCategory['name']);

    $('#step3MainTitle').text(selectedCategory['step3']);
    $('#step3MainUnderTitle').text(selectedCategory['step3Under']);
    $('#step4MainTitle').text(selectedCategory['step4']);
    $('#step5MainTitle').text(selectedCategory['step5']);
    $('#step6MainTitle').text(selectedCategory['step6']);

    $('.onlyForHotelsRest').css('display', 'none');
    $('.onlyForHotelsRestBoom').css('display', 'none');

    if(selectedCategory['id'] == 4 || selectedCategory['id'] == 3 )
        $('.onlyForHotelsRest').css('display', 'flex');

    if(selectedCategory['id'] == 4 || selectedCategory['id'] == 3 || selectedCategory['id'] == 12)
        $('.onlyForHotelsRestBoom').css('display', 'flex');

    if(selectedCategory['id'] == 10 || selectedCategory['id'] == 11) {
        $('#textForChooseCity').hide();
        $('#onlyForPlaces').hide();
        isPlace = false;
    }
    else{
        $('#onlyForPlaces').show();
        $('#textForChooseCity').show();
        isPlace = true;
    }

    $('#sampleText').text(selectedCategory['text']);
    $('#sampleLink').text(selectedCategory['sample']['name']).attr('href', selectedCategory['sample']['link']);

    createInputPlace();
}

function changeSteps(inc){
    $('#nextStep').attr('disabled', true);

    if(currentSteps == 1 && selectedCategory == null)
        return;
    else
        $('#nextStep').attr('disabled', false);

    if(inc == 1) {
        if (currentSteps == 0 || currentSteps == 1) {
            stepLog(currentSteps);
            doChangeStep(inc);
        }
        else if (currentSteps == 2 && checkStep2()) {
            stepLog(currentSteps);
            doChangeStep(inc);
        }
        else if(currentSteps == 3 && checkStep3()) {
            stepLog(currentSteps);
            doChangeStep(inc);
        }
        else if(currentSteps == 4) {
            stepLog(currentSteps);
            storeData();
        }
        else if(currentSteps == 5 || currentSteps == 6) {
            stepLog(currentSteps);
            doChangeStep(inc);
        }
    }
    else
        doChangeStep(inc);

}

function deleteThisPic(_element, _name){
    $.ajax({
        type: 'POST',
        url: deletePicForAddPlaceByUserUrl,
        data: {
            _token: csrfTokenGlobal,
            name: _name,
            id: newPlaceId
        },
        success: function(response){
            if(response.status == 'ok')
                $(_element).parent().parent().parent().remove();
        },
    })
}

function doChangeStep(inc){
    if(!checkLogin(location.href))
        return;

    $('html, body').animate({ scrollTop: 0 }, 'fast');

    $('.bodyOfSteps').addClass('hidden');
    $('.stepHeader').addClass('hidden');
    currentSteps += inc;

    if (currentSteps == 0) {
        $('#stepName').addClass('hidden');
        $('.selectCategoryDiv').addClass('hidden');
    }
    else {
        $('#stepName').removeClass('hidden');
        $('.selectCategoryDiv').removeClass('hidden');
    }

    if (currentSteps <= 0 || currentSteps >= 7)
        $('.steps').addClass('hidden');
    else
        $('.steps').removeClass('hidden');

    if(currentSteps > 1) {
        $('#previousStep').show();
        $('.footerBox1').css('width', 'calc(100% - 230px)')
    }
    else {
        $('#previousStep').hide();
        $('.footerBox1').css('width', 'calc(100% - 115px)')
    }

//for change name of button in steps
    if (currentSteps < 0){
        document.location.href = mainRoutURl;
        currentSteps = 0;
    }
    else if(currentSteps == 0){
        $('#nextStep').html('شروع');
        $('#previousStep').html('بازگشت');
    }
    else if(currentSteps > 0 && currentSteps < 3){
        $('#nextStep').html('بعدی');
        $('#previousStep').html('بازگشت');
    }
    else if(currentSteps == 4){
        $('#nextStep').html('ذخیره');
        $('#previousStep').html('بازگشت');
    }
    else if(currentSteps == 5){
        $('#nextStep').html('بعدی');
        $('.footerBox1').css('width', 'calc(100% - 115px)');
        $('#previousStep').css('display', 'none');
    }
    else if(currentSteps == 6){
        $('#lastButton').removeClass('hidden');
        $('#previousStep').css('display', 'none');
        $('#nextStep').addClass('endSectionButton').addClass('hidden');
        $('.footerBox1').addClass('endSectionFooter');
    }
    else if(currentSteps == 7)
        document.location.href = mainRoutURl;


//for change color of each box of step
    $('.step' + currentSteps).removeClass('hidden');

    $(".bigCircle, .littleCircle").removeClass('completeStep').each(function() {
        if($(this).attr('data-val') <= currentSteps)
            $(this).addClass('completeStep');
    });
//for change name of step
    let stepText = [
        'اولین مرحله',
        'دومین مرحله',
        'سومین مرحله',
        'چهارمین مرحله',
        'پنجمین مرحله',
        'ششمین مرحله',
        'موفق شدید'
    ];

    $('#stepName').html(stepText[currentSteps-1]);

}

function storeData(){
    openLoading();

    let data = {};
    let featureName;

    data['kindPlaceId'] = selectedCategory['id'];
    data['name'] = $('#name').val();
    data['cityId'] = $('#cityId').val();
    data['stateId'] = $('#state').val();
    data['address'] = $('#address').val();
    data['lat'] = $('#lat').val();
    data['lng'] = $('#lng').val();
    data['phone'] = $('#phone').val();
    data['fixPhone'] = $('#fixPhone').val();
    data['email'] = $('#email').val();
    data['website'] = $('#website').val();
    data['description'] = $('#placeDescription').val();

    switch(selectedCategory['kind']){
        case 'atraction':
            featureName = 'amakenFeature[]';
            break;
        case 'restaurant':
            featureName = 'restaurantFeature[]';
            data['restaurantKind'] = $('#restaurantKind').val();
            break;
        case 'hotel':
            featureName = 'hotelFeature[]';
            data['hotelKind'] = $('#hotelKind').val();
            data['hotelStar'] = $('#hotelStar').val();
            break;
        case 'boomgardy':
            featureName = 'boomgardyFeature[]';
            data['room_num'] = $('#room_num').val();
            break;
        case 'soghat':
            featureName = 'soghatFeatures[]';
            data['eatable'] = 1;
            data['size'] = $('input[name="sizeSoghat"]:checked').val();
            data['weight'] = $('input[name="weiSoghat"]:checked').val();
            data['price'] = $('input[name="priceSoghat"]:checked').val();
            break;
        case 'sanaye':
            featureName = 'sanayeFeature[]';
            data['eatable'] = 0;
            data['size'] = $('input[name="sizeSanaye"]:checked').val();
            data['weight'] = $('input[name="weiSanaye"]:checked').val();
            data['price'] = $('input[name="priceSanaye"]:checked').val();
            break;
        case 'ghazamahali':
            featureName = 'foodFeatures[]';
            data['kind'] = $('#foodKind').val();
            let material = [];
            for(let i = 1; i <= nowMaterialRow; i++){
                let mat = [];
                mat[0] = $("#materialName_" + i).val();
                mat[1] = $("#materialVol_" + i).val();
                material.push(mat);
            }
            data['material'] = material;
            data['recipes'] = $('#recipes').val();
            data['hotFood'] = $('input[name="hotFood"]:checked').val();
            break;
    }

    vals = $("input[name='" + featureName + "']").map(function(){
        return [$(this).is(":checked") ? $(this).val() : '-'];
    }).get();
    data['features'] = [];
    vals.forEach(item => {
        if(item != '-')
            data['features'].push(item);
    });

    data = JSON.stringify(data);

    $.ajax({
        type: 'POST',
        url : storeAddPlaceByUserUrl,
        data: {
            _token: csrfTokenGlobal,
            data: data
        },
        complete: closeLoading,
        success: response => {
            if(response.status == 'ok'){
                newPlaceId = response.result;
                doChangeStep(1);
            }
            else
                console.log(response.status);
        },
    });

}

function checkStep2(){
    let nameElement = $('#name');
    let cityIdElement = $('#cityId');

    let name = nameElement.val();
    let city = cityIdElement.val();
    let error = true;
    let errorText = '';

    if(name.trim().length == 0) {
        nameElement.parent().css('background', '#ffafaf');
        error = false;
    }
    else
        nameElement.parent().css('background', '#ebebeb');

    if(city == 0){
        cityIdElement.parent().css('background', '#ffafaf');
        error = false;
    }
    else
        cityIdElement.parent().css('background', '#ebebeb');

    if(isPlace){
        let lat = $('#lat').val();
        let lng = $('#lng').val();
        let address = $('#address').val();

        if(address.trim().length == 0){
            $('#address').css('background', '#ffafaf');
            error = false;
        }
        else
            $('#address').css('background', '#ebebeb');

        if(lat == 0 || lng == 0){
            openWarning('محل را بر روی نقشه مشخص کنید');
            error = false;
        }

        if(selectedCategory['id'] == 3 || selectedCategory['id'] == 4 || selectedCategory['id'] == 12){
            let fixPhone = $('#fixPhone').val();
            if(fixPhone.trim().length == 0){
                $('#fixPhone').parent().css('background', '#ffafaf');
                error = false;
            }
            else
                $('#fixPhone').parent().css('background', '#ebebeb');
        }
    }

    return error;
}

function checkStep3(){
    if(selectedCategory['id'] == 12){
        let room_num = $('#room_num').val();
        if(room_num == 0 || room_num == null){
            openWarning('تعداد اتاق ها را مشخص کنید.');
            return false;
        }
    }
    if(selectedCategory['id'] == 4){
        let kind = $('#hotelKind').val();
        if(kind == 0){
            openWarning('نوع اقامتگاه خود را مشخص کنید.');
            return false;
        }
    }
    if(selectedCategory['id'] == 11){
        let haveMaterial = 0;
        for(let i = 1; i <= nowMaterialRow; i++){
            let mat = [];
            mat[0] = $("#materialName_" + i).val();
            mat[1] = $("#materialVol_" + i).val();

            if(mat[0].trim().length > 0 && mat[1].trim().length > 0)
                haveMaterial++;
        }
        if(haveMaterial == 0){
            openWarning('پر کردن مواد لازم برای غذا الزامی است.');
            return false;
        }


        let recipes = $('#recipes').val();
        if(recipes.trim().length < 2){
            openWarning('پر کردن دستور پخت غذا الزامی است.');
            return false;
        }
    }

    return true;

}

function createInputPlace(){
    $('.inputBody').css('display', 'none');
    if(selectedCategory['id'] == 10)
        $(`.inputBody_${selectedCategory['id']}_${selectedCategory['icon']}`).css('display', 'block');
    else
        $(`.inputBody_${selectedCategory['id']}`).css('display', 'block');
}

function changHotelKind(_value){
    let show = _value == 1 ? 'block' : 'none';
    $('#hotelRate').css('display', show);
}

function changeMaterialName(_element, _num){
    let value = $(_element).val();
    $(`#materialVol_${_num}`).attr('placeholder', `مقدار ${value}`);
}

function addNewRow(_num){
    if(nowMaterialRow == _num){
        let name = $('#materialName_' + _num).val();
        let vol = $('#materialVol_' + _num).val();
        if(name.trim().length > 0 && vol.trim().length > 0){
            nowMaterialRow++;
            numMaterialRow++;
            let text = `<div class="row" style="display: flex; justify-content: space-around; direction: ltr">
                        <div class="matInputTopDiv">
                            <div class="stepInputBox ">
                                <input class="stepInputBoxInput stepInputBoxMat" id="materialVol_${numMaterialRow}" style="text-align: right; padding-right: 10px;" placeholder="مقدار" onchange="addNewRow(${numMaterialRow})">
                            </div>
                        </div>
                        <div class="matInputTopDiv">
                            <div class="stepInputBox ">
                                <input class="stepInputBoxInput stepInputBoxMat" id="materialName_${numMaterialRow}" style="text-align: right; padding-right: 10px;" placeholder="چه چیزی نیاز است" onkeyup="changeMaterialName(this, ${numMaterialRow})" onchange="addNewRow(${numMaterialRow})">
                            </div>
                        </div>
                    </div>`;

            $('#materialRow').append(text);
        }
    }

}

function addPhotoInMobile(input){
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            formData = new FormData();
            formData.append("_token", csrfTokenGlobal);
            formData.append("id", newPlaceId);
            formData.append("pic", input.files[0]);

            $.ajax({
                type: 'post',
                url : uploadPicForAddPlaceByUserUrl,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response){
                    if(response.status == 'ok')
                        createPlacePicCard(response, file);

                    $(input).val('');
                    $(input).files = null;
                }
            });

        };

        reader.readAsDataURL(input.files[0]);
    }
}

function stepLog(_step){
    $.ajax({
        type: 'POST',
        url: stepLogAddPlaceByUserUrl,
        data: {
            _token: csrfTokenGlobal,
            step: _step
        },
        success: function(){},
        error: function(){}
    })
}

function createPlacePicCard(response, file){
    let text = `<div class="step6picBox">
                  <div class="step6pic">
                    <div class="deletedSlid">
                         <button onclick="deleteThisPic(this, '${response.result}' )" class="btn btn-danger">حذف تصویر</button>
                    </div>
                    <img src="${file.dataURL}" style="max-height: 100%; max-width: 100%;">
                  </div>
                  <div class="step6picText">نام عکس</div>
                </div>`;
    $(text).insertBefore($('#addNewPic'));
}
