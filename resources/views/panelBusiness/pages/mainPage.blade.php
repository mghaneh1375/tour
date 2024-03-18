@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>خانه</title>
    <link rel="stylesheet" href="{{ URL::asset('BusinessPanelPublic/css/createBusinessPage.css?v=' . $fileVersions) }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/form.css?v=' . $fileVersions) }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/common.css?v=' . $fileVersions) }}" />
@endsection


@section('body')
    <style>
        .mainPage {}

        .mainPage .headerTitle {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: solid 1px #cfcfcf;
        }

        .mainPage .cardsSection {
            display: flex;
            align-items: center;
        }

        .mainPage .cards {
            background: var(--koochita-light-green);
            color: black;
            height: 100px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin-left: 22px;
            padding: 0px 25px;
        }

        .mainPage .cards .icon {
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #ffffff;
            border-radius: 50%;
            font-size: 35px;
            margin-left: 15px;
        }

        .mainPage .cards .infoSec {}

        .mainPage .cards .infoSec .text {
            font-weight: bold;
            font-size: 20px;
        }

        .mainPage .cards .infoSec .numSec {
            margin-top: 5px;
        }

        .mainPage .cards .infoSec .numSec .num {
            width: 20px;
            height: 20px;
            background: red;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            color: white;
        }

        .mainPage .cards .infoSec .numSec .tex {
            font-size: 12px;
        }
    </style>
    <div class="row mainPage">
        <div class="col-md-12">
            @if ($newTicketCount > 0 || $newNotificationCount > 0)
                <div class="mainBackWhiteBody">
                    <div class="cardsSection">

                        @if ($newTicketCount != 0)
                            <a href="#" class="cards">
                                <div class="icon">
                                    <i class="fa-solid fa-headset"></i>
                                </div>
                                <div class="infoSec">
                                    <div class="text">پشتیبانی</div>
                                    <div class="numSec">
                                        <span class="num">{{ $newTicketCount }}</span>
                                        <span class="tex">پیام جدید</span>
                                    </div>
                                </div>
                            </a>
                        @endif

                        @if ($newNotificationCount != 0)
                            <a href="#" class="cards">
                                <div class="icon">
                                    <i class="fa-regular fa-bell-on"></i>
                                </div>
                                <div class="infoSec">
                                    <div class="text">اعلانات</div>
                                    <div class="numSec">
                                        <span class="num">{{ $newNotificationCount }}</span>
                                        <span class="tex">پیام جدید</span>
                                    </div>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>
            @endif


            <div class="mainBackWhiteBody" style="margin-top: 10px">
                <div class="headerTitle">کسب و کارهای من</div>
                <div class="cardsSection">
                    @if (count($myBusiness) == 0)
                        <div class="row">
                            <div class="">
                                <img style="max-width: 100%" src="{{ URL::asset('images/icons/newsrv0102.png') }}"
                                    alt="">
                            </div>
                            <div class="col-md-9">
                                <p style="font-size:18px; color:#707070 ">هیچ کسب و کاری موجود نیست. اولین کسب و کار خود را
                                    در کوچیتا <a
                                        style="cursor: pointer !important;"href="{{ route('businessPanel.create') }}">ایجاد</a>کنید.
                                </p>
                                <p style="font-size:14px; color:#707070"> اگر در ایجاد کسب و کار مشکلی دارید از قسمت <a
                                        style="cursor: pointer !important;"href=" {{ route('ticket.page') }}">پشتیبانی</a>
                                    مشکل خود را با ما درمیان بگذارید.
                                </p>
                            </div>
                        </div>
                    @else
                        @foreach ($myBusiness as $mb)
                            <a href="{{ $mb->url }}" class="cards">
                                <div class="icon">
                                    @if ($mb->type == 'agency')
                                        <i class="fa-light fa-plane-tail"></i>
                                    @endif
                                </div>
                                <div class="infoSec">
                                    <div class="text">{{ $mb->title }}</div>
                                    <div class="numSec">
                                        <span class="num">{{ $newTicketCount }}</span>
                                        <span class="tex">پیام جدید</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="createBusinessPage height100">
        <div class="row indicator_step height100 ">

            <div class="col-md-12 height100">

                <div class="mainBackWhiteBody">
                    <div class="head">نوع خدمت قابل ارائه</div>
                    <div style="margin-top: 20px">
                        <div id="resultBox">

                            <div id="BusinessType"></div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        let phone = '{{ Auth::user()->phone }}';

        // if (localStorage.getItem("token") === undefined ||
        //     localStorage.getItem("token") === null ||
        //     localStorage.getItem("token") === '') {
        //     $.ajax({
        //         type: 'post',
        //         url: 'https://boom.bogenstudio.com/api/activation_code',
        //         data: {
        //             'phone': phone
        //         },
        //         success: function(res) {
        //             console.log('====================================');
        //             console.log(res);
        //             console.log('====================================');

        //             $.ajax({
        //                 type: 'post',
        //                 url: 'https://boom.bogenstudio.com/api/login',
        //                 data: {
        //                     'phone': phone,
        //                     'verification_code': '1111'
        //                 },
        //                 success: function(res) {

        //                     if (res.status == '0') {
        //                         localStorage.setItem('token', res.access_token);
        //                     }
        //                 }
        //             });
        //         }
        //     });
        // }
        let url = '{{ route('formCreator.root') }}';
        let token = 'Bearer ' + localStorage.getItem("token");
        var assetId = null;
        var step = null;
        var usreId = null;
        let level = '{{ in_array('ADMIN', $userInfo->roles) ? 'ADMIN' : 'USER' }}';
        if (level === 'USER') {
            openLoading();
            $.ajax({
                type: 'get',
                url: url + '/asset/user_assets',
                complete: closeLoading,
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    "Authorization": token
                },
                success: function(res) {
                    var html = '';

                    if (res.status === "0") {
                        if (res.assets.length <= 1) {

                            html += '<div id="BusinessType"></div>';
                            firstStep();
                        } else {
                            html += '<center>';
                            html += '<table class="table table-striped">';
                            html += '<tr style="background: #D4D4D4">';
                            html += '<th>ردیف</th>';
                            html += '<th>عملیات</th>';
                            html += '<th>نام کسب و کار</th>';
                            html += '<th>نوع کسب و کار</th>';
                            html += '<th>وضعیت</th>';
                            html += '<th>تاریخ ایجاد</th>';
                            html += '<th>تاریخ آخرین بروزرسانی </th>';
                            html += '</tr>';
                            for (let i = 0; i < res.assets.length; i++) {
                                for (let z = 0; z < res.assets[i].length; z++) {
                                    if (res.assets[i][z].asset.indexOf('هیئت') > -1 && res.assets[i][z].status
                                        .indexOf('تایید') > -1) {
                                        break;
                                    }
                                    usreId = res.assets[i][z].id;
                                    itemsCount = z + 1;
                                    assetId = res.assets[i][z].asset_id;

                                    html += '<tr id="' + res.assets[i][z].id + '">';
                                    html += '<td>' + itemsCount + '</td>';
                                    if (res.assets[i][z].status === "در حال ساخت") {

                                        html +=
                                            '<td><div class="btn btnError" style="font-size: 10px;" onclick="fillForm(' +
                                            assetId + ',' + usreId + ')">تکمیل اطلاعات </div>';
                                        html +=
                                            '<a style="margin-right: 5px;" class="btn btn-danger circleButton"onclick="deleteBusiness(' +
                                            res.assets[i][z].id + ',this)" title="حذف">';
                                        html += '<i class="fa-solid fa-trash"></i></a>';
                                        html += '</td>';
                                    } else if (res.assets[i][z].status === "در حال بررسی برای تایید") {
                                        html +=
                                            '<td><a href="{{ route('ticket.page') }}" class="btn btnSuccess" style="font-size: 10px;width:60%;">';
                                        html += 'پشتیبانی';
                                        html += '</a>';
                                        html += '</td>';
                                    } else if (res.assets[i][z].status === "رد شده") {
                                        html += '<td style="display:flex;">';
                                        html +=
                                            '<div class="btn btnError" style="font-size: 10px;margin-left: 5px;" onclick="fillForm(' +
                                            assetId + ',' + usreId + ')">تکمیل اطلاعات </div>';
                                        html +=
                                            '<a href="{{ route('ticket.page') }}" class="btn btnAlert" style="font-size: 10px;">';
                                        html += 'هشدارها';
                                        html += '</a>';
                                        html += '</td>';
                                    } else {
                                        html +=
                                            '<td><a href="#"class="btn btnSuccess" style="font-size: 10px;">رفتن به پنل مدیریت</a></td>';
                                    }
                                    html += '<td>' + res.assets[i][z].title + '</td>';
                                    html += '<td>' + res.assets[i][z].asset + '</td>';
                                    html += '<td>' + res.assets[i][z].status + '</td>';
                                    html += '<td>' + res.assets[i][z].createdAt + '</td>';
                                    html += '</tr>';

                                }
                            }
                            html += '</table>';
                            html += '</center> ';
                        }
                        $('#resultBox').empty().append(html);
                    } else {}

                },
                error: function(request, status, error) {
                    if (request.status === 404) {
                        window.location.href = '/404';
                    }
                }
            });

            function fillForm(asset_Id, usreId_) {
                $("#showStep").modal("show");
                openLoading();
                $.ajax({
                    type: 'get',
                    url: url + '/asset/' + asset_Id + "/form",
                    complete: closeLoading,
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        "Authorization": token
                    },
                    success: function(res) {
                        var text = '';

                        if (res.status === 0) {
                            for (let i = 0; i < res.forms.length; i++) {
                                step = res.forms[i].id;
                                text += '<div class="stepView" onclick="goStep(' + step + ',' + usreId_ +
                                    ',' +
                                    asset_Id + ' )">';
                                text += '' + res.forms[i].name + '';
                                text += '</div>';
                            }
                        } else {}

                        $('#stepView').empty().append(text);
                    },
                    error: function(request, status, error) {
                        if (request.status === 404) {
                            window.location.href = '/404';
                        }
                    }
                });
            }

            function goStep(step, usreId_, asset_Id) {
                window.location.href = '/asset/' + asset_Id + "/step/" + step + "/" + usreId_;
            }

            function deleteBusiness(id, el) {
                openLoading();
                $.ajax({
                    type: 'DELETE',
                    complete: closeLoading,
                    url: url + '/user_asset/' + id,
                    headers: {
                        "Authorization": token
                    },
                    success: function(res) {
                        if (res.status == '0')
                            location.reload();
                    }
                })
            }

            function firstStep() {
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
                        var text = '';
                        if (res.status === 0) {
                            console.log(res);
                            text += '<h4>مایل به ارائه چه نوع خدمتی هستید؟</h4>';
                            text += '<div>';
                            text += ' <p>از بین گزینه های زیر یک گزینه را می توانید انتخاب کنید.</p>';
                            text +=
                                '<p>توجه کنید، این انتخاب بعدها قابل تغییر می باشد، اما به سبب گزینه های انتخاب شده، ما نیازمند';
                            text +=
                                'اطلاعات مفصلی از شما هستیم و امکانات متفاوتی را در اختیار شما قرار می دهیم. < /p>';
                            text += '</div>';
                            for (var i = 0; i < res.assets.length; i++) {

                                text += '<div class="col-xs-12 col-md-8" style="margin-top: 10px">';
                                text += '<div data-id="' + res.assets[i].id + '" data-form-id="' + res
                                    .assets[i]
                                    .formIds[0] +
                                    '" data-type="agency" class="businessType">';
                                text += '<div class="picSection">';
                                text +=
                                    '<img class="resizeImgClass" src="' + res.assets[i].pic +
                                    '" onload="fitThisImg(this)">';
                                text += '</div>';
                                text += '<div class="textSec">';
                                text += '<h5>' + res.assets[i].name + ' </h5>';
                                text +=
                                    '<p>شما می توانید برای فروش تورهای خود از امکانات ما استفاده کنید.</p>';
                                text += ' </div>';
                                text += '</div>';
                                text += '</div>';
                            }
                            text +=
                                '<div class="col-xs-12 fullyCenterContent rowReverse SpaceBetween" style="margin-top: 20px;">';
                            text +=
                                '<button onclick="startProcess()" disabled id="startProcessBtn" class="btn btn-success">';
                            text += 'مرحله بعد</button>';
                            text += '</div>';
                        }
                        $('#BusinessType').empty().append(text);

                    }
                });
            }
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
        } else {
            window.location.href = "{{ route('report.index') }} "
        }
    </script>
@endsection
