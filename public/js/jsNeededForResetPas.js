
function resetPas(noticePane) {

    if($("#email").val() == "" && $("#phone").val() == "")
        return;

    mode = 2;

    if($("#email").val() != "") {
        mode = 1;
        val = $("#email").val();
    }

    else {
        mode = 2;
        val = $("#phone").val();
    }

    $.ajax({
        type: 'post',
        url: resetPasPath,
        data:{
            'mode' : mode,
            'val' : val
        },
        success: function (response) {

            if(response == "ok")
                $("#" + noticePane).css("visibility", 'visible');
            else {
                $("#msg").empty();
                $("#msg").append(response);
                $("#msg").css("visibility", "visible");
            }
        }
    });
    
}