@extends('panelBusiness.layout.baseLayout')

@section('head')
    @parent
    <title>گزارش</title>
    <script>
        let delUrl = '{{ url('boom/user_asset') . '/' }}';
    </script>
@stop

@section('body')

    <div class="mainBackWhiteBody">
        <div class="whiteBox">
            <div class="head">درخواست های تعیین تکلیف نشده</div>
            @if (count($userAssets) == 0)
                <p>درخواستی موجود نیست</p>
            @else
                <div>
                    <table class="table table-striped">
                        <thead style="background: var(--koochita-yellow);">
                            <tr>
                                <th>ردیف</th>
                                <th>نام کسب و کار</th>
                                <th>نوع کسب و کار</th>
                                <th>نام درخواست دهنده</th>
                                <th>نام کاربری درخواست دهنده</th>
                                <th>شماره همراه درخواست دهنده</th>
                                <th>وضعیت</th>
                                <th>تاریخ ثبت مدارک</th>
                                <th>تاریخ تکمیل/اصلاح مدارک</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <td><img width="100px" src="{{ URL::asset('storage/' . $asset->pic) }}"></td> --}}
                            <?php $i = 1; ?>
                            @foreach ($userAssets as $asset)
                                {{-- {{ dd($asset) }} --}}
                                {{-- onclick="document.location.href = '{{ route('businessPanel.getSpecificUnChecked', ['business' => $request->id]) }}'" --}}
                                <tr id="tr_{{ $asset['id'] }}" style="cursor: pointer">
                                    <td>{{ $i }}</td>
                                    <td>{{ $asset['title'] }}</td>
                                    <td>{{ $asset['assetName'] }}</td>
                                    <td>{{ $asset['name'] }}</td>
                                    <td>{{ $asset['username'] }}</td>
                                    <td>{{ $asset['phone'] }}</td>
                                    <td id="status_{{ $asset['id'] }}"> {{ $asset['status'] }} </td>
                                    <td>{{ $asset['createdAt'] }} </td>
                                    <td>{{ $asset['updatedAt'] }} </td>
                                    <td>
                                        <a class="btn btn-success btn-default btn-sm mgbtn5" data-placement="top"
                                            title="مشاهده پاسخ کاربر"
                                            href="{{ route('user_asset.show', ['user_asset' => $asset['id']]) }}">
                                            <span class="glyphicon glyphicon-eye-open"></span></a>

                                        @if ($asset['status'] != 'در حال ساخت')
                                            <button data-toggle="modal" data-target="#editModal"data-placement="top"
                                                title="تغییروضعیت"
                                                onclick="changeStatus('{{ $asset['id'] }}','{{ $asset['status'] }}')"
                                                class="btn btn-primary btn-default btn-sm mgbtn5">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </button>
                                        @endif

                                        <button data-toggle="modal" data-target="#removeModal"
                                            class="btn btn-default btn-sm  btn-danger mgbtn5"
                                            onclick="remove('{{ $asset['id'] }}')" data-placement="top"
                                            title="حذف"><span class="glyphicon glyphicon-trash"></span></button>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
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
                            <option value="PENDING"> در حال بررسی </option>
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
    <div id="removeModal" class="modal fade" role="dialog">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">آیا از حذف این آیتم اطمینان دارید؟</h4>
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
{{-- <div class="col-md-1"></div>

    <div class="col-md-10">
        <div class="sparkline8-list shadow-reset mg-tb-30">
            <div class="sparkline8-hd">
                <div class="main-sparkline8-hd">
                    <h1>assets</h1>
                </div>
            </div>

            <div class="sparkline8-graph dashone-comment messages-scrollbar dashtwo-messages">

                <center class="row">

                    <div style="direction: rtl" class="col-xs-12">
                        <table>
                            <tr>
                                <td>دسته</td>
                                <td>نام</td>
                                <td>تصویر شاخص</td>
                                <td>وضعیت</td>
                                <td>عملیات</td>
                            </tr>
                            @foreach ($userAssets as $asset)
                                <tr id="tr_{{ $asset->id }}">
                                    <td>{{ $asset->asset->name }}</td>
                                    <td>{{ $asset->title }}</td>
                                    <td><img width="100px" src="{{ URL::asset('storage/' . $asset->pic) }}"></td>
                                    <td id="status_{{ $asset->id }}">{{ $asset->status }}</td>
                                    <td>
                                        <a class="btn btn-success" href="{{ url('user_asset/' . $asset->id) }}">مشاهده پاسخ
                                            کاربر</a>

                                        @if ($asset->status != 'INIT')
                                            <button data-toggle="modal" data-target="#editModal"
                                                onclick="changeStatus('{{ $asset->id }}')" class="btn btn-primary">تغییر
                                                وضعیت</button>
                                        @endif

                                        <button class="btn btn-danger" onclick="remove('{{ $asset->id }}')">حذف</button>
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                    </div>

                </center>

            </div>
        </div>
    </div>

    <div class="col-xs-1"></div> --}}

@section('script')
    <script>
        var selectedId = -1;

        function remove(id) {
            selectedId = id;
        }

        function changeState() {
            if ($("#status").val() == 'REJECT') {
                $("#errBox").removeClass('hidden');
            } else {
                $("#errBox").addClass('hidden');
            }
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

        function changeStatus(id, state) {
            selectedId = id;
            if (state === 'رد شده') {
                selectedState = 'REJECT';
            } else if (state === 'تایید شده') {
                selectedState = 'CONFIRM';

            } else {
                selectedState = 'PENDING';
            }
            $("#status").val(selectedState).change();
        }

        function doChangeStatus() {
            errText = $('#rejecedText').val()
            var newStatus = $("#status").val();
            var newStatusFa = $("#status option:selected").text();
            $.ajax({
                type: 'post',
                url: '{{ url('boom/setAssetStatus') }}' + "/" + selectedId,
                data: {
                    'status': newStatus,
                    'err_text': errText
                },
                success: function(res) {
                    if (res.status == "0") {
                        $("#closeModalBtn").click();
                        $("#status_" + selectedId).empty().append(newStatusFa);
                        showSuccessNotifiBP('عملیات با موفقیت انجام شد', 'right', '#053a3e');
                    } else {
                        showSuccessNotifiBP(res.msg, 'right', '#ac0020');
                    }
                }
            });

        }
    </script>

@stop
