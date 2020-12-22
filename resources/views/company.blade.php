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
        .width-auto {
            width: auto;
        }
        .mg-lt-30per {
            margin-left: 30%;
        }
    </style>
@stop

@section('main')
    <center class="row">
        <div class="col-xs-12">
            <h3>شرکت</h3>
        </div>

        @if(count($company) == 0)
            <div class="col-xs-12">
                <h4 class="warning_color">شرکتی وجود ندارد</h4>
            </div>
        @else
            <form method="post" action="{{URL('deleteCompany')}}">
                {{csrf_field()}}
                @foreach($company as $it)
                    <div class="col-xs-12">
                        <span>
                            {{$it->name}}
                        </span>
                        <button name="deleteCompany" value="{{$it->id}}" class="btn btn-danger width-auto" data-toggle="tooltip" title="حذف شرکت">
                            <span class="glyphicon glyphicon-remove mg-lt-30per"></span>
                        </button>
                    </div>
                @endforeach
            </form>
        @endif

        @if($mode2 == "add")
            <form method="post" action="{{URL('addCompany')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="col-xs-12">
                    <label>
                        <span>نام شرکت</span>
                        <input type="text" name="name" maxlength="40" required autofocus>
                    </label>
                </div>
                <div class="col-xs-12">
                    <p class="warning_color">{{$msg}}</p>
                    <input type="submit" name="addCom" value="اضافه کن" class="btn btn-primary width-auto mg-lt-30per">
                </div>
            </form>
        @endif
    </center>
@stop