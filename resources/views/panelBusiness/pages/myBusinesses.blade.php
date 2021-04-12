@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>کسب و کارهای من</title>
    <style>
        td {
            padding: 7px;
            min-width: 150px;
        }
        .msgLast{
            min-width: auto;
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
                                <th>ردیف</th>
                                <th>نام کسب و کار</th>
                                <th>نوع کسب و کار</th>
                                <th>تاریخ ایجاد</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                                <th></th>
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
                                            <a href="{{route('businessManagement.panel', ['business' => $business->id])}}" class="btn btn-success" style="font-size: 10px;">رفتن به پنل مدیریت</a>
                                        </td>
                                    @elseif(!$business->problem)
                                        <td>در حال ویرایش/تکمیل توسط کاربر</td>
                                        <td>
                                            <a href="{{route('businessPanel.edit', ['business' => $business])}}" title="ویرایش اطلاعات" class="btn btn-primary circleButton">
                                                <i class="fa-solid fa-file-pen"></i>
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
                                            <a class="btn btn-danger circleButton" onclick="deleteBusiness('{{$business->id}}')" title="حذف">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    @endif

                                    <td class="msgLast">
                                        <a class="btn btn-info circleButton" href="{{route('ticket.msgs', ['business' => $business->id])}}" title="پیام ها">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                    </td>
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
                url: `{{url('deleteBusiness')}}/${id}`,
                complete: closeLoading,
                success: res => {
                    if(res.status === "ok")
                        $(`#tr_${id}`).remove();
                    else if(res.status === "notAccess")
                        alert('شما اجازه حذف کسب و کار خود را ندارید. با پشتیبانی تماس بگیرید.');
                    else{
                        alert('خطا در پاک کردن');
                        console.log(res);
                    }
                },
                error: err =>{
                    alert('خطا در پاک کردن');
                    console.log(err);
                }
            });
        }

    </script>

@endsection

