<div id="reportPane" class="reportBackGround">
    <div class="reportBodyDiv">
        <div class="reportHeaderTxt">گزارش</div>
        <div>
            گزارش خود را از بین موضوعات موجود انتخاب نمایید
        </div>
        <div class="body_text">
            <fieldset id="reportContainer" class="reportContainer"></fieldset>
            <div id="reportTextDiv" style="display: none">
                <textarea name="reportText" id="reportText" class="form-control" rows="5" style="width: 100%" placeholder="اگر توضیحی دارید اینجا بنویسید...."></textarea>
            </div>
            <br>
            <div class="submitReportOptions">
                <button onclick="sendReport()" class="btn btn-success" style="color: #FFF;background-color: var(--koochita-light-green);border-color:var(--koochita-light-green);">تایید</button>
                <input type="submit" onclick="closeReportPrompt()" value="خیر" class="btn btn-default">
            </div>
            <div id="errMsgReport" style="color: red"></div>
        </div>
        <div onclick="closeReportPrompt()" class="ui_close_x closeReport"></div>
    </div>
</div>

<script>
    var reportValue = 0;
    var reportLogId = 0;
    var getReportsQuestionsKindPlaceId = 0;
    var getReportsDir = '{{route('getReportQuestions')}}';
    var storeReportUrl = "{{route('storeReport')}}";
</script>
