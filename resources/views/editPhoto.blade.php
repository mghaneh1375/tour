
<?php $mode = "profile"; $user = Auth::user(); ?>
@extends('layouts.bodyProfile')

@section('header')

    @parent

    <link rel="stylesheet" type="text/css" media="screen, print" href="{{URL::asset('css/shazdeDesigns/account_info.css?v=1')}}"/>
@stop

@section('main')

    <div id="MAIN" class="Settings prodp13n_jfy_overflow_visible">
        <div id="BODYCON" class="col easyClear poolX adjust_padding new_meta_chevron_v2 editPhotoMainDiv">
            <div class="wrpHeader">
            </div>
            <h1 class="heading wrap" id="mainProfileHeadingEditPhoto">
                عکس خود را ویرایش کنید
                <!--<a class="lnkReturnTo" href="/">Continue browsing &raquo;</a>-->
            </h1>

            <div class="avatarUI height-550">

                <div class="currentAvatar">
                    <div class="circularAvWrap">
                        <img id="secondaryContainer" src="{{$photo}}" class="circularAvatar" alt="Photo"/>
                    </div>
                    <div class="description">
                        <span>عکس صفحه کاربری شما</span>
                    </div>
                </div>

                <div class="uploadAvatarOptions" style="display: block;">
                    <div class="optionWebcam"></div>
                    <div id="upload_but" class="avatarOption optionUpload">
                        <img src="{{URL::asset('images/cp.png')}}">
                        <span>بارگذاری از روی کامپیوتر</span>
                    </div>
                    <div id="change_but" onclick="getDefaultPics('change-picture')" class="avatarOption optionList">
                        <img src="{{URL::asset('images/sp.png')}}">
                        <span>از عکس‌های ما انتخاب کنید</span>
                    </div>
                </div>

                <div class="uploadAvatarPopup">
                    <div class="uploadAvatarPopupInner">
                        <div class="actionsSide">

                            <form method="post" action="{{URL('upload.doEditPhoto')}}" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="creatingAvatar fromUpload" id="upload-picture">
                                    <div class="fileContainer">
                                        <input name="newPic" id="photo" type="file"/>
                                    </div>
                                    <div class="uploadImgCropper crop" style="">
                                        <img class="cropImg"/>
                                    </div>
                                    <div class="instructions oldBrowser">
                                      عکس شما می‌بایست در فرمت‌های jpg یا png یا gif بوده و از 3MB بیشتر نباشید. حتما دقت کنید اندازه عکس 80*80 پیکسل باشد تا زیبا به نظر برسد. در غیر اینصورت ممکن است نتیجه نهایی باب میل شما نباشد.
                                    </div>
                                    <!--<div class="instructions newBrowser">
                                        Drag and resize the circle to crop your image. Click "Set as public photo" when you're satisfied. </div>-->
                                </div>
                                <div id="uploadBtn" class="popupButtons" hidden>
                                    <center>
                                        <input type="submit" name="submitPhoto" class="btn btn-success " value="عوض کردن تصویر پروفایل">
                                        <input type="submit" name="cancel" class="btn btn-default commonBtn" value="لغو">
                                    </center>
                                </div>

                                @if(isset($msg) && !empty($msg))
                                    <center class="mg-tp-20px dark-red">
                                        {{$msg}}
                                    </center>
                                @endif
                            </form>

                            <div class="creatingAvatar fromList" id="change-picture">
                            </div>

                            <div id="defaultPhotoBtn" class="popupButtons" hidden>
                                <center class="mg-tp-10">
                                    <input type="submit" onclick="submitPhoto('{{$user->id}}', 'secondaryContainer')" class="btn btn-success " value="عوض کردن تصویر پروفایل">
                                    <input type="submit" class="btn btn-default commonBtn" value="لغو">
                                </center>
                            </div>
                        </div>

                        <div class="avatarPreview">
                            <div class="circularAvWrap">
                                <img id="mainContainer" src="{{$photo}}" class="circularAvatar"/>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <script>

        {{--var defaultPics = '{{route('defaultPics')}}';--}}
        var submitPhotoDir = '{{route('upload.submitPhoto')}}';

        $(document).ready(function() {

            $('#upload_but').click(function (e) {
                showBox1();
            });

            $('#change_but').click(function (e) {
                $('.uploadAvatarPopup').show();
                $('.avatarPreview').show();
                $('.mainAction').show();
                $('.commonBtn').show();
                $("#change-picture").show();
                $("#defaultPhotoBtn").show();


            });
            $('.commonBtn').click(function (e) {
                $('.uploadAvatarPopup').hide();
                $('.avatarPreview').hide();
                $('.mainAction').hide();
                $('.commonBtn').hide();
                $("#change-picture").hide();
                $("#upload-picture").hide();
                $("#defaultPhotoBtn").hide();
                $("#uploadBtn").hide();
            });
        });

        function showBox1() {
            $('.uploadAvatarPopup').show();
            $('.avatarPreview').show();
            $('.mainAction').show();
            $('.commonBtn').show();
            $("#upload-picture").show();
            $("#uploadBtn").show();
        }

    </script>

    <script>


        function getDefaultPics(containerElement) {

            $("#" + containerElement).empty();
            mode = 0;

            $.ajax({

                type: 'post',
                url: '{{route("getDefaultPics")}}',
                data: {},

                success: function (response) {

                    response = JSON.parse(response);

                    newElement = "";

                    newElement += "<div class='avatarList'>";

                    for(i = 0; i < response.length; i++) {
                        newElement += "<div class='circularAvWrap'>";
                        newElement += "<img id='" + response[i].name + "' onclick='changePhoto(id, \"mainContainer\")' src='" + response[i].name + "' class='cursor-pointer circularAvatar'/>";
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
    </script>

    @if(isset($msg) && !empty($msg))
        <script>showBox1()</script>
    @endif
@stop
