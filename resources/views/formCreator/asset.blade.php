@extends('layouts.structure')

@section('header')
    @parent

    <script>
        var delUrl = '{{url('asset')}}' + "/";
    </script>
@stop

@section('content')

    <div class="col-md-1"></div>

    <div class="col-md-10">
        <div class="sparkline8-list shadow-reset mg-tb-30">
            <div class="sparkline8-hd">
                <div class="main-sparkline8-hd">
                    <h1>assets</h1>
                </div>
            </div>

            <div class="sparkline8-graph dashone-comment messages-scrollbar dashtwo-messages">

                <center class="row">

                    <button data-toggle="modal" data-target="#addModal" class="btn btn-success">افزودن asset جدید</button>

                    <div style="direction: rtl" class="col-xs-12">
                        <table>
                            <tr>
                                <td>نام</td>
                                <td>حالت نمایش</td>
                                <td>تصویر</td>
                                <td>تصویر ایجاد</td>
                                <td>اولویت نمایش</td>
                                <td>Hidden</td>
                                <td>عملیات</td>
                            </tr>
                            @foreach($assets as $asset)

                                <tr id="tr_{{$asset->id}}">
                                    <td>{{$asset->name}}</td>
                                    <td>{{$asset->mode}}</td>
                                    <td><img src="{{URL::asset('assets/' . $asset->pic)}}"></td>
                                    <td><img src="{{URL::asset('assets/' . $asset->create_pic)}}"></td>
                                    <td>{{$asset->view_index}}</td>
                                    <td>{{($asset->hidden) ? "Hidden" : "Visible"}}</td>
                                    <td>
                                        <a class="btn btn-success" href="{{url('asset/' . $asset->id . '/form')}}">ویرایش فرم ها</a>
                                        <button data-toggle="modal" data-target="#editModal" onclick="editAsset('{{$asset->id}}', '{{$asset->hidden}}', '{{$asset->mode}}', '{{$asset->view_index}}', '{{$asset->name}}')" class="btn btn-primary">ویرایش asset</button>
                                        <button data-toggle="modal" data-target="#removeModal" class="btn btn-danger" onclick="remove('{{$asset->id}}')">حذف</button>
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
                <form method="post" id="editForm" enctype="multipart/form-data">

                    <div class="modal-header">
                        <h4 class="modal-title">ویرایش asset</h4>
                    </div>
                    <div class="modal-body">

                        <center>
                            <p>Hidden</p>
                            <input type="checkbox" id="hidden" name="hidden">
                        </center>

                        <center>
                            <p>نام</p>
                            <input type="text" id="name" name="name">
                        </center>

                        <center>
                            <p>حالت نمایش</p>
                            <select id="mode" name="mode">
                                <option value="FULL">FULL</option>
                                <option value="HALF">HALF</option>
                                <option value="2/3">2/3</option>
                                <option value="1/3">1/3</option>
                            </select>
                        </center>

                        <center>
                            <p>اولویت نمایش</p>
                            <input type="number" id="view_index" name="view_index">
                        </center>

                        <div style="border-bottom: 2px dashed black">
                            <p>در صورتی که قصد تغییر تصویر یا تصویر ایجاد را دارید قسمت زیر را بررسی کنید.</p>
                        </div>

                        <div>
                            <p>تصویر مورد نظر</p>
                            <input type="file" name="pic">
                        </div>

                        <div>
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
                <form method="post" action="{{url('asset')}}" enctype="multipart/form-data">

                    <div class="modal-header">
                        <h4 class="modal-title">افزودن asset</h4>
                    </div>
                    <div class="modal-body">

                        <center>
                            <p>Hidden</p>
                            <input type="checkbox" name="hidden">
                        </center>

                        <center>
                            <p>نام</p>
                            <input type="text" name="name">
                        </center>

                        <center>
                            <p>حالت نمایش</p>
                            <select id="mode" name="mode">
                                <option value="FULL">FULL</option>
                                <option value="HALF">HALF</option>
                                <option value="2/3">2/3</option>
                                <option value="1/3">1/3</option>
                            </select>
                        </center>

                        <center>
                            <p>اولویت نمایش</p>
                            <input type="number" name="view_index">
                        </center>

                        <div>
                            <p>تصویر مورد نظر</p>
                            <input type="file" name="pic">
                        </div>

                        <div>
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

    <script>

        function editAsset(id, h, m, vi, n) {

            $("#editForm").attr("action", "{{url('asset/')}}" + "/" + id + "/edit");
            $("#name").val(n);
            $("#view_index").val(vi);
            $("#mode").val(m);

            if(h == 1)
                $("#hidden").prop("checked", true);
            else
                $("#hidden").prop("checked", false);
        }

    </script>

@stop
