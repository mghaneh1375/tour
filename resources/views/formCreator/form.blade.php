@extends('panelBusiness.layout.baseLayout')

@section('head')
    @parent

    <script>
        var delUrl = '{{ url('form') }}' + "/";
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
                        <span onclick="document.location.href = '{{ url('asset') }}'" class="back">بازگشت</span>
                    </h1>
                </div>
            </div>
            <button data-toggle="modal" data-target="#addModal" class="btn btn-success">افزودن فرم جدید</button>

            <div style="direction: rtl" class="col-xs-12">
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
                            <td>
                                <a class="btn btn-success" href="{{ url('form/' . $form->id . '/form_field') }}">ویرایش فیلد
                                    ها</a>
                                <button data-toggle="modal" data-target="#editModal"
                                    onclick="editForm('{{ $form->id }}')" class="btn btn-primary">ویرایش
                                    فرم</button>
                                <button data-toggle="modal" data-target="#removeModal" class="btn btn-danger"
                                    onclick="remove('{{ $form->id }}')">حذف</button>
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
                <form method="get" id="editForm">

                    <div class="modal-header">
                        <h4 class="modal-title">ویرایش فرم</h4>
                    </div>
                    <div class="modal-body">

                        <center>
                            <p>نام</p>
                            <input type="text" id="name" name="name">
                        </center>

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
                <form method="post" action="{{ url('asset/' . $asset->id . '/form') }}">

                    <div class="modal-header">
                        <h4 class="modal-title">افزودن فرم</h4>
                    </div>
                    <div class="modal-body">

                        <center>
                            <p>نام</p>
                            <input type="text" name="name">
                        </center>

                        <center>
                            <p>توضیح</p>
                            <textarea name="description"></textarea>
                        </center>

                        <center>
                            <p>تذکر</p>
                            <textarea name="notice"></textarea>
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
@endsection
@section('script')
    <script>
        var forms = {!! json_encode($asset->forms) !!};

        function editForm(id) {
            items = forms.filter(x => x.id == id);
            for (let i = 0; i < items.length; i++) {
                $("#editForm").attr("action", "{{ url('form/') }}" + "/" + items[i].id + "/edit");
                $("#name").val(items[i].name);
                $("#description").val(items[i].description);
                $("#notice").val(items[i].notice);
                $("#step").val(items[i].step);
            }
        }
    </script>
@stop
