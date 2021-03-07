<style>
    .drinkTableSection .materSection{
        display: flex;
        flex-wrap: wrap;
        direction: rtl;
        width: 100%;
    }
    .drinkTableSection .materSection .material{
        margin: 5px;
        font-size: 14px;
        border: solid 1px green;
        padding: 5px 10px;
        border-radius: 7px;
    }
    .drinkTableSection .fitFor{

    }
    .drinkTableSection .fitFor .contentSection{
        margin-left: 5px;
        padding: 5px 10px;
        border-radius: 6px;
        border: solid 1px lightgrey;
    }
    .drinkTableSection .overviewHistogram{
        width: 100% !important;
    }
    .wm0{
        width: 100%;
        margin: 0;
    }
    .brlMH{
        border-left: 1px solid #e5e5e5;
    }
    .brrMH{
        border-right: 1px solid #e5e5e5;
    }
    @media (max-width: 991px) {
        .brlMH{
            border-left: none;
        }
        .brrMH{
            border-right: none;
        }
        .drinkTableSection .materSection .material{
            font-size: 11px;
            padding: 5px 10px;
        }
    }
</style>

<div id="generalDescriptionMobile" class="row reviewsAndDetails generalDescription drinkTableSection">

    <div class="col-md-4 hideOnTablet">
        <div class="tabContent">
            <div class="rateOfPlaceMiddleContent">
                @include('pages.placeDetails.component.PlaceDetailRateSection')
            </div>
        </div>
    </div>

    <div class="col-md-8 brlMH">
        <div id="drinkRecipes" class="row wm0">
            <div class="col-md-6 brrMH">
                <div class="tabContent">
                    <div class="block_header">
                        <div class="titlesPlaceDetail">
                            <h3 class="block_title">طرز تهیه</h3>
                        </div>
                    </div>

                    <div id="introductionText" class="row wm0"> {!! $place->recipes !!} </div>
                </div>
            </div>
            <div class="col-md-6 brlMH">
                <div class="hideOnScreen" style="display: flex; justify-content: space-between; margin-top: 14px; text-align: center;">
                    <div class="foodKindMob" style="box-shadow: -2px 2px 4px 0px #333;">
                        <div class="title">نوع نوشیدنی</div>
                        <div class="val">{{$place->categoryName ?? ''}}</div>
                    </div>
                    <div class="foodKindMob">
                        <div class="title">نوع سرو</div>
                        <div class="val">{{isset($place->isHot) ? ($place->isHot == 1 ? 'گرم' : 'سرد') : ''}}</div>
                    </div>
                </div>
                <div id="materialNeededSection" class="tabContent">
                    <div class="block_header">
                        <div class="titlesPlaceDetail">
                            <h3 class="block_title">مواد لازم</h3>
                        </div>
                    </div>

                    <div class="row wm0 materSection">
                        @if(isset($place->material))
                            @foreach($place->material as $key => $item)
                               <div class="material">{{$item->name}}</div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row wm0 hideOnPhone">
            <div class="col-md-12">
                <div class="tabContent">
                    <div class="block_header">
                        <div class="titlesPlaceDetail">
                            <h3 class="block_title">مناسب برای</h3>
                        </div>
                    </div>
                    <div class="fitFor">
                        @foreach($place->goodFor as $goodFor)
                            <div class="contentSection">{{$goodFor}}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
