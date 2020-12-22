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
    </style>
@stop

@section('main')
    <center class="row">
        <div class="col-xs-12">
            <h3>بخش</h3>
        </div>
        @if(count($section) == 0)
            <div class="col-xs-12">
                <h4 class="warning_color">بخش وجود ندارد</h4>
            </div>
        @else
            <form method="post" action="{{URL('deleteSection')}}">
                {{csrf_field()}}
                @foreach($section as $it)
                    <div class="col-xs-12">
                        <span>
                            {{$it->name}}
                        </span>
                        <button name="deleteSection" value="{{$it->id}}" class="btn btn-danger" data-toggle="tooltip" title="حذف بخش" style="width: auto">
                            <span class="glyphicon glyphicon-remove" style="margin-left: 30%"></span>
                        </button>
                    </div>
                @endforeach
            </form>
        @endif

        @if($mode2 == "add")
            <form method="post" action="{{URL('addSection')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="col-xs-12">
                    <label>
                        <span>نام بخش</span>
                        <input type="text" name="name" maxlength="40" required autofocus>
                    </label>
                </div>
                <div class="col-xs-12">
                    <p class="warning_color">{{$msg}}</p>
                    <input type="submit" name="addCom" value="اضافه کن" class="btn btn-primary" style="width: auto; margin-top: 10px">
                </div>
            </form>
        @endif
    </center>
@stop