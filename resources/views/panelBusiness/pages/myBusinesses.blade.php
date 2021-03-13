@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>کسب و کارهای من</title>
    <style>
        td {
            padding: 7px;
            min-width: 150px;
        }
    </style>
@endsection


@section('body')
    <div class="row">
        <div class="col-md-12">

            <div class="mainBackWhiteBody">
                <div class="head">کسب و کارهای من</div>
                @if(count($businesses) == 0)
                    <p>کسب و کاری موجود نیست</p>
                @else
                    <center>
                        <table class="table table-striped">
                            <tr style="background: var(--koochita-yellow)">
                                <td>ردیف</td>
                                <td>نام کسب و کار</td>
                                <td>نوع کسب و کار</td>
                                <td>تاریخ ایجاد</td>
                                <td>وضعیت</td>
                                <td>عملیات</td>
                            </tr>
                            <?php $i = 1; ?>
                            @foreach($businesses as $business)
                                <tr id="tr_{{$business->id}}">
                                    <td>{{$i}}</td>
                                    <td>{{$business->name}}</td>
                                    <td>{{$business->type}}</td>
                                    <td>{{$business->createBusinessDate}}</td>
                                    @if($business->readyForCheck)
                                        <td>در حال بررسی</td>
                                    @elseif($business->finalStatus)
                                        <td>تایید شده</td>
                                        <td>
                                            <a href="{{route('businessManagement.panel', ['business' => $business->id])}}" class="btn btn-success">رفتن به پنل مدیریت</a>
                                            <a class="btn btn-info circleButton" href="{{route('ticket.msgs', ['business' => $business->id])}}" title="پیام ها">
                                                <i class="fas fa-envelope"></i>
                                            </a>
                                            <a class="btn btn-danger circleButton" onclick="deleteBusiness('{{$business->id}}')" title="حذف">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    @elseif(!$business->problem)
                                        <td>در حال ویرایش/تکمیل توسط کاربر</td>
                                        <td>
                                            <a href="{{route('businessPanel.edit', ['business' => $business])}}" title="ویرایش اطلاعات" class="btn btn-primary circleButton">
                                                <i class="fa-solid fa-file-pen"></i>
                                            </a>
                                            <a class="btn btn-info circleButton" href="{{route('ticket.msgs', ['business' => $business->id])}}" title="پیام ها">
                                                <i class="fas fa-envelope"></i>
                                            </a>
                                            <a class="btn btn-danger circleButton" onclick="deleteBusiness('{{$business->id}}')" title="حذف">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    @elseif($business->problem)
                                        <td>اعلام نقص شده</td>
                                        <td>
                                            <a href="{{route('businessPanel.edit', ['business' => $business])}}" title="اصلاح نواقص" class="btn btn-warning circleButton">
                                                <i class="fa-solid fa-file-pen"></i>
                                            </a>
                                            <a class="btn btn-info circleButton" href="{{route('ticket.msgs', ['business' => $business->id])}}" title="پیام ها">
                                                <i class="fas fa-envelope"></i>
                                            </a>
                                            <a class="btn btn-danger circleButton" onclick="deleteBusiness('{{$business->id}}')" title="حذف">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                                <?php $i++; ?>
                            @endforeach

                        </table>
                    </center>
                @endif
            </div>

        </div>
    </div>

    <script>

        function deleteBusiness(id) {

            openLoading();

            $.ajax({
                type: "delete",
                url: '{{url('deleteBusiness')}}' + "/" + id,
                success: function (res) {

                    closeLoading();

                    if(res.status === "0")
                        $("#tr_" + id).remove();
                }
            });
        }

    </script>

@endsection

