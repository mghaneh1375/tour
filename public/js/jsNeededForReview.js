$(document).ready(function(){

    $(".placeStyle").click(function () {
        selectedPlaceStyle = $(this).attr('data-val');
        $(".placeStyle").removeClass("selected");
        $(this).addClass('selected');
    });

    //getComment();

    $(".seasonTrip").click(function () {
        selectedSeasonTrip = $(this).attr('data-val');
        $(".seasonTrip").removeClass("selected");
        $(this).addClass('selected');
    });
    
    $("#close-but").click(function(){
        $("#add-photo").hide();
        $(".ui_backdrop").hide();
        $("#laws-box").hide();
    });

    $("#photoUploadTipsLink").click(function(){

        if($("#laws-box").is(":hidden")){
            $("#laws-box").show();

        }else{
            $("#laws-box").hide();
        }
    });

    $("#add-picture-but").click(function(){
        $("#add-photo").show();
        $(".ui_backdrop").show();
    });

    $("#close-laws").click(function(){
        $("#laws-box").hide();
    });

    $("#drop-area").on('dragenter', function (e){
        e.preventDefault();
        $(this).css('background', '#BBD5B8');
    });

    $("#drop-area").on('dragover', function (e){
        e.preventDefault();
    });

    $("#drop-area").on('drop', function (e){
        $(this).css('background', '#D8F9D3');
        e.preventDefault();
        var image = e.originalEvent.dataTransfer.files;
        createFormData(image);
    });
});

function sendComment(status) {

    $("#errMsg").empty();

    if($("#ReviewTitle").val() == "") {
        $("#errMsg").append("عنوان نقد خود را مشخص کنید");
        return;
    }

    if($("#ReviewText").val() == "") {
        $("#errMsg").append("متن نقد خود را مشخص کنید");
        return;
    }

    if($("#ReviewText").val().length < 500) {
        $("#errMsg").append("متن نقد شما باید حداقل 500 کاراکتر باشد");
        return;
    }

    if(selectedPlaceStyle == -1) {
        $("#errMsg").append("چگونگی بازدید مکان خود را مشخص کنید");
        return;
    }

    if($("#src").val() == -1) {
        $("#errMsg").append("مبدا سفر خود را مشخص کنید");
        return;
    }

    if(selectedSeasonTrip == -1) {
        $("#errMsg").append("فصل سفر خود را مشخص کنید");
        return;
    }

    $.ajax({
        type: 'post',
        url: sendCommentDir,
        data: {
            'placeId': placeId,
            'kindPlaceId': kindPlaceId,
            'reviewTitle': $("#ReviewTitle").val(),
            'reviewText': $("#ReviewText").val(),
            'placeStyle': selectedPlaceStyle,
            'src': $("#src").val(),
            'seasonTrip': selectedSeasonTrip,
            'status': status
        },
        success: function (response) {
            if(response == "-1") {
                $("#errMsg").append("امتیاز خود به مکان را مشخص کنید");
                return;
            }
            if(response == "-2") {
                $("#errMsg").append("عنوان نقد خود را مشخص کنید");
                return;
            }
            if(response == "-3") {
                $("#errMsg").append("متن نقد خود را مشخص کنید");
                return;
            }
            if(response == "-4") {
                $("#errMsg").append("چگونگی بازدید مکان خود را مشخص کنید");
                return;
            }
            if(response == "-5") {
                $("#errMsg").append("مبدا سفر خود را مشخص کنید");
                return;
            }
            if(response == "-7") {
                $("#errMsg").append("مبدا سفر معتبر نمی باشد");
                return;
            }
            if(response == "-6") {
                $("#errMsg").append("فصل سفر خود را مشخص کنید");
                return;
            }
            if(response == "ok") {
                $("#errMsg").append("نقد شما با موفقیت اضافه گردید و پس از بررسی نمایش داده می شود.");
            }
        }
    });

}

function deleteUserPicFromComment() {
    $.ajax({
        type: 'post',
        url: deleteUserPicFromCommentDir,
        data: {
            'placeId': placeId,
            'kindPlaceId': kindPlaceId
        },
        success: function (response) {
            if(response == "ok")
                getComment();
        }
    })
}

function searchForCity() {

    if($("#src").val().length < 2) {
        $("#result").empty();
        return;
    }
    
    $.ajax({
        type: 'post',
        url: searchForCityDir,
        data: {
            'key': $("#src").val()
        },
        success: function (response) {

            $("#result").empty();
            if(response.length != 0) {
                response = JSON.parse(response);
                newElement = "";
                for(i = 0; i < response.length; i++) {
                    newElement += "<p style='cursor: pointer' onclick='setCityName(\"" + response[i].cityName + "\")'>" + response[i].cityName + " در " + response[i].stateName + "</p>";
                }

                $("#result").append(newElement);
            }

        }
    });

}

function setCityName(cityName) {
    if(cityName != "")
        $("#src").val(cityName);
    $("#result").empty();
}

function getComment() {
    $.ajax({
        type: 'post',
        url: getCommentDir,
        data: {
            'placeId': placeId,
            'kindPlaceId': kindPlaceId
        },
        success: function (response) {
            $("#close_btn").empty();
            response = JSON.parse(response);
            $("#ReviewTitle").val(response.reviewTitle);
            $("#ReviewText").val(response.reviewText);
            $("#src").val(response.src);
            selectedSeasonTrip = response.seasonTrip;
            $(".seasonTrip").removeClass("selected");
            $("#seasonTrip" + selectedSeasonTrip).addClass('selected');
            selectedPlaceStyle = response.placeStyle;
            $(".placeStyle").removeClass("selected");
            $("#placeStyle_" + selectedPlaceStyle).addClass('selected');
            if(response.reviewPic != -1) {
                $("#userPhoto").attr('src', response.reviewPic);
                $("#close_btn").append("<div onclick='deleteUserPicFromComment()' style='cursor: pointer; color: #963019 !important;position: absolute;top: -18px;right: 0; background: url(\'" + homeURL + "/images/closepic.png\');width: 35px;display: block;height: 35px;'></div>");
                $("#userPhoto").show();
            }
            else {
                $("#userPhoto").attr('src', '');
                $("#userPhoto").hide();
            }
        }
    });
}

function createFormData(image) {
    var formImage = new FormData();
    formImage.append('userImage', image[0]);
    uploadFormData(formImage);
}

function uploadFormData(formData)  {
    $.ajax({
        url: "upload_image.php",
        type: "POST",
        data: formData,
        contentType:false,
        cache: false,
        processData: false,
        success: function(data){
            $('#drop-area').html(data);
        }
    });
}

function ansToQuestion(id, ans) {
    $(".jfy_cloud_" + id).removeClass("selected");
    switch (ans) {
        case 'yes':
            $("#yes_question_" + id).addClass("selected");
            break;
        case 'no':
            $("#no_question_" + id).addClass("selected");
            break;
        default:
            $("#noIdea_question_" + id).addClass("selected");
    }

    $.ajax({
        type: 'post',
        url: survey,
        data: {
            'placeId': placeId,
            'kindPlaceId': kindPlaceId,
            'ans': ans,
            'questionId': id
        }
    });
}

function showAns(id) {

    $.ajax({
        type: 'post',
        url: getSurvey,
        data: {
            'placeId': placeId,
            'kindPlaceId': kindPlaceId,
            'questionId': id
        },
        success: function (response) {

            $(".jfy_cloud_" + id).removeClass("selected");
            switch (response) {
                case 'yes':
                    $("#yes_question_" + id).addClass("selected");
                    break;
                case 'no':
                    $("#no_question_" + id).addClass("selected");
                    break;
                case "noIdea":
                    $("#noIdea_question_" + id).addClass("selected");
            }
        }
    });
}

function writeFileName(val) {
    $("#fileName").empty();
    $("#fileName").append(val);
    $("#submitPhotoDiv").css('visibility', 'visible');
}