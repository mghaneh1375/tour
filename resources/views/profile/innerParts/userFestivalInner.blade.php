<link rel="stylesheet" href="{{URL::asset('css/pages/festival.css')}}">

<style>
    .deleteContent{
        position: absolute;
        right: 15px;
        top: 15px;
        background: #445565;
        cursor: pointer;
        width: 45px;
        height: 45px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        padding: 5px;
        color: red;
        font-size: 35px;
    }
    .deleteContent img{
        width: 100%;
    }
</style>

<div id="mainFestivalContent" class="userProfileArticles festivalContent">
    <div id="mainFestivalContentList"></div>

    <div class="SpecfestivalContent hidden">
        <div class="userProfilePostsFiltrationContainer">
            <div id="subFestivalTopMenu" class="userProfilePostsFiltration questionSecTab"></div>
        </div>

        <div class="col-xs-12 notData emptyFestival hidden">
            <div class="pic">
                <img src="{{URL::asset('images/mainPics/noData.png')}}" style="width: 100%">
            </div>
            <div class="info">
                <div class="firstLine">
                    اینجا خالی است.هنوز در این بخش فستیوال شرکت نکرده اید...
                </div>
                <div class="sai" style="display: flex">
                    <a id="noDataFestivalLink" href="#"
                       target="_blank"
                       class="butt"
                       style="font-size: 10px; margin-right: auto;">شرکت در فستیوال</a>
                </div>
            </div>
        </div>

        <div id="festivalContentPlaceHolder" class="hidden">
            <div class="profilePicturesRow kind2">
                <div class="profilePictureDiv placeHolderAnime" style="width: 33%; height: 150px"></div>
                <div class="profilePictureDiv placeHolderAnime" style="width: 33%; height: 150px"></div>
                <div class="profilePictureDiv placeHolderAnime" style="width: 33%; height: 150px"></div>
            </div>
        </div>

        <div id="festivalContentId" class="photosAndVideosMainDiv"></div>
    </div>
</div>

<div id="showFestivalImgModal" class="showFullPicModal hidden">
    <div class="iconClose" onclick="closeShowPictureModal()"></div>
    <div id="showImgModalBody" class="body">
        <div id="modalImgSection" class="imgSec">
            <div id="deleteThisFestivalContent" class="deleteContent trashIcon" data-id="" onclick="deleteMyFestivalContent(this)"></div>
            <img id="modalPicture" >
            <video id="modalVideo"  controls></video>
            <div class="nPButtons next leftArrowIcon" onclick="nextShowFestivalPicModal(-1)"></div>
            <div class="nPButtons prev leftArrowIcon" onclick="nextShowFestivalPicModal(1)"></div>
        </div>

        <div id="modalInfoSection" class="infoSec">
            <div class="userInfo">
                <div style="display: flex; align-items: center;">
                    <div class="userPic">
                        <img class="modalUserPic"  style="height: 100%;">
                    </div>
                    <a href="#" target="_blank" class="username modalUserName"></a>
                </div>
{{--                <div class="hideOnScreen showSLBInM">--}}
{{--                    <button class="modalLike empty-heartAfter" onclick="likeWorks(this)" code="0"></button>--}}
{{--                    <button class="codeButton" onclick="copyUrl(this)">--}}
{{--                        اشتراک گذاری:--}}
{{--                        <span class="modalCode"></span>--}}
{{--                    </button>--}}
{{--                </div>--}}
            </div>
            <div class="picInfo">
                <div class="inf">
                    <div class="title">نام اثر: </div>
                    <div class="text modalTitle"></div>
                </div>
                <div class="inf">
                    <div class="title">محل: </div>
                    <a href="#" target="_blank" class="text modalPlace"></a>
                </div>
{{--                <div id="modalDescription" class="inf">--}}
{{--                    <div class="title">توضیحات عکس: </div>--}}
{{--                    <div class="text" style="font-size: 12px;"></div>--}}
{{--                </div>--}}
                <div id="modalFailedReason" class="inf hidden">
                    <div class="title">دلیل عدم تایید عکس: </div>
                    <div class="text" style="font-size: 12px; color: #ff6464"></div>
                </div>
            </div>

{{--            <div class="liShButtons">--}}
{{--                <div class="likeButton empty-heartAfter modalLike" onclick="likeWorks(this)" code="0"></div>--}}
{{--                <div class="shareButton" onclick="copyUrl(this)">--}}
{{--                    اشتراک گذاری:--}}
{{--                    <span class="modalCode"></span>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
</div>

<script>
    var festivalsInformations = [];
    var nowShowFestivalCode = 0;
    var thisFestivalContent = [];
    var nowShowFestivalPicIndex = 0;
    var nowShowFestival;

    function getMainFestival(){
        $("#mainFestivalContentList").removeClass('hidden');
        $(".SpecfestivalContent").addClass('hidden');

        let sfpl = getSafaranmehPlaceHolderRow(); // component.safarnamehRow.blade.php
        $('#mainFestivalContentList').html(sfpl+sfpl);
        $.ajax({
            type: 'GET',
            url: '{{route("profile.getMainFestival")}}',
            success: response => {
                if(response.status == 'ok')
                    createMainFestivalContent(response.result);
            },
        })
    }

    function createMainFestivalContent(_result){
        let text = '';
        festivalsInformations = _result;
        _result.map(item => {
            text +=  `<div class="usersArticlesMainDiv">
                        <div class="articleImgMainDiv">
                            <div onClick="getFestivalMyWorks(${item.id})">
                                <img src="${item.pic}" class="resizeImgClass" style="width: 100%" onload="fitThisImg(this)">
                            </div>
                        </div>
                        <div class="articleDetailsMainDiv">
                            <div class="articleTitleMainDiv">
                                <div onClick="getFestivalMyWorks(${item.id})" style="cursor: pointer;">${item.name}</div>
                            </div>
                            <div class="articleSummarizedContentMainDiv">
                                <span>${item.description}</span>
                            </div>
                            <a href="${item.pageUrl}" class="readSafarnamehButton"> صفحه فستیوال</a>
                        </div>
                    </div>`;
        });

        $('#mainFestivalContentList').html(text);
    }

    function getFestivalMyWorks(_id){
        var subMenus = '';
        festivalsInformations.map(fest => {
            if(fest.id == _id) {
                nowShowFestival = fest;
                fest.subs.map(sub => subMenus += `<span class="active" onclick="changeFestivalSubTabs('${item.name}', this)">${sub.name}</span>`);
                $('#noDataFestivalLink').attr('href', fest.pageUrl);
            }
        });
        $('#subFestivalTopMenu').html(subMenus);

        $("#mainFestivalContentList").addClass('hidden');
        $(".SpecfestivalContent").removeClass('hidden');

        $('#festivalContentPlaceHolder').removeClass('hidden');
        $('#mainFestivalContent').find('.notData').addClass('hidden');
        $('#festivalContentId').addClass('hidden');

        $.ajax({
            type: 'GET',
            url: '{{route("profile.festival.getMyWorks")}}?id='+_id,
            success: function(response){
                if(response.status == 'ok')
                    createFestivalPictures(response.result);
            },
        })
    }

    function changeFestivalSubTabs(_id, _elem){
        $(_elem).parent().find('.active').removeClass('active');
        $(_elem).addClass('active');

        $('#festivalContentPlaceHolder').removeClass('hidden');
        $('#mainFestivalContent').find('.notData').addClass('hidden');
        $('#festivalContentId').addClass('hidden');

    }

    function createFestivalPictures(_result){
        let addedPic = 0;
        let text = '';
        thisFestivalContent = _result;

        $('#festivalContentId').empty().removeClass('hidden');
        $('#festivalContentPlaceHolder').addClass('hidden');

        if (thisFestivalContent.length == 0)
            $('#mainFestivalContent').find('.notData').removeClass('hidden');
        else
            $('#mainFestivalContent').find('.notData').addClass('hidden');

        thisFestivalContent.map((item, index) => {
            if(addedPic == 0)
                text += '<div class="profilePicturesRow kind2">';

            text +=  `<div class="profilePictureDiv" style="width: 33%;" onclick="openFestivalPictureWithIndex(${index})">
                        <div class="confirmState ${item.confirm == 1 ? 'success' : (item.confirm == 0 ? 'waiting' : 'failed')}"></div>
                        <div class="festivalContentTitle">${item.title}</div>
                        <img src="${item.showPic}" class="resizeImgClass" style="width: 100%" onload="fitThisImg(this)">
                    </div>`;
            addedPic++;

            if(addedPic == 3) {
                text += '</div>';
                addedPic = 0;
            }
        });

        $('#festivalContentId').html(text);
    }

    function nextShowFestivalPicModal(_kind){
        openFestivalPictureWithIndex(nowShowFestivalPicIndex+_kind);
    }

    function openFestivalPictureWithIndex(_index){
        nowShowFestivalPicIndex = _index;
        if(nowShowFestivalPicIndex < 0)
            nowShowFestivalPicIndex = thisFestivalContent.length-1;
        else if(nowShowFestivalPicIndex == thisFestivalContent.length)
            nowShowFestivalPicIndex = 0;

        openShowPictureModal(thisFestivalContent[nowShowFestivalPicIndex]);
    }

    function openShowPictureModal(_picture){
        $('#modalPicture').attr('src', '#');
        $('#modalVideo').attr('src', '#');

        if(_picture['type'] == 'image'){
            $('#modalVideo').hide();
            $('#modalPicture').show().attr('src', _picture['file']);
        }
        else{
            $('#modalPicture').hide();
            $('#modalVideo').show().attr('src', _picture['file']);
        }

        $('#deleteThisFestivalContent').attr('data-id', _picture['id']);

        $('.modalUserPic').attr('src', _picture['userPic']);
        $('.modalUserName').text(_picture['username']).attr('href', _picture['userUrl']);
        $('.modalTitle').text(_picture['title']);
        $('.modalPlace').attr('href', _picture['placeUrl']).text(_picture['place']);

        if(_picture['failedReason'] != null)
            $('#modalFailedReason').removeClass('hidden').find('.text').text(_picture['failedReason']);
        else
            $('#modalFailedReason').addClass('hidden');

        // $('.modalLike').text(_picture['like']).attr('code', _picture['code']);
        // $('.modalCode').text(_picture['code']+'#');
        // if(_picture['description'] != null)
        //     $('#modalDescription').show().find('.text').text(_picture['description']);
        // else
        //     $('#modalDescription').hide().find('.text').text('');
        //
        // if(_picture['youLike'] == 1)
        //     $('.modalLike').removeClass('empty-heartAfter').addClass('HeartIconAfter');
        // else
        //     $('.modalLike').removeClass('HeartIconAfter').addClass('empty-heartAfter');

        nowShowFestivalCode = _picture.code;
        $('#showFestivalImgModal').removeClass('hidden');
    }

    function closeShowPictureModal(){
        $('#showFestivalImgModal').addClass('hidden');
    }

    function copyUrl(_elems){
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val("{{route('festival.main')}}?code="+nowShowFestivalCode).select();
        document.execCommand("copy");
        $temp.remove();

        let inputText = $(_elems).text();
        $(_elems).text('لینک کپی شد');
        setTimeout(() => $(_elems).text(inputText), 2000)
    }

    function deleteMyFestivalContent(_element){
        var id = $(_element).attr('data-id');
        openLoading(false, () => {
            $.ajax({
                type: 'delete',
                url: '{{route("profile.festival.deleteMyWork")}}',
                data:{
                    _token: '{{csrf_token()}}',
                    id: id,
                    festivalId: nowShowFestival.id
                },
                success: response => {
                    closeLoading();
                    if(response.status == 'ok'){
                        showSuccessNotifi('محتوای مورد نظر با موفقیت پاک شد', 'left', 'var(--koochita-blue)');
                        getFestivalMyWorks(nowShowFestival.id);
                        closeShowPictureModal();
                    }
                    else
                        showSuccessNotifi('خطای در پاک کردن محتوا', 'left', 'red')
                },
                error: err => {
                    closeLoading();
                    showSuccessNotifi('خطای سرور', 'left', 'red')
                }
            })
        })
    }

</script>