@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>کسب و کارهای من</title>
    <style>
        td {
            padding: 7px;
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
                        <table>
                            <tr>
                                <td><center>ردیف</center></td>
                                <td><center>نام کسب و کار</center></td>
                                <td><center>نوع کسب و کار</center></td>
                                <td><center>تاریخ ایجاد</center></td>
                                <td><center>وضعیت</center></td>
                                <td><center>عملیات</center></td>
                            </tr>
                            <?php $i = 1; ?>
                            @foreach($businesses as $business)
                                <tr id="tr_{{$business->id}}">
                                    <td><center>{{$i}}</center></td>
                                    <td><center>{{$business->name}}</center></td>
                                    <td><center>{{$business->type}}</center></td>
                                    <td><center>{{$business->created_at}}</center></td>
                                    @if(!$business->readyForCheck)
                                        <td><center>در حال ویرایش/تکمیل توسط کاربر</center></td>
                                        <td>
                                            <center>
                                                <a href="{{route('businessPanel.edit', ['business' => $business])}}" class="btn btn-info">رفتن برای تکمیل اطلاعات</a>
                                                <a class="btn btn-danger" onclick="deleteBusiness('{{$business->id}}')">حذف</a>
                                            </center>
                                        </td>
                                    @elseif($business->readyForCheck)
                                        <td><center>در حال بررسی</center></td>
                                        <td><center></center></td>
                                    @elseif($business->finalStatus)
                                        <td><center>تایید شده</center></td>
                                        <td>
                                            <center>
                                                <a href="{{route('businessManagement.panel')}}" class="btn btn-success">رفتن به پنل مدیریت</a>
                                                <a class="btn btn-danger" onclick="deleteBusiness('{{$business->id}}')">حذف</a>
                                            </center>
                                        </td>
                                    @else
                                        <td><center>اعلام نقص شده</center></td>
                                        <td>
                                            <center>
                                                <a href="{{route('businessPanel.edit', ['business' => $business])}}" class="btn btn-warning">رفتن برای اصلاح نواقص</a>
                                                <a class="btn btn-danger" onclick="deleteBusiness('{{$business->id}}')">حذف</a>
                                            </center>
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
            $.ajax({
                type: "delete",
                url: '{{url('deleteBusiness')}}' + "/" + id,
                success: function (res) {
                    if(res.status === "0")
                        $("#tr_" + id).remove();
                }
            });
        }

    </script>

@endsection

