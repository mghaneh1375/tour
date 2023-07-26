@extends('layouts.structure')

@section('header')
    @parent
@stop

@section('content')

    <div class="col-md-1"></div>

    <div class="col-md-10">
        <div class="sparkline8-list shadow-reset mg-tb-30">

            <div class="sparkline8-hd">
                <div class="main-sparkline8-hd">
                    <h1>
                        <span>نوتیفیکیشن ها</span>
                    </h1>
                </div>
            </div>

            <div class="sparkline8-graph dashone-comment messages-scrollbar dashtwo-messages">

                <center class="row">

                    <div style="direction: rtl" class="col-xs-12">
                        <table>

                            @foreach($notifications as $notification)
                                <tr>
                                    <td>{{$notification->msg}}</td>
                                    <td>{{$notification->created_at}}</td>
                                    <td><a target="_blank" href="{{url('user_asset') . '/' . $notification->user_asset_id}}">مشاهده جزئیات</a></td>
                                </tr>

                            @endforeach

                        </table>
                    </div>

                </center>

            </div>
        </div>
    </div>

    <div class="col-xs-1"></div>

@stop
