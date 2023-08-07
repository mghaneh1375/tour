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
                                        </tr>
                                    @endforeach

                                </table>
                            @endforeach
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
                            <select id="status" name="status">
                                <option value="PENDING"> در حال بررسی برای تایید </option>
                                <option value="REJECT">رد شده</option>
                                <option value="CONFIRM"> تایید شده </option>
                            </select>
                        </center>

                    </div>
                    <div class="modal-footer">
                        <button id="closeModalBtn" type="button" class="btn btn-default"
                            data-dismiss="modal">انصراف</button>
                        <input onclick="doChangeStatus()" type="submit" class="btn btn-success" value="تایید">
                    </div>
                </div>

            </div>
        </div>

        <div id="removeModal" class="modal fade" role="dialog">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title">حذف دارایی کاربر</h4>
                    </div>
                    <div class="modal-body">
                        <h3>آیا از حذف دارایی کاربر اطمینان دارید؟</h3>
                    </div>
                    <div class="modal-footer">
                        <button id="closeRemoveModalBtn" type="button" class="btn btn-default"
                            data-dismiss="modal">انصراف</button>
                        <input onclick="doRemove()" type="submit" class="btn btn-success" value="تایید">
                    </div>
                </div>

            </div>
        </div>
    @endsection
    @section('script')
        <script>
            var selectedId = -1;

            function remove(id) {
                selectedId = id;
            }

            function doRemove() {

                $.ajax({
                    type: "DELETE",
                    url: '{{ url('user_asset') }}' + "/" + selectedId,
                    success: function(res) {
                        if (res.status == "0") {
                            $("#tr_" + selectedId).remove();
                            $("#closeRemoveModalBtn").click();
                        } else {
                            showSuccessNotifiBP(res.msg, 'right', '#ac0020');
                        }
                    }
                });
            }

            function changeStatus(id) {
                selectedId = id;
            }

            function doChangeStatus() {

                var newStatus = $("#status").val();

                $.ajax({
                    type: 'post',
                    url: '{{ url('setAssetStatus') }}' + "/" + selectedId,
                    data: {
                        'status': newStatus
                    },
                    success: function(res) {

                        if (res.status == "0") {
                            $("#closeModalBtn").click();
                            $("#status_" + selectedId).empty().append(newStatus);
                        } else {
                            showSuccessNotifiBP(res.msg, 'right', '#ac0020');
                        }
                    }
                });

            }
        </script>

    @stop
