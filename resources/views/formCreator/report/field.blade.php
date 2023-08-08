@extends('panelBusiness.layout.baseLayout')

@section('head')
    @parent
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
                                            <td>عملیات</td>

                                        </tr>
                                    </thead>
                                    @foreach ($form->fields as $field)
                                        <tr>
                                            <td>{{ $field->name }}</td>
                                            <td>{{ $field->type }}</td>
                                            <td>
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
                        <textarea type="textarea" placeholder="اختیاری"></textarea>
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
                        <textarea type="textarea" placeholder="اختیاری"></textarea>
                    </center>
                </div>
                <div class="modal-footer">
                    <button id="closeModalBtn" type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
                    <input onclick="rejectReq()" type="submit" class="btn btn-success" value="تایید">
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script>
        var rejectUrl;
        var rejectId;
        $(document).ready(function() {
            console.log(selectedId);
        })
        var selectedId = -1;

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
            console.log(rejectUrl);
            console.log(rejectId);
            $.ajax({
                type: 'post',
                url: rejectUrl,
                data: {
                    'status': 'REJECT'
                },
                success: function(res) {

                    if (res.status == "0") {
                        newStatus = 'رد شده';
                        $("#" + rejectId).empty().append(newStatus);
                        $('#rejectText').modal('toggle');
                        showSuccessNotifiBP('عملیات با موفقیت انجام شد', 'right', '#053a3e');
                    } else {
                        showSuccessNotifiBP(res.msg, 'right', '#ac0020');
                    }
                }
            });
        }

        function doChangeStatus() {

            var newStatus = $("#status").val();

            $.ajax({
                type: 'post',
                url: '{{ route('setAssetStatus', ['user_asset' => $id]) }}',
                data: {
                    'status': newStatus
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
