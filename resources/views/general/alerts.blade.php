<div id="alertBoxDiv" class="alertDarkBack">
    <div class="alertBox">
        <div class="alertTitle warningTitle">
            درخواست شما با مشکل مواجه شد
        </div>
        <div class="alertDescriptionBox">
            <div id="alertBodyDiv" class="alertDescription"></div>
            <div>
                <button class="alertBtn leftBtn" onclick="closeErrorAlert()">متوجه شدم</button>
            </div>
        </div>
    </div>
</div>

<div id="warningBoxDiv" class="alertDarkBack">
    <div class="alertBox">
        <div class="alertTitle offerTitle">
            {{__('یک لحظه درنگ کنید')}}
        </div>
        <div class="alertDescriptionBox">
            <div id="warningBody" class="alertDescription"></div>
            <div style="display: flex; justify-content: flex-end; align-items: center">
                <button id="warningModalCallBackShow" class="alertBtn rightBtn" onclick="cancelWarning()" style="display: none; color: #761c19; background: white;">فعلا، نه</button>
                <button id="warningOkText" class="alertBtn leftBtn" onclick="closeWarning()"></button>
            </div>
        </div>
    </div>
</div>

<div id="successNotifiAlert" class="notifAlert"></div>

<script src="{{URL::asset('js/component/alert.js?v='.$fileVersions)}}"></script>
