@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>تکمیل اطلاعات فردی</title>

    <style>

    </style>
@endsection


@section('body')
    <div class="row">
        <div class="col-md-6">
            <div class="mainBackWhiteBody">
                <div class="head">تکمیل اطلاعات فردی</div>
                <div class="mt-2">
                    <div class="descriptions mt-2">شما برای شروع فعالیت در سامانه کسب و کار کوچیتا ابتدا باید اطلاعات فردی خود را تکمیل کنید.</div>
                    <div class="row mt-4">

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
                                <label for="codeMeli">شماره ملی</label>
                                <input type="text" id="codeMeli" class="form-control" value="{{$userInfo->codeMeli}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="birthDay">تاریخ تولد</label>
                                <input type="text" id="birthDay" class="form-control" value="{{$userInfo->birthDay}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">شماره تماس</label>
                                <input type="text" id="phone" class="form-control" placeholder="09xxxxxxxxx" value="{{$userInfo->phone}}">
                            </div>
                        </div>
                    </div>

                    <div class="descriptions danger mt-2">در صورتی که شماره تماس وارد شده جدید باشد، یک کد تایید برای شما ارسال خواهد شد.</div>
                </div>

                <div class="buttonGroupBottom">
                    <button class="btn btn-success">ادامه</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')

    <script>


        // isNeedSideProgressBar(true);
        //
        // updateSideProgressBar(23);
    </script>

@endsection
