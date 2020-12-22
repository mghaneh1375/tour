<style>
    .readSafarnamehButton{
        /*background: var(--koochita-green);*/
        width: fit-content;
        padding: 5px 10px;
        color: var(--koochita-blue);
        border-radius: 10px;
        position: absolute;
        bottom: 10px;
        left: 10px;
        cursor: pointer;
        transition: .3s;
    }
    .readSafarnamehButton:hover{
        border: solid;
        color: var(--koochita-blue);
    }
    .commonSafarnamehIcon{
        position: absolute;
        top: 10px;
        font-size: 25px;
        cursor: pointer;
        width: 30px;
        height: 30px;
        border: solid 2px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 8px;
        transition: .3s;
    }
    .commonSafarnamehIcon.delete{
        color: red;
        left: 10px;
    }
    .commonSafarnamehIcon.delete:hover{
        background: red;
        color: white;
        border-color: red;
    }

    .commonSafarnamehIcon.edit{
        color: var(--koochita-blue);
        left: 50px;
    }
    .commonSafarnamehIcon.edit:hover{
        background: var(--koochita-blue);
        color: white;
        border-color: var(--koochita-blue);
    }
</style>

<div id="safarnamehList" class="userProfileArticles">
    @if(isset($myPage) && $myPage)
        <div class="userProfilePostsSearchContainer">
            <button class="btn btn-primary" onclick="openNewSafarnameh()">نوشتن سفرنامه</button>
        </div>
    @endif

    <div class="col-xs-12 notData hidden">
        <div class="pic">
            <img src="{{URL::asset('images/mainPics/noData.png')}}" style="width: 100%">
        </div>
        <div class="info">
            @if($myPage)
                <div class="firstLine">
                    اینجا خالی است.هنوز سفرنامه ای ننوشتید...
                </div>
                <div class="sai">
                    خاطراتت رو مرور کن و
                    <button class="butt" onclick="writeNewSafaranmeh()">سفرنامه بنویس</button>
                </div>
            @else
                <div class="firstLine">
                    اینجا خالی است. {{$user->username}} هنوز سفرنامه ای ننوشته...
                </div>
            @endif
        </div>
    </div>

    <div id="safarnamehShowList"></div>
</div>

<script>


    let myPageAccess = {{isset($myPage) && $myPage ? 1 : 0}}
    function getSafarnamehs(){
        let sfpl = getSafaranmehPlaceHolderRow(); // component.safarnamehRow.blade.php
        let data;
        if(userPageId == 0)
            data = { _token: '{{csrf_token()}}' };
        else
            data = {
                _token: '{{csrf_token()}}',
                userId: userPageId, // in mainProfile.blade.php
            };

        $('#safarnamehShowList').html(sfpl+sfpl);
        $('#safarnamehList').find('.notData').addClass('hidden');
        $.ajax({
            type: 'post',
            url: '{{route("profile.getSafarnameh")}}',
            data: data,
            success: function(response){
                response = JSON.parse(response);
                if(response.status == 'ok') {
                    response.result.map(item => item.editAble = true);
                    let safranamehText = showSafarnameh(response.result);
                    $('#safarnamehShowList').html(safranamehText);
                }
            },
            error: err => console.log(err)
        })
    };

    function showSafarnameh(_result){
        let text = '';

        if(_result.length == 0)
            $('#safarnamehList').find('.notData').removeClass('hidden');

        _result.forEach(item => {
            item.editAble = myPageAccess && item.editAble;
            text += getSafarnamehRow(item); // in component.safarnamehRow.blade.php
        });

        return text;
    }
</script>
