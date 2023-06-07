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
            url: 'https://boom.koochita.com/api/asset',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiZTUxMDZjOTNiNGEzOTc5ODdmNjI0ZDllMTYyMGFiNzNkNjM0Y2IzOTA2YTRlNThmOTY3NGQxZDliMzVjYmY5OTE3MmUyMGUzODAxYjBmOTAiLCJpYXQiOjE2ODUxODQyNjcuOTkzNDE3LCJuYmYiOjE2ODUxODQyNjcuOTkzNDIyLCJleHAiOjE3MTY4MDY2NjcuNzgzODkzLCJzdWIiOiIxNCIsInNjb3BlcyI6W119.ieMJMIypKQF-u6-RbyyjQ-IuZsK31o92D7pIh4YHAX0GD8iKUKF9dnZ0cWDtA85cGcNVxTsdL908fmDKB8IyU5ZzfOQC1KBTMaQ8d8-uXafnJfJHFs9sJ8DDap1yoCn7FwHh-ICOYwSiWcZmwcbMYXyA-Vr8ltALZgSSqKHNLw0AfxOd2WColEGpudpnRb5ZSu59t6WnjUMuTlW1qQKjUv2lcuIQMsdTSOIiEDLfAYU1uReWKobNzv3VgiLINLfKNRfopJU7rSWE9qeC5RTXIxh5hR-ojp64hC_vO4KAMJMDjJEtB6y6TQczDSqU7GCupuY5ff2ZNHrKKcAVCrKhhenhWfViJvDVpYdEdyoI_8nvhlCpAVFSvDn6M344RuoTlPJzg8UHsEc-anEO16ihff3VAbo41vy0ZA7WPGWi8JxDajJeMPcl_IGtGwMkTPbNM2NP45-zQWjdr54GgEL2b11TwK_DUXW07RKCcozN1akuOw86q2O86J23s16PtcrVl3_iGhwjrHfOFUNvBDukenKcinB6Dd4tgz6aFacOCeIJSphJzcI7UCKIEyl9VBNIZDAQMqQBq_MyITTslq7DiuikcapUfBlZCnQvWgTOBfinQmo-Tub3ocAZjted5EBnU8vZncLRMftqahLNpmxyPLbgAQf2RvIT9n5Jko_4Io8"
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
