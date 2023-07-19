<?php $mode = "profile"; $user = Auth::user(); ?>
@extends('layouts.bodyProfile')

@section('header')

    @parent
    <style>
        .left {
            float: left !important;
        }
    </style>

    <style>
        .infoFlyout .myLevel {
            text-align: right;
        }

        .infoFlyout .myLevel span {
            background: url('{{URL::asset('images') . '/profile.png'}}') no-repeat -9px -299px !important;
            width: 40px;
            height: 40px;
            line-height: 42px;
            display: inline-block;
            margin-left: 5px;
            text-align: center;
            float: right;
            font-weight: bold;
            font-size: 18px;
            color: #fff;
            background-size: 56px !important;
        }

        .modules-membercenter-level-progress .myBadge {
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            background: url('{{URL::asset('images') . '/profile.png'}}') no-repeat -13px -344px !important;
            background-size: 56px;
            font-weight: bold;
            font-size: 18px;
            color: #fff;
        }

    </style>
@stop

@section('main')

    <div id="MAIN" class="MemberProfile prodp13n_jfy_overflow_visible" style="height: 100vh">
        <div id="BODYCON" class="col easyClear poolB adjust_padding new_meta_chevron_v2">
            <div class="business_welcomeBox">سلام!! به پنل مدیریت کسب و کار کوچیتا خوش آمدید</div>
            <div class="business_mainBox">
                <div>
                    <div class="business_title">برای استفاده از مزایای پنل کسب و کار چند گام ساده در پیش رو دارید</div>
                    <a class="business_link">پنل کسب و کار چیست؟</a>
                </div>
                <div style="margin: 20px 25% 10px">
                    <div class="business_boxOfCheckBox">
                        <div style="display: inline-block">شخصیت حقوقی هستم</div>
                        <div class="business_checkBox">
                            <input onclick="filter()" id="1" type="checkbox">
                            <label for="1">
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="business_boxOfCheckBox" style="float: left">
                        <div style="display: inline-block">شخصیت حقیقی هستم</div>
                        <div class="business_checkBox">
                            <input onclick="filter()" id="2" type="checkbox">
                            <label for="2">
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="business_redNotice">شخصیت های حقوقی، شخصیت هایی مانند شرکت، تعاونی، موسسه و مانند آن می باشند که به صورت تجاری و یا غیر تجاری به ثبت رسیده و دارای شخصیتی جداگانه نسبت به افراد تشکیل دهنده آن می باشند. شخصیت های حقیقی شخصیت های فردی می باشند که اقدام به راه اندازی کسب  کار نموده است.</div>
            </div>
        </div>
    </div>

@stop
