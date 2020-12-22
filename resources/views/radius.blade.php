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
            <h3>تعیین شعاع نزدیک ترین اماکن</h3>
        </div>
        <form method="post" action="{{URL('determineRadius')}}">
            {{csrf_field()}}
            <div class="col-xs-12">
                <label>
                    <span>اندازه ی شعاع مورد نظر</span>
                    <input type="number" min="0" max="1000" name="radius" value="{{$radius}}">
                </label>
            </div>
            <div class="col-xs-12">
                <input type="submit" value="تایید" class="btn btn-primary" name="saveChange">
            </div>
        </form>
    </center>
@stop