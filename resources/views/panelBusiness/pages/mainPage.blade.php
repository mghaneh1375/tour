@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>خانه</title>
@endsection


@section('body')
    <style>
        .mainPage {}

        .mainPage .headerTitle {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: solid 1px #cfcfcf;
        }

        .mainPage .cardsSection {
            display: flex;
            align-items: center;
        }

        .mainPage .cards {
            background: var(--koochita-light-green);
            color: black;
            height: 100px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin-left: 22px;
            padding: 0px 25px;
        }

        .mainPage .cards .icon {
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #ffffff;
            border-radius: 50%;
            font-size: 35px;
            margin-left: 15px;
        }

        .mainPage .cards .infoSec {}

        .mainPage .cards .infoSec .text {
            font-weight: bold;
            font-size: 20px;
        }

        .mainPage .cards .infoSec .numSec {
            margin-top: 5px;
        }

        .mainPage .cards .infoSec .numSec .num {
            width: 20px;
            height: 20px;
            background: red;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            color: white;
        }

        .mainPage .cards .infoSec .numSec .tex {
            font-size: 12px;
        }
    </style>
    <div class="row mainPage">
        <div class="col-md-12">
            @if ($newTicketCount > 0 || $newNotificationCount > 0)
                <div class="mainBackWhiteBody">
                    <div class="cardsSection">

                        @if ($newTicketCount != 0)
                            <a href="#" class="cards">
                                <div class="icon">
                                    <i class="fa-solid fa-headset"></i>
                                </div>
                                <div class="infoSec">
                                    <div class="text">پشتیبانی</div>
                                    <div class="numSec">
                                        <span class="num">{{ $newTicketCount }}</span>
                                        <span class="tex">پیام جدید</span>
                                    </div>
                                </div>
                            </a>
                        @endif

                        @if ($newNotificationCount != 0)
                            <a href="#" class="cards">
                                <div class="icon">
                                    <i class="fa-regular fa-bell-on"></i>
                                </div>
                                <div class="infoSec">
                                    <div class="text">اعلانات</div>
                                    <div class="numSec">
                                        <span class="num">{{ $newNotificationCount }}</span>
                                        <span class="tex">پیام جدید</span>
                                    </div>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>
            @endif


            <div class="mainBackWhiteBody" style="margin-top: 10px">
                <div class="headerTitle">کسب و کارهای من</div>
                <div class="cardsSection">
                    @if (count($myBusiness) == 0)
                        <div class="row">
                            <div class="col-md-3">
                                <img style="max-width: 100%" src="{{ URL::asset('images/icons/newsrv0102.png') }}"
                                    alt="">
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
                        @foreach ($myBusiness as $mb)
                            <a href="{{ $mb->url }}" class="cards">
                                <div class="icon">
                                    @if ($mb->type == 'agency')
                                        <i class="fa-light fa-plane-tail"></i>
                                    @endif
                                </div>
                                <div class="infoSec">
                                    <div class="text">{{ $mb->name }}</div>
                                    {{--                            <div class="numSec"> --}}
                                    {{--                                <span class="num">{{$newTicketCount}}</span> --}}
                                    {{--                                <span class="tex">پیام جدید</span> --}}
                                    {{--                            </div> --}}
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
