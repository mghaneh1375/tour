function findHotel(_id){

    for(i = 0; i < city.length; i++){
        if(city[i].id == _id){
            hotelCity = city[i];
            break;
        }
    }

    $.ajax({
        type: 'post',
        url: findHotelURL,
        data: {
            '_token' : _token,
            'cityId' : _id
        },
        success: function(response){
            hotelsList = JSON.parse(response);
        }
    })
}

function showHotelList(_value){
    var text = '';
    hotelInSearch = [];

    if(_value != '' && _value != ' ' && _value != '   ') {
        text += '<li class="searchHover" style="color: blue;"> "' + _value + '"را اضافه کنید.</li>';
        for (i = 0; i < hotelsList.length; i++) {
            if (hotelsList[i].name.includes(_value)) {
                hotelInSearch[hotelInSearch.length] = hotelsList[i];
                text += '<li class="searchHover" onclick="chooseHotel(' + hotelsList[i].id + ')">' + hotelsList[i].name + '</li>';
            }
        }
        document.getElementById('hotelResult').innerHTML = text;
    }
    else{
        document.getElementById('hotelResult').innerHTML = '';
    }
}

function chooseHotel(_id){

    var text = '';
    var mainText = '';
    var index;

    for(i = 0; i < hotelInSearch.length; i++){
        if(hotelInSearch[i].id == _id){

            index = hotelChoose.length;
            hotelChoose[hotelChoose.length] = hotelInSearch[i].id;
            hotelChooseList[hotelChooseList.length] = hotelInSearch[i];
            roomKind[roomKind.length] = '0';
            roomCost[roomCost.length] = '0';
            roomPack[roomPack.length] = '0';

            document.getElementById('hotelList').value = JSON.stringify(hotelChoose);

            text = '<div id="chooseHotel_' + index + '_' + hotelInSearch[i].id + '"><div class="inputBoxGeneralInfo inputBox InlineTourInputBoxes position-relative">\n' +
                '<div class="inputBoxTextGeneralInfo inputBoxText width-30per">\n' +
                '<div>\n' +
                'استان\n' +
                '</div>\n' +
                '</div>\n' +
                '<input class="inputBoxInput text-align-right width-70per pd-rt-10" type="text" value="' + chooseState.name + '" readonly>\n' +
                '</div>\n' +
                '<div class="inputBoxGeneralInfo inputBox InlineTourInputBoxes position-relative">\n' +
                '<div class="inputBoxTextGeneralInfo inputBoxText width-30per">\n' +
                '<div>\n' +
                'شهر\n' +
                '</div>\n' +
                '</div>\n' +
                '<input class="inputBoxInput text-align-right width-70per pd-rt-10" type="text" value="' + hotelCity.name + '" readonly>\n' +
                '</div>\n' +
                '<div class="inputBoxGeneralInfo inputBox InlineTourInputBoxes position-relative">\n' +
                '<div class="inputBoxTextGeneralInfo inputBoxText width-30per">\n' +
                '<div>\n' +
                'نام مکان\n' +
                '</div>\n' +
                '</div>\n' +
                '<input class="inputBoxInput text-align-right width-70per pd-rt-10" type="text" value="' + hotelInSearch[i].name + '" readonly>\n' +
                '</div>\n' +
                '<div class="popUpButtons display-inline-block">\n' +
                '<div class="display-inline-block">\n' +
                '</div>\n' +
                '</div></div>';

            mainText =  '                        <div id="mainShowHotel_' + index  + '_' + hotelInSearch[i].id + '" class="tourOccupationDetailsTourCreation mg-tp-15 col-xs-12">\n' +
                '                            <div class="col-xs-2">\n' +
                '                                <img src="' + hotelInSearch[i].pic + '" style="width: 100%;">\n' +
                '                            </div>\n' +
                '                            <div class="col-xs-2 pd-0 mg-tp-20">\n' +
                '                                <b class="fullwidthDiv font-size-20">' + hotelInSearch[i].name + '</b>\n' +
                '                                <span class="tourOccupationGradeTitle">درجه هتل:</span>\n' +
                '                                <span class="tourOccupationGrade">' + hotelInSearch[i].rate + '</span>\n' +
                '                            </div>\n' +
                '                            <div class="inputBox col-xs-2 mg-30-10" id="">\n' +
                '                                <div class="inputBoxText">\n' +
                '                                    <div>\n' +
                '                                        نوع اتاق\n' +
                '                                        <span>*</span>\n' +
                '                                    </div>\n' +
                '                                </div>\n' +
                '                                <input class="inputBoxInput styled-select" id="roomKind_' + index + '" type="text" placeholder="مدل اتاق" onkeyup="changeroomInfo(' + index + ', \'kind\')">\n' +
                '                            </div>\n' +
                '                            <div class="mg-tp-20 mg-rt-10 col-xs-2 pd-0">\n' +
                '                                <div class="inputBox full-width" id="">\n' +
                '                                    <div class="inputBoxText">\n' +
                '                                        <div>\n' +
                '                                            قیمت\n' +
                '                                            <span>*</span>\n' +
                '                                        </div>\n' +
                '                                    </div>\n' +
                '                                    <input class="inputBoxInput" type="number" id="roomCost_' + index + '" placeholder="ریال" onkeyup="changeroomInfo(' + index + ', \'cost\')">\n' +
                '                                </div>\n' +
                '                                <div class="inboxHelpSubtitle">قیمت اقامتگاه</div>\n' +
                '                            </div>\n' +
                '                           <div class="mg-tp-20 mg-rt-10 col-xs-2 pd-0">\n' +
                '                                <div class="inputBox full-width" id="">\n' +
                '                                    <div class="inputBoxText">\n' +
                '                                        <div>\n' +
                '                                            پک\n' +
                '                                            <span>*</span>\n' +
                '                                        </div>\n' +
                '                                    </div>\n' +
                '                                    <select class="inputBoxInput" id="roomPack_' + index + '" onchange="changeroomInfo(' + index + ', \'pack\')">' +
                '                                           <option value="a">a</option>' +
                '                                           <option value="b">b</option>' +
            '                                               <option value="c">c</option>' +
                '                                           <option value="d">d</option>' +
            '                                       </select>\n' +
                '                                </div>\n' +
                '                            </div>\n' +
                '                            <button type="button" class="tourOccupationDetailsBtn copyBtnTourCreation" onclick=copyHotel(' + index + ')>\n' +
                '                                <img src="' + copyPic + '">\n' +
                '                            </button>\n' +
                '                            <button class="tourOccupationDetailsBtn deleteBtnTourCreation" onclick="cancelHotel(' + index + ', ' + hotelInSearch[i].id + ')">\n' +
                '                                <img src="' + deletePic + '">\n' +
                '                            </button>\n' +
                '                        </div>\n';

            $('#hotelChoose').append(text);
            $('#hotelMainList').append(mainText);

            break;
        }
    }
}

function cleanHotelSearch(){
    document.getElementById('hotelResult').innerHTML = '';
    document.getElementById('inputSearchHotel').value = '';
}

function cancelHotel(_index, _id){

    hotelChoose[_index] = 0;
    hotelChooseList[_index] = 0;
    roomKind[_index] = '0';
    roomCost[_index] = '0';
    roomPack[_index] = '0';

    $('#mainShowHotel_' + _index + '_' + _id).remove();
    $('#chooseHotel_' + _index + '_' + _id).remove();

    document.getElementById('hotelList').value = JSON.stringify(hotelChoose);

}

function copyHotel(_index){
    let index = hotelChoose.length;
    let id = hotelChoose[_index];

    hotelChoose[index] = hotelChoose[_index];
    hotelChooseList[index] = hotelChooseList[_index];
    roomKind[index] = '0';
    roomCost[index] = '0';
    roomPack[index] = 'a';

    document.getElementById('hotelList').value = JSON.stringify(hotelChoose);

    mainText =  '                        <div id="mainShowHotel_' + index  + '_' + hotelChooseList[index].id + '" class="tourOccupationDetailsTourCreation mg-tp-15 col-xs-12">\n' +
        '                            <div class="col-xs-2">\n' +
        '                                <img src="' + hotelChooseList[index].pic + '" style="width: 100%;">\n' +
        '                            </div>\n' +
        '                            <div class="col-xs-2 pd-0 mg-tp-20">\n' +
        '                                <b class="fullwidthDiv font-size-20">' + hotelChooseList[index].name + '</b>\n' +
        '                                <span class="tourOccupationGradeTitle">درجه هتل:</span>\n' +
        '                                <span class="tourOccupationGrade">' + hotelChooseList[index].rate + '</span>\n' +
        '                            </div>\n' +
        '                            <div class="inputBox col-xs-2 mg-30-10" id="">\n' +
        '                                <div class="inputBoxText">\n' +
        '                                    <div>\n' +
        '                                        نوع اتاق\n' +
        '                                        <span>*</span>\n' +
        '                                    </div>\n' +
        '                                </div>\n' +
        '                                <input class="inputBoxInput styled-select" id="roomKind_' + index + '" type="text" placeholder="مدل اتاق" onkeyup="changeroomInfo(' + index + ', \'kind\')">\n' +
        '                            </div>\n' +
        '                            <div class="mg-tp-20 mg-rt-10 col-xs-2 pd-0">\n' +
        '                                <div class="inputBox full-width" id="">\n' +
        '                                    <div class="inputBoxText">\n' +
        '                                        <div>\n' +
        '                                            قیمت\n' +
        '                                            <span>*</span>\n' +
        '                                        </div>\n' +
        '                                    </div>\n' +
        '                                    <input class="inputBoxInput" type="number" id="roomCost_' + index + '" placeholder="ریال" onkeyup="changeroomInfo(' + index + ', \'cost\')">\n' +
        '                                </div>\n' +
        '                                <div class="inboxHelpSubtitle">قیمت اقامتگاه</div>\n' +
        '                            </div>\n' +
        '                           <div class="mg-tp-20 mg-rt-10 col-xs-2 pd-0">\n' +
        '                                <div class="inputBox full-width" id="">\n' +
        '                                    <div class="inputBoxText">\n' +
        '                                        <div>\n' +
        '                                            پک\n' +
        '                                            <span>*</span>\n' +
        '                                        </div>\n' +
        '                                    </div>\n' +
        '                                    <select class="inputBoxInput" id="roomPack_' + index + '" onchange="changeroomInfo(' + index + ', \'pack\')">' +
        '                                           <option value="a">a</option>' +
        '                                           <option value="b">b</option>' +
        '                                               <option value="c">c</option>' +
        '                                           <option value="d">d</option>' +
        '                                       </select>\n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '                            <button type="button" class="tourOccupationDetailsBtn copyBtnTourCreation" onclick=copyHotel(' + index + ')>\n' +
        '                                <img src="' + copyPic + '">\n' +
        '                            </button>\n' +
        '                            <button class="tourOccupationDetailsBtn deleteBtnTourCreation" onclick="cancelHotel(' + index + ', ' + hotelChooseList[index].id + ')">\n' +
        '                                <img src="' + deletePic + '">\n' +
        '                            </button>\n' +
        '                        </div>\n';

    $('#mainShowHotel_' + _index + '_' + id).after(mainText);
}

function isHotelFunc(_value){
    if(_value == 1){
        document.getElementById('isHotelDiv').style.display = 'block';
    }
    else{
        document.getElementById('isHotelDiv').style.display = 'none';
    }
}

function changeroomInfo(_index, _kind){
    if(_kind == 'kind'){
        roomKind[_index] = document.getElementById('roomKind_' + _index).value;
    }
    else if(_kind == 'cost'){
        roomCost[_index] = document.getElementById('roomCost_' + _index).value;
    }
    else{
        roomPack[_index] = document.getElementById('roomPack_' + _index).value;
    }

}

function deleteFeature(_index){
    $('#features_' + _index).remove();
}
function newFeature(){
    var text = '                        <div class="row featuresRow" id="features_' + featuersIndex + '">\n' +
        '                            <div class="inputBox float-right col-xs-2" id="">\n' +
        '                                <input id="featureName_' + featuersIndex + '" name="featureName[]" class="inputBoxInput moreFacilityInputs" type="text" placeholder="نام">\n' +
        '                            </div>\n' +
        '                            <div class="inputBox float-right col-xs-3 mg-rt-10" id="">\n' +
        '                                <input id="featureDesc_' + featuersIndex + '" name="featureDesc[]" class="inputBoxInput moreFacilityInputs" type="text" placeholder="توضیحات" maxlength="250">\n' +
        '                            </div>\n' +
        '                            <div class="inputBox float-right col-xs-2 mg-rt-10" id="">\n' +
        '                                <div class="select-side">\n' +
        '                                    <i class="glyphicon glyphicon-triangle-bottom"></i>\n' +
        '                                </div>\n' +
        '                                <select id="featureGroup_' + featuersIndex + '" name="featureGroup[]"  class="inputBoxInput moreFacilityInputs styled-select">\n' +
        '                                    <option value="0">هم‌گروهی</option>\n' +
        '                                    <option value="a">a</option>\n' +
        '                                    <option value="b">b</option>\n' +
        '                                    <option value="c">c</option>\n' +
        '                                    <option value="d">d</option>\n' +
        '                                    <option value="e">e</option>\n' +
        '                                    <option value="f">f</option>\n' +
        '                                    <option value="g">g</option>\n' +
        '                                    <option value="h">h</option>\n' +
        '                                    <option value="i">i</option>\n' +
        '                                    <option value="j">j</option>\n' +
        '                                </select>\n' +
        '                            </div>\n' +
        '                            <div class="inputBox float-right col-xs-3 mg-rt-10 relative-position" id="">\n' +
        '                                <input id="featureCost_' + featuersIndex + '" name="featureCost[]" class="inputBoxInput moreFacilityInputs" type="number" placeholder="ریال">\n' +
        '                                <div class="inboxHelpSubtitle" id="subtitleMoreFacility">\n' +
        '                                    میزان افزایش قیمت را وارد نمایید.\n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '                            <div class="col-xs-2" style="text-align: left; position: relative">\n' +
        '                                <button type="button" class="tourMoreFacilityDetailsBtn deleteBtnTourCreation" style="position: relative; bottom: 0px; left: 0px; top: 0px" onclick="deleteFeature(' + featuersIndex + ')">\n' +
        '                                    <img src="' + deletePic + '">\n' +
        '                                </button>\n' +
        '                            </div>\n' +
        '                        </div>\n';

    $('#featuresDiv').append(text);
    featuersIndex++;
}

function addNewDisCount(_index){
    disCountTo[disCountIndex] = 0;
    disCountFrom[disCountIndex] = 0;

    var text =  '                        <div id="groupDiscount_' + disCountIndex + '" class="col-xs-12 pd-0">\n' +
        '                            <div class="inputBox discountLimitationWholesale float-right">\n' +
        '                                <div class="inputBoxText">\n' +
        '                                    <div>\n' +
        '                                        بازه‌ی تخفیف\n' +
        '                                        <span>*</span>\n' +
        '                                    </div>\n' +
        '                                </div>\n' +
        '                                <input class="inputBoxInput" name="disCountFrom[]" id="disCountFrom_' + disCountIndex + '" type="number" placeholder="از" onkeyup="checkDiscount(' + disCountIndex + ', this.value, 0)" onchange="checkAllDiscount()">\n' +
        '                                <div class="inputBoxText">\n' +
        '                                    <div>\n' +
        '                                        الی\n' +
        '                                    </div>\n' +
        '                                </div>\n' +
        '                                <input class="inputBoxInput" name="disCountTo[]" id="disCountTo_' + disCountIndex + '" type="number" placeholder="تا" onkeyup="checkDiscount(' + disCountIndex + ', this.value, 1)" onchange="checkAllDiscount()">\n' +
        '                                <div class="inputBoxText">\n' +
        '                                    <div>\n' +
        '                                        درصد تخفیف\n' +
        '                                        <span>*</span>\n' +
        '                                    </div>\n' +
        '                                </div>\n' +
        '                                <input class="inputBoxInput no-border-imp" name="disCountCap[]" id="disCountCap_' + disCountIndex + '" type="text" placeholder="عدد">\n' +
        '                            </div>\n' +
        '                            <div class="inline-block mg-tp-12 mg-rt-10">\n' +
        '                                <button type="button" id="submitDisCount_' + disCountIndex + '" class="wholesaleDiscountLimitationBtn verifyBtnTourCreation" onclick="addNewDisCount(' + disCountIndex + ')">\n' +
        '                                    <img src="' + approvePic + '">\n' +
        '                                </button>\n' +
        '                                <button id="deleteDisCount_' + disCountIndex + '" type="button" class="wholesaleDiscountLimitationBtn deleteBtnTourCreation" onclick="deleteDisCount(' + disCountIndex + ')" style="display: none;">\n' +
        '                                    <img src="' + deletePic + '">\n' +
        '                                </button>\n' +
        '                            </div>\n' +
        '                        </div>\n';
    document.getElementById('submitDisCount_' + _index).style.display = 'none';
    document.getElementById('deleteDisCount_' + (disCountIndex-1)).style.display = 'block';

    disCountIndex++;
    $('#groupDiscountDiv').append(text);
}

function deleteDisCount(_index){
    disCountTo[_index] = -1;
    disCountFrom[_index] = -1;

    $('#groupDiscount_'+_index).remove();
}

function checkDiscount(_index, _value, _kind){
    var errorIndex = false;

    if(_kind == 1)
        disCountTo[_index] = parseInt(_value);
    else
        disCountFrom[_index] = parseInt(_value) ;


    for(i = 0; i < disCountTo.length && i < disCountFrom.length; i++){
        if(i != _index){
            if(disCountTo[i] != 0 && disCountTo[i] != -1 && disCountFrom[i] != 0 && disCountFrom[i] != -1 ){
                if((_value >= disCountFrom[i] && _value <= disCountTo[i] )){
                    errorIndex = true;
                    break;
                }
            }
        }
    }

    if(errorIndex){
        if(_kind == 1)
            document.getElementById('disCountTo_' + _index).classList.add('errorClass');
        else
            document.getElementById('disCountFrom_' + _index).classList.add('errorClass');

    }
    else{
        if(_kind == 1)
            document.getElementById('disCountTo_' + _index).classList.remove('errorClass');
        else
            document.getElementById('disCountFrom_' + _index).classList.remove('errorClass');

    }
}

function checkAllDiscount(){
    discountError = false;

    for(i = 0; i < disCountTo.length && i < disCountFrom.length; i++){
        if (disCountTo[i] != -1 && disCountFrom[i] != -1) {
            if (disCountFrom[i] == 0 || disCountTo[i] == 0) {
                if (disCountTo[i] == 0) {
                    document.getElementById('disCountTo_' + i).classList.add('errorClass');
                }
                if (disCountFrom[i] == 0) {
                    document.getElementById('disCountFrom_' + i).classList.add('errorClass');
                }
            }
            else if (disCountFrom[i] > disCountTo[i]) {
                document.getElementById('disCountTo_' + i).classList.add('errorClass');
                document.getElementById('disCountFrom_' + i).classList.add('errorClass');
            }
            else {
                var checkErrorTo = false;
                var checkErrorFrom = false;

                for (j = i + 1; j < disCountTo.length && j < disCountFrom.length; j++) {
                    if (disCountTo[j] != 0 && disCountTo[j] != -1 && disCountFrom[j] != 0 && disCountFrom[j] != -1) {
                        if (!checkErrorFrom && disCountFrom[i] >= disCountFrom[j] && disCountFrom[i] <= disCountTo[j]) {
                            document.getElementById('disCountFrom_' + i).classList.add('errorClass');
                            checkErrorFrom = true;
                            discountError = true;
                        }
                        if (!checkErrorTo && disCountTo[i] >= disCountFrom[j] && disCountTo[i] <= disCountTo[j]) {
                            document.getElementById('disCountTo_' + i).classList.add('errorClass');
                            checkErrorTo = true;
                            discountError = true;
                        }
                    }
                }

                if(!checkErrorFrom){
                    document.getElementById('disCountFrom_' + i).classList.remove('errorClass');
                }
                if(!checkErrorTo){
                    document.getElementById('disCountTo_' + i).classList.remove('errorClass');
                }
            }
        }
    }

}

$('#minCost').keyup(function(e){
    document.getElementById('minCostDiv').classList.remove('errorClass');
});
$('#minCapacity').keyup(function(e){
    document.getElementById('minCapacityDiv').classList.remove('errorClass');
});
$('#maxCapacity').keyup(function(e){
    document.getElementById('maxCapacityDiv').classList.remove('errorClass');
});