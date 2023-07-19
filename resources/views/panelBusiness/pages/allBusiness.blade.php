@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>عنوان</title>
@endsection


@section('body')
    <div class="row">
        <div class="col-md-6">

            <div class="mainBackWhiteBody">
                <div class="head">قراردادها</div>
                <div>
                    <p>نوع کسب و کار خود را انتخاب کنید</p>
                    @foreach($contracts as $contract)
                        <a href="{{route('businessPanel.contract', ['contract' => $contract->id])}}" class="btn btn-primary">{{$contract->type}}</a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection

