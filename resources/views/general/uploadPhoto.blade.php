<link rel="stylesheet" href="{{URL::asset('css/theme2/cropper.css?v=1')}}">
<link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/component/editor.css?v=2')}}'/>

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
    <span id="editPane" class="ui_overlay ui_modal photoUploadOverlay hidden">
        <div class="body_text photoUploader">
             <div class="headerBar">
                 <h3 id="photoUploadHeader" class="photoUploadHeader">
                     <span>{{__('افزودن تصویر به')}} </span>
                     <span class="titleOfUploadPhoto"></span>
                 </h3>
             </div>
            <div class="bodyEditFrame">
               <div class="row">
                  <div class="col-md-12" style="padding: 0px">
                     <div class="img-container img-container-photogrpher" style="position: relative">
                        <img class="imgInEditor" id="editUploadPhoto" alt="Picture" style="width: 100%;">
                     </div>
                  </div>
               </div>
               <div class="row" id="actions" style="">
                        <div class="col-md-12 docs-buttons">

                            <div class="uploadPicCropLeftSection">
                                <div class="editBtnsGroup">
                                <div class="editBtns">
                                   <div class="flipVertical" data-toggle="tooltip" data-placement="top" title="Flip Horizontal" onclick="rotateUploadPhoto('Y')"></div>
                                </div>
                                <div class="editBtns">
                                   <div class="flipHorizontal" data-toggle="tooltip" data-placement="top" title="Flip Vertical" onclick="rotateUploadPhoto('X')"></div>
                                </div>
                            </div>

                                <div class="editBtnsGroup">
                                    <div class="editBtns">
                                       <div class="rotateLeft" data-toggle="tooltip" data-placement="top" title="{{__('چرخش 45 درجه ای به سمت چپ')}}" onclick="cropper.rotate(-45)"></div>
                                    </div>
                                    <div class="editBtns">
                                       <div class="rotateRight" data-toggle="tooltip" data-placement="top" title="{{__('چرخش 45 درجه ای به سمت راست')}}" onclick="cropper.rotate(45)"></div>
                                    </div>
                                </div>

                                <div class="editBtnsGroup">
                                <div class="editBtns">
                                   <div class="cropping" data-toggle="tooltip" data-placement="top" title="{{__('برش')}}" onclick="cropper.crop()"></div>
                                </div>
                                <div class="editBtns">
                                    <div class="clearing" data-toggle="tooltip" data-placement="top" title="{{__('بازگشت به اول')}}" onclick="cropper.clear()"></div>
                                </div>
                            </div>
                            </div>

                            <div class="btnActionEditFrame">
                                <div class="upload" style="margin-left: 10px">
                                    <div onclick=" cropImg();" class="uploadBtn ui_button primary confirmButton">{{__('تایید')}}</div>
                                </div>

                                <div class="return">
                                    <div onclick="cancelCrop()" class="returnBtnEditPhoto">{{__('بازگشت')}}</div>
                                </div>
                            </div>

                        <!-- Show the cropped image in modal -->
                            <div class="modal fade docs-cropped" id="getCroppedCanvasModal" role="dialog" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" tabindex="-1">
                           <div class="modal-dialog modal-dialog-scrollable">
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <h5 class="modal-title" id="getCroppedCanvasTitle">Cropped</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>
                                 <div class="modal-body"></div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.jpg">Download</a>
                                 </div>
                              </div>
                           </div>
                        </div>

                     </div>
                   </div>
           </div>
        </div>
        <div class="ui_close_x" onclick="$('#editPane').addClass('hidden'); $('#darkModeMainPage').hide()"></div>
    </span>

    <input id="uploadPhotoInputPic" type="file" accept="image/*" style="display: none;" onchange="submitPhoto(this.files[0])">
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
                                     <button onclick="newUploadPic()">
                                         {{__('تغییر عکس')}}
                                     </button>
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

<style>
    .mainPicUploadPercentDiv{
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: 99999;
    }
    .mainUploadProgressBar{
        position: absolute;
        bottom: 25%;
        background: #ffffffd1;
        width: 90%;
        right: 5%;
        border-radius: 10px;
        height: 25px;
        display: flex;
        overflow: hidden;
    }
    .progressPercent{
        width: 0%;
        background: var(--koochita-yellow);
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 10px;
    }
</style>

<div class="mainPicUploadPercentDiv" style="display: none;">
    <div class="mainUploadProgressBar">
        <div class="progressPercent">0%</div>
    </div>
</div>

<script src="{{URL::asset('js/cropper.js')}}"></script>

<script src="{{URL::asset('js/mainCrop.js')}}"></script>

<script>
    var file;
    var uploadPhotoUrl;
    var crop1Clicked = false;
    var crop2Clicked = false;
    var cropResult;
    var mainPicUploadPhoto;
    var uploadPhotoFormData = new FormData();
    var dropzone = $('#dropArea');
    var userId = '{{auth()->user()->id}}';
    var additionalData;
    var lImage;
    var tImage;
    var sImage;
    var fImage;
    var mainImage;
    var mainFileName = null;
    var mainFilesUploaded = [];
    var placeIdUploadPhoto;
    var kindPlaceIdUploadPhoto;
    var repeatTime = 3;
    var squerImg;
    var reqImg;

    //drag and drop file
    dropzone.on('dragover', function() {
        dropzone.addClass('hover');
        return false;
    });
    dropzone.on('dragleave', function() {
        dropzone.removeClass('hover');
        return false;
    });
    dropzone.on('drop', function(e) {
        e.stopPropagation();
        e.preventDefault();
        dropzone.removeClass('hover');
        var files = e.originalEvent.dataTransfer.files;
        submitPhoto(files[0]);
        return false;
    });

    function openUploadPhotoModal(_title, _uploadUrl, _placeId = 0, _kindPlaceId = 0, _additionalData){

        $('#placeIdUploadPhoto').val(_placeId);
        $('#kindPlaceIdUploadPhoto').val(_kindPlaceId);
        $('#placeNameUploadPhoto').val(_title);

        $('.titleOfUploadPhoto').text(_title);
        uploadPhotoUrl = _uploadUrl;
        additionalData = _additionalData;

        if(!checkLogin())
            return;

        $("#addPhotographerModal").removeClass('hidden');
    }

    function closePhotoModal(){
        $(".successScreen").addClass('hidden');

        newUploadPic();

        $('#addPhotographerModal').addClass('hidden');
    }

    function submitPhoto(input) {
        openLoading();
        mainImage = input;

        $('#uploadPhotoPicName').val('');
        $('#uploadPhotoPicAlt').val('');
        $('#uploadPhotoDescription').val('');
        $(".successScreen").addClass('hidden');

        var reader = new FileReader();
        reader.onload = function(e) {
            $('#rectanglePicUploadPhoto').attr('src', e.target.result);
            $('#squarePicUploadPhoto').attr('src', e.target.result);
            $('#mainPicUploadPhotoImg').attr('src', e.target.result);
            mainPicUploadPhoto = e.target.result;
            closeLoading();
        };
        $(".itemRow").css('display', 'block');
        $(".startScreen").addClass('hidden');
        $(".action").css('display', 'block');
        $(".footer").removeClass('hidden');
        reader.readAsDataURL(input);
    }

    function doEdit(ratio, result) {
        cropResult = result;
        if(ratio != 1) {
            $('#editUploadPhoto').attr('src', mainPicUploadPhoto);
            setMode(1);
            crop1Clicked = true;
            $("#saveBtn").removeClass('hidden');
            $("#saveBtn2").addClass('hidden');
            $('#frameEditorHeader').text('({{__('قاب مستطیل')}})')
        }
        else {
            $('#editUploadPhoto').attr('src', mainPicUploadPhoto);
            setMode(2);
            crop2Clicked = true;
            $("#saveBtn").addClass('hidden');
            $("#saveBtn2").removeClass('hidden');
            $('#frameEditorHeader').text('({{__('قاب مربع')}})')
        }
        startCropper(ratio);
        $('#photoEditor').addClass('hidden');
        $('#editPane').removeClass('hidden');
    }

    function resizeImg(){
        var name = document.getElementById('uploadPhotoPicName').value;
        var alt = document.getElementById('uploadPhotoPicAlt').value;
        var description = document.getElementById('uploadPhotoDescription').value;

        placeIdUploadPhoto = $('#placeIdUploadPhoto').val();
        kindPlaceIdUploadPhoto = $('#kindPlaceIdUploadPhoto').val();

        $('.photographerErrors').text('');

        if($('#uploadPhotoRole').is(":checked") && name.trim().length > 0 &&
            description.trim().length <= 100 && kindPlaceIdUploadPhoto != 0 &&
            placeIdUploadPhoto != 0) {

            openLoading();

            uploadPhotoFormData = new FormData();

            uploadPhotoFormData.append('name', name);
            uploadPhotoFormData.append('alt', alt);
            uploadPhotoFormData.append('description', description);
            uploadPhotoFormData.append('additionalData', additionalData);

            submitUpload('squ');
        }
        else {
            var text = '';
            if(name == null || name == '') {
                $('#uploadPhotoPicNameDiv').addClass('inputUploadPhotosError');
                text = '{{__('فیلد های بالا را پر کنید.')}}\n';
            }
            if(description.trim().length > 100){
                $('#uploadPhotoPicAltDiv').addClass('inputUploadPhotosError');
                text += '{{__('توضیح باید کمتر از 100 کاراکتر باشد.')}}\n';
            }

            if(placeIdUploadPhoto == 0 || placeIdUploadPhoto == 0){
                $('#uploadPhotoPicAltDiv').addClass('inputUploadPhotosError');
                text += '{{__('لطفا مشخص کنید که عکس برای چه مکانی است.')}}\n';
            }

            if(!$('#photographerRole').is(":checked")) {
                text += '{{__('تایید مقررات اجباری است')}}';
                $('#uploadCheckBoxPolici').addClass('tickInputUploadPhotosError');
                $('.secondStepPolicyText').css('color', 'red');
            }

            $('.photographerErrors').text(text);
        }
    }

    function submitUpload(type){
        var im = null;
        switch (type){
            case 'mainFile':
                im = mainImage;
                break;
            case 'squ':
                im = squerImg;
                break;
            case 'req':
                im = reqImg;
                break;
        }

        if(im == undefined)
            im = mainImage;
        $('.mainPicUploadPercentDiv').show();

        uploadPhotoFormData.set('pic', im);
        uploadPhotoFormData.set('fileName', mainFileName);
        uploadPhotoFormData.set('fileKind', type);
        uploadPhotoFormData.set('placeId', placeIdUploadPhoto);
        uploadPhotoFormData.set('kindPlaceId', kindPlaceIdUploadPhoto);

        $.ajax({
            type : 'post',
            url : uploadPhotoUrl,
            data: uploadPhotoFormData,
            processData: false,
            contentType: false,
            xhr: function () {
                var xhr = new XMLHttpRequest();
                xhr.upload.onprogress = function (e) {
                    var percent = '0';
                    var percentage = '0%';

                    if (e.lengthComputable) {
                        percent = Math.round((e.loaded / e.total) * 100);

                        if(type === 'squ')
                            percent = percent/2;
                        else if(type === 'req')
                            percent = 50 + percent/2;

                        percentage = percent + '%';
                        $('.progressPercent').css('width', percentage);
                        $('.progressPercent').text(percentage);
                    }
                };
                return xhr;
            },
            success: function (response) {
                if(response.status == 'ok'){
                    mainFileName = response.result[0];
                    switch (type){
                        case 'mainFile':
                            submitUpload('squ');
                            break;
                        case 'squ':
                            submitUpload('req');
                            break;
                        case 'req':
                            mainFilesUploaded[mainFilesUploaded.length] = response.result[1];
                            mainFileName = null;
                            goToPage3();
                            break;
                    }
                }
                else if(response.status == 'nok1'){
                    if(repeatTime != 0){
                        closeLoading();
                        $('.mainPicUploadPercentDiv').hide();
                        showSuccessNotifi('{{__("در بارگذاری عکس مشکلی پیش امده لطفا دوباره تلاش کنید.")}}', 'left', 'red');
                    }
                    else{
                        repeatTime--;
                        resizeImg();
                    }
                }
                else if(response.status == 'nok2'){
                    closeLoading();
                    $('.mainPicUploadPercentDiv').hide();
                    showSuccessNotifi('{{__("فرمت عکس باید jpg و یا webp و یا jpeg و یا png باشد")}}', 'left', 'red');
                }
                else if(response.status == 'sizeError'){
                    closeLoading();
                    $('.mainPicUploadPercentDiv').hide();
                    showSuccessNotifi('{{__("حجم عکس باید از 2 مگابایت کمتر باشد.")}}', 'left', 'red');
                }
            },
            error: function(err){
                closeLoading();
                $('.mainPicUploadPercentDiv').hide();
                showSuccessNotifi('{{__("در بارگذاری عکس مشکلی پیش امده لطفا دوباره تلاش کنید.")}}', 'left', 'red');
            }
        })
    }

    function newUploadPic(){
        $('#uploadPhotoInputPic').val('');
        $('#uploadPhotoPicName').val('');
        $('#uploadPhotoPicAlt').val('');
        $('#uploadPhotoDescription').val('');

        $(".itemRow").css('display', 'none');
        $(".startScreen").removeClass('hidden');
        $(".action").css('display', 'none');
        $(".footer").addClass('hidden');
    }

    function cropImg(){
        openLoading();
        setTimeout(function(){
            var canvas1;
            if(cropResult == 'squarePicUploadPhoto') {
                canvas1 = cropper.getCroppedCanvas({
                    minWidth: 250,
                    minHeight: 250,
                });
                canvas1.toBlob(function (blob) {
                    squerImg = blob;
                });
            }
            else {
                canvas1 = cropper.getCroppedCanvas({
                    minWidth: 600,
                    minHeight: 400,
                });
                canvas1.toBlob(function (blob) {
                    reqImg = blob;
                });
            }

            $('#' + cropResult).attr('src', canvas1.toDataURL());
            cancelCrop();
        }, 500);
    }

    function cancelCrop(){
        $('#modal').modal('hide');
        $('#photoEditor').removeClass('hidden');
        $('#editPane').addClass('hidden');
        closeLoading();
    }

    function goToPage3() {
        closeLoading();
        $('.mainPicUploadPercentDiv').hide();

        var text = '';
        var picWidth = Math.floor(100/mainFilesUploaded.length);
        for (var i = 0; i < mainFilesUploaded.length; i++){
            text += '<div class="uploadedImgShowDiv" style=" width: ' + picWidth + '%">\n' +
                    ' <img alt="کوچیتا، سامانه جامع گردشگری ایران" src="' + mainFilesUploaded[i] + '" class="uploadedImgPic" style="height: 100%; width: auto; ">\n' +
                    '</div>';
        }

        $('#uploadedImgDiv').html(text);
        $(".itemRow").css('display', 'none');
        $(".successScreen").removeClass('hidden');
    }

    function b64toBlob(dataURI) {

        var byteString = atob(dataURI.split(',')[1]);
        var ab = new ArrayBuffer(byteString.length);
        var ia = new Uint8Array(ab);

        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }
        return new Blob([ab], { type: 'image/jpeg' });
    }

    function searchPlaceForUploadPhoto(){
        createSearchInput(searchInPlacesUploadPhoto, '{{__('نام مکان مورد نظر را وارد کنید.')}}');
    }

    function searchInPlacesUploadPhoto(_element) {
        var value = _element.value;

        if(value.trim().length > 1){
            cities = -1;

            hotelFilter = 1;
            amakenFilter = 1;
            restuarantFilter = 1;
            majaraFilter = 1;
            sogatSanaieFilter = 1;
            mahaliFoodFilter = 1;
            boomgardyFilter = 1;


            $.ajax({
                type: 'POST',
                url: '{{route('proSearch')}}',
                data: {
                    key:  value,
                    hotelFilter: hotelFilter,
                    amakenFilter: amakenFilter,
                    restaurantFilter: restuarantFilter,
                    majaraFilter: majaraFilter,
                    sogatSanaieFilter: sogatSanaieFilter,
                    mahaliFoodFilter: mahaliFoodFilter,
                    boomgardyFilter: boomgardyFilter,
                    selectedCities: cities,
                    mode: 'city'
                },
                success: function (response) {
                    $("#resultPlace").empty();

                    if(response.length == 0)
                        return;

                    response = JSON.parse(response);

                    newElement = "";
                    for(i = 0; i < response.length; i++) {

                        if(response[i].kindPlace == 'هتل')
                            icon = '<div class="icons hotelIcon spIcons"></div>';
                        else if(response[i].kindPlace == 'رستوران')
                            icon = '<div class="icons restaurantIcon spIcons"></div>';
                        else if(response[i].kindPlace == 'اماکن')
                            icon = '<div class="icons touristAttractions spIcons"></div>';
                        else if(response[i].kindPlace == 'ماجرا')
                            icon = '<div class="icons adventure spIcons"></div>';
                        else if(response[i].kindPlace == 'غذای محلی')
                            icon = '<div class="icons traditionalFood spIcons"></div>';
                        else if(response[i].kindPlace == 'صنایع سوغات')
                            icon = '<div class="icons souvenirIcon spIcons"></div>';
                        else if(response[i].kindPlace == 'بوم گردی')
                            icon = '<div class="icons boomIcon spIcons"></div>';
                        else
                            icon = '<div class="icons touristAttractions spIcons"></div>';

                        newElement += '<div style="padding: 5px 20px; display: flex">' +
                            '   <div style="width: 80%; color: black;" onclick="choosePlaceForUploadPhoto(' + response[i].id + ', ' + response[i].kindPlaceId + ', \'' + response[i].cityName + '\', \'' + response[i].name + '\')">' +
                            '       <div>' +
                            icon +
                            '       <p class="suggest cursor-pointer font-weight-700" id="suggest_1" style="margin: 0px; display: inline-block;">' + response[i].name + '</p>' +
                            '       <p class="suggest cursor-pointer stateName" id="suggest_1">' + response[i].stateName + ' در ' + response[i].cityName + '</p>' +
                            '       </div>\n' +
                            '   </div>' +
                            '</div>';
                    }

                    setResultToGlobalSearch(newElement);
                }
            });
        }
        else
            clearGlobalResult();
    }

    function choosePlaceForUploadPhoto(_placeId, _kindPlaceId, _city, _placeName){
        var name = _placeName + ' در ' + _city;

        $('#placeIdUploadPhoto').val(_placeId);
        $('#kindPlaceIdUploadPhoto').val(_kindPlaceId);
        $('#placeNameUploadPhoto').val(name);
        closeSearchInput();
    }

    function clickUploadRoleButton(){
        $('#uploadCheckBoxPolici').removeClass('tickInputUploadPhotosError');
        $('.secondStepPolicyText').css('color', '#4a4a4a');

    }
</script>
