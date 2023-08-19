@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>کسب و کارهای من</title>
    <style>
        td {
            padding: 7px;
            min-width: 150px;
        }

        .msgLast {
            min-width: auto;
        }
    </style>
@endsection


@section('body')
    <div class="row">
        <div class="col-md-12">

            <div class="mainBackWhiteBody">
                <div class="head">کسب و کارهای من</div>

                @if (count($businesses) == 0)
                    <div class="row">
                        <div class="col-md-3">
                            <img style="max-width: 100%" src="{{ URL::asset('images/icons/newsrv0102.png') }}" alt="">
                        </div>
                        <div class="col-md-7">
                            <p>هیچ کسب و کاری موجود نیست. اولین کسب و کار خود را در کوچیتا <a
                                    style="cursor: pointer !important;"href="{{ route('businessPanel.create') }}">ایجاد</a>
                                کنید.
                                اگر در ایجاد کسب و کار مشکلی دارید از قسمت <a style="cursor: pointer !important;"
                                    href=" {{ route('ticket.page') }}">پشتیبانی</a>
                                مشکل خود را با ما درمیان بگذارید.
                            </p>
                        </div>
                    </div>
                @else
                    <center>
                        <table class="table table-striped">
                            <tr style="background: #D4D4D4">
                                <th>ردیف</th>
                                <th>عملیات</th>
                                <th>نام کسب و کار</th>
                                <th>نوع کسب و کار</th>
                                <th>وضعیت</th>
                                <th>تاریخ ایجاد</th>

                            </tr>

                            <?php $i = 1; ?>
                            @foreach ($businesses as $business)
                                <tr id="tr_{{ $business->id }}">
                                    <td>{{ $i }}</td>
                                    @if ($business->readyForCheck)
                                        <td> در حال بررسی </td>
                                        <td>{{ $business->name }}</td>
                                        <td>{{ $business->type }}</td>
                                        <td>در حال بررسی</td>
                                    @elseif($business->finalStatus)
                                        <td>
                                            <a href="{{ route('businessManagement.panel', ['business' => $business->id]) }}"
                                                class="btn btnSuccess" style="font-size: 10px;">رفتن به پنل مدیریت</a>
                                        </td>
                                        <td>{{ $business->name }}</td>
                                        <td>{{ $business->type }}</td>
                                        <td>تایید شده</td>
                                    @elseif(!$business->problem)
                                        <td>
                                            <a href="{{ route('businessPanel.edit', ['business' => $business]) }}"
                                                title="ویرایش اطلاعات" class="btn btn-primary circleButton">
                                                <i class="fa-solid fa-file-pen"></i>
                                            </a>
                                            <a class="btn btn-danger circleButton"
                                                onclick="deleteBusiness('{{ $business->id }}')" title="حذف">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                        <td>{{ $business->name }}</td>
                                        <td>{{ $business->type }}</td>
                                        <td>در حال ویرایش/تکمیل توسط کاربر</td>
                                    @elseif($business->problem)
                                        <td>
                                            <a href="{{ route('businessPanel.edit', ['business' => $business]) }}"
                                                class="btn btnError" style="font-size: 10px;">تکمیل اطلاعات </a>
                                            <a class="btn btn-danger circleButton"
                                                onclick="deleteBusiness('{{ $business->id }}')" title="حذف">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                        <td>{{ $business->name }}</td>
                                        <td>{{ $business->type }}</td>
                                        <td>اعلام نقص شده</td>
                                    @endif


                                    <td>{{ $business->createBusinessDate }}</td>
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
                url: `{{ url('deleteBusiness') }}/${id}`,
                complete: closeLoading,
                success: res => {
                    if (res.status === "ok")
                        $(`#tr_${id}`).remove();
                    else if (res.status === "notAccess")
                        alert('شما اجازه حذف کسب و کار خود را ندارید. با پشتیبانی تماس بگیرید.');
                    else {
                        alert('خطا در پاک کردن');
                    }
                },
                error: err => {
                    alert('خطا در پاک کردن');
                }
            });
        }
    </script>

@endsection
