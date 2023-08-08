@extends('panelBusiness.layout.baseLayout')

@section('head')
    @parent

    <script>
        var delUrl = '{{ url('boom/form') }}' + "/";
    </script>

@stop

@section('body')
    <div class="mainBackWhiteBody">
        <div class="whiteBox">
            <div class="sparkline8-hd">
                <div class="main-sparkline8-hd">
                    <h1>
                        <span>فرم ها</span>
                        <span>&nbsp;&nbsp;&nbsp;</span>
                        <span> | </span>
                        <span>&nbsp;&nbsp;&nbsp;</span>
                        <span>asset</span>
                        <span>{{ $asset->name }}</span>
                        <span onclick="document.location.href = '{{ route('asset.index') }}'" class="back"
                            data-placement="left" title="برگشت"><span class="glyphicon glyphicon-arrow-left"></span></span>
                    </h1>
                </div>
            </div>
            <button data-toggle="modal" data-target="#addModal"
                class="btn btn-success"data-placement="top"title="افزودن دارایی جدید"><i
                    class="plus2 iconStyle"></i></button>
            @if ($errors->any())
                {!! implode('', $errors->all('<div id="err" class="hidden">:message</div>')) !!}
            @endif
            <div style="direction: rtl;padding-top:5px">
                <table class="table table-striped">
                    <thead style="background: var(--koochita-yellow);">
                        <tr>
                            <td>گام</td>
                            <td>نام</td>
                            <td>توضیح</td>
                            <td>تذکر</td>
                            <td>عملیات</td>
                        </tr>
                    </thead>
                    @foreach ($asset->forms as $form)
                        <tr id="tr_{{ $form->id }}">
                            <td>{{ $form->step }}</td>
                            <td>{{ $form->name }}</td>
                            <td>{{ $form->description }}</td>
                            <td>{{ $form->notice }}</td>
                            <td style="width:15%">
                                <a class="btn btn-success mgbtn5"
                                    href="{{ route('form.form_field.index', ['form' => $form->id]) }}"data-placement="top"
                                    title="ویرایش فیلدها"><span class="	glyphicon glyphicon-eye-open"></span></a>
                                <button data-toggle="modal" data-target="#editModal"
                                    onclick="editForm('{{ $form->id }}')"
                                    class="btn btn-primary mgbtn5"data-placement="top" title="ویرایش فرم"> <span
                                        class="glyphicon glyphicon-edit"></span></button>
                                <button data-toggle="modal" data-target="#removeModal" class="btn btn-danger mgbtn5"
                                    onclick="remove('{{ $form->id }}')"data-placement="top"title="حذف"><span
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
                <form method="post" id="editForm">

                    <div class="modal-header">
                        <h4 class="modal-title">ویرایش فرم</h4>
                    </div>
                    <div class="modal-body">

                        <label for="name" style="text-align: center">نام</label>
                        <input type="text" name="name" id="name" style="width:50%">

                        <center>
                            <p>توضیح</p>
                            <textarea id="description" name="description"></textarea>
                        </center>

                        <center>
                            <p>تذکر</p>
                            <textarea id="notice" name="notice"></textarea>
                        </center>

                        <center>
                            <p>گام</p>
                            <input type="number" id="step" name="step">
                        </center>

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
                <form method="post" action="{{ route('asset.form.store', ['asset' => $asset->id]) }}">

                    <div class="modal-header">
                        <h4 class="modal-title">افزودن فرم</h4>
                    </div>
                    <div class="modal-body">

                        <label for="name" style="text-align: center">نام</label>
                        <input type="text" name="name" style="width:50%">

                        <p for="description" style="text-align: center">توضیح</p>
                        <textarea name="description" style="width:100%;line-height: 3;"></textarea>

                        <p for="notice" style="text-align: center">تذکر</p>
                        <textarea name="notice" style="width:100%;line-height: 3;"></textarea>

                        <label for="step" style="text-align: center">گام</label>
                        <input type="number" id="step" name="step" style="width:50%">

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
                if (err !== undefined && err.length > 1)
                    showSuccessNotifiBP(err, 'right', '#ac0020');
            }, 500);
        });
        var forms = {!! json_encode($asset->forms) !!};

        function editForm(id) {
            items = forms.filter(x => x.id == id);
            for (let i = 0; i < items.length; i++) {
                $("#editForm").attr("action", "{{ url('boom/form/') }}" + "/" + items[i].id + "/edit");
                $("#name").val(items[i].name);
                $("#description").val(items[i].description);
                $("#notice").val(items[i].notice);
                $("#step").val(items[i].step);
            }
        }
    </script>
@stop
