function render_a_form(idx) {

    var newElement = "";

    newElement += '<div class="cards" data-val="' + idx + '" id="user_' + idx + '">';

    newElement += '<div class="inputLabel" id="inputLabel_title_' + idx + '" style=" background-color: #FFDE9E; padding-right: 30px; margin-top: 30px">';

    newElement += '<div style=" padding: 3px 0 10px 30px; font-size: 15px; width: 100%;">';

    newElement += "<input type='hidden' name='id_" + idx + "' value='-1'>";
    newElement += '<span id="title_' + idx + '" style=" padding: 3px 0 0 30px; font-size: 15px; width: 100%; color: #aa0800;">عضو ' + arr_nums[idx] + '</span>';

    newElement += '</div>';

    newElement += '<span style=" padding: 3px 0 0 30px; font-size: 15px; width: 100%;">نام</span>';

    newElement += '<div style=" width: 100%;">';
    newElement += '<input class="signInInput form-control" type="text" placeholder="نام" id="name_' + idx + '" style="width:80%; display: inline-block; margin: 0 0 0 2%">';
    newElement += '</div></div>';

    newElement += '<div class="inputLabel" id="inputLabel_name_' + idx + '" style=" background-color: #FFDE9E; padding-right: 30px">';

    newElement += '<div style=" padding: 3px 0 10px 30px; font-size: 15px; width: 100%;">';
    newElement += '<span style=" padding: 3px 0 0 30px; font-size: 15px; width: 100%;">سمت</span>';
    newElement += '</div>';

    newElement += '<div style=" width: 100%">';
    newElement += '<select class="signInInput form-control" id="role_' + idx + '" style="width:80%; display: inline-block">';
    newElement += '<option value="1">رئیس هیئت مدیره</option>';
    newElement += '<option value="2">مدیر عامل</option>';
    newElement += '<option value="3">عضو هیئت مدیره</option>';
    newElement += '<option value="4">نایب رئیس هیئت مدیره</option>';
    newElement += '<option value="5">سایر</option>';
    newElement += '</select>';
    newElement += '</div></div>';

    newElement += '<div class="inputLabel" id="inputLabel_nid_' + idx + '" style=" background-color: #FFDE9E; padding-top: 10px; padding-bottom: 10px; padding-right: 30px">';
    newElement += '<div style=" padding: 3px 0 10px 30px; font-size: 15px; width: 100%;">';

    newElement += '<div class="boldDescriptionText" style="color: var(--koochita-green);">تصویر رو و پشت کارت ملی را در این قسمت آپلود نمایید.</div>';
    newElement += '<div id="uploadedSectionMadarek_' + idx +'" class="uploadPicSection" style="background-color: #f1f1f1">';
    newElement += '<div id="showUploadPicsSectionMadarek_' + idx + '" class="showUploadedFiles"></div>';
    newElement += '<div id="uploadPicInfoTextMadarek_' + idx + '" class="uploadPic">';
    newElement += '<label class="labelForClick" for="madarekPics_' + idx + '">کلیک کنید</label>';
    newElement += '</div>';
    newElement += '<input type="file" accept="image/*" id="madarekPics_' + idx + '" style="display: none" onchange="var tmpIdx = initUploader(\'madarek_' + idx + '\', \'showUploadPicsSectionMadarek_' + idx + '\', \'uploadPicInfoTextMadarek_' + idx +'\', 2); if(tmpIdx != -1) uploadPicClickHandler(this, tmpIdx)">';

    newElement += '</div><div style=" width: 100%;">';
    newElement += '<p data-val="' + idx + '" class="delete" style="float: left; color: #2098D1; cursor: pointer">حذف</p>';
    newElement += '</div></div>';

    $("#usersDiv").append(newElement);

}

function changeNum(val) {

    val = parseInt(val);

    var filled = 0;

    for (var i = 0; i < 10; i++) {
        if(busy_idx[i])
            filled++;

        if(filled > val) {
            // alert(filled);
            // alert(val);
            for (var j = i; j < 10; j++) {
                $("#user_" + j).remove();
                busy_idx[j] = false;
            }
        }
    }

    if (filled < val) {
        // alert("heyy1");
        // alert(filled);
        // alert(val);
        for (var i = 0; i < val - filled; i++) {
            for(var j = 0; j < 10; j++) {
                if(!busy_idx[j]) {
                    render_a_form(j);
                    busy_idx[j] = true;
                    break;
                }
            }
        }
    }

    renewTitles();
}

function removeUser(idx) {

    if(id_idx[idx] !== -1) {
        $.ajax({
            type: 'delete',
            url: deleteMadarekBaseUrl + "/" + data.id,
            data: {
                'idx': idx
            },
            success: function (res) {

                if(res.status === "ok") {

                    var uploadersIdx = getIdxInFitImages("madarek_" + idx);
                    uploaders[uploadersIdx][4] = [];

                    $("#user_" + idx).remove();
                    busy_idx[idx] = false;

                    var counter = 0;
                    for (var i = 0; i < 10; i++) {
                        if (busy_idx[i])
                            counter++;
                    }

                    if(counter === 0) {
                        counter = 1;
                        render_a_form(0);
                        busy_idx[0] = true;
                    }

                    $("#numOfMembers").val(counter);
                }
                else
                    showSuccessNotifiBP(res.msg, 'right', '#ac0020');
            },
            error: function (reject) {
                errorAjax(reject);
            }
        });
    }
    else {
        $("#user_" + idx).remove();
        busy_idx[idx] = false;

        var counter = 0;
        for(var i = 0; i < 10; i++) {
            if(busy_idx[i])
                counter++;
        }

        if(counter === 0) {
            counter = 1;
            render_a_form(0);
            busy_idx[0] = true;
        }

        $("#numOfMembers").val(counter);
    }
}

function renewTitles() {

    var queue = [];
    var counter2 = 0;

    $(".cards").each(function () {
        queue[counter2++] = $(this).attr('data-val');
    });

    var counter = 0;
    for (var i = 0; i < busy_idx.length; i++) {
        if(busy_idx[i])
            $("#title_" + queue[counter]).text('عضو ' + arr_nums[counter++]);
    }
}

$("#numOfMembers").on("change", function () {
    changeNum($(this).val());
});

$(document).on('click','.delete',function() {
    removeUser($(this).attr('data-val'));
    renewTitles();
});
