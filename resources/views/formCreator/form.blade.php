@extends('layouts.structure')

@section('header')
    @parent

    <script>
        var delUrl = '{{url('form')}}' + "/";
    </script>

@stop

@section('content')

    <div class="col-md-1"></div>

    <div class="col-md-10">
        <div class="sparkline8-list shadow-reset mg-tb-30">

            <div class="sparkline8-hd">
                <div class="main-sparkline8-hd">
                    <h1>
                        <span>فرم ها</span>
                        <span>&nbsp;&nbsp;&nbsp;</span>
                        <span> | </span>
                        <span>&nbsp;&nbsp;&nbsp;</span>
                        <span>asset</span>
                        <span>{{$asset->name}}</span>
                        <span onclick="document.location.href = '{{url('asset')}}'" class="back">بازگشت</span>
                    </h1>
                </div>
            </div>

            <div class="sparkline8-graph dashone-comment messages-scrollbar dashtwo-messages">

                <center class="row">

                    <button data-toggle="modal" data-target="#addModal" class="btn btn-success">افزودن فرم جدید</button>

                    <div style="direction: rtl" class="col-xs-12">
                        <table>
                            <tr>
                                <td>گام</td>
                                <td>نام</td>
                                <td>توضیح</td>
                                <td>تذکر</td>
                                <td>عملیات</td>
                            </tr>
                            @foreach($asset->forms as $form)

                                <tr id="tr_{{$form->id}}">
                                    <td>{{$form->step}}</td>
                                    <td>{{$form->name}}</td>
                                    <td>{{$form->description}}</td>
                                    <td>{{$form->notice}}</td>
                                    <td>
                                        <a class="btn btn-success" href="{{url('form/' . $form->id . '/form_field')}}">ویرایش فیلد ها</a>
                                        <button data-toggle="modal" data-target="#editModal" onclick="editForm('{{$form->id}}', '{{$form->name}}', '{{$form->description}}', '{{$form->notice}}', '{{$form->step}}')" class="btn btn-primary">ویرایش فرم</button>
                                        <button data-toggle="modal" data-target="#removeModal" class="btn btn-danger" onclick="remove('{{$form->id}}')">حذف</button>
                                    </td>
                                </tr>

                            @endforeach

                        </table>
                    </div>

                </center>

            </div>
        </div>
    </div>

    <div class="col-xs-1"></div>

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
                <form method="post" action="{{url('asset/' . $asset->id . '/form')}}">

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

    <script>

        function editForm(id, n, d, not, s) {
            $("#editForm").attr("action", "{{url('form/')}}" + "/" + id + "/edit");
            $("#name").val(n);
            $("#description").val(d);
            $("#notice").val(not);
            $("#step").val(s);
        }

    </script>

@stop
