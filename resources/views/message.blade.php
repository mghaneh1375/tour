<?php $mode = "message"; $user = Auth::user(); ?>
@extends('layouts.bodyProfile')

@section('header')
    @parent
@stop

@section('main')


    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/messages.css?v=1')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/abbreviations.css?v=1')}}'/>

    <div id="MAIN" class="Messages prodp13n_jfy_overflow_visible">
        <div id="BODYCON" class="col easyClear poolB adjust_padding new_meta_chevron_v2">
            <div class="wrpHeader">
            </div>
            <h1 class="heading wrap pd-bt-10Imp messagesHeading">
                پیام‌های من
            </h1>

            @if(!empty($err))
                <center>
                    <p class="color-146-50-27">{{$err}}</p>
                </center>
            @endif

            <div class="responsiveSendMode">

                <div class="main_content display-flex min-height-300" id="MESSAGES_CONTENT">

                    <div class="vt-align-top">

                        <div class="floatLeft">
                            <div class="saveLeftNav cursor-pointer">
                                <div id="inboxFolder" onclick="inboxMode('inboxFolder', 'inbox', 'tableId', 'outbox', 'sendMsgDiv', 'showMsgContainer', 'reportPrompt', 'blockPrompt')" class="menu_bar cursor-pointer">
                                    <div class="displayFolder">
                                        <a onclick="" class="saveLink">
                                            <strong>
                                                <span>پیام‌های ورودی‌({{$inMsgCount}})</span>
                                            </strong>
                                        </a>
                                    </div>
                                </div>
                                <div id="outboxFolder" onclick="outboxMode('outboxFolder', 'inbox', 'tableId', 'sendMsgDiv', 'showMsgContainer', 'reportPrompt', 'blockPrompt')" class="menu_bar cursor-pointer">
                                    <div class="displayFolder">
                                        <a onclick="" class="saveLink">
                                            <strong>
                                                <span>پیام‌های خروجی‌({{$outMsgCount}})</span>
                                            </strong>
                                        </a>
                                    </div>
                                </div>
                                <div id="sendFolder" onclick="sendMode('sendFolder', 'inbox', 'sendMsgDiv', 'showMsgContainer', 'reportPrompt', 'blockPrompt')" class="menu_bar cursor-pointer">
                                    <div class="displayFolder">
                                        <a class="saveLink">
                                            <strong>ارسال پیام</strong>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div width="100%" border="0" cellpadding="0" cellspacing="0" class="mb_12" id="PROFILE_MESSAGING">
    {{--                    <tr>--}}
    {{--                        <td id="inbox">--}}
                                <div class="alignLeft" id="inbox">
                                    <div class="mainDivTable p5 bg-color-light-grey">

                                        <div class="display-flex">

                                            <div class="messagingButton">
                                                <a rel="nofollow" class="buttonLink" onclick="setAllChecked()">
                                                    <div class="m2m_link">
                                                        <div class="cursor-pointer">
                                                            <div class="m2m_copy">
                                                                {{--<img id="selectAllImg" src="{{URL::asset('images') . '/selectAll.gif'}}" border="0" align="absmiddle" class="mg-lt-8"/>--}}
                                                                <div id="selectAllImg"></div>
                                                                <span id="selectAll">انتخاب همه</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                            <div class="messagingButton">
                                                <a class="buttonLink">
                                                    <div class="m2m_link">
                                                        <div class="cursor-pointer">
                                                            <div class="m2m_copy dark-blue" onclick="showConfirmationForDelete()">
                                                                {{--<img src="{{URL::asset('images') . '/deleteIcon.gif'}}" border="0" alt="Delete" align="absmiddle" class="mg-lt-8"/>--}}
                                                                <div class="confirmationForDelete"></div>
                                                                <input name="deleteMsg" class="confirmationForDeleteInput" type="submit" value="حذف">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                            <div class="messagingButton">
                                                <a rel="nofollow" class="buttonLink" onclick="getBlockList('blockPrompt', 'blocks', 'reportPrompt')">
                                                    <div class="m2m_link">
                                                        <div class="cursor-pointer">
                                                            <div class="m2m_copy dark-blue">
                                                                {{--<img src="{{URL::asset('images') . '/memberBlock.gif'}}" border="0" alt="Block" align="absmiddle" class="mg-lt-8"/>بلاک--}}
                                                                <div class="blockListBtn"></div>
                                                                <span>بلاک</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                            <div class="messagingButton" id="reportSpamButton">
                                                <a id="reportSpam" rel="nofollow" class="buttonLink" onclick="showReportPrompt('reportPrompt', 'showMsgContainer', 'blockPrompt')">
                                                    <div class="m2m_link">
                                                        <div class="cursor-pointer dark-blue">
                                                            <div class="m2m_copy">
                                                                {{--<img src="{{URL::asset('images') . '/m2m_reportAbuse.gif'}}" border="0" alt="Report spam" align="absmiddle" class="mg-lt-8"/>گزارش--}}
                                                                <div class="reportPromptBtn"></div>
                                                                <span>گزارش</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                        </div>

                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="clear mg-tp-5">

                                            <tr class="inboxHeaders">
                                                <th class="SortNavOff width-30per">
                                                    <a href="" title="Sort by: From" class="text-align-centerImp">ارسال شده از / به
                                                        {{--<img src="{{URL::asset('images') . '/blackNavArrowUp.gif'}}" width="7" height="4" hspace="10" border="0" align="absmiddle"/>--}}
                                                        {{--<div class="sendFromMainDiv"></div>--}}
                                                    </a>
                                                </th>
                                                <th class="SortNavOff width-35per">
                                                    <a href="" title="Sort by: Subject" class="text-align-centerImp">موضوع
                                                        {{--<img src="{{URL::asset('images') . '/blackNavArrowUp.gif'}}" width="7" height="4" hspace="10" border="0" align="absmiddle"/>--}}
                                                        {{--<div class="topicMainDiv"></div>--}}
                                                    </a>
                                                </th>
                                                <th class="SortNavOn width-20per bg-color-white text-align-center">
                                                    <a onclick="sortByDate('tableId', 'dateIcon')" title="Sort by: Date" class="text-align-centerImp">تاریخ
                                                        {{--<img id="dateIcon" src="{{URL::asset('images') . '/blackNavArrowUp.gif'}}" width="7" height="4" hspace="10" border="0" align="absmiddle"/>--}}
                                                        <div id="dateIcon"></div>
                                                    </a>
                                                </th>
                                                <th class="SortNavOff width-15per" id="select-title">
                                                    <span>انتخاب</span>
                                                </th>
                                            </tr>
                                        </table>

                                        <table id="tableId" width="100%" border="0" cellspacing="0" cellpadding="0" class="clear">
                                        </table>
                                    </div>
                                </div>
    {{--                        </td>--}}
    {{--                    </tr>--}}
                    </div>
                </div>

                <center id="sendMsgDiv">
                    <div class="row">
                        <form method="post" action="{{route('sendMsg')}}" class="form-horizontal" id="contact_form">
                            {{csrf_field()}}
                            <fieldset class="contactFormFieldset">
                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="control-label userNameLabel">نام کاربری</label>
                                    <div class="messagesInputsMainDiv">
                                        <input id="name" onkeyup="searchForMyContacts()" name="destUser" type="text" placeholder="لطفا نام کاربری خود را وارد نمایید " class="form-control input-md" required=""  maxlength="40">
                                        <div id="result" class="data_holder"></div>
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="control-label topicLabel">موضوع</label>
                                    <div class="messagesInputsMainDiv">
                                        @if(isset($subject) && !empty($subject))
                                            <input name="subject" value="{{$subject}}" maxlength="40" type="text" placeholder="لطفا موضوع پیام خود را وارد نمایید" class="form-control input-md" required="">
                                        @else
                                            <input name="subject" maxlength="40" type="text" placeholder="لطفا موضوع پیام خود را وارد نمایید" class="form-control input-md" required="">
                                        @endif
                                    </div>
                                </div>

                                <!-- Textarea -->
                                <div class="form-group">
                                    <label class="control-label messagesLabel">پیام</label>
                                    <div class="messagesInputsMainDiv">
                                        @if(isset($currMsg) && !empty($currMsg))
                                            <textarea class="form-control" id="msg" name="msg"  placeholder="حداکثر 1000 کاراکتر"></textarea>
                                        @else
                                            <textarea class="form-control" id="msg" name="msg" cols="8" rows="8" placeholder="حداکثر 1000 کاراکتر"></textarea>
                                        @endif
                                    </div>
                                </div>

                                <!-- Button -->
                                <div class="form-group">
                                    <label class="control-label" for="submit"></label>
                                    <div>
                                        <button id="submit" name="sendMsg" class="btn btn-primary">ارسال پیام</button>
                                    </div>
                                    @if(isset($err) && !empty($err))
                                        <p class="msgErr">{{$err}}</p>
                                    @endif
                                </div>

                            </fieldset>
                        </form>
                    </div>
                </center>

{{--                <div class="hideOnScreen footerOptimizer"></div>--}}

            </div>

            <span id="reportPrompt" class="ui_overlay ui_modal editTags">
                    <div class="header_text mg-bt-10Imp">گزارش</div>
                    <div class="subheader_text">
                        دلیل گزارش خود را از موارد ذیل انتخاب کنید
                    </div>
                    <div class="body_text alaki">
                        <fieldset id="memberTags">
                            <div class="reports" id="reports">
                            </div>
                        </fieldset>
                        <div class="submitOptions">
                            <button onclick="sendReport('reportPrompt')" class="btn btn-success">تایید</button>
                            <input type="submit" onclick="closeReportPrompt('reportPrompt')" value="خیر" class="btn btn-default">
                        </div>
                    </div>
                    <div onclick="closeReportPrompt('reportPrompt')" class="ui_close_x"></div>
                </span>

            <span id="showMsgContainer" class="showMsgContainerStyles top-15per ui_overlay ui_modal editTags">
            </span>

            <span id="blockPrompt" class="ui_overlay ui_modal editTags">
                    <div class="header_text">محدود سازی ارتباط</div>
                    <p>کاربران زیر با شما در ارتباط هستند با انتخاب آن‌ها، ارتباطشان با خود را محدود می‌سازید.</p>

                    <p class="font-size-10">برای رفع محدودیت، کاربر مورد نظر را از حالت انخاب خارج نمایید.</p>
                    <div class="subheader_text">
                        لیست کاربران
                    </div>
                    <div class="body_text">
                        <fieldset id="memberTags">
                            <div id="blocks"></div>
                        </fieldset>
                        <div class="submitOptions">
                            <button onclick="blockUser('blockPrompt')" class="btn btn-success">تایید</button>
                            <input type="submit" onclick="closeReportPrompt('blockPrompt')" value="خیر" class="btn btn-default">
                        </div>
                    </div>
                    <div onclick="closeReportPrompt('blockPrompt')" class="ui_close_x"></div>
                </span>

            <span id="showMsgContainer" class="showMsgContainerStyles top-33per ui_overlay ui_modal editTags">
            </span>

            <span class="ui_overlay ui_modal editTags deleteMessage" id="deleteMsg">
                <p>آیا از پاک کردن پیام اطمینان دارید؟</p>
                <br><br>
                <div class="body_text">

                    <div class="submitOptions">
                        <button onclick="deleteSelectedMsgs()" class="btn btn-success deleteSelectedMessagesBtn">بله </button>
                        <input type="submit" onclick="hideConfirmationPane()" value="خیر" class="btn btn-default">
                    </div>
                </div>

                <div onclick="hideConfirmationPane()" class="ui_close_x"></div>

            </span>

            <div class="ui_backdrop dark display-none"></div>
        </div>
    </div>

    <script>

        var getListOfMsgsDir = '{{route('getListOfMsgsDir')}}';
        var getBlockListDir = '{{route('getBlockListDir')}}';
        var blockDir = '{{route('block')}}';
        var getMessage = '{{route('getMessage')}}';
        var getReportsDir = '{{route('getReportsDir')}}';
        var sendReportDir = '{{route('sendReport')}}';
        var sendMsgDir = '{{route('sendReceiveReport')}}';
        var opOnMsgs = '{{route('opOnMsgs')}}';
        var msgs = '{{route('msgs')}}';
        var searchForMyContactsDir = '{{route('searchForMyContacts')}}';
        var upArrow = '{{URL::asset('images') . '/blackNavArrowUp.gif'}}';
        var downArrow = '{{URL::asset('images') . '/blackNavArrowDown.gif'}}';
        var deselect = '{{URL::asset('images') . '/deselectAll.gif'}}';
        var select = '{{URL::asset('images') . '/selectAll.gif'}}';

        $(document).ready(function () {

            err = "{{(isset($err) && !empty($err)) ? "err" : ""}}";
            errMode = "{{(isset($currMsg) && isset($subject) && !empty($currMsg) && !empty($subject)) ? "true" : "false"}}";

            if(err == "" || (err.length != 0 && errMode == "false"))
                inboxMode('inboxFolder', 'inbox', 'tableId', 'outbox', 'sendMsgDiv', 'showMsgContainer', 'reportPrompt', 'blockPrompt');
            else
                sendMode('sendFolder', 'inbox', 'sendMsgDiv', 'showMsgContainer', 'reportPrompt', 'blockPrompt');
        });

    </script>

    <script>
        var mode = false;
        var sortMode = 'DESC';
        var containerMode = 'inbox';

        function setAllChecked() {

            if(!mode) {
                $("input:checkbox[name='selectedMsg[]']").each(function() {
                    this.checked = true;
                });
                $("#selectAll").text("غیرفعال‌کردن همه");
                $("#selectAllImg").css('background-position', '0 -16px');
            }
            else {
                $("input:checkbox[name='selectedMsg[]']").each(function() {
                    this.checked = false;
                });
                $("#selectAll").text("فعال‌کردن همه");
                $("#selectAllImg").css('background-position', '0 -67px');
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
                            newElement += "<p class='cursor-pointer' onclick='setUserName(\"" + response[i].username + "\")'>" + response[i].username + "</p>";
                        }

                        $("#result").empty().addClass('resultStyles');
                        $("#result").append(newElement);
                    }

                }
            });

        }

        function setUserName(val) {
            $("#name").val(val);
            $("#result").empty().removeClass('resultStyles');

        }

        function customReport(element, checkBoxId) {

            if($("#" + checkBoxId).is(':checked')) {
                newElement = "<div class='col-xs-12'>";
                newElement += "<textarea id='customDefinedReport' maxlength='1000' required placeholder=' دلیل گزارش خود را به طور کامل وارد نمایید'></textarea>";
                newElement += "</label></div>";
                $("#" + element).empty().append(newElement).css("visibility", "visible");
            }
            else {
                $("#" + element).empty().css("visibility", "hidden");
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

                    newElement += "<div id='custom-define-report'></div>";

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
            $("#" + inbox).css({"display": 'none', "visibility" : ""});
            $(".menu_bar").removeClass("selectedFolder");
            $("#" + sendFolder).addClass("selectedFolder");
            $("#" + msgContainer).css({"display": 'block',"visibility" : ""});
            $('#MESSAGES_CONTENT').removeClass('min-height-300');
            $('#PROFILE_MESSAGING').addClass('display-none');


            if ($(window).width() > 480) {

                $('.responsiveSendMode').addClass('display-flex');

            }

            $( window ).resize(function() {
                if ($(window).width() > 480) {

                    $('.responsiveSendMode').addClass('display-flex');

                }

                else {
                    $('.responsiveSendMode').removeClass('display-flex');
                }
            });

            containerMode = "send";
        }

        function inboxMode(inboxFolder, inbox, table, msgContainer, showMsgContainer, reportContainer, blockContainer) {
            $("#" + showMsgContainer).css({"display": 'none',"visibility" : ""});
            $("#" + reportContainer).css("visibility", 'hidden');
            $("#" + blockContainer).css("visibility", 'hidden');
            $("#" + inbox).css({"display": 'block', "visibility" : ""});
            $(".menu_bar").removeClass("selectedFolder");
            $("#" + inboxFolder).addClass("selectedFolder");
            $("#" + msgContainer).css("visibility", 'hidden');
            $('#MESSAGES_CONTENT').addClass('min-height-300');
            $('#PROFILE_MESSAGING').removeClass('display-none');

            $('.responsiveSendMode').removeClass('display-flex');

            containerMode = "inbox";

            showTable(table, true);
        }

        function outboxMode(outboxFolder, inbox, table, msgContainer, showMsgContainer, reportContainer, blockContainer) {
            $("#" + showMsgContainer).css("visibility", 'hidden');
            $("#" + reportContainer).css("visibility", 'hidden');
            $("#" + blockContainer).css("visibility", 'hidden');
            $("#" + msgContainer).css({"display": 'none', "visibility" : ""});
            $("#" + inbox).css({"display": 'block', "visibility" : ""});
            $(".menu_bar").removeClass("selectedFolder");
            $("#" + outboxFolder).addClass("selectedFolder");
            $('#MESSAGES_CONTENT').addClass('min-height-300');
            $('#PROFILE_MESSAGING').removeClass('display-none');

            $('.responsiveSendMode').removeClass('display-flex');

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

                    newElement = "<div class='header_text dark-blue'> موضوع :  " + response.subject + "</div><br>";
                    if(mode)
                        newElement += "<div class='header_text dark-blue'> ارسال شده از طرف  :  " + response.senderId + "</div><br>";
                    else
                        newElement += "<div class='header_text'> ارسال شده به  :  " + response.receiverId + "</div><br>";
                    newElement += "<div class='header_text'> تاریخ ارسال  :  " + response.date + "</div><br><br>";
                    newElement += "<div class='subheader_text'><p class='alaki responseSubheaderParagraph'>" + response.message + "</p></div>";
                    newElement += "<div onclick='closeReportPrompt(\"" + element + "\")' class='ui_close_x'></div>";

                    $("#" + element).append(newElement).css("visibility", 'visible');
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
                        $('.mainDivTable').addClass('height-500');
                        $('.mainDivTable').addClass('height-autoImp');
                    }

                    else {
                        for(i = 0; i < response.length; i++) {
                            newElement = '<tr class="bottomNav">';
                            newElement += '<td class="width-30per text-align-center">' + response[i].target + '</td>';
                            newElement += "<td onclick='showMsg(" + response[i].id + ", \"showMsgContainer\", " + mode + ")' class='showMsgDiv'>" + response[i].subject + "</td>";
                            newElement += "<td class='width-20per text-align-center'>" + response[i].date + "</td>";
                            newElement += "<td class='text-align-center width-15per'>";
                            newElement += "<div class='ui_input_checkbox'>";
                            newElement += "<input id='msg_" + response[i].id + "' name='selectedMsg[]' value='" + response[i].id + "' type='checkbox'>";
                            newElement += "<label class='labelForCheckBox' for='msg_" + response[i].id + "'><span></span></label>";
                            newElement += "</div></td></tr>";
                            $("#" + element).append(newElement);
                            $('.mainDivTable').addClass('height-500');
                            $('.mainDivTable').removeClass('height-autoImp');
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
//                $("#" + icon).css('src', upArrow);
                $("#" + icon).css('background-image', 'url("' + '{{URL::asset('images') . 'all_messages.png'}}' + '")')
                             .css('background-position', '4px -62px')
                             .css('background-size', '10px');
            }
            else {
                sortMode = 'DESC';
//                $("#" + icon).css('src', downArrow);
                $("#" + icon).css('background-image', 'url("' + '{{URL::asset('images') . 'tripplace.png'}}' + '")')
                             .css('background-position', '-3px -81px')
                             .css('background-size', '21px');
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

    </script>

@stop