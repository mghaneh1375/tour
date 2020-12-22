
<div class="descriptionSections">
    <div class="titleSection">
    <span class="titleSectionSpan">
        تعداد اتاق
    </span>
    </div>
    <div class="contentSection col-xs-3" style="direction: rtl;">
        <span>
            {{$place->room_num}}
        </span>
        <span>
            {{__('واحد')}}
        </span>
    </div>
</div>

@foreach($features as $item)
    <div class="descriptionSections">
        <div class="titleSection">
            <span class="titleSectionSpan">
                {{$item->name}}
            </span>
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