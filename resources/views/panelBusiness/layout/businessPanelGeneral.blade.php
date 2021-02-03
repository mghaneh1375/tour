<div id="fullPageLoader" class="loaderDiv hidden">
    <div class="loader_200">
        <img alt="loading" src="{{URL::asset('images/loading.gif?v='.$fileVersions)}}" style="width: 300px;">
    </div>
    <div class="processBar hidden">
        <div class="percentBar">0%</div>
        <div class="bar"></div>
    </div>
</div>


<div id="alertBoxDivBP" class="alertDarkBackBP">
    <div class="alertBoxBP">
        <div class="alertTitleBP warningTitleBP">درخواست شما با مشکل مواجه شد</div>
        <div class="alertDescriptionBoxBP">
            <div id="alertBodyDivBP" class="alertDescriptionBP"></div>
            <div>
                <button class="alertBtnBP leftBtnBP" onclick="closeErrorAlertBP()">متوجه شدم</button>
            </div>
        </div>
    </div>
</div>

<div id="warningBoxDivBP" class="alertDarkBackBP">
    <div class="alertBoxBP">
        <div class="alertTitleBP offerTitleBP">{{__('یک لحظه درنگ کنید')}}</div>
        <div class="alertDescriptionBoxBP">
            <div id="warningBodyBP" class="alertDescriptionBP"></div>
            <div style="display: flex; justify-content: flex-end; align-items: center">
                <button id="warningModalCallBackShowBP" class="alertBtnBP rightBtnBP" onclick="cancelWarningBP()" style="display: none; color: #761c19; background: white;">فعلا، نه</button>
                <button id="warningOkTextBP" class="alertBtnBP leftBtnBP" onclick="closeWarningBP()"></button>
            </div>
        </div>
    </div>
</div>

<div id="successNotifiAlertBP" class="notifAlertBP"></div>
