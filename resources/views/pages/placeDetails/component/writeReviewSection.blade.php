<style>
    .editReviewPicturesSection{
        position: fixed;
        z-index: 99;
        background-color: #000000bf;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
    }
    .backEditReviewPic{
        color: var(--koochita-light-green);
        background-color: white !important;
        border: none;
        box-shadow: none;
        display: inline-block;
    }
</style>

<div id="reviewMainDivDetails" class="postModalMainDiv hidden" style="z-index: 9999;">
    <div class="modal-dialog">
        <div>
            <input type="hidden" id="storeReviewKindPlaceId" name="kindPlaceId" value="{{$kindPlaceId}}">
            <input type="hidden" id="storeReviewPlaceId" name="placeId" value="{{$place->id}}">
            <input type="hidden" id="storeReviewCode" name="code" value="{{$userCode}}">
            <input type="hidden" id="assignedMemberToReview" name="assignedUser">
            <input type="hidden" id="multiAnsInput" name="multiAns">
            <input type="hidden" id="multiQuestionInput" name="multiQuestion">
            <input type="hidden" id="rateAnsInput" name="rateAns">
            <input type="hidden" id="rateQuestionInput" name="rateQuestion">

            <div class="modal-content">
                <div class="postMainDivHeader" style="display: flex; justify-content: space-between">
                    <button type="button" class="close closeBtnPostModal" data-dismiss="modal" onclick="closeNewPostModal()">&times;</button>
                    {{__('دیدگاه شما')}}
                </div>
                <div class="commentInputMainDivModal">
                    <div class="inputBoxGeneralInfo inputBox postInputBoxModal">
                        <div class="profilePicForPostModal circleBase type2">
                            <img src="{{ $userPic }}" style="width: 100%; height: 100%; border-radius: 50%;">
                        </div>
                        <textarea id="postTextArea" class="inputBoxInput inputBoxInputComment openEmojiIcon"
                                  name="text" type="text"
                                  placeholder="{{ auth()->user()->username }}، چه فکر یا احساسی داری.....؟"
                                  style="overflow:hidden" data-emo onchange="checkReviewToSend()"></textarea>
                        <div id="emojiIcons" class="commentSmileyIcon " style="width: 300px; text-align: left"></div>
                    </div>

                    <div class="clear-both"></div>
                    <div class="row" style="width: 97%; margin: 0px auto;">
                        <div id="reviewShowPics" class="commentPhotosMainDiv"></div>
                    </div>

                    <div class="addParticipantName">
                        <span class="addParticipantSpan">با</span>
                        <div class="inputBoxGeneralInfo inputBox addParticipantInputBoxPostModal">
                            <textarea id="assignedSearch" class="inputBoxInput" placeholder="{{__('چه کسی بودید؟ نام کاربری را وارد کنید')}}" onkeyup="searchUser(this.value)"></textarea>
                            <div class="assignedResult" id="assignedResultReview"></div>
                            <div class="participantDivMainDiv" id="participantDivMainDiv"></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-details-content">
                <center class="commentMoreSettingBar">
                    <div class="commentOptionsBoxes">
                        <label for="picReviewInput0">
                            <span class="addPhotoCommentIcon"></span>
                            <span class="commentOptionsText">{{__('عکس اضافه کنید.')}}</span>
                        </label>
                    </div>
                    <input type="file" id="picReviewInput0" accept="image/*" style="display: none"
                           onchange="uploadReviewPics(this, 0)">
                    <div class="commentOptionsBoxes">
                        <label for="videoReviewInput">
                            <span class="addVideoCommentIcon"></span>
                            <span class="commentOptionsText">{{__('ویدیو اضافه کنید.')}}</span>
                        </label>
                    </div>
                    <input type="file" id="videoReviewInput" accept="video/*" style="display: none" onchange="uploadReviewVideo(this, 0)">
                    <div class="commentOptionsBoxes">
                        <label for="video360ReviewInput">
                            <span class="add360VideoCommentIcon"></span>
                            <span class="commentOptionsText">{{__('افزودن ویدیو 360')}}</span>
                        </label>
                    </div>
                    <input type="file" id="video360ReviewInput" accept="video/*" style="display: none" onchange="uploadReviewVideo(this, 1)">
                    <div class="commentOptionsBoxes">
                        <span class="tagFriendCommentIcon"></span>
                        <span class="commentOptionsText">{{__('افزودن دوست')}}</span>
                    </div>
                </center>

                @foreach($textQuestion as $item)
                    <div id="questionDiv_{{$item->id}}" class="commentQuestionsForm">
                        <span class="addOriginCity">{{$item->description}}</span>
                        <div class="inputBoxGeneralInfo inputBox addOriginCityInputBoxPostModal">
                            <textarea id="textQuestionAns_{{$item->id}}" name="textAns[]" class="inputBoxInput inputBoxInputComment" style="border: solid gray 1px; border-radius: 5px"></textarea>
                            <input type="hidden" id="textQuestionId_{{$item->id}}" name="textId[]" value="{{$item->id}}">
                        </div>
                    </div>
                @endforeach

                @foreach($multiQuestion as $index => $item)
                    <div class="commentQuestionsForm">
                        <div class="visitKindCommentModalHeader">
                            {{$item->description}}
                        </div>
                        <div class="visitKindCommentModal">
                            @for($i = 0; $i < count($item->ans); $i++)
                                <label for="radioAns_{{$item->id}}_{{$item->ans[$i]->id}}">
                                    <b id="radioAnsStyle_{{$item->id}}_{{$item->ans[$i]->id}}"
                                       class="filterChoices multiSelectAns">
                                        {{$item->ans[$i]->ans}}
                                    </b>
                                </label>
                                <input id="radioAns_{{$item->id}}_{{$item->ans[$i]->id}}"
                                       value="{{$item->ans[$i]->id}}"
                                       name="radioAnsName_{{$item->id}}"
                                       onchange="radioChange(this.value, {{$item->id}}, {{$index}}, {{$item->ans[$i]->id}})"
                                       type="radio" style="display: none">
                            @endfor
                        </div>
                    </div>
                @endforeach

                <div class="commentQuestionsRatingsBox">
                    {{--<div class="commentQuestionsRatingsBoxHeader"></div>--}}

                    @for($i = 0; $i < count($rateQuestion); $i++)
                        <div class="display-inline-block full-width">
                            <b id="rateName_{{$i}}"
                               class="col-xs-3 font-size-15 line-height-108 pd-lt-0"></b>
                            <div class="prw_rup prw_common_bubble_rating overallBubbleRating col-xs-3 text-align-left pd-0">
                                <div class="font-size-25" style="display: flex;">
                                    <span id="rate_5_{{$i}}" class="starRating"
                                          onmouseover="momentChangeRate({{$i}}, 5, 'in')"
                                          onmouseleave="momentChangeRate({{$i}}, 5, 'out')"
                                          onclick="chooseQuestionRate({{$i}}, 5, {{$rateQuestion[$i]->id}})"></span>
                                    <span id="rate_4_{{$i}}" class="starRating"
                                          onmouseover="momentChangeRate({{$i}}, 4, 'in')"
                                          onmouseleave="momentChangeRate({{$i}}, 4, 'out')"
                                          onclick="chooseQuestionRate({{$i}}, 4, {{$rateQuestion[$i]->id}})"></span>
                                    <span id="rate_3_{{$i}}" class="starRating"
                                          onmouseover="momentChangeRate({{$i}}, 3, 'in')"
                                          onmouseleave="momentChangeRate({{$i}}, 3, 'out')"
                                          onclick="chooseQuestionRate({{$i}}, 3, {{$rateQuestion[$i]->id}})"></span>
                                    <span id="rate_2_{{$i}}" class="starRating"
                                          onmouseover="momentChangeRate({{$i}}, 2, 'in')"
                                          onmouseleave="momentChangeRate({{$i}}, 2, 'out')"
                                          onclick="chooseQuestionRate({{$i}}, 2, {{$rateQuestion[$i]->id}})"></span>
                                    <span id="rate_1_{{$i}}" class="starRating"
                                          onmouseover="momentChangeRate({{$i}}, 1, 'in')"
                                          onmouseleave="momentChangeRate({{$i}}, 1, 'out')"
                                          onclick="chooseQuestionRate({{$i}}, 1, {{$rateQuestion[$i]->id}})"></span>
                                </div>
                            </div>
                            <b class="col-xs-6 font-size-15 line-height-108">{{$rateQuestion[$i]->description}}</b>
                        </div>
                    @endfor
                </div>

                <button id="sendReviewButton" class="postMainDivFooter" type="button" onclick="checkReviewToSend('send');">
                    {{__('ارسال دیدگاه')}}
                </button>

                <div id="sendReviewLoader" class="postMainDivFooter" style="display: none; justify-content: center; align-items: center; color: #cccccc;">
                    <img src="{{URL::asset('images/icons/mGear.svg')}}" style="width: 30px; height: 30px;">
                    {{__('در حال ارسال دیدگاه')}}
                </div>

            </div>

        </div>

        <div id="editReviewPictures" class="editReviewPicturesSection backDark hidden">
            <span class="ui_overlay ui_modal photoUploadOverlay editSection">
                <div class="body_text" style="padding-top: 12px">
                   <div class="headerBar epHeaderBar"></div>
                   <div class="row">
                      <div class="col-md-12">
                         <div style="margin: 5px 15px">قاب مربع</div>
                         <div class="img-container" style="position: relative">
                            <img class="imgInEditor" id="imgEditReviewPics" alt="Picture"
                                 style="width: 100%;">
                         </div>
                      </div>
                   </div>
                   <div class="row" id="actions" >
                      <div class="col-md-12 docs-buttons">
                        <div class="editBtnsGroup">
                            <div class="editBtns">
                               <div class="flipHorizontal" data-toggle="tooltip"
                                    data-placement="top" title="Flip Horizontal"
                                    onclick="cropper.scaleY(-1)"></div>
                            </div>

                            <div class="editBtns">
                               <div class="flipVertical" data-toggle="tooltip" data-placement="top"
                                    title="Flip Vertical" onclick="cropper.scaleX(-1)"></div>
                            </div>
                        </div>
                        <div class="editBtnsGroup">
                            <div class="editBtns">
                               <div class="rotateLeft" data-toggle="tooltip" data-placement="top"
                                    title="چرخش 45 درجه ای به سمت چپ"
                                    onclick="cropper.rotate(-45)"></div>
                            </div>

                            <div class="editBtns">
                               <div class="rotateRight" data-toggle="tooltip" data-placement="top"
                                    title="چرخش 45 درجه ای به سمت راست"
                                    onclick="cropper.rotate(45)"></div>
                            </div>
                        </div>
                        <div class="editBtnsGroup">
                            <div class="editBtns">
                               <div class="cropping" data-toggle="tooltip" data-placement="top"
                                    title="برش" onclick="cropper.crop()"></div>
                            </div>

                            <div class="editBtns">
                               <div class="clearing" data-toggle="tooltip" data-placement="top"
                                    title="بازگشت به اول" onclick="cropper.clear()"></div>
                            </div>
                        </div>

                        <div class="upload" style="margin-right: auto;">
                            <div onclick="$('#editReviewPictures').addClass('hidden')" class="uploadBtn backEditReviewPic" >بازگشت</div>
                            <div onclick="cropReviewImg()" class="uploadBtn ui_button primary">تایید</div>
                        </div>

                        <div class="modal fade docs-cropped" id="getCroppedCanvasModal"
                               role="dialog" aria-hidden="true"
                               aria-labelledby="getCroppedCanvasTitle" tabindex="-1">
                           <div class="modal-dialog modal-dialog-scrollable">
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <h5 class="modal-title" id="getCroppedCanvasTitle">Cropped</h5>
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>
                                 <div class="modal-body"></div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                    <a class="btn btn-primary" id="download"
                                       href="javascript:void(0);"
                                       download="cropped.jpg">Download</a>
                                 </div>
                              </div>
                           </div>
                        </div><!-- /.modal -->

                     </div>
                   </div>
               </div>
                <div class="ui_close_x" onclick="$('#editReviewPictures').addClass('hidden');"></div>
            </span>
        </div>
    </div>
</div>

<script>
    var allReviews;
    var reviewsCount;
    var imgCropNumber;
    var fileUploadNum = 0;
    var reviewPicNumber = 0;

    var assignedUser = [];
    var reviewMultiAns = [];
    var reviewRateAnsId = [];
    var rateQuestionAns = [];
    var reviewMultiAnsId = [];
    var reviewRateAnsQuestionId = [];
    var reviewMultiAnsQuestionId = [];
    var uploadedWriteReviewPicture = [];

    var rateQuestion = {!! json_encode($rateQuestion) !!} ;
    var textQuestions = {!! json_encode($textQuestion) !!};

    var storeReviewURLM = '{{route("storeReview")}}';
</script>
<script defer src="{{URL::asset('js/pages/placeDetialsWriteReview.js')}}"></script>

