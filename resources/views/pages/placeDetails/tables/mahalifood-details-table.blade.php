<div class="descriptionSections">

    <div class="row">
        <div class="col-xs-6" style="float: right">
            <div class="titleSection">
                <div class="titlesPlaceDetail">
                    <span class="titleSectionSpan">
                        نوع غذا
                    </span>
                </div>
            </div>
            <div class="contentSection">{{$place->kindName}}</div>
        </div>
        <div class="col-xs-6" style="float: right">
            <div class="titleSection">
                <div class="titlesPlaceDetail">
                    <span class="titleSectionSpan">
                        نوع سرو
                    </span>
                </div>
            </div>
            <div class="contentSection">{{$place->hotOrCold}}</div>
        </div>
    </div>

    <div class="titleSection">
        <div class="titlesPlaceDetail">
            <span class="titleSectionSpan">
                مناسب برای
            </span>
        </div>
    </div>
    <div class="contentSection col-xs-12">افراد گیاه خوار
        <span style=" color: {{$place->vegetarian == 1 ? 'green' : 'red'}};">
        {{$place->vegetarian == 1 ? 'هست' : 'نیست'}}
    </span>
    </div>
    <div class="contentSection col-xs-12">افراد وگان
        <span style=" color: {{$place->vegan == 1 ? 'green' : 'red'}};">
        {{$place->vegan == 1 ? 'هست' : 'نیست'}}
    </span>
    </div>
    <div class="contentSection col-xs-12">افراد دیابتی
        <span style=" color: {{$place->diabet == 1 ? 'green' : 'red'}};">
            {{$place->diabet == 1 ? 'هست' : 'نیست'}}
        </span>
    </div>

    <div class="titleSection">
        <div class="titlesPlaceDetail">
            <span class="titleSectionSpan">
                کالری
            </span>
        </div>
    </div>
    <div class="contentSection col-xs-12">
        <span style="float: right"> : {{$place->name}} </span>
        <span style="float: right"> {{$place->energy}} </span>
        <span style="float: right"> کالری در هر</span>
        <span style="float: right"> {{$place->volume}} </span>
        <span style="float: right"> {{$place->source}} </span>
    </div>
    @if($place->rice == 1)
        <div class="contentSection col-xs-12">
            برنج: 20 کالری در 1 قاشق غذاخوری
        </div>
    @endif
    @if($place->bread == 1)
            <div class="contentSection col-xs-12">
                نان: 40 کالری به اندازه ی هر کف دست
            </div>
        @endif

</div>

