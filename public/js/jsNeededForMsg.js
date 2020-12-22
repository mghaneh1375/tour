var mode = false;
var sortMode = 'DESC';
var containerMode = 'inbox';

function setAllChecked() {

    if(!mode) {
        $("input:checkbox[name='selectedMsg[]']").each(function() {
            this.checked = true;
        });
        $("#selectAll").text("غیر فعال کردن همه");
        $("#selectAllImg").attr('src', deselect);
    }
    else {
        $("input:checkbox[name='selectedMsg[]']").each(function() {
            this.checked = false;
        });
        $("#selectAll").text("فعال کردن همه");
        $("#selectAllImg").attr('src', select);
    }

    mode = !mode;
}

function searchForMyContacts() {
    
    if($("#name").val().length < 3) {
        $("#result").empty();
        return;
    }
    
    $.ajax({
        type: 'post',
        url: searchForMyContactsDir,
        data: {
            'key': $("#name").val() 
        },
        success: function (response) {

            $("#result").empty();

            if(response.length != 0) {

                response = JSON.parse(response);
                newElement = "";

                for(i = 0; i < response.length; i++) {
                    newElement += "<p style='cursor: pointer' onclick='setUserName(\"" + response[i].username + "\")'>" + response[i].username + "</p>";
                }

                $("#result").append(newElement);
            }

        }
    });
    
}

function setUserName(val) {
    $("#name").val(val);
    $("#result").empty();
}

function customReport(element, checkBoxId) {

    if($("#" + checkBoxId).is(':checked')) {
        $("#" + element).empty();
        newElement = "<div class='col-xs-12'>";
        newElement += "<textarea id='customDefinedReport' style='height: auto;margin-top: 5px;min-height: 100px;padding: 5px !important;width: 100%;' maxlength='1000' required placeholder=' دلیل گزارش خود را به طور کامل وارد نمایید'></textarea>";
        newElement += "</label></div>";
        $("#" + element).append(newElement);
        $("#" + element).css("visibility", "visible");
    }
    else {
        $("#" + element).empty();
        $("#" + element).css("visibility", "hidden");
    }
}

function getReports(element) {

    $("#" + element).empty();

    $.ajax({
        type: 'post',
        url: getReportsDir,
        success: function (response) {

            response = JSON.parse(response);

            newElement = "<div id='reportContainer' class='row'>";

            for(i = 0; i < response.length; i++) {
                newElement += "<div class='col-xs-12'>";
                newElement += "<label>";
                newElement += "<div class='ui_input_checkbox'>";
                newElement += "<input id='desc_" + response[i].id + "' type='checkbox' name='reports' value='" + response[i].id + "'>";
                newElement += "<label class='labelForCheckBox' for='desc_" + response[i].id + "'><span></span>&nbsp;&nbsp;" + response[i].description + "</label>";
                newElement += "</div>";
                newElement += "</label>";
                newElement += "</div>";
            }

            newElement += "<div class='col-xs-12'>";
            newElement += "<label>";
            newElement += "<div class='ui_input_checkbox'>";
            newElement += "<input id='custom-checkBox' onchange='customReport(\"custom-define-report\", \"custom-checkBox\")' type='checkbox' name='reports' value='-1'>";
            newElement += "<label class='labelForCheckBox' for='custom-checkBox'><span></span>&nbsp;&nbsp;سایر موارد</label>";
            newElement += "</div>";
            newElement += "</label>";
            newElement += "</div>";

            newElement += "<div id='custom-define-report' style='visibility: hidden'></div>";

            newElement += "</div>";

            $("#" + element).append(newElement);

        }
    });
}

function sendReport(reportContainer) {

    customMsg = "";

    if($("#customDefinedReport").val() != null)
        customMsg = $("#customDefinedReport").val();

    var checkedValuesReports = $("input:checkbox[name='reports']:checked").map(function() {
        return this.value;
    }).get();

    var checkedValuesMsgs = $("input:checkbox[name='selectedMsg[]']:checked").map(function() {
        return this.value;
    }).get();

    if(checkedValuesReports.length <= 0 || checkedValuesMsgs <= 0)
        return;

    $.ajax({
        type: 'post',
        url: sendReportDir,
        data: {
            "checkedValuesReports": checkedValuesReports,
            "checkedValuesMsgs" : checkedValuesMsgs,
            "customMsg" : customMsg
        },
        success: function (response) {
            if(response == "ok") {

                $.ajax({
                    type: 'post',
                    url: sendMsgDir,
                    data: {
                        'checkedValuesReports': checkedValuesReports,
                        "customMsg" : customMsg
                    },
                    success: function (response) {
                        closeReportPrompt(reportContainer);
                    }
                });
            }
        }
    });
}

function closeReportPrompt(element) {
    $("#" + element).css("visibility", 'hidden');
    $("#custom-define-report").css("visibility", 'hidden');
    $('.dark').hide();
}

function showReportPrompt(element, showMsgContainer, blockPrompt) {

    var checkedValues = $("input:checkbox[name='selectedMsg[]']:checked").map(function() {
        return this.value;
    }).get();

    if(checkedValues.length > 0) {
        $('.dark').show();
        $("#" + showMsgContainer).css("visibility", 'hidden');
        $("#" + blockPrompt).css("visibility", "hidden");
        $("#" + element).css("visibility", 'visible');
        getReports("reports");
    }
}

function sendMode(sendFolder, inbox, msgContainer, showMsgContainer, reportContainer, blockContainer) {
    $("#" + showMsgContainer).css("visibility", 'hidden');
    $("#" + reportContainer).css("visibility", 'hidden');
    $("#" + blockContainer).css("visibility", 'hidden');
    $("#" + inbox).css("visibility", 'hidden');
    $(".menu_bar").removeClass("selectedFolder");
    $("#" + sendFolder).addClass("selectedFolder");
    $("#" + msgContainer).css("visibility", 'visible');

    containerMode = "send";
}

function inboxMode(inboxFolder, inbox, table, msgContainer, showMsgContainer, reportContainer, blockContainer) {
    $("#" + showMsgContainer).css("visibility", 'hidden');
    $("#" + reportContainer).css("visibility", 'hidden');
    $("#" + blockContainer).css("visibility", 'hidden');
    $("#" + inbox).css("visibility", "visible");
    $(".menu_bar").removeClass("selectedFolder");
    $("#" + inboxFolder).addClass("selectedFolder");
    $("#" + msgContainer).css("visibility", 'hidden');

    containerMode = "inbox";

    showTable(table, true);
}

function outboxMode(outboxFolder, inbox, table, msgContainer, showMsgContainer, reportContainer, blockContainer) {
    $("#" + showMsgContainer).css("visibility", 'hidden');
    $("#" + reportContainer).css("visibility", 'hidden');
    $("#" + blockContainer).css("visibility", 'hidden');
    $("#" + msgContainer).css("visibility", 'hidden');
    $("#" + inbox).css("visibility", "visible");
    $(".menu_bar").removeClass("selectedFolder");
    $("#" + outboxFolder).addClass("selectedFolder");

    containerMode = "outbox";

    showTable(table, false);
}

function showMsg(id, element, mode) {

    $('.dark').show();
    $("#" + element).empty();

    $.ajax({

        type: 'post',
        url: getMessage,
        data: {
            mId: id
        },
        success: function (response) {
            response = JSON.parse(response);

            newElement = "<div style='color: #16174f;' class='header_text'> موضوع :  " + response.subject + "</div><br>";
            if(mode)
                newElement += "<div style='color: #16174f;' class='header_text'> ارسال شده از طرف  :  " + response.senderId + "</div><br>";
            else
                newElement += "<div class='header_text'> ارسال شده به  :  " + response.recieverId + "</div><br>";
            newElement += "<div class='header_text'> تاریخ ارسال  :  " + response.date + "</div><br><br>";
            newElement += "<div class='subheader_text'><p class='alaki' style='font-size: 16px;color: #000;max-height: 200px; height: 200px; overflow: auto;'>" + response.message + "</p></div>";
            newElement += "<div onclick='closeReportPrompt(\"" + element + "\")' class='ui_close_x'></div>";

            $("#" + element).append(newElement);
            $("#" + element).css("visibility", 'visible');
        }

    });
}

function showTable(element, mode) {

    $("#" + element).empty();

    $.ajax({

        type: 'post',
        url: getListOfMsgsDir,
        data: {
            'mode': mode,
            'sortMode' : sortMode
        },
        success: function (response) {

            response = JSON.parse(response);

            if(response.length == 0) {
                newElement = "<tr class='bottomNav'>";
                newElement += "<td align='right' class='p5' colspan='4'>";
                newElement += "هیچ پیامی موجود نیست";
                newElement += "</td></tr>";
                $("#" + element).append(newElement);
            }

            else {
                for(i = 0; i < response.length; i++) {
                    newElement = '<tr class="bottomNav">';
                    newElement += '<td style="width: 15%; text-align: center">' + response[i].target + '</td>';
                    newElement += "<td onclick='showMsg(" + response[i].id + ", \"showMsgContainer\", " + mode + ")' style='cursor: pointer; width: 55%; text-align: center'>" + response[i].subject + "</td>";
                    newElement += "<td style='width: 15%; text-align: center'>" + response[i].date + "</td>";
                    newElement += "<td style='text-align: center'>";
                    newElement += "<div class='ui_input_checkbox'>";
                    newElement += "<input id='msg_" + response[i].id + "' name='selectedMsg[]' value='" + response[i].id + "' type='checkbox'>";
                    newElement += "<label class='labelForCheckBox' for='msg_" + response[i].id + "'><span></span>&nbsp;&nbsp;</label>";
                    newElement += "</div></td></tr>";
                    $("#" + element).append(newElement);
                }
            }
        }
    });

}

function getBlockList(blockContainer, blockList, reportPrompt) {
    $('.dark').show();

    $("#" + blockList).empty();

    $.ajax({
        type: 'post',
        url: getBlockListDir,
        success: function (response) {

            response = JSON.parse(response);

            newElement = "";

            for(i = 0; i < response.length; i++) {
                newElement += "<div class='ui_input_checkbox'>";
                if(response[i].block == "1")
                    newElement += "<input id='block_" + response[i].senderId  + "' type='checkbox' name='blocks[]' checked value='" + response[i].senderId + "'>";
                else
                    newElement += "<input id='block_" + response[i].senderId  + "' type='checkbox' name='blocks[]' value='" + response[i].senderId + "'>";
                newElement += "<label class='labelForCheckBox' for='block_" + response[i].senderId  + "'><span></span>&nbsp;&nbsp;" + response[i].senderName + "</label>";
                newElement += "</div>";
            }

            $("#" + blockList).append(newElement);
            $("#" + reportPrompt).css("visibility", "hidden");
            $("#" + blockContainer).css("visibility", 'visible');
        }
    });
}

function blockUser(element) {

    var blockList = $("input:checkbox[name='blocks[]']:checked").map(function() {
        return this.value;
    }).get();

    $.ajax({
        type: 'post',
        url: blockDir,
        data: {
            "blockList": blockList
        },
        success: function (response) {
            if(response == "ok") {
                alert("عملیات مورد نظر انجام پذیرفت");
                $("#" + element).css("visibility", "hidden");
                $(".dark").hide();
            }
            else if(response == "nok") {
                alert("شما اجازه ی بلاک کردن ادمین را ندارید");
                $("#" + element).css("visibility", "hidden");
                $(".dark").hide();
            }
        }
    });
}

function sortByDate(element, icon) {

    if(sortMode == 'DESC') {
        sortMode = 'ASC';
        $("#" + icon).attr('src', upArrow);
    }
    else {
        sortMode = 'DESC';
        $("#" + icon).attr('src', downArrow);
    }

    if(containerMode == "inbox")
        showTable(element, true);
    else
        showTable(element, false);
}

function confirmationBeforeSubmit() {
    $(".dark").show();
    $("#deleteMsg").css('visibility', 'visible');
}

function hideConfirmationPane() {
    $("#deleteMsg").css('visibility', 'hidden');
    $(".dark").hide();
}

function deleteSelectedMsgs() {

    var checkedValues = $("input:checkbox[name='selectedMsg[]']:checked").map(function() {
        return this.value;
    }).get();

    if(checkedValues.length > 0) {
        $.ajax({
            type: 'post',
            url: opOnMsgs,
            data: {
                'selectedMsgs': checkedValues
            },
            success: function (response) {
                if(response == "ok")
                    document.location.href = msgs;

            }
        });
    }
}

function showConfirmationForDelete() {

    var checkedValues = $("input:checkbox[name='selectedMsg[]']:checked").map(function() {
        return this.value;
    }).get();

    if(checkedValues.length > 0)
        confirmationBeforeSubmit();
}
