@extends('layouts.structure')

@section('header')
    @parent
    <script>
        var delUrl = "{{url('form_field')}}" + "/";
    </script>
    <style>
        textarea {
            width: 80%;
            height: 100px;
            overflow: auto;
        }
    </style>
@stop

@section('content')

    <div class="col-md-1"></div>

    <div class="col-md-10">
        <div class="sparkline8-list shadow-reset mg-tb-30">

            <div class="sparkline8-hd">
                <div class="main-sparkline8-hd">
                    <h1>
                        <span>فیلد ها</span>
                        <span>&nbsp;&nbsp;&nbsp;</span>
                        <span> | </span>
                        <span>&nbsp;&nbsp;&nbsp;</span>

                        <span class="clickable" onclick="document.location.href = '{{url('asset')}}'">
                            <span>{{$form->asset->name}}</span>
                        </span>
                        <span>&nbsp;&nbsp;&nbsp;</span>
                        <span> | </span>
                        <span>&nbsp;&nbsp;&nbsp;</span>

                        <span>{{$form->name}}</span>
                        <span onclick="document.location.href = '{{url('asset/' . $form->asset->id . '/form')}}'" class="back">بازگشت</span>
                    </h1>
                </div>
            </div>

            <div class="sparkline8-graph dashone-comment messages-scrollbar dashtwo-messages">

                <center class="row">

                    <button data-toggle="modal" data-target="#addModal" class="btn btn-success">افزودن فیلد جدید</button>

                    <div style="direction: rtl; overflow: auto" class="col-xs-12">
                        <table style="overflow: auto">
                            <tr>
                                <td>نام</td>
                                <td>ضروری</td>
                                <td>متن ارور</td>
                                <td>Help</td>
                                <td>Force Help</td>
                                <td>نوع</td>
                                <td>محدودیت</td>
                                <td>tooltip</td>
                                <td>نوع چینش</td>
                                <td>نوع نمایش</td>
                                <td>multiple</td>
                                <td>عملیات</td>
                            </tr>

                            @foreach($form->form_fields as $field)

                                <tr id="tr_{{$field->id}}">
                                    <td>{{$field->name}}</td>
                                    <td>{{($field->necessary) ? "بله" : "خیر"}}</td>
                                    <td>{{$field->err}}</td>
                                    <td>{{$field->force_help}}</td>
                                    <td>{{$field->help}}</td>
                                    <td>{!! html_entity_decode($field->type) !!}</td>
                                    <td>{!! html_entity_decode($field->limitation) !!}</td>
                                    <td>{{$field->placeholder}}</td>
                                    <td>{{($field->rtl) ? "rtl" : "ltr"}}</td>
                                    <td>{{($field->half) ? "نمایش نصفه" : "نمایش کامل"}}</td>
                                    <td>{{$field->multiple}}</td>
                                    <td>
                                        <button data-toggle="modal" data-target="#editModal" onclick="editField('{{$field->id}}', '{{$field->name}}', '{{$field->type}}', '{{$field->help}}', '{{$field->necessary}}', '{{$field->placeholder}}')" class="btn btn-primary">ویرایش فیلد</button>
                                        <button data-toggle="modal" data-target="#removeModal" class="btn btn-danger" onclick="remove('{{$field->id}}')">حذف</button>
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

        <div class="modal-dialog" style="width: 80% !important;">

            <div class="modal-content">
                <form method="post" action="{{url('form/' . $form->id . '/form_field')}}">

                    <div class="modal-header">
                        <h4 class="modal-title">افزودن فیلد</h4>
                    </div>
                    <div class="modal-body">

                        <center>
                            <p>نام</p>
                            <input type="text" name="name">
                        </center>

                        <center>
                            <p>نوع ورودی</p>
                            <select name="type" onchange="changeType(this.value)">
                                <option value="INT">عدد صحیح</option>
                                <option value="FLOAT">عدد اعشاری</option>
                                <option value="STRING">رشته حروف</option>
                                <option value="MAP">مختصات جغرافیایی</option>
                                <option value="CALENDAR">تاریخ</option>
                                <option value="TIME">ساعت</option>
                                <option value="TEXTAREA">متن بلند</option>
                                <option value="GALLERY">گالری</option>
                                <option value="LISTVIEW">لیستی از sub assets</option>
                                <option value="RADIO">انتخاب یک گزینه از میان گزینه های موجود</option>
                                <option value="CHECKBOX">انتخاب چند گزینه از میان گزینه های موجود</option>
                                <option value="FILE">تک عکس</option>
                                <option value="REDIRECTOR">هدایت گر به فرم دیگر</option>
                                <option value="API">API</option>
                            </select>
                        </center>

                        <center id="subAssets" class="hidden">
                            <p>sub asset مورد نظر</p>
                            <select name="subAsset">
                                <option value="-1">انتخاب کنید</option>
                                @foreach($subAssets as $subAsset)
                                    <option value="{{$subAsset->id}}">{{$subAsset->name}}</option>
                                @endforeach
                            </select>
                        </center>

                        <center id="forms" class="hidden">
                            <p>فرم مورد نظر</p>
                            <select name="form">
                                <option value="-1">انتخاب کنید</option>
                                @foreach($forms as $f)
                                    <option value="{{$f->id}}">{{$f->name}}</option>
                                @endforeach
                            </select>
                        </center>

                        <center id="options" class="hidden">
                            <p id="optionsLabel"></p>
                            <textarea name="options"></textarea>
                        </center>

                        <center>
                            <p>tooltip</p>
                            <textarea name="placeholder"></textarea>
                        </center>

                        <center>
                            <p>متن ارور</p>
                            <textarea name="err"></textarea>
                        </center>

                        <center>
                            <p>متن کمک</p>
                            <textarea name="help"></textarea>
                        </center>

                        <center>
                            <p>force help</p>
                            <textarea name="force_help"></textarea>
                        </center>

                        <center>
                            <p>آیا پر کردن این فیلد اجباری است؟</p>
                            <select name="necessary">
                                <option value="1">بله</option>
                                <option value="0">خیر</option>
                            </select>
                        </center>

                        <center>
                            <p>آیا کاربر می تواند چند ورودی داشته باشد؟</p>
                            <select name="multiple">
                                <option value="0">خیر</option>
                                <option value="1">بله</option>
                            </select>
                        </center>

                        <center>
                            <p>آیا این فیلد کل عرض را بگیرد؟</p>
                            <select name="half">
                                <option value="0">بله</option>
                                <option value="1">خیر</option>
                            </select>
                        </center>

                        <center>
                            <p>محدودیت ها</p>

                            <div>
                                <label for="nid">صحت سنجی کد ملی</label>
                                <input id="nid" type="checkbox" name="limitations[]" value="9">
                            </div>

                            <div>
                                <label for="minChar">محدودیت تعداد کاراکتر</label>
                                <input id="minChar" type="checkbox" onchange="changeCharLimit()" name="limitations[]" value="1">
                            </div>

                            <div id="charCountDiv" class="hidden">
                                <label for="charCount">تعداد کاراکتر مورد نظر</label>
                                <input id="charCount" type="number" name="charCount">
                            </div>

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

        function changeType(val) {

            if(val === "LISTVIEW")
                $("#subAssets").removeClass('hidden');
            else
                $("#subAssets").addClass('hidden');

            if(val === "REDIRECTOR")
                $("#forms").removeClass('hidden');
            else
                $("#forms").addClass('hidden');

            if(val === "CHECKBOX" || val === "RADIO" || val === "API")
                $("#options").removeClass('hidden');
            else
                $("#options").addClass('hidden');

            if(val === "CHECKBOX" || val === "RADIO")
                $("#optionsLabel").text("گزینه های مدنظر (گزینه های خود را با علامت '_' از هم جدا کنید");
            else if(val === "API")
                $("#optionsLabel").text("آدرس url، سرویس دهنده را وارد نمایید. نام کاربری و رمزعبور جهت اتصال به سرویس دهنده را با علامت _ از هم جدا کنید و وارد نمایید");
        }

        function changeCharLimit() {

            if($("#minChar").prop("checked"))
                $("#charCountDiv").removeClass("hidden");
            else
                $("#charCountDiv").addClass("hidden");
        }

    </script>

@stop
