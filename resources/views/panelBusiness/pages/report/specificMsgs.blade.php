@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>عنوان</title>
    <style>
        td {
            padding: 5px;
            min-width: 150px;
        }
    </style>
@endsection


@section('body')
    <div class="row">
        <div class="col-md-12" id="table">

            <div class="mainBackWhiteBody">
                <div class="head">پیام ها</div>

                <center>

                    <button onclick="addMsg()" class="btn btn-success">افزودن پیام جدید</button>

                    <h4 style="float: right">موضوع: {{$ticket->subject}}</h4>

                    <table style="margin-top: 20px">
                        <thead>
                        <tr>
                            <td><center>ردیف</center></td>
                            <td><center>متن پیام</center></td>
                            <td><center>فایل ضمیمه</center></td>
                            <td><center>تاریخ ایجاد</center></td>
                            <td><center>عملیات</center></td>
                        </tr>
                        </thead>
                        <tbody id="tbody"></tbody>

                    </table>
                </center>
            </div>

        </div>

        <div class="col-md-12 hidden" id="newTicket">

            <div class="mainBackWhiteBody">

                <form method="post" action="{{route('businessPanel.ticketAddMsg', ['ticket' => $id])}}" enctype="multipart/form-data">

                    {{csrf_field()}}

                    <div class="col-md-12">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="msg">متن درخواست</label>
                                <textarea id="msg" name="msg" style="height: 300px; overflow: auto" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="file">فایل پیوست (در صورت لزوم)</label>
                                <input type="file" name="file" id="file" class="form-control">
                            </div>
                        </div>
                    </div>

                    <input type="submit" class="btn btn-success" value="ثبت">
                    <span onclick="cancelAddMsg()" class="btn btn-danger">انصراف</span>

                </form>
            </div>

        </div>

    </div>

    <script>

        $(document).ready(function () {

            $.ajax({
                type: 'post',
                url: '{{route('businessPanel.ticketMsgs', ['ticket' => $id])}}',
                success: function (res) {

                    msgs = [res.ticket];
                    var newElem = "";

                    for(var i = 0; i < msgs.length; i++) {
                        newElem += "<tr id='tr_" + msgs[i].id + "'>";
                        newElem += "<td><center>" + (i + 1) + "</center></td>";
                        newElem += "<td><center>" + msgs[i].msg + "</center></td>";

                        if(msgs[i].file != null && msgs[i].file != "null" && msgs[i].file.length > 0)
                            newElem += "<td><center><a target='_blank' download href='" + "{{\Illuminate\Support\Facades\URL::asset('storage')}}" + "/" + msgs[i].file + "'>دانلود</a></center></td>";
                        else
                            newElem += "<td><center>ندارد</center></td>";

                        newElem += "<td><center>" + msgs[i].create + "</center></td>";

                        newElem += "<td><center>";
                        newElem += "<button onclick='deleteMsg(" + msgs[i].id + ")' style='margin: 5px' class='btn btn-danger'>حذف پیام</button>";
                        newElem += "</center></td>";
                        newElem += "</tr>";
                    }

                    msgs = res.others;

                    for(i = 0; i < msgs.length; i++) {
                        newElem += "<tr id='tr_" + msgs[i].id + "'>";
                        newElem += "<td><center>" + (i + 2) + "</center></td>";
                        newElem += "<td><center>" + msgs[i].msg + "</center></td>";

                        if(msgs[i].file != null && msgs[i].file != "null" && msgs[i].file.length > 0)
                            newElem += "<td><center><a target='_blank' download href='" + "{{\Illuminate\Support\Facades\URL::asset('storage')}}" + "/" + msgs[i].file + "'>دانلود</a></center></td>";
                        else
                            newElem += "<td><center>ندارد</center></td>";

                        newElem += "<td><center>" + msgs[i].create + "</center></td>";

                        newElem += "<td><center>";
                        newElem += "<button onclick='deleteMsg(" + msgs[i].id + ")' style='margin: 5px' class='btn btn-danger'>حذف پیام</button>";
                        newElem += "</center></td>";
                        newElem += "</tr>";
                    }

                    $("#tbody").empty().append(newElem);
                }
            });

        });

        function deleteMsg(id) {

            openLoading();

            $.ajax({
                type: 'delete',
                url: "{{url("deleteTicket")}}" + "/" + id,
                success: function (res) {

                    closeLoading();

                    if(res.status === "0") {

                        if(res.redirect.length > 0)
                            document.location.href = res.redirect;
                        else
                            $("#tr_" + id).remove();
                    }
                }
            });

        }

        function addMsg() {
            $("#newTicket").removeClass('hidden');
            $("#table").addClass('hidden');
        }

        function cancelAddMsg() {
            $("#newTicket").addClass('hidden');
            $("#table").removeClass('hidden');
        }

    </script>

@endsection

