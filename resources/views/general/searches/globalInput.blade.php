

<div id="globalSearch" class="globalSearchBlackBackGround">
    <div class="row" style="width: 100%; display: flex; align-items: center; flex-direction: column">
        <div class="globalSearchWithBox">
            <div class="row">
                <div class="icons iconClose globalSearchCloseIcon" onclick="closeSearchInput()"></div>
            </div>
            <div class="row" style="width: 100%; text-align: center;">
                <input id="globalSearchInput" type="text" class="globalSearchInputField" placeholder="" onkeyup="" autocomplete="off">
            </div>
            <div class="row" style="width: 100%;">
                <div id="globalSearchResult" class="data_holder globalSearchResult"></div>
            </div>
        </div>
    </div>
</div>


<script defer src="{{URL::asset('js/jquery.farsiInput.js')}}"></script>
<script>

    var callBackFunctionForGollobalSearchInput;
    function createSearchInput(_doFuncName, _placeHolderTxt){
        clearGlobalResult();
        callBackFunctionForGollobalSearchInput = _doFuncName;

        $('#globalSearchResult').html('').hide();
        $('#globalSearch').css('display', 'flex');
        $('#globalSearchInput').attr('placeholder', _placeHolderTxt)
                                .val('')
                                .focus()
                                .keyup(function(){
                                    if(typeof callBackFunctionForGollobalSearchInput === "function")
                                        callBackFunctionForGollobalSearchInput(this);
                                });
    }

    function setResultToGlobalSearchDefaultForPlaces(_result, _selectItemFunc){
        var html = '';
        _result.map(item => {
            html += `<div class="globalSearchItem" data-kindPlaceId="${item.kindPlaceId}" data-placeId="${item.id}" data-placeName="${item.name}">
                        <div class="globalSearchItemFirstLine">
                            <span class="globalSearchItemIcon ${window.mainIconsPlaces[item.kindPlaceName].icon}"></span>
                            <span class="globalSearchItemName">${item.name}</span>
                        </div>
                        <div class="globalSearchItemState"> ${item.city} در ${item.state} </div>
                    </div>`;
        });
        setResultToGlobalSearch(html);

        $('.globalSearchItem').on('click', function() {
            var kindPlaceId = $(this).attr('data-kindPlaceId');
            var placeId = $(this).attr('data-placeId');
            var placeName = $(this).attr('data-placeName');
            clearGlobalResult();
            closeSearchInput();

            _selectItemFunc(kindPlaceId, placeId, placeName);
        })
    }

    var setResultToGlobalSearch = _txt => $('#globalSearchResult').show().html(_txt);
    var clearGlobalResult = () => $('#globalSearchResult').hide().html('');
    var closeSearchInput = () => $('#globalSearch').css('display', 'none');
</script>
