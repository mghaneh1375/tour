<link rel="stylesheet" href="{{URL::asset('css/theme2/cropper.css?v=1')}}">
<link rel='stylesheet' type='text/css' href='{{URL::asset('css/component/editor.css?v='.$fileVersions)}}'/>

@if(\App::getLocale() == 'en')
    <style>
        .photoUploader .headerBar h3{
            float: left;
            padding-right: 0px;
            padding-left: 14px;
        }
        .closeAddPhotographer{
            right: 10px;
            left: auto;
        }
        .epInputBoxText{
            padding-right: 15px;
            border-right: 1px solid #d8d8d8;
            padding-left: 0px;
            border-left: none;
        }
        .epInputIconRequired{
            right: -10px;
            left: auto;
        }
        .itemRow .row .col-xs-7{
            float: left;
            border-left: none;
            border-right: 1px solid #cccccc;
        }
        .imageVerificationBtn{
            right: 10px;
            left: auto;
        }
        .secondStepPolicyText{
            padding: 0 10px 0 5px;
        }
        #guidelinesOverlay{
            left: 460px;
            right: auto;
        }
    </style>
@endif

<div id="addPhotographerModal" class="addPhotographerModal hidden">
    <input id="uploadPhotoInputPic" type="file" accept="image/*" style="display: none;" onchange="submitPhoto(this)">
    <span id="photoEditor" class="ui_overlay ui_modal photoUploadOverlay">
         <div class="body_text">
             <div class="photoUploader">
                 <div class="headerBar">
                     <h3 id="photoUploadHeader" class="photoUploadHeader">
                         <span>{{__('افزودن تصویر به')}} </span>
                         <span class="titleOfUploadPhoto"></span>
                     </h3>
                 </div>
                 <div id="uploader-dlg" class="uploaderDlg hasFiles" style="height: calc(100% - 48px);">
                     <div id="dropArea" class="startScreen infoScreen">
                         <div class="inner">
                             <div class="innerPic"></div>
                             <label for="uploadPhotoInputPic" class="uploadPicChoosePic">
                                 <div class="ui_button primary addPhotoBtn">
                                     <span>{{__('عکس خود را انتخاب کنید')}}</span>
                                 </div>
                             </label>

                             <div class="separator">
                                 <span class="text">{{__('یا')}}</span>
                             </div>
                             <div class="dragDropText">{{__('به سادگی عکس خود را در این قاب قرار دهید')}}</div>

                             <div class="invalidDragScreen infoScreen hidden">
                                 <div class="inner">
                                     <div class="dropText">That image type is not supported. Please use a jpeg or png.</div>
                                 </div>
                                 <div class="dropOverlay"></div>
                             </div>

                             <div id="photographerLoadingPic" class="progressScreen infoScreen hidden">
                                 <div class="inner">
                                     <img alt="loading" src="{{URL::asset('images/loading.gif?v='.$fileVersions)}}">
                                 </div>
                             </div>

                         </div>
                         <div class="footerTextBox stFooter">
                             <span>{{__('توجه نمایید که عکس‌ما می‌بایست در فرمت های رایج تصویر و با حداکثر سایز 500 مگابایت باشد. تصاویر پیش از انتشار توسط ما بازبینی می‌گردد. لطفاً از بارگذاری تصاویری که با قوانین سایت مغایرت دارند اجتناب کنید.')}}</span>
                             <a href="{{route('policies')}}" target="_blank" class="footerPolicyLink">{{__('صفحه مقررات')}}</a>
                         </div>
                     </div>
                     <div class="template itemRow loading" style="height: 100%; overflow-y: auto; width: 100%">
                         <div class="row uploadPicMainSection" style="display: flex">
                             <div class="col-xs-7" style="margin-bottom: 10px;">
                                 <div>
                                     <div class="epPicBox">
                                         <div class="epPic">
                                             <div class="imgContainer">
                                                 <img alt="loading" id="rectanglePicUploadPhoto">
                                             </div>
                                         </div>
                                         <div class="step6picText epicText">{{__('قاب مستطیل')}}</div>
                                         <div class="epEditPicText" onclick="doEdit(1.77, 'rectanglePicUploadPhoto');" style="cursor: pointer;">{{__('ویرایش')}}</div>
                                     </div>
                                     <div class="epPicBox">
                                         <div class="epPic">
                                             <div class="imgContainer">
                                                 <img alt="loading" id="squarePicUploadPhoto">
                                             </div>
                                         </div>
                                         <div class="epPicText">{{__('قاب مربع')}}</div>
                                         <div class="epEditPicText" onclick="doEdit(1, 'squarePicUploadPhoto');" style="cursor: pointer;">{{__('ویرایش')}}</div>
                                     </div>
                                 </div>
                                 <div class="photoTemplateTypeDesc">{{__('عکس‌های ما در دو نوع قاب مختلف نمایش داده می‌شود می‌توانید خود نسبت به برش نمایش مناسب عکس در داخل قاب اقدام نمایید در غیر اینصورت تصویر به صورت اتوماتیک برش می‌خورد')}}</div>

                                 <div class="imageVerificationBtn">
                                     <button onclick="newUploadPic()">تغییر عکس</button>
                                </div>
                                 <div class="photographerErrors hideOnPhone"></div>
                             </div>
                             <div class="col-xs-5 uploadPicInfoSection">

                                 <div id="uploadPhotoPicAltDiv" class="epInputBox">
                                    <div class="epInputBoxText">
                                        <div class="epInputBoxRequired"><div class="icons epInputIconRequired redStar"></div>{{__('عکس برای')}}:</div>
                                    </div>
                                    <input class="epInputBoxInput" id="placeNameUploadPhoto" onclick="searchPlaceForUploadPhoto()" readonly>
                                    <input type="hidden" class="epInputBoxInput" id="placeIdUploadPhoto">
                                    <input type="hidden" class="epInputBoxInput" id="kindPlaceIdUploadPhoto" >
                                </div>

                                <div id="uploadPhotoPicNameDiv" class="epInputBox">
                                    <div class="epInputBoxText">
                                        <div class="epInputBoxRequired">
                                            <div class="icons epInputIconRequired redStar"></div>
                                            {{__('نام عکس')}}
                                        </div>
                                    </div>
                                    <input class="epInputBoxInput" id="uploadPhotoPicName" onkeydown="$('#uploadPhotoPicNameDiv').removeClass('inputUploadPhotosError')">
                                </div>
                                <div id="uploadPhotoPicAltDiv" class="epInputBox">
                                    <div class="epInputBoxText">
                                        <div class="epInputBoxRequired">{{__('نام جایگزین')}}</div>
                                    </div>
                                    <input class="epInputBoxInput" id="uploadPhotoPicAlt" onkeydown="$('#uploadPhotoPicAltDiv').removeClass('inputUploadPhotosError')">
                                </div>
                                <div class="epRedNotice">{{__('نام جایگزین توصیف کننده موضوعی است که از تصویر استنباط می شود')}}</div>

                                <div>
                                   <div class="epTitle">{{__('توضیحات')}}</div>
                                   <textarea class="epAddresText" placeholder="{{__('توضیحات همراه با عکس برای دوستانتان نمایش داده می شود.حداقل 100 کاراکتر')}}" maxlength="100" id="uploadPhotoDescription"></textarea>
                                </div>

                                 <div class="termsLabel">
                                     <div style="display: flex">
                                         <div class="secondStepPolicyCheckBox">
                                             <input id="uploadPhotoRole" type="checkbox" onchange="clickUploadRoleButton()">
                                             <label for="uploadPhotoRole">
                                                 <span id="uploadCheckBoxPolici"></span>
                                             </label>
                                         </div>
                                         <div class="secondStepPolicyText">
                                             {{__('تایید میکنم تمامی حقوق مرتبط با انتشار این تصویر متعلق به من می باشد. تایید می نمایم در صورت حضور چهره دیگران در تصویر، آن ها نیز از انتشار این عکس راضی می باشند.')}}
                                             <div id="photoUploadTipsLink" class="headerLink tipsLink" style="display: inline-block; font-size: 10px;">
                                                 <a href="{{route("policies")}}" target="_blank">{{__('صفحه مقررات')}}</a>
                                                 <span id="guidelinesOverlay" class="hidden ui_overlay ui_popover arrow_top guidelinesOverlayParent ui_tooltip">
                                                     <div class="header_text"></div>
                                                     <div class="body_text">
                                                         <div class="guidelinesOverlay">
                                                             <div class="listHdr">All photos must be...</div>
                                                             <ul class="listBody">
                                                                 <li>Family-friendly</li>
                                                                 <li>Original, non-copyrighted images</li>
                                                                 <li>Non-commercial</li>
                                                                 <li>Virus-free</li>
                                                                 <li>In
                                                                    <b>.gif</b>,
                                                                    <b>.jpg</b>, or
                                                                    <b>.png</b> format</li>
                                                                 <li>No more than 50 photos per upload</li>
                                                             </ul>
                                                             <div class="listFtr">Read our complete <a href="https://www.tripadvisorsupport.com/hc/en-us/articles/200615067-Photo-Guidelines" target="_blank" class="js_popFraud">photo submission guidelines</a>.</div>
                                                         </div>
                                                     </div>
                                                     <div class="ui_close_x" onclick="$('#guidelinesOverlay').addClass('hidden')"></div>
                                                 </span>
                                             </div>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="upload secondFooterVerification">
                                      <div onclick="resizeImg()" class="uploadBtn ui_button primary confirmButton" style="padding: 8px 20px;">{{__('تایید و انتشار')}}</div>
                                      <div class="photographerErrors hideOnScreen"></div>
                                 </div>

                             </div>
{{--                             <div class="col-xs-12 footer secondStepFooter">--}}
{{--                                 <div id="photographerErrors" style="color: red; position: absolute; bottom: 0px"></div>--}}
{{--                                 <div class="upload secondFooterVerification">--}}
{{--                                     <div onclick="resizeImg()" class="uploadBtn ui_button primary confirmButton" style="padding: 8px 20px;">{{__('تایید و انتشار')}}</div>--}}
{{--                                 </div>--}}
{{--                             </div>--}}
                         </div>
                     </div>
                     <div class="successScreen hidden">
                         <div class="successTextBox">
                            <div class="successText">{{__('موفق شدید')}}</div>
                            <div class="successTextDes">{{__('عکس شما برای ما ارسال گردید و پس از بررسی بارگذاری خواهد شد')}}</div>
                         </div>
                         <div class="uploadNextPicBtnBox">

                             <label for="uploadPhotoInputPic" style="width: 250px;">
                                 <div class="uploadNextPicBtn ui_button primary confirmButton">{{__('بارگذاری عکس بعدی')}}</div>
                             </label>

                             <div class="uploadNextPicDeny" onclick="closePhotoModal()">{{__('نه، برای بعد')}}</div>

                         </div>
                         <div id="uploadedImgDiv" class="uploadedImgDiv"></div>
                         <div class="footerTextBox" style="position: absolute; bottom: 0">
                             <span>{{__('پس از تایید عکس امتیاز شما در پروفایل افزایش خواهد یافت. به گذاشتن عکس ادامه دهید تا علاوه بر امتیاز بتوانید نشان های افتخار مخصوص عکس را برنده شوید.')}}</span>
                             <a href="{{route('policies')}}" class="footerPolicyLink" onclick="">{{__('صفحه مقررات')}}</a>
                         </div>

                     </div>
                 </div>
             </div>
         </div>

         <div class="iconFamily iconClose closeAddPhotographer" onclick="$('#addPhotographerModal').addClass('hidden');"></div>
        <img alt="کوچیتا، سامانه جامع گردشگری ایران"  id="mainPicUploadPhotoImg" style="display: none">
    </span>
</div>

{{--<div class="mainPicUploadPercentDiv" style="display: none;">--}}
{{--    <div class="mainUploadProgressBar">--}}
{{--        <div class="progressPercent">0%</div>--}}
{{--    </div>--}}
{{--</div>--}}

<script>
    var proSearchUrl = '{{route("proSearch")}}';
</script>

<script defer src="{{URL::asset('js/component/uploadPhoto.js')}}"></script>
