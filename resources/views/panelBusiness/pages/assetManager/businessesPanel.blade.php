@extends('panelBusiness.layout.baseLayout')

@section('head')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/shazdeDesigns/tourCreation.css?v=11') }}" />
    <title>کسب و کارهای من</title>
    <style>
        .btn:hover {
            color: white;
        }

        .whiteBox {
            border-bottom: unset;
        }

        td {
            padding: 7px;
            min-width: 150px;
        }

        .msgLast {
            min-width: auto;
        }
    </style>
@endsection


@section('body')
    <div class="mainBackWhiteBody">
        <div class="whiteBox">
            <div class="head">کسب و کارهای من</div>

            <div id="resultBox"></div>

        </div>
    </div>
@endsection
@section('modals')
    <div class="modal fade" id="showStep">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" style="direction: rtl">
                    <div class="row">
                        <div class="col-md-12 mb-md-0 mb-4">
                            <div id="stepView" style="width: 100%; height: 100px;flex-wrap: wrap;
    display: flex;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer" style="text-align: center">
                    <button id="goToForthStep" class="btn nextStepBtnTourCreation" data-dismiss="modal">تأیید</button>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        let url = "https://boom.bogenstudio.com/api";
        let token = 'Bearer ' + localStorage.getItem("token");
        var assetId = null;
        var step = null;
        var usreId = null;
        openLoading();
        $.ajax({
            type: 'get',
            // url: 'http://myeghamat.com/api/asset/' + assetId + "/form",
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
                    if (res.assets.length < 1) {
                        html += '<div class="row">';
                        html += '<div class="">';
                        html +=
                            '<img style="max-width: 100%" src="{{ URL::asset('images/icons/newsrv0102.png') }}" alt="">';
                        html += '</div>';
                        html += '<div class="col-md-9">';
                        html +=
                            '<p style="font-size:18px; color:#707070 ">هیچ کسب و کاری موجود نیست. اولین کسب و کار خود رادر کوچیتا <a style="cursor: pointer !important;"href="{{ route('businessPanel.create') }}">ایجاد </a>کنید.</p>';
                        html +=
                            '<p style="font-size:14px; color:#707070"> اگر در ایجاد کسب و کار مشکلی دارید از قسمت <a style="cursor: pointer !important;"href=" {{ route('ticket.page') }}">پشتیبانی </a>مشکل خود را با ما درمیان بگذارید.</p>';
                        html += '</div>';
                        html += '</div>';
                    } else {

                        for (let i = 0; i < res.assets.length; i++) {

                            html += '<center>';
                            html += '<table class="table table-striped">';
                            html += '<tr style="background: #D4D4D4">';
                            html += '<th>ردیف</th>';
                            html += '<th>عملیات</th>';
                            html += '<th>نام کسب و کار</th>';
                            html += '<th>نوع کسب و کار</th>';
                            html += '<th>وضعیت</th>';
                            html += '<th>تاریخ ایجاد</th>';
                            html += '</tr>';
                            for (let z = 0; z < res.assets[i].length; z++) {
                                console.log(res);
                                usreId = res.assets[i][z].id;
                                itemsCount = z + 1;
                                assetId = res.assets[i][z].assetId;
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
                                html += '';
                                html += '';
                                html += '';
                                html += '';
                                html += '';
                                html += '</tr>';
                            }
                            html += '</table>';
                            html += '</center> ';
                        }
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
                // url: 'http://myeghamat.com/api/asset/' + assetId + "/form",
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
                            text += '<div class="stepView" onclick="goStep(' + step + ',' + usreId_ + ',' +
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
            })
            $(el).parent().parent().remove();
            location.reload();
        }
    </script>
@endsection
