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

                    <button onclick="addTicket()" class="btn btn-success">افزودن تیکت جدید</button>

                    <table  class="table table-striped" style="margin-top: 20px">
                        <thead>
                            <tr STYLE="background: var(--koochita-yellow)">
                                <td>ردیف</td>
                                <td>عنوان</td>
                                <td>تاریخ ایجاد</td>
                                <td>آخرین بروز رسانی</td>
                                <td>وضعیت</td>
                                <td>عملیات</td>
                            </tr>
                        </thead>
                        <tbody id="tbody"></tbody>
                    </table>
                </center>
            </div>

        </div>

        <div class="col-md-12 hidden" id="newTicket">

            <div class="mainBackWhiteBody">

                <form method="post" action="{{route('businessPanel.addTicket', ['business' => $id])}}" enctype="multipart/form-data">

                    {{csrf_field()}}

                    <div class="col-md-12">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="title">عنوان</label>
                                <input type="text" name="title" id="title" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="msg">متن درخواست</label>
                                <textarea style="height: 300px; overflow: auto" id="msg" name="msg" class="form-control"></textarea>
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
        var businessSpecificMsgsUrl = '{{url("businessSpecificMsgs")}}';
        var isAdminUserInMsgs = '{{\Illuminate\Support\Facades\Auth::user()->level}}';

        $(document).ready(function () {

            $.ajax({
                type: 'post',
                url: '{{route('businessPanel.generalMsgs', ['business' => $id])}}',
                success: res => createTabelMsgsRow(res.msgs)
            });

        });

        function createTabelMsgsRow(msgs){
            var newElem = "";


            for(var i = 0; i < msgs.length; i++) {
                newElem += `<tr>
                                <td>${(i + 1)}</td>
                                <td>${msgs[i].subject}</td>
                                <td>${msgs[i].create}</td>
                                <td>${msgs[i].update}</td>
                                <td id='status_${msgs[i].id}'>${msgs[i].close == "1" ? "مختوم" : "باز"}</td>
                                <td>
                                    <a href='${businessSpecificMsgsUrl}/${msgs[i].id}' style='margin: 5px' class='btn btn-success'>مشاهده پیام ها</a>`;

                if(isAdminUserInMsgs == "1" && msgs[i].close != "1")
                    newElem += `<button onclick='finishMsg(${msgs[i].id})' style='margin: 5px' class='btn btn-warning'>مختومه کردن</button>`;
                else if(isAdminUserInMsgs == "1" && msgs[i].close == "1")
                    newElem += `<button onclick='reOpenMsg(${msgs[i].id})' style='margin: 5px' class='btn btn-primary'>باز کردن</button>`;

                newElem += `<button onclick='deleteTicket(${msgs[i].id})' style='margin: 5px' class='btn btn-danger circleButton'>
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            </td>
                        </tr>`;
            }

            $("#tbody").empty().append(newElem);
        }

        function deleteTicket(id) {

            openLoading();

            $.ajax({
                type: 'delete',
                url: "{{url("deleteTicket")}}" + "/" + id,
                success: function (res) {
                    closeLoading();
                    if(res.status === "0")
                        $("#tr_" + id).remove();
                }
            });

        }

        function finishMsg(id) {

            $.ajax({
                type: 'post',
                url: '{{url('ticketClose')}}' + "/" + id,
                success: function (res) {
                    if(res.status == "0") {
                        $("#status_" + id).empty().append("مختوم");
                    }
                }
            });

        }

        function reOpenMsg(id) {

            $.ajax({
                type: 'post',
                url: '{{url('ticketOpen')}}' + "/" + id,
                success: function (res) {
                    if(res.status == "0") {
                        $("#status_" + id).empty().append("باز");
                    }
                }
            });

        }

        function addTicket() {
            $("#newTicket").removeClass('hidden');
            $("#table").addClass('hidden');
        }

        function cancelAddMsg() {
            $("#newTicket").addClass('hidden');
            $("#table").removeClass('hidden');
        }

    </script>

@endsection

