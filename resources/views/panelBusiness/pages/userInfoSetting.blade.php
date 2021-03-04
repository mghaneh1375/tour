@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>تکمیل اطلاعات فردی</title>
    <link rel="stylesheet" href="{{URL::asset('css/theme2/bootstrap-datepicker.css?v=1')}}">

@endsection


@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="mainBackWhiteBody">
                <div class="head">تکمیل اطلاعات فردی</div>
                <div class="mt-2">
                    <div class="descriptions mt-2">شما برای شروع فعالیت در سامانه کسب و کار کوچیتا ابتدا باید اطلاعات فردی خود را تکمیل کنید.</div>
                    <div class="row mt-4 col-xs-12 col-md-6">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstName">نام</label>
                                <input type="text" id="firstName" class="form-control" value="{{$userInfo->first_name}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lastName">نام خانوادگی</label>
                                <input type="text" id="lastName" class="form-control" value="{{$userInfo->last_name}}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="foreign">من تبعه نیستم</label>
                                @if($userInfo->isForeign)
                                    <input type="checkbox" id="foreign">
                                @else
                                    <input type="checkbox" checked id="foreign">
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label id="nidLabel" for="codeMeli">شماره ملی</label>
                                <input type="text" id="nid" onkeypress="justNum(event)" class="form-control" value="{{$userInfo->codeMeli}}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="birthDay">تاریخ تولد</label>
                                <input style="direction: ltr; text-align: left" type="text" onkeydown="validateDate(event, 'birthDay')" id="birthDay" placeholder="____ / __ / __" class="form-control" value="{{$userInfo->birthday}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">شماره تماس</label>
                                <input type="tel" id="phone" onkeypress="justNum(event)" class="form-control" placeholder="09xxxxxxxxx" value="{{$userInfo->phone}}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mail">ایمیل</label>
                                <input type="email" id="mail" class="form-control" placeholder="info@example.com" value="{{$userInfo->email}}">
                            </div>
                        </div>

                    </div>

                    <div class="descriptions danger mt-2">در صورتی که شماره تماس وارد شده جدید باشد، یک کد تایید برای شما ارسال خواهد شد.</div>
                </div>

                <div class="buttonGroupBottom">
                    <button onclick="editInfo()" class="btn btn-success">ادامه</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')

    <script>

        function editInfo() {

            var firstName = $("#firstName").val();
            var lastName = $("#lastName").val();
            var nid = $("#nid").val();
            var phone = $("#phone").val();
            var birthDay = $("#birthDay").val();
            var email = $("#mail").val();


            if(firstName.length == 0 || lastName.length == 0 || nid.length == 0 ||
                phone.length == 0 || birthDay.length == 0 || email.length == 0
            ) {
                showSuccessNotifiBP("لطفا تمام اطلاعات لازم را پر نمایید.", 'right', '#ac0020');
                return;
            }

            var isForeign = ($("#foreign").prop("checked")) ? "false" : "true";
            openLoading();

            $.ajax({
                type: 'post',
                url: '{{route('businessPanel.editUserInfo')}}',
                data: {
                    'firstName': firstName,
                    'lastName': lastName,
                    'birthDay': birthDay.replace(/\s/g, ''),
                    'phone': phone,
                    'nid': nid,
                    'isForeign': isForeign,
                    "email": email
                },
                success: function (res) {

                    closeLoading();

                    if(res.status == "ok") {
                        document.location.href = "{{route('businessPanel.mainPage')}}";
                        return;
                    }

                    showSuccessNotifiBP(res.msg, 'right', '#ac0020');
                },
                error: function (reject) {
                    errorAjax(reject);
                }
            });
        }

        $(document).ready(function () {

            $("#foreign").on("change", function () {

                if($(this).prop("checked"))
                    $("#nidLabel").text("شماره ملی");
                else
                    $("#nidLabel").text("شماره پاسپورت");
            });

        });

    </script>

@endsection
