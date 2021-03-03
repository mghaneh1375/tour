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
                <div class="head">درخواست های تعیین تکلیف نشده</div>
                @if(count($requests) == 0)
                    <p>درخواستی موجود نیست</p>
                @else
                    <div>
                        <table>
                            <tr>
                                <td>ردیف</td>
                                <td>نام کسب و کار</td>
                                <td>نوع کسب و کار</td>
                                <td>نام درخواست دهنده</td>
                                <td>نام کاربری درخواست دهنده</td>
                                <td>شماره همراه درخواست دهنده</td>
                                <td>تاریخ ثبت مدارک</td>
                                <td>تاریخ تکمیل/اصلاح مدارک</td>
                            </tr>
                            <?php $i = 1; ?>
                            @foreach($requests as $request)
                                <tr style="cursor: pointer" onclick="document.location.href = '{{route('businessPanel.getSpecificUnChecked', ['business' => $request->id])}}'">
                                    <td><center>{{$i}}</center></td>
                                    <td><center>{{$request->name}}</center></td>
                                    <td><center>{{$request->type}}</center></td>
                                    <td><center>{{$request->user->first_name . ' ' . $request->user->last_name}}</center></td>
                                    <td><center>{{$request->user->username}}</center></td>
                                    <td><center>{{$request->user->phone}}</center></td>
                                    <td><center>{{$request->created_at}}</center></td>
                                    <td><center>{{$request->updated_at}}</center></td>
                                </tr>
                                <?php $i++; ?>
                            @endforeach

                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection

