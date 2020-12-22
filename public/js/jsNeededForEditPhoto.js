

function getDefaultPics(containerElement) {

    $("#" + containerElement).empty();
    mode = 0;

    $.ajax({

        type: 'post',
        url: defaultPics,
        data: {},

        success: function (response) {

            response = JSON.parse(response);

            newElement = "";

            newElement += "<div class='avatarList'>";

            for(i = 0; i < response.length; i++) {
                newElement += "<div class='circularAvWrap'>";
                newElement += "<img id='" + response[i].name + "' onclick='changePhoto(id, \"mainContainer\")' style='cursor: pointer;' src='" + response[i].name + "' class='circularAvatar'/>";
                newElement += "</div>";
            }


            newElement += "</div>";

            $("#" + containerElement).append(newElement);

        }
    });

}

var selectedPhoto = -1;
var mode = -1;

function changePhoto(element, container) {

    selectedPhoto = element;
    $("#" + container).attr('src', element);
}

function submitPhoto(uId, secondaryContainer) {

    if(selectedPhoto != -1 && mode != -1) {

        $.ajax({
            type : "post",
            url : submitPhotoDir,
            data : {
                "pic" : selectedPhoto,
                "mode" : mode
            },
            success: function (response) {

                $("#" + secondaryContainer).attr('src', selectedPhoto);
                $('.uploadAvatarPopup').hide();
                $('.avatarPreview').hide();
                $('.mainAction').hide();
                $('.commonBtn').hide();
                $("#change-picture").hide();
                $("#upload-picture").hide();
                $("#defaultPhotoBtn").hide();
            }
        });
    }

}
