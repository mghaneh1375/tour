<style>
    .processBar{
        max-width: 400px;
        width: 95%;
        height: 20px;
        background: #d0d0d0;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
    }
    .processBar .percentBar{
        z-index: 1;
    }
    .processBar .bar{
        right: 0px;
        height: 100%;
        background: var(--koochita-yellow);
        position: absolute;
        border-radius: 20px;
    }
</style>

<div id="fullPageLoader" class="loaderDiv hidden">
    <div class="loader_200">
        <img alt="loading" data-src="{{URL::asset('images/loading.gif?v='.$fileVersions)}}" class="lazyload" style="width: 300px;">
    </div>

    <div class="processBar hidden">
        <div class="percentBar">0%</div>
        <div class="bar"></div>
    </div>
</div>

<script>
    function openLoading(_process = false, _callBack = ''){
        $('#fullPageLoader').removeClass('hidden');

        $('#fullPageLoader').find('.percentBar').text(`0%`);
        $('#fullPageLoader').find('.bar').css('width', `0%`);

        if(_process)
            $('#fullPageLoader').find('.processBar').removeClass('hidden');

        setTimeout(function(){
            if(typeof _callBack === 'function')
                _callBack();
            else if(typeof _process === 'function')
                _process();
        }, 200);
    }

    function closeLoading(){
        $('#fullPageLoader').addClass('hidden');
    }

    function updatePercentLoadingBar(_percent){
        $('#fullPageLoader').find('.percentBar').text(`${_percent}%`);
        $('#fullPageLoader').find('.bar').css('width', `${_percent}%`);
    }
</script>