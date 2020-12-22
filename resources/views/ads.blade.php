<?php $mode = "setting" ?>
@extends('layouts.bodyProfile')

@section('header')
    @parent

    <style>
        .col-xs-12 {
            margin-top: 10px;
        }

        button {
            margin-right: 10px;
        }

        .row {
            direction: rtl;
        }

        .calendar2 {
             top: 113% !important;
             left: 27% !important;
         }
    </style>

    <style>
        .calendar2 {
            top: 113% !important;
            left: 27% !important;
        }
        .icon-circle-arrow-right {
            background-image: url('{{URL::asset('img/glyphicons-halflings.png')}}') !important;
            background-position: -240px -144px;
            background-repeat: no-repeat;
            display: inline-block;
            height: 14px;
            line-height: 14px;
            margin-top: 1px;
            vertical-align: text-top;
            width: 14px;
        }
        .icon-circle-arrow-left {
            background-image: url('{{URL::asset('img/glyphicons-halflings.png')}}') !important;
            background-position: -264px -144px;
            background-repeat: no-repeat;
            display: inline-block;
            height: 14px;
            line-height: 14px;
            margin-top: 1px;
            vertical-align: text-top;
            width: 14px;
        }
    </style>
@stop

@section('main')

    @include('layouts.pop-up-create-trip')

    <link rel="stylesheet" href="{{URL::asset('css/theme2/specific designs/profile.css?v=1')}}">

    <center class="row">
        <div class="col-xs-12">
            <h3>تبلیغات</h3>
        </div>

        @if($mode2 == "see")

            @if(count($ads) == 0)
                <div class="col-xs-12">
                    <h4 class="warning_color">تبلیغی وجود ندارد</h4>
                </div>
            @else
                <form method="post" action="{{route('deleteAd')}}">
                    {{csrf_field()}}
                    @foreach($ads as $ad)
                        <div class="col-xs-12">
                            <img width="100" height="100" src="{{URL::asset('ads') . '/' . $ad->pic}}">
                            <span>نام شرکت </span><span>{{$ad->companyId}}</span>
                            <span>محل قرارگیری </span> <span>{{$ad->sections}}</span>
                            <span> از {{$ad->from_}} تا {{$ad->to_}}</span>
                            <span> استان ها </span> <span>{{$ad->states}}</span>

                            <a href="{{route('editAd', ['adId' => $ad->id])}}" class="btn btn-info width-auto" data-toggle="tooltip" title="ویرایش تبلیغ">
                                <span class="glyphicon glyphicon-edit mg-lt-30per"></span>
                            </a>

                            <button name="adId" value="{{$ad->id}}" class="btn btn-danger width-auto" data-toggle="tooltip" title="حذف تبلیغ">
                                <span class="glyphicon glyphicon-remove mg-lt-30per"></span>
                            </button>
                        </div>
                    @endforeach
                </form>
            @endif

            <div class="col-xs-12">
                <a href="{{URL::route('addAds')}}">
                    <button class="btn btn btn-default" id="addNewAdsBtn" data-toggle="tooltip" title="اضافه کردن تبلیغ جدید">
                        <span class="glyphicon glyphicon-plus mg-lt-30per"></span>
                    </button>
                </a>
            </div>
        @elseif($mode2 == "add")
            <form method="post" action="{{URL::route('addAds')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="col-xs-12">
                    <label>
                        <span>نام شرکت</span>
                        <select name="companyId">
                            @foreach($companies as $company)
                                <option value="{{$company->id}}">{{$company->name}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="col-xs-12">
                    <label>
                        <span>استان های مورد نظر</span>
                        @foreach($states as $state)
                            <div>
                                <label for="state_{{$state->id}}">{{$state->name}}</label>
                                <input id="state_{{$state->id}}" type="checkbox" value="{{$state->id}}" name="states[]">
                            </div>
                        @endforeach
                    </label>
                </div>
                <div class="col-xs-12">
                    <label>
                        <span>صفحات مورد نظر</span>
                        @foreach($sections as $section)
                            <div>
                                <label for="section_{{$section->id}}">{{$section->name}}</label>
                                <input onchange="changeSection('{{$section->id}}')" id="section_{{$section->id}}" type="checkbox" value="{{$section->id}}" name="sections[]">
                                <span id="part_{{$section->id}}"></span>
                            </div>
                        @endforeach
                    </label>
                </div>
                <div class="col-xs-12">
                    <label>
                        <span>url</span>
                        <input type="text" name="url" required maxlength="300">
                    </label>
                </div>
                <div class="col-xs-12">
                    <label>
                        <span>تصویر</span>
                        <input type="file" name="pic" accept="image/png" required>
                    </label>
                </div>
                <div class="col-xs-12">
                    <div class="ui_column max-width-200">
                        <div id="date_btn_start_edit">تاریخ شروع</div>
                        <label class="editDateTripLabel">
                            <span onclick="editDateTrip()" class="ui_icon calendar editDateTripSpan"></span>
                            <input name="startDate" id="date_input_start_edit_2" placeholder="روز/ماه/سال" required readonly class="editDateTripInput" type="text">
                        </label>
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="ui_column max-width-200">
                        <div id="date_btn_end_edit">تاریخ اتمام</div>
                        <label class="editDateTripLabel">
                            <span onclick="editDateTripEnd()" class="ui_icon calendar editDateTripSpan"></span>
                            <input name="endDate" id="date_input_end_edit_2" placeholder="روز/ماه/سال" required readonly class="editDateTripInput" type="text">
                        </label>
                    </div>
                </div>

                <div class="col-xs-12">
                    <p class="warning_color">{{$msg}}</p>
                    <input type="submit" name="addPublicity" value="اضافه کن" class="btn btn-primary width-auto mg-tp-10">
                </div>
            </form>
        @else
            <form method="post" action="{{URL::route('editAd', ['adId' => $ad->id])}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="col-xs-12">
                    <label>
                        <span>نام شرکت</span>
                        <select name="companyId">
                            @foreach($companies as $company)
                                @if($ad->companyId == $company->id)
                                    <option selected value="{{$company->id}}">{{$company->name}}</option>
                                @else
                                    <option value="{{$company->id}}">{{$company->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="col-xs-12">
                    <label>
                        <span>استان های مورد نظر</span>
                        @foreach($states as $state)
                            <div>
                                <label for="state_{{$state->id}}">{{$state->name}}</label>
                                @if($state->select == 1)
                                    <input checked id="state_{{$state->id}}" type="checkbox" value="{{$state->id}}" name="states[]">
                                @else
                                    <input id="state_{{$state->id}}" type="checkbox" value="{{$state->id}}" name="states[]">
                                @endif
                            </div>
                        @endforeach
                    </label>
                </div>
                <div class="col-xs-12">
                    <label>
                        <span>صفحات مورد نظر</span>
                        @foreach($sections as $section)
                            <div>
                                <label for="section_{{$section->id}}">{{$section->name}}</label>
                                @if($section->select == 1)
                                    <input onchange="changeSection('{{$section->id}}')" checked id="section_{{$section->id}}" type="checkbox" value="{{$section->id}}" name="sections[]">
                                    <span id="part_{{$section->id}}">
                                        <input type="number" min="1" max="10" value="{{$section->part}}" name="parts[]">
                                    </span>
                                @else
                                    <input onchange="changeSection('{{$section->id}}')" id="section_{{$section->id}}" type="checkbox" value="{{$section->id}}" name="sections[]">
                                    <span id="part_{{$section->id}}"></span>
                                @endif
                            </div>
                        @endforeach
                    </label>
                </div>
                <div class="col-xs-12">
                    <label>
                        <span>url</span>
                        <input type="text" value="{{$ad->url}}" name="url" required maxlength="300">
                    </label>
                </div>

                <script>
                    $(document).ready(function() {
                        writeFileName('{{$ad->pic}}');
                    });

                    function writeFileName(val) {
                        $("#fileName").empty().append(val);
                    }
                </script>

                <div class="col-xs-12">
                    <label>
                        <input onchange="writeFileName(this.value)" id="photo" type="file" name="pic" class="display-none">
                        <label for="photo">
                            <div class="ui_button primary addPhotoBtn">تصویر </div>
                        </label>
                        <p id="fileName"></p>
                    </label>
                </div>
                <div class="col-xs-12">
                    <div class="ui_column max-width-200">
                        <div id="date_btn_start_edit">تاریخ شروع</div>
                        <label class="editDateTripLabel">
                            <span onclick="editDateTrip()" class="ui_icon calendar editDateTripSpan"></span>
                            <input value="{{convertStringToDate($ad->from_)}}" name="startDate" id="date_input_start_edit_2" placeholder="روز/ماه/سال" required readonly class="editDateTripInput" type="text">
                        </label>
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="ui_column max-width-200">
                        <div id="date_btn_end_edit">تاریخ اتمام</div>
                        <label class="editDateTripLabel">
                            <span onclick="editDateTripEnd()" class="ui_icon calendar editDateTripSpan"></span>
                            <input value="{{convertStringToDate($ad->to_)}}" name="endDate" id="date_input_end_edit_2" placeholder="روز/ماه/سال" required readonly class="editDateTripInput" type="text">
                        </label>
                    </div>
                </div>

                <div class="col-xs-12">
                    <p class="warning_color">{{$msg}}</p>
                    <input type="submit" name="addPublicity" value="ویرایش" class="btn btn-primary width-auto mg-tp-10">
                </div>
            </form>
        @endif
    </center>

    <script async src="{{URL::asset("js/bootstrap-datepicker.js")}}"></script>

    <link rel="stylesheet" href="{{URL::asset('css/theme2/bootstrap-datepicker.css?v=1')}}">


    <script>
        
        function changeSection(val) {
            if($("#section_" + val).prop('checked'))
                $("#part_" + val).empty().append('<input type="number" min="1" max="10" value="1" name="parts[]">');
            else
                $("#part_" + val).empty();
        }
        
        function editDateTrip() {

            $("#date_input_start_edit_2").datepicker({
                numberOfMonths: 2,
                showButtonPanel: true,
                minDate: 0,
                dateFormat: "yy/mm/dd"
            });
        }
        function editDateTripEnd() {

            $("#date_input_end_edit_2").datepicker({
                numberOfMonths: 2,
                showButtonPanel: true,
                minDate: 0,
                dateFormat: "yy/mm/dd"
            });
        }
    </script>
@stop