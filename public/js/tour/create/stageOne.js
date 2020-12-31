var tourKind = [];
var tourDifficult = [0];
var tourDifficultChoose = [0];
var srcCity = [];
var dest;

function changeKindColorToHover(_i){
    document.getElementById('tourKind' + _i).style.backgroundColor = 'rgb(77, 199, 188)';
}

function changeColorToLeave(_i) {
    document.getElementById('tourKind' + _i).style.backgroundColor = '';
}

function chooseTourKind(_id){

    if(tourKind.includes(_id)){
        document.getElementById('tourKind' + _id).classList.remove('chooseTourKind');
        index = tourKind.indexOf(_id);
        tourKind[index] = 'none';
    }
    else{
        document.getElementById('tourKind' + _id).classList.add('chooseTourKind');
        if(tourKind.includes('none')){
            index = tourKind.indexOf('none');
            tourKind[index] = _id;
        }
        else{
            tourKind.push(_id);
        }
    }

    document.getElementById('kind').value = JSON.stringify(tourKind);
}

function chooseDifficult(_i, _id, _type){

    if(_type == 0){
        var firstZero = 0;
        var end = 1;

        for(i = 1; i < tourDifficult.length; i++){
            if(firstZero == 0 && tourDifficult[i] == 0)
                firstZero = i;

            if(tourDifficult[i] == _id){
                document.getElementById('tourDifficult' + tourDifficultChoose[i]).classList.remove('chooseTourKind');
                tourDifficult[i] = 0;
                tourDifficultChoose[i] = 0;
                end = 0;
            }
        }

        if(firstZero == 0 && end){
            document.getElementById('tourDifficult' + _i).classList.add('chooseTourKind');
            tourDifficult.push(_id);
            tourDifficultChoose.push(_i);
        }
        else if(end){
            tourDifficult[firstZero] = _id;
            tourDifficultChoose[firstZero] = _i;
            document.getElementById('tourDifficult' + _i).classList.add('chooseTourKind');
        }

    }
    else{
        // for first time
        if(tourDifficult[0] == 0){
            tourDifficult[0] = _id;
            tourDifficultChoose[0] = _i;
            document.getElementById('tourDifficult'+_i).classList.add('chooseTourKind');
        }
        else{
            document.getElementById('tourDifficult' + tourDifficultChoose[0]).classList.remove('chooseTourKind');
            tourDifficult[0] = _id;
            tourDifficultChoose[0] = _i;
            document.getElementById('tourDifficult'+_i).classList.add('chooseTourKind');
        }
    }
}


function chooseSrcCityModal(){
    $('#chooseSrcModal').toggle();
    document.getElementById('srcCityShow').innerHTML = '';
    document.getElementById('srcCityInput').value = '';
}

function findCity(_value){
    $.ajax({
        type: 'GET',
        url: findCityWithState+'?stateId='+_value,
        success: response => {
            if(response.status == 'ok')
                city = response.result;
        }
    });
}

function chooseCity(_value, _div, _src){
    document.getElementById(_div).innerHTML = '';
    var text = '';

    if(_value != '' && _value != ' '){
        var limit = 0;

        for(i = 0; i < city.length && limit < 10; i++){
            cityName = city[i].name;
            if(cityName.search(_value) != -1){
                cityId = city[i].id;
                text += '<div onclick="fillSrcCity('+ _src +', ' + cityId + ')" style="cursor: pointer;">' + city[i].name + '</div>';
                limit++;
            }
        }

        document.getElementById(_div).innerHTML = text;
    }
}

function fillSrcCity(_src, _value){

    if(_src == 0) {
        for(i = 0; i < city.length; i++){
            if(city[i].id == _value){
                document.getElementById('srcCity').value = city[i].name;
                document.getElementById('srcCityId').value = city[i].id;
                $('#chooseSrcModal').toggle();
            }
        }
    }
}

function srcDest(){
    value = document.getElementById('c01').checked;

    if(value){
        document.getElementById('destDiv').style.display = 'none';
        document.getElementById('mahali').style.display = 'inline-block';
        document.getElementById('shahr').style.display = 'none';
        document.getElementById('destCityId').value = document.getElementById('srcCityId').value;

        if(tourKind.includes(shahr_id)){
            document.getElementById('tourKind' + shahr_id).classList.remove('chooseTourKind');
            index = tourKind.indexOf(shahr_id);
            tourKind[index] = 'none';
        }

        document.getElementById('tourKind' + mahali_id).classList.add('chooseTourKind');

        if(tourKind.includes('none')){
            index = tourKind.indexOf('none');
            tourKind[index] = mahali_id;
        }
        else
            tourKind.push(mahali_id);

        document.getElementById('kind').value = JSON.stringify(tourKind);
    }
    else{
        document.getElementById('destDiv').style.display = 'inline-block';
        document.getElementById('mahali').style.display = 'none';
        document.getElementById('shahr').style.display = 'inline-block';
        document.getElementById('destCityId').value = 0;

        if(tourKind.includes(mahali_id)){
            document.getElementById('tourKind' + mahali_id).classList.remove('chooseTourKind');
            index = tourKind.indexOf(mahali_id);
            tourKind[index] = 'none';
        }
        document.getElementById('kind').value = JSON.stringify(tourKind);

    }
}

function hideSearchDest(){
    setTimeout(function (){
        $('#destinationListTourCreation').hide();
    }, 100);
}

function searchDest(_value){
    $('#destinationListTourCreation').show();
    if(_value != '' && _value != ' ' && _value != '  ') {
        findAllCity(_value);
    }
}

function findAllCity(_value){
    $.ajax({
        type: 'post',
        url : searchForCity,
        data: {
            '_token' : _token,
            'key' : _value
        },
        success: function (response){
            response = JSON.parse(response);
            dest = response;

            var text = '';
            for(i = 0; i < 10 && i < response.length; i++){
                text += '<div onclick="chooseDest(' + response[i].id + ')" style="cursor: pointer">' +
                    '<span>' + response[i].cityName + ' در ' + response[i].stateName + '</span>' +
                    '</div>';
            }
            document.getElementById('destCitySearch').innerHTML = text;
        }
    })
}

function chooseDest(_id){
    for(i = 0; i < dest.length; i++){
        if(dest[i].id == _id){
            document.getElementById('destInput').value = dest[i].cityName + ' در ' + dest[i].stateName;
            document.getElementById('destCityId').value = dest[i].id;
            $('#destinationListTourCreation').hide();
        }
    }
}
