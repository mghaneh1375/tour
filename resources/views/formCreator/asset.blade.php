@extends('panelBusiness.layout.baseLayout')

@section('head')
    @parent
    <style>
        .modalForm {
            padding: 10px 0px 10px 0;
        }
    </style>
@stop

@section('body')

    <div class="mainBackWhiteBody">
        <div class="whiteBox">
            <div class="main-sparkline8-hd">
                <h1>دارایی
                    <span onclick="document.location.href = '{{ route('asset.index') }}'" class="back" data-placement="left"
                        title="برگشت"><span class="glyphicon glyphicon-arrow-left"></span></span>
                </h1>

            </div>

            @if ($errors->any())
                {!! implode('', $errors->all('<div id="err" class="hidden">:message</div>')) !!}
            @endif

            <button data-toggle="modal" data-target="#addModal"
                class="btn btn-success"data-placement="top"title="افزودن دارایی جدید"><i
                    class="plus2 iconStyle"></i></button>

            <div style="direction: rtl;padding-top:5px">
                <table class="table table-striped">
                    <thead style="background: var(--koochita-yellow);">
                        <tr>
                            <td>نام</td>
                            <td>حالت نمایش</td>
                            <td>تصویر</td>
                            <td>تصویر ایجاد</td>
                            <td>اولویت نمایش</td>
                            <td>وضعیت نمایش</td>
                            <td>عملیات</td>
                        </tr>
                    </thead>
                    @foreach ($assets as $asset)
                        <tr id="tr_{{ $asset->id }}">
                            <td>{{ $asset->name }}</td>
                            @if ($asset->mode === 'FULL')
                                <td> تمام صفحه</td>
                            @elseif($asset->mode === 'HALF')
                                <td> نیمه صفحه</td>
                            @elseif($asset->mode === '2/3')
                                <td> 2/3</td>
                            @else
                                <td>1/3 </td>
                            @endif
                            <td><img src="{{ URL::asset('assets/' . $asset->pic) }}"></td>
                            <td><img src="{{ URL::asset('assets/' . $asset->create_pic) }}"></td>
                            <td>{{ $asset->view_index }}</td>
                            <td>{{ $asset->hidden ? 'عدم نمایش' : 'قابل نمایش' }}</td>
                            <td>

                                <a class="btn btn-success " href="{{ route('asset.form.index', ['asset' => $asset->id]) }}"
                                    data-placement="top" title="ویرایش فرم ها"><span
                                        class="	glyphicon glyphicon-eye-open"></span></a>

                                <a class="btn btn-info "
                                    href="{{ route('asset.sub_asset.index', ['asset' => $asset->id]) }}"
                                    data-placement="top" title="ویرایش زیردارایی ها">
                                    <span class="glyphicon glyphicon-list"></span>
                                </a>
                                <button data-toggle="modal" data-target="#editModal"
                                    onclick="editAsset('{{ $asset->id }}', '{{ $asset->hidden }}', '{{ $asset->mode }}', '{{ $asset->view_index }}', '{{ $asset->name }}')"
                                    class="btn btn-primary" data-placement="top" title="ویرایش دارایی"> <span
                                        class="glyphicon glyphicon-edit"></span></button>
                                <button data-toggle="modal" data-target="#removeModal" class="btn btn-danger"
                                    onclick="remove('{{ $asset->id }}')"data-placement="top"title="حذف"><span
                                        class="glyphicon glyphicon-trash"></span></button>
                            </td>
                        </tr>
                    @endforeach

                </table>
            </div>

        </div>
    </div>
@endsection

@section('modals')

    <div id="editModal" class="modal fade" role="dialog">

        <div class="modal-dialog">

            <div class="modal-content">
                <form method="post" id="editForm" enctype="multipart/form-data">

                    <div class="modal-header">
                        <h4 class="modal-title">ویرایش asset</h4>
                    </div>
                    <div class="modal-body">

                        <div class="modalForm">
                            <label for="hidden">عدم نمایش</label>
                            <input type="checkbox" name="hidden" id="hidden">
                        </div>

                        <div class="modalForm">
                            <label for="name">نام</label>
                            <input type="text" id="name" name="name">
                        </div>

                        <div class="modalForm">
                            <label for="mode">حالت نمایش</label>
                            <select id="mode" name="mode">
                                <option value="FULL">تمام صفحه</option>
                                <option value="HALF">نیمه صفحه </option>
                                <option value="2/3">2/3</option>
                                <option value="1/3">1/3</option>
                            </select>
                        </div>

                        <div class="modalForm">
                            <label for="view_index">اولویت نمایش</label>
                            <input type="number" id="view_index" name="view_index">
                        </div>

                        <div style="border-bottom: 2px dashed black">
                            <p>در صورتی که قصد تغییر تصویر یا تصویر ایجاد را دارید قسمت زیر را بررسی کنید.</p>
                        </div>

                        <div class="modalForm">
                            <label for="pic">تصویر مورد نظر</label>
                            <input type="file" name="pic">
                        </div>

                        <div class="modalFormp">
                            <p>تصویر ایجاد مورد نظر</p>
                            <input type="file" name="create_pic">
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
                        <input type="submit" class="btn btn-success" value="تایید">
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div id="addModal" class="modal fade" role="dialog">

        <div class="modal-dialog">

            <div class="modal-content">
                <form method="post" action="{{ route('asset.store') }}" enctype="multipart/form-data">

                    <div class="modal-header">
                        <h4 class="modal-title">افزودن دارایی</h4>
                    </div>
                    <div class="modal-body">

                        <div class="modalForm">

                            <label for="hidden">عدم نمایش</label>
                            <input type="checkbox" name="hidden">
                        </div>


                        <div class="modalForm">
                            <label for="name">نام</label>
                            <input type="text" name="name">
                        </div>
                        <div class="modalForm">
                            <label for="mode">حالت نمایش</label>
                            <select id="mode" name="mode">
                                <option value="FULL">تمام صفحه</option>
                                <option value="HALF">نیمه صفحه </option>
                                <option value="2/3">2/3</option>
                                <option value="1/3">1/3</option>
                            </select>
                        </div>
                        <div class="modalForm">
                            <label for="view_index">اولویت نمایش</label>
                            <input type="number" name="view_index">
                        </div>

                        <div class="modalForm">
                            <label for="pic">تصویر مورد نظر</label>
                            <input type="file" name="pic">
                        </div>

                        <div class="modalFormp">
                            <p>تصویر ایجاد مورد نظر</p>
                            <input type="file" name="create_pic">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
                        <input type="submit" class="btn btn-success" value="تایید">
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                err = $("#err").text();
                console.log(err.length);
                if (err !== undefined && err.length > 1)
                    showSuccessNotifiBP(err, 'right', '#ac0020');
            }, 1000);
        });

        var delUrl = '{{ route('asset.index') }}' + "/";

        function editAsset(id, h, m, vi, n) {

            $("#editForm").attr("action", "{{ route('asset.index') }}" + "/" + id + "/edit");
            $("#name").val(n);
            $("#view_index").val(vi);
            $("#mode").val(m);

            if (h == 1)
                $("#hidden").prop("checked", true);
            else
                $("#hidden").prop("checked", false);
        }
    </script>
@stop
