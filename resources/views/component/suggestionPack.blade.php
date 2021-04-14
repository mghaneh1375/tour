<style>

</style>
{{--suggestionPackBookMark--}}
<script>
    var suggestionPlacePackSample = `
        <div class="suggestionPackDiv">
            <div class="suggestionPackContent">
                <img alt="pin" src="{{URL::asset('images/pin.png')}}" class="imageGoldPin">
                <div class="suggestionPackMainBody" style="display: none">
                    <a href="##url##" class="suggestionPackPicLink">
                        <div class="suggestionPackBookMark BookMarkIconEmpty hideOnScreen"></div>
                        <div class="suggestionPackPicDiv">
                            <img src="##pic##" alt="##alt##" class="suggestionPackPic resizeImgClass" onload="loadSuggestionPack(this)" onerror="loadSuggestionPack(this, 'error')">
                        </div>
                    </a>
                    <div class="suggestionPackDetailDiv">
                        <a href="##url##" class="suggestionPackName lessShowText">##name##</a>
                        <div class="suggestionPackReviewRow" style="display: ##citySection##">
                            <span class="ui_bubble_rating bubble_##rate##0"></span>
                            <span class="suggestionPackReviewCount"> ##review## </span>
                            <span>نقد</span>
                        </div>
                        <div class="suggestionPackReviewRow" style="display: ##articleSetion##">
                            <span class="suggestionPackReviewCount"> ##review## </span>
                            <span>نقد</span>
                        </div>
                        <div class="suggestionPackCityRow" style="display: ##citySection##">
                            ##city##
                            <span> در</span>
                            <span>##state##</span>
                        </div>
                    </div>
                </div>

                <div class="suggestionPackMainBody suggestionPlaceHolderDiv">
                    <div class="suggestionPackPicLink">
                        <div class="placeHolderAnime"></div>
                    </div>
                    <div class="suggestionPackDetailDiv">
                        <div class="suggestionPackName placeHolderAnime resultLineAnim" style="width: 80%;"></div>
                        <div class="suggestionPackReviewRow placeHolderAnime resultLineAnim" style="width: 60%;"></div>
                        <div class="suggestionPackCityRow placeHolderAnime resultLineAnim" style="width: 40%;"></div>
                    </div>
                </div>
            </div>
        </div>
    `;
    var suggestionPlacePlaceHolderSample = `
        <div class="suggestionPackDiv" style="width: 250px">
            <div class="suggestionPackContent">
                <img alt="pin" src="{{URL::asset('images/pin.png')}}" class="imageGoldPin">
                <div class="suggestionPackMainBody suggestionPlaceHolderDiv">
                    <div class="suggestionPackPicLink">
                        <div class="placeHolderAnime"></div>
                    </div>
                    <div class="suggestionPackDetailDiv">
                        <div class="suggestionPackName placeHolderAnime resultLineAnim" style="width: 80%;"></div>
                        <div class="suggestionPackReviewRow placeHolderAnime resultLineAnim" style="width: 60%;"></div>
                        <div class="suggestionPackCityRow placeHolderAnime resultLineAnim" style="width: 40%;"></div>
                    </div>
                </div>
            </div>
        </div>
    `;
</script>
<script>
    function createSuggestionPack(_id, _data, _callback = '', _isClass = false){
        // _data = [{
        //     'name'  : '',
        //     'url': '',
        //     'pic': '',
        //     'alt': '',
        //     'rate': '',
        //     'review': '',
        //     'city': '',
        //     'state': '',
        // }];

        var res = '';
        _data.forEach(item => {
            var text = suggestionPlacePackSample;
            var fk = Object.keys(item);
            for (var x of fk)
                text = text.replace(new RegExp(`##${x}##`, "g"), item[x]);

            if(item['city']){
                text = text.replace(new RegExp('##articleSetion##', "g"), 'none');
                text = text.replace(new RegExp('##citySection##', "g"), 'flex');
            }
            else{
                text = text.replace(new RegExp('##articleSetion##', "g"), 'flex');
                text = text.replace(new RegExp('##citySection##', "g"), 'none');
            }
            res += text;
        });

        if(_isClass)
            $(`.${_id}`).html(res);
        else
            $(`#${_id}`).html(res);

        if(typeof _callback === 'function')
            _callback();
    }

    function loadSuggestionPack(_element, _type = 'ok'){
        var elem = $(_element);
        elem.parent().parent().parent().show();
        elem.parent().parent().parent().next().remove();

        if(_type == 'error')
            elem.attr('src', '{{URL::asset("images/mainPics/noPicSite.jpg")}}');

        fitThisImg(_element); // in forAllPages
    }

    function createSuggestionPackPlaceHolder(_id, _callback = ''){
        $('#' + _id).append(suggestionPlacePlaceHolderSample);
        if(typeof _callback == 'function')
            _callback();
    }

    function createSuggestionPackPlaceHolderClassName(_class, _callback = ''){
        $('.' + _class).append(suggestionPlacePlaceHolderSample);
        if(typeof _callback == 'function')
            _callback();
    }

    function getSuggestionPackPlaceHolder(){
        return suggestionPlacePlaceHolderSample;
    }

</script>
