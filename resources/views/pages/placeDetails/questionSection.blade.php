<style>
    @media (max-width: 767px) {
        .newQuestionContainer > div{
            font-size: 12px;
        }
    }
</style>

<div class="seperatorSections"></div>

<div id="QAndAMainDivId" class="tabContentMainWrap" style="display: flex; flex-direction: column;">
    <div class="topBarContainerQAndAs display-none"></div>
    <div class="col-md-12 col-xs-12 QAndAMainDiv" style="margin-bottom: 10px;">
        <div class="mainDivQuestions">
            <div class="QAndAMainDivHeader">
                <h3>پرسش و پاسخ</h3>
            </div>
            <div class="askQuestionMainDiv">
                <div class="newQuestionContainer">
                    <div class="direction-rtl text-align-right float-right full-width mg-bt-10" style="font-weight: bold;">
                        سؤلات خود را بپرسید تا با کمک دوستانتان آگاهانه‌تر سفر کنید. همچنین می‌توانید با
                        پاسخ یه سؤالات دوستانتان علاوه بر دریافت امتیاز، اطلاعات خود را به اشتراک
                        بگذارید.
                    </div>
                    <div class="display-inline-block float-right direction-rtl mg-lt-5">
                        در حال حاضر
                        <span class="color-blue" id="questionCount"></span>
                        سؤال
                        <span class="color-blue" id="answerCount"></span>
                        پاسخ موجود می‌باشد.
                    </div>

                    <div class="newQuestionMainDiv mg-tp-30 full-width display-inline-block">
                        <div class="questionInputBoxMainDiv">
                            <div class="circleBase type2 newQuestionWriterProfilePic">
                                <img src="{{ $userPic }}" style="width: 100%; height: 100%; border-radius: 50%;">
                            </div>
                            <div class="inputBox questionInputBox">
                                <textarea id="questionInput"
                                          class="inputBoxInput inputBoxInputComment"
                                          type="text" placeholder="شما چه سؤالی دارید؟"
                                          onclick="checkLogin()"></textarea>
                                <div class="sendQuestionBtn" onclick="sendQuestion(this)">ارسال</div>
                                <div class="sendQuestionBtn sendingQuestionLoading" style="display: none;"  disabled>
                                    <img src="{{URL::asset('images/icons/mGear.svg')}}" style="width: 30px; height: 30px;">
                                    {{__('در حال ثبت سوال')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12" style="padding: 0px;">
        <div class="row" style="margin: 0px">
            <div class="col-md-6">
                <div id="questionSectionDiv_1"></div>
            </div>
            <div class="col-md-6">
                <div id="questionSectionDiv_2"></div>
            </div>
        </div>
    </div>

{{--    <div id="questionPaginationDiv" class="col-xs-12 questionsMainDivFooter position-relative" style="margin-top: 0px;">--}}
{{--        <div class="col-xs-5 font-size-13 line-height-2">--}}
{{--            نمایش--}}
{{--            <span id="showQuestionPerPage"></span>--}}
{{--            پست در هر صفحه--}}
{{--        </div>--}}
{{--        <div class="col-xs-4 font-size-13 line-height-2 text-align-right float-right">--}}
{{--            <span class="float-right">صفحه</span>--}}
{{--            <span id="questionPagination"></span>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>


<script>
    var askQuestionUrl = '{{route("askQuestion")}}';
    var getQuestionsUrl = '{{route("getQuestions")}}';

    var questionPerPageNum = [3, 5, 10];
</script>

<script src="{{URL::asset('js/component/getAndAskQuestionForPlaces.js?v='.$fileVersions)}}"></script>
