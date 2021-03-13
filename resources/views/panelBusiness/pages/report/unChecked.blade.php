@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>عنوان</title>
    <style>
        td {
            padding: 5px;
        }

        thead th{
            font-size: 11px;
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
                        <table class="table table-striped">
                            <thead style="background: var(--koochita-yellow);">
                                <tr>
                                    <th>ردیف</th>
                                    <th>نام کسب و کار</th>
                                    <th>نوع کسب و کار</th>
                                    <th>نام درخواست دهنده</th>
                                    <th>نام کاربری درخواست دهنده</th>
                                    <th>شماره همراه درخواست دهنده</th>
                                    <th>تاریخ ثبت مدارک</th>
                                    <th>تاریخ تکمیل/اصلاح مدارک</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($requests as $request)
                                <tr style="cursor: pointer" onclick="document.location.href = '{{route('businessPanel.getSpecificUnChecked', ['business' => $request->id])}}'">
                                    <td>{{$i}}</td>
                                    <td>{{$request->name}}</td>
                                    <td>{{$request->type}}</td>
                                    <td>{{$request->user->first_name . ' ' . $request->user->last_name}}</td>
                                    <td>{{$request->user->username}}</td>
                                    <td>{{$request->user->phone}}</td>
                                    <td>{{$request->createBusinessDate}}</td>
                                    <td>{{$request->updateBusinessDate}}</td>
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection

