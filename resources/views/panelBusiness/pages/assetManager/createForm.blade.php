@extends('panelBusiness.layout.baseLayout')

@section('head')
    <link rel="stylesheet" href="{{ URL::asset('css/pages/localShops/mainLocalShops.css?v=' . $fileVersions) }}">
    <link rel="stylesheet" href="{{ URL::asset('css/pages/business.css?v=' . $fileVersions) }}">
    <link rel="stylesheet" href="{{ URL::asset('BusinessPanelPublic/css/createBusinessPage.css?v=' . $fileVersions) }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/form.css?v=' . $fileVersions) }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/common.css?v=' . $fileVersions) }}" />

@endsection
@section('body')
    <div class="createBusinessPage height100">
        <div class="row indicator_step height100 ">

            <div class="col-md-12 height100">

                <div class="mainBackWhiteBody">
                    <div class="head">نوع خدمت قابل ارائه</div>
                    <div style="margin-top: 20px">
                        <h4>مایل به ارائه چه نوع خدمتی هستید؟</h4>
                        <div>
                            <p>از بین گزینه های زیر یک گزینه را می توانید انتخاب کنید.</p>
                            <p>توجه کنید، این انتخاب بعدها قابل تغییر می باشد، اما به سبب گزینه های انتخاب شده، ما نیازمند
                                اطلاعات مفصلی از شما هستیم و امکانات متفاوتی را در اختیار شما قرار می دهیم.</p>
                        </div>
                        <div id="hotel">

                        </div>

                    </div>

                    <div class="col-xs-12 fullyCenterContent rowReverse SpaceBetween" style="margin-top: 20px;">
                        <button onclick="startProcess()" disabled id="startProcessBtn" class="btn btn-success">مرحله
                            بعد</button>
                        {{-- <button onclick="(-1, -10)" class="btn btn-danger">مرحله قبل</button> --}}
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        let selectedAssetId;
        let firstStepFormId;

        $(document).on("click", ".businessType", function() {
            if (!this.getAttribute('disabled')) {
                $(".businessType").removeClass('selected');
                $(this).addClass("selected");
                selectedAssetId = $(this).attr('data-id');
                firstStepFormId = $(this).attr('data-form-id');

                $("#startProcessBtn").removeAttr('disabled');
            }
        });

        function startProcess() {
            window.location.href = '/asset/' + selectedAssetId + "/step/" + firstStepFormId;
        }

        $.ajax({
            type: 'get',
            // url: 'http://myeghamat.com/api/asset',
            url: 'https://boom.bogenstudio.com/api/asset',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzIiwianRpIjoiODcyZjc0YjI4MDcwNjVkOTAzYjBkMGUzYTM3ZGZlZTc1ZjE2OTQ5NzQzYjhlNzhiMjdjNzkyN2Y0YzE3NjEyZjk3Y2Y1MTY3YTkzYjhhYmYiLCJpYXQiOjE2ODYxNDQzMTYuODMxMjU1LCJuYmYiOjE2ODYxNDQzMTYuODMxMjU4LCJleHAiOjE3MTc3NjY3MTYuODI3MTc2LCJzdWIiOiIxNCIsInNjb3BlcyI6W119.ZhLHb_mQTKpyC-YbAEogNL-kV4mpOGdvxApdFAZYJxtBsapF6LQy75AdQINDuy_pbA3D2ZsxKcvhnnPZcFyROmN-HrHK5DphDDkgIAYHIGo-pM6Oe0Z1etpwpzNVQPpG2yqY-A-n9mXK9ElfXuKsyVl70N2nYFXDbTwJile2N8Mh898MQj6vGQAqnbwCs6SUun94eLGt0cte38BEn5-4zWSsDkddGBIDQMaQXyC5wbCs1n_GITA0RtWE04fDlagowZ1SBLQ5uaS5WS2Eu_VLkdYlp3H9-Derg20QcLqqAtSrQzumYrf8_JNfGkkxdAudakIf0oN3lCvvGQJc3yvupnjMlizgBfjO5Gov-JSi58BEe6Dlyh1PH_aHclUMApNqs_GF4znGtlM7vivz56eNJfb7pdiF8DyMVrvgE73CQbqBf71R02D6LuoG6uSuiBvCg7fgprx592kjX3IHZPlRUhO7ecHChPC2A2D9wI8T08l536CceLnySWcD7o_iv-gk1JoJuY_9gfgSkRdumgxQKdXLPCvRCHGeRysLZSJupbh_6VugYBTA2oBRxDuVWKm7msks0XHvRYkc7hwx74EdqygJuVC6ejs_AY3QFHFTXJ2hvTLb5Kf5hJVhPT7xjHnagkiA-PSenc8OfCS-xASDE2woyTdoERSLMHVDJdUQ7h8"
            },
            success: function(res) {
                var html = '';
                if (res.status === 0) {
                    for (var i = 0; i < res.assets.length; i++) {
                        html += '<div class="col-xs-12 col-md-8" style="margin-top: 10px">';
                        html += '<div data-id="' + res.assets[i].id + '" data-form-id="' + res.assets[i]
                            .formIds[0] +
                            '" data-type="agency" class="businessType">';
                        html += '<div class="picSection">';
                        html +=
                            '<img class="resizeImgClass" src="' + res.assets[i].pic +
                            '" onload="fitThisImg(this)">';
                        html += '</div>';
                        html += '<div class="textSec">';
                        html += '<h5>' + res.assets[i].name + ' </h5>';
                        html += '<p>شما می توانید برای فروش تورهای خود از امکانات ما استفاده کنید.</p>';
                        html += ' </div>';
                        html += '</div>';
                        html += '</div>';
                    }
                }
                $('#hotel').empty().append(html);
                console.log('====================================');
                console.log(res);
                console.log('====================================');
            }
        });
    </script>
@stop
