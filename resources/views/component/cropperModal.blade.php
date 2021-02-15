<link rel="stylesheet" href="{{URL::asset('css/component/cropImg.css')}}">

<div id="editCropModal" class="modalBlackBack editCropModal fullCenter notCloseOnClick">
    <div class="modalBody">
        <div class="closeModal iconClose" onclick="closeCropImgModal()"></div>
        <div class="body_text photoUploaderCrop">
             <div class="headerBar">
                 <h3 class="photoUploadHeader">ویرایش تصویر</h3>
             </div>
            <div class="bodyEditFrame">
               <div class="row hasBorder">
                 <div class="img-container img-container-photogrpher" style="position: relative">
                    <img class="imgInEditor" id="editUploadPhoto" alt="Picture" style="max-width: 100%;">
                 </div>
               </div>
               <div class="row">
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
                                <div onclick="submitCropInModal()" class="uploadBtn ui_button primary confirmButton">تایید</div>
                            </div>
                            <div class="return">
                                <div onclick="closeCropImgModal()" class="returnBtnEditPhoto">بازگشت</div>
                            </div>
                        </div>
                    </div>
               </div>
           </div>
        </div>
    </div>
</div>

<script defer src="{{URL::asset('js/cropper.js?v='.$fileVersions)}}"></script>
<script defer src="{{URL::asset('js/mainCrop.js?v='.$fileVersions)}}"></script>
<script defer src="{{URL::asset('js/component/cropImg.js?v='.$fileVersions)}}"></script>
