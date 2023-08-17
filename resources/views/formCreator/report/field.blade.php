@extends('panelBusiness.layout.baseLayout')

@section('head')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/pages/localShops/mainLocalShops.css?v=' . $fileVersions) }}">
    <link rel="stylesheet" href="{{ URL::asset('css/pages/business.css?v=' . $fileVersions) }}">
    <link rel="stylesheet" href="{{ URL::asset('BusinessPanelPublic/css/createBusinessPage.css?v=' . $fileVersions) }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/form.css?v=' . $fileVersions) }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/common.css?v=' . $fileVersions) }}" />
    <style>
        .businessType {
            width: 100%;
            cursor: pointer;
            border: 2px solid #7d7d7d;
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            margin-top: 5px;
            margin-bottom: 5px
        }
    </style>
@stop

@section('body')
    <div class="mainBackWhiteBody">
        <div class="whiteBox">
            <div class="sparkline8-list shadow-reset mg-tb-30">
                <div class="sparkline8-hd">
                    <div class="main-sparkline8-hd">
                        <h1>پاسخ های کاربر
                            <span data-placement="left" title="برگشت"
                                onclick="document.location.href = '{{ route('report.index') }}'" class="back"><span
                                    class="glyphicon glyphicon-arrow-left"></span></span>
                        </h1>
                    </div>

                    <button data-toggle="modal" data-target="#editModal"data-placement="top" title="تغییروضعیت"
                        onclick="changeStatus('{{ $status }}')" class="btn btn-primary btn-default btn-sm mgbtn5">
                        <span class="glyphicon glyphicon-edit"></span>
                    </button>
                    <button data-toggle="modal" data-target=""data-placement="top" title="تخصیص بوم گردی از سامانه کوچیتا"
                        onclick="chooseBoom()"
                        class="btn btn-primary btn-default btn-sm mgbtn5 "style="background-color: orange;border-color:orange">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                    <div style="padding-top: 10px;">
                        <figcaption style="font-size: 17px">
                            {{ $err_text }}
                        </figcaption>
                    </div>
                    <div class="sparkline8-graph dashone-comment messages-scrollbar dashtwo-messages">
                        <div style="direction: rtl" class="col-xs-12">

                            @foreach ($forms as $form)
                                <h3 style="margin-top: 20px">{{ $form->name }}</h3>

                                <table class="table table-striped">
                                    <thead style="background: var(--koochita-yellow);">
                                        <tr>
                                            <td>سوال</td>
                                            <td>نوع سوال</td>
                                            <td>پاسخ</td>
                                            <td>وضعیت</td>
                                            <td>توضیحات خطا</td>
                                            <td>عملیات</td>

                                        </tr>
                                    </thead>
                                    @foreach ($form->fields as $field)
                                        <tr>
                                            <td>{{ $field->name }}</td>
                                            <td>{{ $field->type }}</td>
                                            <td>
                                                @if ($field->type === 'LISTVIEW')
                                                    @foreach ($field->items as $item)
                                                        @foreach ($item['data'] as $f)
                                                            @if ($f->type === 'gallery')
                                                                @foreach ($f->val as $img)
                                                                    <img src="{{ $img }}" width="100px" />
                                                                @endforeach
                                                            @else
                                                                {{ $f->key_ . ' : ' . $f->val }}
                                                            @endif
                                                        @endforeach
                                                        <a
                                                            href="{{ route('user_sub_asset.show', ['user_sub_asset' => $item['id']]) }}">see
                                                            more</a>
                                                    @endforeach
                                                @else
                                                    @if ($field->data == null || empty($field->data))
                                                        پاسخی ثبت نشده است
                                                    @else
                                                        {{-- @if ($field->type == 'MAP')
                                                            <?php $tmp = explode('_', $field->data);
                                                            $lat = $tmp[0];
                                                            $lng = $tmp[1]; ?>
                                                            <a target="_blank"
                                                                href="https://www.google.com/maps/?q={{ $lat }},{{ $lng }}">کلیک
                                                                کنید</a>
                                                        @else --}}
                                                        {{ $field->data }}
                                                        {{-- @endif --}}
                                                    @endif
                                                @endif
                                            </td>
                                            <td id="{{ $field->id }}">
                                                @if ($field->status == 'CONFIRM')
                                                    تایید شده
                                                @elseif($field->status == 'REJECT')
                                                    رد شده
                                                @else
                                                    در حال بررسی برای تایید
                                                @endif
                                            </td>
                                            <td>
                                                {{ $field->err_text }}
                                            </td>
                                            <td>
                                                <div class="btn btn-success "
                                                    onclick="changeAnswStatus('{{ $field->update_status_url }}', 'CONFIRM',{{ $field->id }})"
                                                    data-placement="top" title="تایید شده"><span
                                                        class="	glyphicon glyphicon-ok"></span></div>
                                                <div class="btn btn-danger " data-toggle="modal" data-target="#rejectText"
                                                    onclick="reject('{{ $field->update_status_url }}',{{ $field->id }})"
                                                    data-placement="top" title="رد شده"><span
                                                        class="	glyphicon glyphicon-remove"></span></div>
                                            </td>

                                        </tr>
                                    @endforeach

                                </table>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modals')
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">تغییر وضعیت</h4>
                </div>
                <div class="modal-body">

                    <center>
                        <p>وضعیت مورد نظر</p>
                        <select id="status" name="status" onchange="changeState()">
                            <option value="PENDING"> در حال بررسی برای تایید </option>
                            <option value="REJECT">رد شده</option>
                            <option value="CONFIRM"> تایید شده </option>
                        </select>
                    </center>
                    <center id="errBox" class="hidden"style="margin-top: 10px;">

                        <p style="margin: 0;">علت رد شدن</p>
                        <textarea id="rejecedText" type="textarea" placeholder="اختیاری"></textarea>
                    </center>

                </div>
                <div class="modal-footer">
                    <button id="closeModalBtn" type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
                    <input onclick="doChangeStatus()" type="submit" class="btn btn-success" value="تایید">
                </div>
            </div>

        </div>
    </div>
    <div id="rejectText" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">توضیح علت رد شدن</h4>
                </div>
                <div class="modal-body">
                    <center style="margin-top: 10px;">
                        <p style="margin: 0;">علت رد شدن</p>
                        <textarea id="errText" type="textarea" placeholder="اختیاری"></textarea>
                    </center>
                </div>
                <div class="modal-footer">
                    <button id="closeModalBtn" type="button" class="btn btn-default"
                        data-dismiss="modal">انصراف</button>
                    <input onclick="rejectReq()" type="submit" class="btn btn-success" value="تایید">
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="addCityModal" style="top:30px !important;">
        <div class="modal-dialog modal-lg" style="max-width: 500px !important">
            <div class="modal-content">
                <div class="modal-body" style="direction: rtl ;border-bottom: 1px solid #707070;">
                    <div class="fullwidthDiv">
                        <div class="addPlaceGeneralInfoTitleTourCreation">
                            اقامتگاه مورد نظر خود را اضافه کنید
                        </div>
                    </div>

                    <div class="row" style="display: flex;flex-direction: column;padding-top: 10px;">
                        <div class="inputBoxTour col-xs-5 relative-position mainClassificationOfPlaceInputDiv">

                            <div class="inputBoxTour col-xs-5 relative-position placeNameAddingPlaceInputDiv">
                                <div class="inputBoxText" style="min-width: 60px;">

                                </div>

                                <input id="inputSearchCity" class="inputBoxInput text-align-right" type="text"
                                    placeholder="نام اقامتگاه" onkeyup="searchForBoom(this)" />
                                <div class="searchResult"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footerrow fullyCenterContent rowReverse SpaceBetween"
                        style="padding: 15px; text-align: center">
                        <button style="width: 20%;" id="DoneProcess" onclick="setWork()" class="btn btn-success"
                            disabled>تأیید</button>
                        <button style="width: 20%;" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var rejectUrl;
        var rejectId;
        var selectedId = -1;

        function chooseBoom() {
            $("#addCityModal").modal("show");
        }
        $(document).on("click", ".businessType", function() {
            if (!this.getAttribute('disabled')) {
                $(".businessType").removeClass('selected');
                $(this).addClass("selected");
                selectedWork = $(this).attr('data-id');
                $("#DoneProcess").removeAttr('disabled');
            }
        });

        function setWork() {
            $.ajax({
                type: 'post',
                url: '{{ route('setPlaceId', ['user_asset' => $id]) }}',
                data: {
                    'place_id': selectedWork,
                },
                success: function(res) {
                    console.log(res.status);
                    if (res.status === "0") {
                        $('#addCityModal').attr("data-dismiss", "modal");
                        showSuccessNotifiBP('عملیات با موفقیت انجام شد', 'right', '#053a3e');
                    } else {
                        showSuccessNotifiBP('عملیات انجام نشد', 'right', '#ac0020');
                    }
                }
            });
        }

        function searchForBoom(_element) {

            var value = $(_element).val().trim();
            if (value.length < 3)
                return;

            openLoading();

            let params = new URLSearchParams();

            params.append("placeMode", "boom");
            params.append("key", value);
            let html = "";
            $.ajax({
                type: 'get',
                url: 'https://koochita-server.bogenstudio.com/api/place/totalSearch?' + params.toString(),
                complete: closeLoading,
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                success: function(res) {
                    console.log(res.data.places);
                    for (let i = 0; i < res.data.places.length; i++) {
                        console.log(res.data.places[i].city_name);
                        html += '<div class="row businessType cursorPointer" data-id="' + res.data.places[i]
                            .id +
                            '" style="padding-top: 5px;padding-bottom: 5px;">';
                        html += '<div class="col-md-4 col-sm-4 col-4">';
                        html += '<img src="' + res.data.places[i].pic +
                            '" style="height: 105px; width: 100%;object-fit: contain;">';
                        html += '</div>';
                        html += '<div class="col-md-8 col-sm-8 col-8">';
                        html += '<div>';
                        html += '' + res.data.places[i].target_name + 'در ' + res.data.places[i].city_name +
                            'در ' + res.data.places[i].state_name + '';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                    }
                    $('.searchResult').empty().append(html);
                }
            });
        }
        $(document).ready(function() {
            console.log(selectedId);
        })

        function changeStatus(state) {
            $("#status").val(state).change();
        }

        function changeState() {
            if ($("#status").val() == 'REJECT') {
                $("#errBox").removeClass('hidden');
            } else {
                $("#errBox").addClass('hidden');
            }
        }

        function reject(url, id) {
            rejectUrl = url;
            rejectId = id;
        }

        function rejectReq() {
            errText = $('#errText').val()
            $.ajax({
                type: 'post',
                url: rejectUrl,
                data: {
                    'status': 'REJECT',
                    'err_text': errText
                },
                success: function(res) {

                    if (res.status == "0") {
                        newStatus = 'رد شده';
                        $("#" + rejectId).empty().append(newStatus);
                        $('#rejectText').modal('toggle');
                        showSuccessNotifiBP('عملیات با موفقیت انجام شد', 'right', '#053a3e');
                        location.reload();
                    } else {
                        showSuccessNotifiBP(res.msg, 'right', '#ac0020');
                    }
                }
            });
        }

        function doChangeStatus() {

            var newStatus = $("#status").val();
            errText = $('#rejecedText').val()
            $.ajax({
                type: 'post',
                url: '{{ route('setAssetStatus', ['user_asset' => $id]) }}',
                data: {
                    'status': newStatus,
                    'err_text': errText
                },
                success: function(res) {

                    if (res.status == "0") {
                        $("#closeModalBtn").click();
                        $("#status_" + selectedId).empty().append(newStatus);
                        showSuccessNotifiBP('عملیات با موفقیت انجام شد', 'right', '#053a3e');
                    } else {
                        showSuccessNotifiBP(res.msg, 'right', '#ac0020');
                    }
                }
            });

        }

        function changeAnswStatus(url, newStatus, id) {

            $.ajax({
                type: 'post',
                url: url,
                data: {
                    'status': newStatus
                },
                success: function(res) {

                    if (res.status == "0") {
                        if (newStatus === 'CONFIRM') {
                            newStatus = 'تایید شده';
                        } else {
                            newStatus = 'رد شده';
                        }
                        $("#" + id).empty().append(newStatus);
                        showSuccessNotifiBP('عملیات با موفقیت انجام شد', 'right', '#053a3e');
                    } else {
                        showSuccessNotifiBP(res.msg, 'right', '#ac0020');
                    }
                }
            });

        }
    </script>

@stop
