
<div id="safarnamehPlaceHolderRow" class="hidden">
    <div class="usersArticlesMainDiv placeHolderCard">
        <div class="articleImgMainDiv placeHolderAnime" style="border: none"></div>
        <div class="articleDetailsMainDiv">
            <div class="articleTagsMainDiv" style="cursor: default;">
                <div class="articleTags placeHolderAnime" style="width: 60px; height: 30px;background-color: inherit;"></div>
            </div>
            <div class="articleTitleMainDiv placeHolderAnime resultLineAnim" style="width: 40%; height: 10px; padding: 0px;"></div>
            <div class="articleSummarizedContentMainDiv" style="width: 100%; margin-top: 10px;">
                <div class="placeHolderAnime resultLineAnim" style="width: 80%; height: 7px; padding: 0px;"></div>
                <div class="placeHolderAnime resultLineAnim" style="width: 70%; height: 7px; padding: 0px;"></div>
                <div class="placeHolderAnime resultLineAnim" style="width: 20%; height: 7px; padding: 0px;"></div>
                <div class="placeHolderAnime resultLineAnim" style="width: 60%; height: 7px; padding: 0px;"></div>
            </div>
            <div class="readSafarnamehButton placeHolderAnime" style="width: 15%; height: 45px;"></div>
        </div>
    </div>
</div>

<script>
    let safarnamehPlaceHolderRow = $('#safarnamehPlaceHolderRow').html();
    $('#safarnamehPlaceHolderRow').remove();

    function getSafaranmehPlaceHolderRow(){
        return safarnamehPlaceHolderRow;
    }

    function getSafarnamehRow(_safarnameh){
        // let _safarnameh = {
        //    id,
        //    url,
        //    pic,
        //    userPic,
        //    editAble,
        //    title,
        //    summery,
        //    time,
        //    username,
        // }
        let text = '';

        text += '<div class="usersArticlesMainDiv">\n' +
            '            <div class="articleImgMainDiv">\n' +
            '                <a href="' + _safarnameh.url + '"><img src="' + _safarnameh.pic + '" class="resizeImgClass" style="width: 100%" onload="fitThisImg(this)"></a>\n' +
            '                <img class="userPic" src="' + _safarnameh.userPic + '">\n' +
            '            </div>\n' +
            '            <div class="articleDetailsMainDiv">\n';

        @if(auth()->check())
            if(_safarnameh.editAble) {
                text += '<div class="trashIcon commonSafarnamehIcon delete" onclick="deleteThisSafarnameh(' + _safarnameh.id + ')"></div>';
                text += '<div class="editIcon commonSafarnamehIcon edit" onclick="editThisSafarnameh(' + _safarnameh.id + ')"></div>';
            }
        @endif
        text += '<div class="articleTagsMainDiv" style="cursor: default;">\n' +
            '   <div class="articleTags">سفرنامه</div>\n' +
            '</div>\n' +
            '<div class="articleTitleMainDiv">\n' +
            '   <a href="' + _safarnameh.url + '">' + _safarnameh.title + '</a>\n' +
            '</div>\n';
        if(_safarnameh.summery != null) {
            text += '<div class="articleSummarizedContentMainDiv">\n' +
                '   <span>' + _safarnameh.summery + '</span>\n' +
                '   <span>...</span>\n' +
                '</div>\n';
        }
        text += '<div class="articleSpecificationsMainDiv">\n' +
            '   <div class="articleDateMainDiv">' + _safarnameh.time + '</div>\n' +
            '   <div class="articleCommentsMainDiv">0</div>\n' +
            '   <div class="articleWriterMainDiv">'+ _safarnameh.username +'</div>\n' +
            '   <div class="articleWatchListMainDiv">0</div>\n' +
            '</div>\n' +
            '<a href="{{url('/safarnameh/show')}}/' + _safarnameh.id + '" class="readSafarnamehButton"> مطالعه سفرنامه</a>' +
            '</div>\n' +
            '</div>';

        return text;
    }

    @if(auth()->check())
        let deletedSafarnamehId = null;
        function deleteThisSafarnameh(_id){
            if(checkLogin()) {
                deletedSafarnamehId = _id;
                openWarning('آیا می خواهید سفرنامه ی خود را پاک کنید؟', doDeleteSafarnameh, 'بله پاک شود');
            }
        }

        function doDeleteSafarnameh(){
            if(deletedSafarnamehId != null){
                openLoading(false, function(){
                    $.ajax({
                        type: 'post',
                        url: '{{route("upload.safarnameh.delete")}}',
                        data: {
                            _token: '{{csrf_token()}}',
                            id: deletedSafarnamehId
                        },
                        success: function(response){

                            if(response == 'ok'){
                                location.reload();
                                showSuccessNotifi('سفرنامه شما با موفقیت حذف شد.', 'left', 'var(--koochita-blue)');
                            }
                            else {
                                closeLoading();
                                showSuccessNotifi('در حذف سفرنامه مشکلی پیش امده لطفا دوباره تلاش نمایید.', 'left', 'red');
                            }
                        },
                        error: function(err){
                            closeLoading();
                            showSuccessNotifi('در حذف سفرنامه مشکلی پیش امده لطفا دوباره تلاش نمایید.', 'left', 'red');
                        }
                    })
                })
            }
        }

        function editThisSafarnameh(_id){
            editSafarnameh(_id); //in addSafarnameh.blade.php
        }
    @endif
</script>
