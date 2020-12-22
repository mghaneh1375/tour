{{--<link rel="stylesheet" href="{{URL::asset('css/globalSearch.css?v=1')}}">--}}

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

    function createSearchInput(_doFuncName, _placeHolderTxt){
        // _doFuncName must be string
        clearGlobalResult();

        $('#globalSearchInput').attr('onkeyup', _doFuncName+'(this)');
        $('#globalSearchInput').attr('placeholder', _placeHolderTxt);
        $('#globalSearchInput').val('');

        $('#globalSearchResult').html('');
        $('#globalSearchResult').hide();

        $('#globalSearch').css('display', 'flex');

        $('#globalSearchInput').focus();
    }

    function setResultToGlobalSearch(_txt){
        $('#globalSearchResult').show();
        $('#globalSearchResult').html(_txt);
    }

    function clearGlobalResult(){
        $('#globalSearchResult').hide();
        $('#globalSearchResult').html('');
    }

    function closeSearchInput(){
        $('#globalSearch').css('display', 'none');
    }
</script>