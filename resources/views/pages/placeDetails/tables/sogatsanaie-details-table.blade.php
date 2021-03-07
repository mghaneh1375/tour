<style>
    .centeredTitle{
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        margin-bottom: 10px;
    }
    .centeredTitle .title{
        color: var(--koochita-blue);
        z-index: 2;
        background: white;
        padding: 0px 10px;
        font-size: 22px !important;
        font-weight: normal;
    }
    .centeredTitle .line{
        position: absolute;
        height: 1px;
        background: #4dc7bc52;
        width: 100%;
        z-index: 1;
    }
</style>
<div id="goToMapSection" class="row hideOnScreen">
    <div class="seperatorSections"></div>
    <div class="sogatSanieMobileFeatures">
        <div class="centeredTitle">
            <h3 class="title">ویژگی ها</h3>
            <div class="line"></div>
        </div>
        @if($place->eatable == 0)
            <div class="featureBox">
                <div class="title"> سبک </div>
                <div class="value">
                    <div class="val">{{$place->style}}</div>
                    <div class="val">{{$place->fragile}}</div>
                </div>
            </div>
            <div class="featureBox">
                <div class="title"> جنس </div>
                <div class="value">
                    @if($place->material != null)
                        <div class="val">{{$place->material}}</div>
                    @endif
                </div>
            </div>
            <div class="featureBox">
                <div class="title"> نوع </div>
                <div class="value">
                    @foreach($place->kind as $kind)
                        <div class="val">{{$kind}}</div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="featureBox">
                <div class="title"> مزه </div>
                <div class="value">
                    @foreach($place->taste as $test)
                        <div class="val">{{$test}}</div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<div class="row hideOnPhone" style="font-size: 15px; width: 100%; margin: 0;">

    @if($place->eatable == 0)
        <div class="descriptionSections">
            <div class="titleSection">
                <span class="titleSectionSpan">
                    {{__('سبک :')}}
                </span>
            </div>
            <div class="contentSection col-xs-4">{{$place->style}}</div>
            <div class="contentSection col-xs-4">{{$place->fragile}}</div>
        </div>
    @else
        <div class="descriptionSections">
            <div class="titleSection">
                <span class="titleSectionSpan">
                    {{__('مزه :')}}
                </span>
            </div>
            @foreach($place->taste as $test)
                <div class="contentSection col-xs-3">{{$test}}</div>
            @endforeach
        </div>
    @endif


    <div class="descriptionSections">
        <div class="titleSection">
            <span class="titleSectionSpan">
                {{__('ابعاد :')}}
            </span>
        </div>
        <div class="contentSection col-xs-3">{{$place->size}}</div>
    </div>
    <div class="descriptionSections">
        <div class="titleSection">
            <span class="titleSectionSpan">
                {{__('وزن :')}}
            </span>
        </div>
        <div class="contentSection col-xs-3">{{$place->weight}}</div>
    </div>
    <div class="descriptionSections">
        <div class="titleSection">
            <span class="titleSectionSpan">
                {{__('کلاس قیمتی :')}}
            </span>
        </div>
        <div class="contentSection col-xs-3">{{$place->price}}</div>
    </div>

    @if($place->eatable == 0)
        <div class="descriptionSections">
            <div class="titleSection">
                <span class="titleSectionSpan">
                    {{__('نوع :')}}
                </span>
            </div>
            @foreach($place->kind as $kind)
                <div class="contentSection col-xs-3">{{$kind}}</div>
            @endforeach
        </div>
        <div class="descriptionSections">
            <div class="titleSection">
                <span class="titleSectionSpan">
                    {{__('جنس :')}}
                </span>
            </div>
            @if($place->material != null)
                <div class="contentSection col-xs-3">{{$place->material}}</div>
            @endif
        </div>
    @endif
</div>

<script>
    var checkFeatures = $('.descriptionSections');
    for(var i = 0; i < checkFeatures.length; i++){
        if(checkFeatures[i].children.length < 2)
            checkFeatures[i].remove();
    }
</script>
