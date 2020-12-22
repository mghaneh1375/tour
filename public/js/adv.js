
function fillMyDivWithAdv(sectionId, stateId) {
    $.ajax({
        type: 'post',
        url: 'http://localhost/pro_shazde/public/fillMyDivWithAdv',
        data: {
            'sectionId': sectionId,
            'state': stateId
        },
        success: function (response) {
            response = JSON.parse(response);
            var newElement = "<a ";
            if(response.mobileHidden)
                newElement += "class='hideOnPhone' ";
            newElement += "target='_blank' style='cursor: pointer; position: absolute; width: " + response.width + "px; height: " + response.height + "px; ";
            if(parseInt(response.top) != -1)
                newElement += "top: " + response.top_ + "px; ";
            if(parseInt(response.left) != -1)
                newElement += "left: " + response.left_ + "px; ";
            if(parseInt(response.right) != -1)
                newElement += "right: " + response.right_ + "px; ";
            if(parseInt(response.bottom) != -1)
                newElement += "bottom: " + response.bottom_ + "px; ";

            newElement += "background: url(\"" + response.pic + "\"); " +
                "background-size: " + response.backgroundSize + "; background-repeat: no-repeat; '" +
                "href = '" + response.url + "' />";

            $("body").append(newElement);
        }
    })
}