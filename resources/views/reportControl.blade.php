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
        td {
            padding: 10px;
            max-width: 300px;
            border: 2px solid black;
        }

        .pageNum {
            display: block;
            float: left;
            padding: 0 12px;
            margin: 0 10px;
            line-height: 30px;
            border-radius: 3px;
            font-size: 14px;
            font-weight: bold;
            color: #00AF87;
        }
        .pageNumbers {
            display: inline-block;
            padding-top: 2px;
            text-align: center;
        }
        .current {
            line-height: 30px;
            text-align: center;
            color: #fff;
            background-color: #00AF87;
            border-color: #00AF87;
            font-size: 1.0835em;
            cursor: default;
        }
        .pagination {
            border: none !important;
        }
    </style>
@stop

@section('main')
    <center class="row">
        @if(count($logs) == 0)
            <div class="col-xs-12">
                <h4 class="warning_color">فعالیتی وجود ندارد</h4>
            </div>
        @else
            <div class="col-xs-12" style="padding: 20px">
                <table>
                    <tr>
                        <td>نام کاربری گزارش دهنده</td>
                        <td>نام کاربری صاحب محتوا</td>
                        <td>نوع مکان</td>
                        <td>نام مکان</td>
                        <td>تاریخ گزارش</td>
                        <td>تاریخ بارگذاری</td>
                        <td>توضیحات گزارش</td>
                        <td>توضیحات محتوا</td>
                        <td>redirect</td>
                        <td>
                            <p>
                                <span>انتخاب همه</span><input type="checkbox" data-val="select" onclick="checkAll(this)">
                            </p>
                        </td>
                    </tr>
                    @foreach($logs as $log)
                        <tr>
                            <td>{{$log->visitorId}}</td>
                            <td>{{$log->writer}}</td>
                            <td>{{$log->kindPlaceId}}</td>
                            <td>{{$log->name}}</td>
                            <td>{{$log->date}}</td>
                            <td>{{$log->publishDate}}</td>
                            <td>{{$log->text}}</td>
                            <td>
                                @if($log->activityName != "عکس")
                                    <span>محتوا: </span><span>{{$log->descText}}</span><span> - </span>
                                @else
                                    <span><img width="100px" height="100px" src="{{$log->userPic}}"></span>
                                @endif
                            </td>

                            <td>
                                @if($log->activityName == "نظر")
                                    <a href="{{$log->redirect}}">بپر به نقد</a>
                                @endif
                            </td>

                            <td>
                                <input value="{{$log->id}}" type="checkbox" name="checkedLogs[]">
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <div class="col-xs-12" style="padding: 10px">
                <button onclick="deleteLogs()" class="btn btn-danger">حذف</button>
            </div>

            <div class="deckTools btm">
                <div class="unified pagination js_pageLinks">

                    <?php
                    $limit = ceil($total / 10);
                    $passPage = false;
                    ?>

                    @if($currPage != $limit)
                        <button value="{{$currPage + 1}}" name="pageNum" class="nav next rndBtn ui_button primary taLnk" style="float: right !important; background-color: var(--koochita-light-green) !important; border-color: var(--koochita-light-green) !important;">بعدی</button>
                    @endif
                    @if($currPage != 1)
                        <button value="{{$currPage - 1}}" name="pageNum" class="nav next rndBtn ui_button primary taLnk prePage" style="float: left !important;">قبلی</button>
                    @endif

                    <div class="pageNumbers">
                        @for($i = 1; $i <= $limit; $i++)
                            @if(abs($currPage - $i) < 4 || $i == 1 || $i == $limit)
                                @if($i == $currPage)
                                    <span class="pageNum current" style="background-color: var(--koochita-light-green) !important; float: left;">{{$i}}</span>
                                @else
                                    <button value="{{$i}}" name="pageNum" onclick="document.location.href = '{{route('getReports2', ['page' => $i])}}'" class="pageNum taLnk" style="float: left; background-color: transparent; border: none">{{$i}}</button>
                                @endif
                            @elseif($i < $currPage)
                                <span class='separator'>&hellip;</span>
                            @elseif($i > $currPage && !$passPage)
                                <?php
                                $passPage = true;
                                ?>
                                <span class='separator'>&hellip;</span>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
        @endif
    </center>

    <script>
        var selfUrl = '{{route('getReports', ['page' => $currPage])}}';
        {{--var deleteLogsDir = '{{route('deleteLogs')}}';--}}
    </script>
    <script>

        function checkAll(val) {

            if($(val).attr('data-val') == 'select') {
                $(":checkbox[name='checkedLogs[]']").prop('checked', true);
                $(val).attr('data-val', 'unSelect');
            }
            else {
                $("input[name='checkedLogs[]']").prop('checked', false);
                $(val).attr('data-val', 'select');
            }

        }

        function submitLogs() {

            var checkedValues = $("input:checkbox[name='checkedLogs[]']:checked").map(function() {
                return this.value;
            }).get();

            if(checkedValues.length == 0)
                return;

            $.ajax({
                type: 'post',
                url: submitLogsDir,
                data: {
                    'logs': checkedValues
                },
                success: function (response) {
                    if(response == "ok") {
                        document.location.href = selfUrl;
                    }
                }
            });
        }

        function deleteLogs() {

            var checkedValues = $("input:checkbox[name='checkedLogs[]']:checked").map(function() {
                return this.value;
            }).get();

            if(checkedValues.length == 0)
                return;

            $.ajax({
                type: 'post',
                url: deleteLogsDir,
                data: {
                    'logs': checkedValues
                },
                success: function (response) {
                    if(response == "ok") {
                        document.location.href = selfUrl;
                    }
                }
            });
        }
    </script>
@stop