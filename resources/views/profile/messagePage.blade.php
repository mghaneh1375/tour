@extends('layouts.bodyPlace')

@section('title')
    <title>صفحه پیام ها</title>
@stop

@section('meta')

@stop

@section('header')
    @parent

    <link rel="stylesheet" href="{{URL::asset('css/pages/messagePage.css?v='.$fileVersions)}}">

    <style>
        body{
            overflow: hidden;
        }
        .msgBody{
            background-image: url("{{URL::asset('images/mainPics/msgBack.jpg')}}");
            background-image: url("{{URL::asset('images/mainPics/msgBack2.jpg')}}");
            background-image: url("{{URL::asset('images/mainPics/msgBack3.jpg')}}");
            background-size: auto;
        }
        .msgContent .otherText.corner:before{
            background-image: url("{{URL::asset('images/icons/whiteCorner.png')}}");
        }
        .msgContent .myText.corner:before{
            background-image: url("{{URL::asset('images/icons/greenCorner2.png')}}");
        }

    </style>
@stop

@section('main')
    <div class="mainMsgBody">
        <div id="msgBody" class="msgBody">
            <div class="msgHeader">
                <div class="userInfoMSg">
                    <div class="leftBigArrowIcon" onclick="backToList()"></div>
                    <a class="headerUserLink" href="#">
                        <div class="userPic">
                            <img id="msgBodyPic" style="width: 100%">
                        </div>
                        <div id="msgBodyUserName" style="margin-right: 10px"></div>
                    </a>
                </div>
                <div class="userSetting">
                    <span class="threeDotIconVertical" onclick="$(this).next().toggleClass('open')"></span>
                    <div class="userSettingMenu">
                        <div class="nav">پاک کردن گفتگو ها</div>
                        <div class="nav">حذف کاربر</div>
                    </div>
                </div>
            </div>

            <div id="bodyMsg" class="msgContent"></div>

            <div class="msgFooter">
                <div class="sendIcon" onclick="sendMsg(this)"></div>
                <img src="{{URL::asset('images/icons/mGear.svg')}}" style="width: 30px; height: 30px; margin-bottom: 10px; margin-right: 10px; display: none">
                <div class="inputMsgSec">
                    <textarea id="msgText" rows="1" onkeyup="changeHeight()" placeholder="پیام خود را وارد کنید..."></textarea>
                </div>
            </div>
        </div>
        <div id="sideListUser" class="sideContacts">
            <div class="userSearchSec">
                <a href="{{route('profile')}}" class="leftBigArrowIcon" title="بازگشت"></a>
                <div class="searchInp">
                    <input id="searchInUser" type="text" onkeyup="searchInUsers(this.value)">
                    <div class="searchIcon"></div>
                    <div class="iconClose" style="display: none" onclick="clearSearchBox()"></div>
                </div>
            </div>
            <div id="contacts" class="userSideSection Scroll"></div>
        </div>
    </div>

    <script>
        let contacts = {!! json_encode($contacts) !!};
        let uId = {{auth()->user()->id}};
        let showMsgUserId = 0;
        let specUser = null;
        let lastDate = '';
        let lastSendMsg = '';
        let lastId = 0;
        let updateInterval = null;
        let loadingMsg ='<div class="loading">\n' +
                        '<img src="{{URL::asset("images/loading.gif?v=".$fileVersions)}}" style="width: 200px;">\n' +
                        '</div>';

        autosize($('textarea'));
        $('.searchInp').on('click', function(){
            $('#searchInUser').focus();
        });

        function searchInUsers(_value){
            if(_value.trim().length == 0){
                $('.searchInp').find('.searchIcon').show();
                $('.searchInp').find('.iconClose').hide();
                createContacts(contacts);
            }
            else{
                $('.searchInp').find('.searchIcon').hide();
                $('.searchInp').find('.iconClose').show();

                showContacts = [];
                contacts.map(item =>{
                    if(item.username.search(_value) > -1)
                        showContacts.push(item);
                });
                createContacts(showContacts);
            }
        }

        function clearSearchBox(){
            $('#searchInUser').val('');
            $('.searchInp').find('.searchIcon').show();
            $('.searchInp').find('.iconClose').hide();
            createContacts(contacts);
        }

        function changeHeight(){
            let height = $('.msgFooter').height();
            height += 70;
            if(height < 110)
                height = 110;

            if($(window).width() < 768 && height < 190)
                height = 190;

            $('.msgContent').css('height', 'calc(100% - ' + height + 'px)');
        }

        let lastTopIndex = -1;
        $('.msgContent').on('scroll', function(e){
            let date = $('.Date');
            date.map((index, item) => {
                if(lastTopIndex != index) {
                    let topIndex = $(item).position().top;
                    if (topIndex <= 60){
                        $('.Date.fixed').removeClass('fixed');
                        lastTopIndex = index;
                        $(item).addClass('fixed');
                    }
                }
            })
        });

        function backToList(){
            $('#msgBody').removeClass('showThis');
            $('#sideListUser').removeClass('hideThis');
        }

        let koochitaNew = {{$newKoochitaMsg}};
{{--        let koochitaNewMsg = {{$lastKoochitaMsg}};--}}
//         console.log(koochitaNewMsg)

        function showThisMsgs(_id){
            $('#msgBody').addClass('showThis');
            $('#sideListUser').addClass('hideThis');

            $('.userRow').removeClass('active');
            $('#user_' + _id).addClass('active');
            getUserMsgs(_id);
        }

        function getUserMsgs(_id){
            if(_id == 0){
                $('#msgBodyPic').attr('src', "{{URL::asset('images/icons/KOFAV0.svg')}}");
                $('#msgBodyUserName').text('کوچیتا');
            }
            else {
                contacts.map(item => {
                    if (item.id == _id) {
                        $('#msgBodyPic').attr('src', item.pic);
                        $('#msgBodyUserName').text(item.username);
                        $('.headerUserLink').attr('href', '{{url('profile/index')}}/'+item.username);
                    }
                });
            }

            $('#bodyMsg').html(loadingMsg);
            lastDate = '';
            lastSendMsg = '';
            lastId = 0;
            showMsgUserId = _id;

            if(updateInterval != null){
                updateInterval.abort();
                updateInterval = null;
            }

            $.ajax({
                type: 'post',
                url: '{{route("profile.message.get")}}',
                data: {
                    _token: '{{csrf_token()}}',
                    id: _id
                },
                success: function (response) {
                    $("#bodyMsg").empty();
                    response = JSON.parse(response);
                    if(response.length == 0){
                        let text =  '<div id="notMsg" class="notMsg">\n' +
                                    '<div class="content">\n' +
                                    'هنوز هیچ پیامی برای کاربر ارسال نشده است.' +
                                    '</div>\n' +
                                    '</div>';
                        $("#bodyMsg").html(text);
                    }
                    else {
                        $('#user_' + _id).find('.newMsg').remove();

                        response.map(msg => createMsgs(msg));
                        $('#bodyMsg').scrollTop($('#bodyMsg')[0].scrollHeight);
                    }
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }

        function createMsgs(msg){
            let classType;
            let corner = '';
            $('#notMsg').remove();
            if(msg.date != lastDate){
                $("#bodyMsg").append('<div class="Date">' + msg.date + '</div>');
                lastDate = msg.date;
                corner = 'corner';
            }

            if(msg.senderId == uId) {
                if(lastSendMsg != 'me')
                    corner = 'corner';

                classType = 'myText';
                lastSendMsg = 'me';
            }
            else {
                if(lastSendMsg != 'other')
                    corner = 'corner';

                classType = 'otherText';
                lastSendMsg = 'other';
            }

            let text =  '<div class="' + classType + ' ' + corner + '">\n' +
                '<div style="white-space: pre-wrap;">' + msg.message + '</div>\n' +
                '<div class="time">' + msg.time + '</div>\n' +
                '</div>';
            $("#bodyMsg").append(text);

            if(lastId < msg.id)
                lastId = msg.id;
        }

        function sendMsg(_element){
            let text = $('#msgText').val();
            if(text.trim().length > 0){
                $(_element).hide();
                $(_element).next().show();
                $.ajax({
                    type: 'post',
                    url: '{{route("profile.message.send")}}',
                    data: {
                        _token: '{{csrf_token()}}',
                        userId: showMsgUserId,
                        text: text
                    },
                    success: function(response){
                        $(_element).next().hide();
                        $(_element).show();

                        response = JSON.parse(response);
                        if(response.status == 'ok'){
                            showSuccessNotifi('{{__('پیام شما با موفقیت ارسال شد.')}}', 'left', 'var(--koochita-blue)');
                            $('#msgText').val('');
                            createMsgs(response.result);
                            setTimeout(function(){
                                $('#bodyMsg').scrollTop($('#bodyMsg')[0].scrollHeight);
                                $('#msgText').css('height', 'auto');
                                changeHeight();
                            }, 100);
                        }
                    },
                    error: function(err){
                        $(_element).next().hide();
                        $(_element).show();

                        showSuccessNotifi('{{__('ارسال پیام شما با مشکل مواجه شد دوباره تلاش کنید.')}}', 'left', 'red');
                    }
                })
            }
        }
        function createContacts(_contacts){
            $('#contacts').empty();

            let text = '';
            text += '<div id="user_0" class="userRow" onclick="showThisMsgs(0)">\n' +
                    '                        <div class="userPic">\n' +
                    '                            <img src="{{URL::asset('images/icons/KOFAV0.svg')}}" style="width: 100%">\n' +
                    '                        </div>\n' +
                    '                        <div class="userInfo">\n' +
                    '                            <div class="userName">\n' +
                    '                                <div>کوچیتا</div>\n' +
                    '                                <div class="time"></div>\n' +
                    '                            </div>\n' +
                    '                            <div class="userLastMsg">\n' +
                    '                                <div class="lastMsgCotacts">{{$lastKoochitaMsg}}</div>\n';
            if(koochitaNew != 0)
                text +=  '<div class="newMsg">' + koochitaNew + '</div>\n';
            text += '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>';
            koochitaNew = 0;

            _contacts.map(item => {
                text +=  '<div id="user_' + item.id + '" class="userRow" onclick="showThisMsgs(' + item.id + ')">\n' +
                    '                        <div class="userPic">\n' +
                    '                            <img src="' + item.pic + '" style="height: 100%">\n' +
                    '                        </div>\n' +
                    '                        <div class="userInfo">\n' +
                    '                            <div class="userName">\n' +
                    '                                <div>' + item.username + '</div>\n' +
                    '                                <div class="time">' + item.lastTime + '</div>\n' +
                    '                            </div>\n' +
                    '                            <div class="userLastMsg">\n' +
                    '                                <div class="lastMsgCotacts">' + item.lastMsg + '</div>\n';
                if(item.newMsg != 0)
                    text +=  '                                <div class="newMsg">' + item.newMsg + '</div>\n';

                text +=  '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>';
            });

            $('#contacts').append(text);
        }
        createContacts(contacts);

        function updateMsg(){
            updateInterval = $.ajax({
                type: 'post',
                url: '{{route("profile.message.update")}}',
                data: {
                    _token: '{{csrf_token()}}',
                    lastId: lastId,
                    userId: showMsgUserId
                },
                success: function (response) {
                    response = JSON.parse(response);
                    if(response.result.length != 0){
                        response.result.map(msg => createMsgs(msg));
                        $('#bodyMsg').scrollTop($('#bodyMsg')[0].scrollHeight);
                    }
                },
                error: function (err) {
                    console.log(err);
                }
            });
            setTimeout(updateMsg, 4000);
        }

        setTimeout(updateMsg, 5000);

        @if(isset($specUser) && $specUser != null)
            specUser = {!! $specUser !!};
            showThisMsgs(specUser);
        @endif
    </script>
@stop