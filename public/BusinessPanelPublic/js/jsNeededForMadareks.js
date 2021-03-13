var shareHolderCardHtmlSample = $('#userShareHolderCardHtmlSample').html();
$('#userShareHolderCardHtmlSample').remove();

var numOfMembersElement = $("#numOfMembers");

function render_a_form(idx) {
    var newElement = shareHolderCardHtmlSample;
    newElement = newElement.replace(new RegExp('##idx##', 'g'), idx);
    newElement = newElement.replace(new RegExp('##arr_nums##', 'g'), arr_nums[idx]);

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
        console.log(idx);
        $.ajax({
            type: 'delete',
            url: `${deleteMadarekBaseUrl}/${data.id}?`,
            data: { idx },
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

                    numOfMembersElement.val(counter);
                }
                else
                    showSuccessNotifiBP(res.msg, 'left', '#ac0020');
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

        numOfMembersElement.val(counter);
    }
}

function renewTitles() {

    var queue = [];
    var counter2 = 0;

    $(".cards").each(() => queue[counter2++] = $(this).attr('data-val'));

    var counter = 0;
    for (var i = 0; i < busy_idx.length; i++) {
        if(busy_idx[i])
            $("#title_" + queue[counter]).text('عضو ' + arr_nums[counter++]);
    }
}

numOfMembersElement.on("change", function () {
    changeNum($(this).val());
});

$(document).on('click','.delete', function(){
    removeUser($(this).attr('data-val'));
    renewTitles();
});
