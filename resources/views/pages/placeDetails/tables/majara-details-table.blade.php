
@foreach($features as $item)
    <div class="descriptionSections">
        <div class="titleSection">
            <span class="titleSectionSpan">
                {{$item->name}}
            </span>
        </div>
        <div class="row">
            @foreach($item->subFeat as $item2)
                @if(in_array($item2->id, $place->features))
                    <div class="contentSection col-xs-4 ">{{$item2->name}}</div>
                @endif
            @endforeach
        </div>
    </div>
@endforeach

<script>
    var checkFeatures = $('.descriptionSections');
    for(var i = 0; i < checkFeatures.length; i++){
        if(checkFeatures[i].children.length < 2)
            checkFeatures[i].remove();
    }
</script>