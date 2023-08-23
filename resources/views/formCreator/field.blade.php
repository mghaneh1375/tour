@extends('panelBusiness.layout.baseLayout')

@section('head')
    @parent
    <script>
        var delUrl = "{{ url('boom/form_field') }}" + "/";
    </script>
    <style>
        textarea {
            width: 80%;
            height: 100px;
            overflow: auto;
        }

        label {
            font-size: 13px;
        }
    </style>
@stop

@section('body')
    <div class="mainBackWhiteBody">
        <div class="whiteBox">
            <div class="sparkline8-list shadow-reset mg-tb-30">
                @if ($errors->any())
                    {!! implode('', $errors->all('<div id="err" class="hidden">:message</div>')) !!}
                @endif
                <div class="sparkline8-hd">
                    <div class="main-sparkline8-hd">
                        <h1>
                            <span>فیلد ها</span>
                            <span>&nbsp;&nbsp;&nbsp;</span>
                            <span> | </span>
                            <span>&nbsp;&nbsp;&nbsp;</span>

                            <span class="clickable" onclick="document.location.href = '{{ url('asset') }}'">
                                <span>{{ $form->asset->name }}</span>
                            </span>
                            <span>&nbsp;&nbsp;&nbsp;</span>
                            <span> | </span>
                            <span>&nbsp;&nbsp;&nbsp;</span>

                            <span>{{ $form->name }}</span>
                            <span
                                onclick="document.location.href = '{{ route('asset.form.index', ['asset' => $form->asset->id]) }}'"
                                class="back" data-placement="left" title="برگشت"><span
                                    class="glyphicon glyphicon-arrow-left"></span></span>
                        </h1>
                    </div>
                </div>

                <div class="sparkline8-graph dashone-comment messages-scrollbar dashtwo-messages">
                    <button data-toggle="modal" data-target="#addModal"
                        class="btn btn-success"data-placement="top"title="افزودن فیلد جدید"><i class="plus2 iconStyle"
                            onclick="changeType(' ') "></i></button>

                    <div style="direction: rtl; overflow: auto;padding-top:5px">
                        <table class="table table-striped">
                            <thead style="background: var(--koochita-yellow);">
                                <tr>
                                    <td>نام</td>
                                    <td>ضروری</td>
                                    <td>متن ارور</td>
                                    <td>متن کمک</td>
                                    <td>Force Help</td>
                                    <td>نوع</td>
                                    <td>محدودیت</td>
                                    <td>tooltip</td>
                                    <td>منتخب</td>
                                    <td>نوع چینش</td>
                                    <td>نوع نمایش</td>
                                    <td>چند ورودی</td>
                                    <td>کلید</td>
                                    <td>عملیات</td>
                                </tr>
                            </thead>
                            @foreach ($form->form_fields as $field)
                                <tr id="tr_{{ $field->id }}">
                                    <td>{{ $field->name }}</td>
                                    <td>{{ $field->necessary ? 'بله' : 'خیر' }}</td>
                                    <td>{{ $field->err }}</td>
                                    <td>{{ $field->help }}</td>
                                    <td>{{ $field->force_help }}</td>
                                    <td>{!! html_entity_decode($field->type) !!}</td>
                                    <td>{!! html_entity_decode($field->limitation) !!}</td>
                                    <td>{{ $field->placeholder }}</td>
                                    <td>{{ $field->presenter ? 'بله' : 'خیر' }}</td>
                                    <td>{{ $field->rtl ? 'rtl' : 'ltr' }}</td>
                                    <td>{{ $field->half ? 'نمایش نصفه' : 'نمایش کامل' }}</td>
                                    <td>{{ $field->multiple ? 'بله' : 'خیر' }}</td>
                                    <td>{{ $field->key_ }}</td>
                                    <td style="width:13%">
                                        <button data-toggle="modal" data-target="#editModal"
                                            onclick="editForm('{{ $field->id }}', '{{ $field->rtl ? 'rtl' : 'ltr' }}','{{ $field->half ? 'نمایش نصفه' : 'نمایش کامل' }}', '{{ $field->editUrl }}')"
                                            class="btn btn-primary"data-placement="top" title="ویرایش فبلد">
                                            <span class="glyphicon glyphicon-edit"></span></button>
                                        <button data-toggle="modal" data-target="#removeModal" class="btn btn-danger"
                                            onclick="remove('{{ $field->id }}')"data-placement="top"title="حذف"><span
                                                class="glyphicon glyphicon-trash"></span></button>
                                    </td>
                                </tr>
                            @endforeach

                        </table>
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
                    <h4 class="modal-title">افزودن فیلد</h4>
                </div>
                <div class="modal-body">
                    <div style="display: flex;flex-wrap: wrap;justify-content: space-evenly;margin-bottom:20px">
                        <div>
                            <label for="name">نام</label>
                            <input id="editName" type="text" name="name">
                        </div>
                        <div>
                            <label for="key">کلید</label>
                            <input id="editKey" type="text" name="key">
                        </div>
                    </div>

                    <center style="margin-bottom:10px">
                        <label for="type">نوع ورودی</label>
                        <select id="editType" name="type" onchange="changeType(this.options[this.selectedIndex].text)">
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
                            <option value="CKEDITOR">CKEDITOR</option>
                        </select>
                    </center>

                    <center id="subAssets" class="hidden subAssets">
                        <label for="subAsset">sub asset مورد نظر</label>
                        <select name="subAsset">
                            <option value="-1">انتخاب کنید</option>
                            @foreach ($subAssets as $subAsset)
                                <option value="{{ $subAsset->id }}">{{ $subAsset->name }}</option>
                            @endforeach
                        </select>
                    </center>
                    <center id="forms" class="hidden forms">
                        <label for="form">فرم مورد نظر</label>
                        <select name="form">
                            <option value="-1">انتخاب کنید</option>
                            @foreach ($forms as $f)
                                <option value="{{ $f->id }}">{{ $f->name }}</option>
                            @endforeach

                            @if (isset($subAssetForms))
                                @foreach ($subAssetForms as $ff)
                                    @foreach ($ff as $f)
                                        <option value="{{ $f->id }}">{{ $f->name }}</option>
                                    @endforeach
                                @endforeach
                            @endif

                        </select>
                    </center>

                    <center id="options" class="hidden options">
                        <p id="optionsLabel" class="optionsLabel"></p>
                        <textarea id="showOptions" style="width:100%;" name="options"></textarea>
                    </center>

                    <center>
                        <p>tooltip</p>
                        <textarea id="editPlaceholder" style="width:100%;" name="placeholder" placeholder="هنوز محتوایی وارد نشده است"></textarea>
                    </center>

                    <center>
                        <p>متن ارور</p>
                        <textarea id="editErr" name="err" style="width:100%;" placeholder="هنوز محتوایی وارد نشده است"></textarea>
                    </center>

                    <center>
                        <p>متن کمک</p>
                        <textarea id="editHelp" style="width:100%;" name="help"placeholder="هنوز محتوایی وارد نشده است"></textarea>
                    </center>

                    <center>
                        <p>force help</p>
                        <textarea id="editForceHelp" style="width:100%;" name="force_help"placeholder="هنوز محتوایی وارد نشده است"></textarea>
                    </center>

                    <div style="display: flex;flex-wrap: wrap;margin-top:10px">
                        <div
                            style="display: flex;width: 51%;justify-content: space-between;margin-left:5px;margin-bottom:5px">
                            <label for="necessary">آیا پر کردن این فیلد اجباری است؟</label>
                            <select id="editNecessary" name="necessary">
                                <option value="1">بله</option>
                                <option value="0">خیر</option>
                            </select>
                        </div>

                        <div style="display: flex;width: 45%;justify-content: space-between;margin-bottom:5px">
                            <label for="presenter">آیا فیلد منتخب است؟</label>
                            <select id="editPresenter" name="presenter">
                                <option value="0">خیر</option>
                                <option value="1">بله</option>
                            </select>
                        </div>
                        <div
                            style="display: flex;width: 51%;justify-content: space-between;margin-left:5px;margin-bottom:5px">
                            <label for="multiple">آیا کاربر می تواند چند ورودی داشته باشد؟</label>
                            <select id="editMultiple" name="multiple">
                                <option value="0">خیر</option>
                                <option value="1">بله</option>
                            </select>
                            </span>
                        </div>
                        <div style="display: flex;width: 45%;justify-content: space-between;margin-bottom:5px">
                            <label for="direction">نوع چینش</label>
                            <select id="editDr" name="direction">
                                <option value="0">ltr</option>
                                <option value="1">rtl</option>
                            </select>
                        </div>


                        <div style="display: flex;width: 51%;justify-content: space-between;margin-bottom:5px">
                            <label for="half">آیا این فیلد کل عرض را بگیرد؟</label>
                            <select id="editHalf"name="half">
                                <option value="1">خیر</option>
                                <option value="0">بله</option>
                            </select>
                        </div>
                    </div>
                    <div style="display: flex;align-items: center;margin-top:10px">
                        <label style="margin-left: 25px;">محدودیت ها</label>

                        <div>
                            <div>
                                <label for="nid">صحت سنجی کد ملی</label>
                                <input id="nid" type="checkbox" onchange="change()" name="limitations[]"
                                    value="9">
                            </div>

                            <div>
                                <label for="minChar">محدودیت تعداد کاراکتر</label>
                                <input id="minChar" type="checkbox" onchange="changeCharLimitEdit()"
                                    name="limitations[]" value="1">
                            </div>

                            <div id="charCountDiv" class="hidden">
                                <label for="charCount">تعداد کاراکتر مورد نظر</label>
                                <input id="charCount" type="number" name="charCount">
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
                    <div class="btn btn-success" onclick="updateFields()"> تایید</div>

                </div>
            </div>

        </div>
    </div>

    <div id="addModal" class="modal fade" role="dialog">

        <div class="modal-dialog" style="width: 80% !important;">

            <div class="modal-content">
                <form method="post" action="{{ route('form.form_field.store', ['form' => $form->id]) }}">

                    <div class="modal-header">
                        <h4 class="modal-title">افزودن فیلد</h4>
                    </div>
                    <div class="modal-body">

                        <div style="display: flex;flex-wrap: wrap;justify-content: space-evenly;margin-bottom:20px">
                            <div>
                                <label for="name">نام</label>
                                <input type="text" name="name">
                            </div>
                            <div>
                                <label for="key_">کلید</label>
                                <input type="text" name="key_">
                            </div>
                        </div>


                        <center style="margin-bottom:10px">
                            <label for="type">نوع ورودی</label>
                            <select name="type" onchange="changeType(this.options[this.selectedIndex].text)">
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
                                <option value="CKEDITOR">CKEDITOR</option>
                            </select>
                        </center>

                        <center id="subAssets" class="hidden subAssets">
                            <label for="subAsset">sub asset مورد نظر</label>
                            <select name="subAsset">
                                <option value="-1">انتخاب کنید</option>
                                @foreach ($subAssets as $subAsset)
                                    <option value="{{ $subAsset->id }}">{{ $subAsset->name }}</option>
                                @endforeach
                            </select>
                        </center>

                        <center id="forms" class="hidden forms">
                            <label for="form">فرم مورد نظر</label>
                            <select name="form">
                                <option value="-1">انتخاب کنید</option>
                                @foreach ($forms as $f)
                                    <option value="{{ $f->id }}">{{ $f->name }}</option>
                                @endforeach

                                @if (isset($subAssetForms))
                                    @foreach ($subAssetForms as $ff)
                                        @foreach ($ff as $f)
                                            <option value="{{ $f->id }}">{{ $f->name }}</option>
                                        @endforeach
                                    @endforeach
                                @endif
                            </select>
                        </center>

                        <center id="options" class="options hidden">
                            <label for="options" id="optionsLabel" class="optionsLabel"></label>
                            <textarea name="options" style="width: 100%"></textarea>
                        </center>

                        <center>
                            <p>tooltip</p>
                            <textarea name="placeholder" style="width:100%;"></textarea>
                        </center>

                        <center>
                            <p>متن ارور</p>
                            <textarea name="err" style="width:100%;"></textarea>
                        </center>

                        <center>
                            <p>متن کمک</p>
                            <textarea name="help"style="width:100%;"></textarea>
                        </center>

                        <center>
                            <p>force help</p>
                            <textarea name="force_help" style="width:100%;"></textarea>
                        </center>

                        <div style="display: flex;flex-wrap: wrap;margin-top:10px">
                            <div
                                style="display: flex;width: 51%;justify-content: space-between;margin-left:5px;margin-bottom:5px">
                                <label for="necessary">آیا پر کردن این فیلد اجباری است؟</label>
                                <select name="necessary">
                                    <option value="1">بله</option>
                                    <option value="0">خیر</option>
                                </select>
                            </div>

                            <div style="display: flex;width: 45%;justify-content: space-between;margin-bottom:5px">
                                <label for="presenter">آیا فیلد منتخب است؟</label>
                                <select name="presenter">
                                    <option value="1">بله</option>
                                    <option value="0">خیر</option>
                                </select>
                            </div>
                            <div
                                style="display: flex;width: 51%;justify-content: space-between;margin-left:5px;margin-bottom:5px">
                                <label for="multiple">آیا کاربر می تواند چند ورودی داشته باشد؟</label>
                                <select name="multiple">
                                    <option value="1">بله</option>
                                    <option value="0">خیر</option>
                                </select>
                                </span>
                            </div>
                            <div style="display: flex;width: 45%;justify-content: space-between;margin-bottom:5px">
                                <label for="direction">نوع چینش</label>
                                <select name="rtl">
                                    <option value="1">rtl</option>
                                    <option value="0">ltr</option>
                                </select>
                            </div>


                            <div style="display: flex;width: 51%;justify-content: space-between;margin-bottom:5px">
                                <label for="half">آیا این فیلد کل عرض را بگیرد؟</label>
                                <select name="half">
                                    <option value="1">خیر</option>
                                    <option value="0">بله</option>
                                </select>
                            </div>
                        </div>

                        <div style="display: flex;align-items: center;margin-top:10px">
                            <label style="margin-left: 25px;">محدودیت ها</label>
                            <div>

                                <div>
                                    <label for="nid">صحت سنجی کد ملی</label>
                                    <input id="nid" type="checkbox" name="limitations[]" value="9">
                                </div>

                                <div>
                                    <label for="minChar">محدودیت تعداد کاراکتر</label>
                                    <input id="minChar" class="minCharadd" type="checkbox"
                                        onchange="changeCharLimit()" name="limitations[]" value="1">
                                </div>

                                <div id="charCountDivAdd" class="hidden">
                                    <label for="charCount">تعداد کاراکتر مورد نظر</label>
                                    <input id="charCount" type="number" name="charCount">
                                </div>
                            </div>

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
                if (err !== undefined && err.length > 1)
                    showSuccessNotifiBP(err, 'right', '#ac0020');
            }, 500);
        });
        let url;
        var charCount;
        var limitations = [];
        var forms = {!! json_encode($form->form_fields) !!};
        var nothing;

        function editForm(id, dr, half, u) {
            items = forms.filter(x => x.id == id);

            for (let i = 0; i < items.length; i++) {
                console.log(items[i]);
                url = u;
                $('#editType option').attr('selected', false);
                // $("#editType option").attr('selected', false);
                $('textarea').empty();
                $('inpt').empty();
                $('input:checkbox').removeAttr('checked');
                if (items[i].type.indexOf('RADIO') > -1) {
                    $("#editType").val('RADIO');
                    $("#options").removeClass('hidden');
                    $(".optionsLabel").text("گزینه های مدنظر (گزینه های خود را با علامت '_' از هم جدا کنید");
                    $("textarea[name='options']").append();
                } else if (items[i].type.indexOf('CHECKBOX') > -1) {
                    $("#editType").val('CHECKBOX');
                    $("#options").removeClass('hidden');
                    $(".optionsLabel").text("گزینه های مدنظر (گزینه های خود را با علامت '_' از هم جدا کنید");
                } else {}

                $("#editType option").each(function() {
                    if ($(this).text() === items[i].type) {
                        changeType($(this).text());
                        $(this).attr('selected', true);
                    } else {
                        return;
                    }

                });
                if (items[i].type.indexOf('API') > -1) {
                    changeType('API');
                    $('#editType option[value="API"]').attr('selected', true);
                }

                $("#editName").val(items[i].name);
                $("#editNecessary").val(items[i].necessary);
                $("#editMultiple").val(items[i].multiple);
                $("#editHalf").val(items[i].half);
                $("#editPresenter").val(items[i].presenter);
                $("#editDr").val(items[i].rtl);
                $("#editPlaceholder").append(items[i].placeholder);
                $("#editErr").append(items[i].err);
                $("#editHelp").append(items[i].help);
                $("#editKey").val(items[i].key_);
                $("#editForceHelp").append(items[i].force_help);
                $("#showOptions").append(items[i].options);
                limitations = items[i].limitation;
                if (limitations.indexOf('ملی') > -1 && limitations.indexOf('کاراکتر') != -1) {
                    $('#nid').prop('checked', true);
                    $('#minChar').prop('checked', true);
                    str = limitations.replace(/[^\d.]/g, '');
                    total = parseInt(str, 10);
                    $("#charCount").val(total);
                    $("#charCountDiv").removeClass("hidden");
                } else if (limitations.indexOf('ملی') != -1) {
                    $('#nid').prop('checked', true);
                } else if (limitations.indexOf('کاراکتر') != -1) {
                    $('#minChar').prop('checked', true);
                    $("#charCountDiv").removeClass("hidden");
                    str = limitations.replace(/[^\d.]/g, '');
                    total = parseInt(str, 10);
                    $("#charCount").val(total);
                } else {
                    // limitations.push('محدودیتی موجود نیست');
                }
            }
        }

        function change() {
            limitations = [];
            if ($('#nid').is(':checked') && $('#minChar').is(':checked')) {
                limitations.push($('#nid').val());
                limitations.push($('#minChar').val());
            } else if ($('#nid').is(':checked')) {
                limitations.push($('#nid').val());
            } else if ($('#minChar').is(':checked')) {
                limitations.push($('#minChar').val());
            } else {
                limitations.push(nothing);
            }
        }

        function updateFields() {

            change();

            $.ajax({
                type: 'put',
                url: url,
                data: {
                    options: $("#showOptions").val(),
                    name: $("#editName").val(),
                    type: $("#editType").val(),
                    help: $("#editHelp").val(),
                    placeholder: $("#editPlaceholder").val(),
                    force_help: $("#editForceHelp").val(),
                    err: $("#editErr").val(),
                    necessary: $("#editNecessary").val(),
                    half: $("#editHalf").val(),
                    presenter: $("#editPresenter").val(),
                    multiple: $("#editMultiple").val(),
                    rtl: $("#editDr").val(),
                    limitations: limitations,
                    charCount: $("#charCount").val(),
                    key_: $("#editKey").val(),
                },
                success: function(res) {
                    if (res.status === "ok") {
                        showSuccessNotifiBP('عملیات با موفقیت انجام شد', 'right', '#053a3e');
                        location.reload();
                    } else {
                        showSuccessNotifiBP('عملیات با موفقیت انجام نشد', 'right', '#ac0020');
                    }
                }
            });
        }

        function changeType(val) {
            $("#showOptions").empty();
            $(".optionsLabel").empty();
            $(".subAssets").addClass('hidden');
            $(".forms").addClass('hidden');
            $(".options").addClass('hidden');
            if (val === "لیستی از sub assets") {
                $(".subAssets").removeClass('hidden');
                return;
            } else if (val === "هدایت گر به فرم دیگر") {
                $(".forms").removeClass('hidden');
            } else if (val === 'API') {
                $(".options").removeClass('hidden');
                $(".optionsLabel").text(
                    "آدرس url، سرویس دهنده را وارد نمایید. نام کاربری و رمزعبور جهت اتصال به سرویس دهنده را با علامت _ از هم جدا کنید و وارد نمایید"
                );

            } else if (val === "انتخاب چند گزینه از میان گزینه های موجود" || val ===
                "انتخاب یک گزینه از میان گزینه های موجود") {
                $(".options").removeClass('hidden');
                $(".optionsLabel").text("گزینه های مدنظر (گزینه های خود را با علامت '_' از هم جدا کنید");
            } else if (val === "API") {} else {
                // $("#editType option").attr('selected', false);
            }
        }

        function changeCharLimit() {
            if ($(".minCharadd").prop("checked")) {
                $("#charCountDivAdd").removeClass("hidden");
            } else {
                $("#charCountDivAdd").addClass("hidden");
            }
        }

        function changeCharLimitEdit() {
            if ($('#nid').is(':checked') && $('#minChar').is(':checked')) {
                limitations = [];
                limitations.push($('#nid').val());
                limitations.push($('#minChar').val());
            } else if ($('#nid').is(':checked')) {
                limitations = [];
                limitations.push($('#nid').val());
            } else if ($('#minChar').is(':checked')) {
                limitations = [];
                limitations.push($('#minChar').val());
            } else {
                limitations = [];
                limitations.push(nothing);
            }

            if ($("#minChar").prop("checked")) {
                $("#charCountDiv").removeClass("hidden");
                // charCount = $("#charCount").val();
            } else {
                $("#charCount").val('');
                $("#charCountDiv").addClass("hidden");
            }
        }
    </script>

@stop
