
<div id="topPlacesSection22" class="mainSuggestionMainDiv cpBorderBottom ng-scope" style="display: none;">
    <div id="##id##" class="topPlacesDivInCity">
        <div class="topPlacesDivInCityHeader">
            <img class="nagLogoRowSuggestion hideOnPhone" src="{{URL::asset('images/icons/iconneg.svg')}}" alt="koochita" loading="lazy">
            <img class="nagLogoRowSuggestion hideOnScreen" src="{{URL::asset('images/icons/iconnegBlack.svg')}}" alt="koochita" loading="lazy">
            <a href="##url##">
                <div class="shelf_title_container h3">
                    <h3>##name##</h3>
                </div>
            </a>
        </div>
        <div class="swiper-container mainSuggestion" style="padding-top: 15px; background: inherit;">
            <div id="##id##Content" class="swiper-wrapper thisfirsPlaceHolder" style="position: relative;"></div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</div>

<script>
    let topPlacesSample = 0;
    let rowSectionInfos;

    createSuggestionPackPlaceHolderClassName('thisfirsPlaceHolder');

    topPlacesSample = $('#topPlacesSection22').html();
    $('#topPlacesSection22').html('');

    function initPlaceRowSection(_headers){
        rowSectionInfos = _headers;
        createTopPlacesSection();
    }

    function createTopPlacesSection(){
        rowSectionInfos.forEach(item => {
            let text = topPlacesSample;
            let fk = Object.keys(item);
            for (let x of fk) {
                let re = new RegExp(`##${x}##`, "g");
                text = text.replace(re, item[x]);
            }
            $('#topPlacesSection22').append(text);
        });
        $('#topPlacesSection22').show();
    }

</script>