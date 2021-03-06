@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>عنوان</title>
    <style>
        td {
            padding: 5px;
        }
    </style>
@endsection


@section('body')
    <div class="row">
        <div class="col-md-12">

            <div class="mainBackWhiteBody">

                <div style="margin-bottom: 200px; margin-top: 20px">

                <div class="head">درخواست های تعیین تکلیف نشده</div>
                <center>

                    <button class="btn btn-success" style="margin-top: 20px" onclick="finalize()">اتمام ارزیابی درخواست</button>
                    <a class="btn btn-primary" style="margin-top: 20px" href="{{route('ticket.msgs', ['business' => $id])}}">پیام به درخواست دهنده</a>

                    <table style="margin-top: 10px">
                        <tr>
                            <td><center>ردیف</center></td>
                            <td><center>نام فیلد</center></td>
                            <td><center>جواب کاربر</center></td>
                            <td><center>وضعیت کنونی</center></td>
                            <td><center>عملیات</center></td>
                        </tr>
                        <?php $i = 1; ?>
                        @foreach($attrs as $attr)
                            <tr>
                                <td><center>{{$i}}</center></td>
                                <td><center>{{$attr[0][0]}}</center></td>
                                @if(strpos($attr[0][1], "storage/") !== false)
                                    <td><center><img width="50px" src="{{$attr[0][1]}}"></center></td>
                                @else
                                    <td><center>{{$attr[0][1]}}</center></td>
                                @endif
                                <td><center id="{{$attr[2]}}_status">{{($attr[1]) ? "تایید شده" : "رد شده"}}</center></td>
                                <td><center><button class="btn btn-info" onclick="toggleStatus('{{$attr[2]}}')">تغییر وضعیت</button></center></td>
                            </tr>
                            <?php $i++; ?>
                        @endforeach

                    </table>

                </center>

                <div style="margin-top: 20px; border: 1px solid; padding: 10px">
                    <h3>اطلاعات مدارک</h3>
                    <?php
                    $i = 0;
                    $arr_nums = ["اول", "دوم", "سوم", "چهارم", "پنجم", "ششم", "هفتم", "هشتم", "نهم", "دهم"];
                    ?>

                    @foreach($madareks as $madarek)
                        <div style="margin-top: 20px; background-color: #ccc">
                            <h3 style="color: #3998a4">
                                عضو {{$arr_nums[$i]}}
                                <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <span>وضعیت: </span>
                                <span id="madareks_status_{{$madarek->id}}">{{($madarek->status) ? "تایید شده" : "تایید نشده"}}</span>
                                <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <button onclick="toggleStatusWithId('madareks', '{{$madarek->id}}')" class="btn btn-info">تغییر وضعیت</button>
                            </h3>
                            <p>نام: {{$madarek->name}}</p>
                            <p>نقش: {{$madarek->role}}</p>
                            <p>تصاویر کارت ملی</p>
                            <img width="300px" src="{{$madarek->pic1}}">
                            <img width="300px" src="{{$madarek->pic2}}">
                        </div>
                        <?php $i++; ?>
                    @endforeach
                </div>

                <div style="margin-top: 20px; border: 1px solid; padding: 10px">
                    <h3>تصاویر</h3>

                    @foreach($pics as $pic)
                        <div style="margin-top: 20px; background-color: #ccc">
                            <h3>
                                <span>وضعیت: </span>
                                <span id="pics_status_{{$pic->id}}">{{($madarek->status) ? "تایید شده" : "تایید نشده"}}</span>
                                <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <button onclick="toggleStatusWithId('pics', '{{$pic->id}}')" class="btn btn-info">تغییر وضعیت</button>
                            </h3>
                            <img width="300px" src="{{$pic->pic}}">
                        </div>
                    @endforeach
                </div>

            </div>

            </div>

        </div>
    </div>

    <script>

        function doFinalize() {

            $.ajax({
                type: 'post',
                url: '{{route('businessPanel.finalize', ['business' => $id])}}',
                success: function (res) {

                    if(res.status === "ok") {
                        document.location.href = '{{route('businessPanel.getUnChecked')}}';
                        return;
                    }

                    showSuccessNotifiBP(res.msg, 'right', '#ac0020');
                },
                error: function (rejected) {
                    errorAjax(rejected);
                }
            });
        }

        function toggleStatus(field) {

            $.ajax({
                type: 'post',
                url: '{{route('businessPanel.setFieldStatus', ['business' => $id])}}',
                data: {
                    field: field
                },
                success: function (res) {

                    if(res.status === "ok")
                        $("#" + field + "_status").empty().append(res.newStatus);
                    else
                        showSuccessNotifiBP(res.msg, 'right', '#ac0020');
                },
                error: function (rejected) {
                    errorAjax(rejected);
                }
            });

        }

        function toggleStatusWithId(field, id) {

            $.ajax({
                type: 'post',
                url: '{{route('businessPanel.setFieldStatus', ['business' => $id])}}',
                data: {
                    field: field,
                    id: id
                },
                success: function (res) {
                    if(res.status === "ok")
                        $("#" + field + "_status_" + id).empty().append(res.newStatus);
                    else
                        showSuccessNotifiBP(res.msg, 'right', '#ac0020');
                },
                error: function (rejected) {
                    errorAjax(rejected);
                }
            });

        }

        function finalize() {

            $.ajax({
                type: 'post',
                url: '{{route('businessPanel.getFinalStatus', ['business' => $id])}}',
                success: function (res) {

                    var msg = "<div style='max-height: 200px; overflow: auto'>";

                    if(res.status == "ok")
                        msg += "تمام فیلد ها تایید شده است و با اتمام ارزیابی درخواست، این درخواست تایید شده خواهد بود. آیا مطمئن هستید؟";
                    else if(res.status === "nok") {
                        msg += "یک سری از فیلد ها رد شده هستند که در زیر لیست شده اند و با زدن دکمه اتمام ارزیابی درخواست، این درخواست رد شده خواهد بود. آیا مطمئن هستید؟";

                        for (var i = 0; i < res.fields.length; i++) {
                            msg += "<p>";
                            msg += res.fields[i];
                            msg += "</p>";
                        }
                    }
                    else {
                        showSuccessNotifiBP(res.msg, 'right', '#ac0020');
                        return;
                    }

                    msg += "</div>";
                    openWarningBP(msg, doFinalize, "بله");
                },
                error: function (rejected) {
                    errorAjax(rejected);
                }
            });

        }

    </script>

@endsection

