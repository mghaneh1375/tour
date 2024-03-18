@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>پنل تعریف کسب و کار</title>
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
        let url = '{{ route('formCreator.root') }}';
        let selectedAssetId;
        let firstStepFormId;
        let selectedAssetName;

        $(document).on("click", ".businessType", function() {
            if (!this.getAttribute('disabled')) {
                $(".businessType").removeClass('selected');
                $(this).addClass("selected");
                selectedAssetId = $(this).attr('data-id');
                firstStepFormId = $(this).attr('data-form-id');
                selectedAssetName = $(this).attr('data-name');

                $("#startProcessBtn").removeAttr('disabled');
            }
        });

        function startProcess() {
            if (selectedAssetName == 'آژانس گردشگری') {
                window.location.href = '/create';
            } else {
                window.location.href = '/asset/' + selectedAssetId + "/step/" + firstStepFormId;
            }
        }
        openLoading();
        $.ajax({
            type: 'get',
            // url: 'http://myeghamat.com/api/asset',
            url: url + '/asset',
            complete: closeLoading,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                "Authorization": "Bearer " + localStorage.getItem("token")
            },
            success: function(res) {

                var html = '';
                if (res.status === "0") {
                    html += '<p>لطفا منتطر تایید احراز هویت بمانید</p>';
                }
                if (res.status === 0) {
                    html += '<h4>مایل به ارائه چه نوع خدمتی هستید؟</h4>';
                    html += '<div>';
                    html += ' <p>از بین گزینه های زیر یک گزینه را می توانید انتخاب کنید.</p>';
                    html +=
                        '<p>توجه کنید، این انتخاب بعدها قابل تغییر می باشد، اما به سبب گزینه های انتخاب شده، ما نیازمند';
                    html += 'اطلاعات مفصلی از شما هستیم و امکانات متفاوتی را در اختیار شما قرار می دهیم.</p>';
                    html += '</div>';
                    for (var i = 0; i < res.assets.length; i++) {
                        html += '<div class="col-xs-12 col-md-8" style="margin-top: 10px">';
                        html += '<div data-name="' + res.assets[i].name + '" data-id="' + res.assets[i].id +
                            '" data-form-id="' + res.assets[i]
                            .formIds[0] +
                            '" data-type="agency" class="businessType">';
                        html += '<div class="picSection">';
                        html +=
                            '<img class="resizeImgClass" src="' + res.assets[i].pic +
                            '" onload="fitThisImg(this)">';
                        html += '</div>';
                        html += '<div class="textSec">';
                        html += '<h5>' + res.assets[i].name + ' </h5>';
                        html += '<p>' + res.assets[i].description + ' </p>';
                        html += ' </div>';
                        html += '</div>';
                        html += '</div>';
                    }
                }
                $('#hotel').empty().append(html);

            }
        });
    </script>
@stop
