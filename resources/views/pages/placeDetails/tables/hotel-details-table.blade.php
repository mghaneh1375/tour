<?php
        if(isset($place->kind_id))
            switch ($place->kind_id){
                    case 1:
                        $placeKindName = 'هتل';
                        break;
                    case 2:
                        $placeKindName = 'هتل آپارتمان';
                        break;
                    case 3:
                        $placeKindName = 'مهمان‌سرا';
                        break;
                    case 4:
                        $placeKindName = 'ویلا';
                        break;
                    case 5:
                        $placeKindName = 'متل';
                        break;
                    case 6:
                        $placeKindName = 'مجتمع تفریحی';
                        break;
                    case 7:
                        $placeKindName = 'پانسیون';
                        break;
                    case 8:
                        $placeKindName = 'بوم گردی';
                        break;
                    }

        $hotelRate = ['', 'یک ستاره', 'دو ستاره', 'سه ستاره', 'چهار ستاره', 'پنج ستاره'];
?>


@if(isset($place->kind_id) && $place->kind_id == 1)
    <div class="descriptionSections">
        <div class="titleSection">
            <span class="titleSectionSpan">
                {{__('درجه')}}
                {{$placeKindName}}
            </span>
        </div>
        <div class="contentSection col-xs-3">
            {{$hotelRate[$place->rate_int]}}
            {{$place->momtaz == 1 ? __('ممتاز') : ''}}
        </div>
    </div>
@endif

@foreach($features as $item)
    <?php
        $colWidth = '100%';
        if($item->name == 'محدوده قرار گیری' || $item->name == 'موقعیت ترافیکی' || $item->name == 'معماری' || $item->name == 'امکانات غذایی هتل')
            $colWidth = '49%';
    ?>
    <div class="descriptionSections" style="width: {{$colWidth}}">
        <div class="titleSection">
            <span class="titleSectionSpan"> {{$item->name}} </span>
        </div>
        @foreach($item->subFeat as $item2)
            @if(in_array($item2->id, $place->features))
                <div class="contentSection col-xs-4">{{$item2->name}}</div>
            @endif
        @endforeach
    </div>
@endforeach


<script>
    var checkFeatures = $('.descriptionSections');
    for(var i = 0; i < checkFeatures.length; i++){
        if(checkFeatures[i].children.length < 2)
            checkFeatures[i].remove();
    }
</script>
