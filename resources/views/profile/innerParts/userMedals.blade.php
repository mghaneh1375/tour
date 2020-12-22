<div class="postsMainDivInSpecificMode medalsSection col-xs-12">
    <div id="notDataMedal" style="display: none">
        <div class="col-xs-12 notData">
            <div class="pic">
                <img src="{{URL::asset('images/mainPics/noData.png')}}" style="width: 100%">
            </div>
            <div class="info">
                @if($myPage)
                    <div class="firstLine">
                        اینجا خالی است.هنوز مدالی کسب نکرده اید...
                    </div>
                @else
                    <div class="firstLine">
                        اینجا خالی است. {{$user->username}} هنوز مدالی کسب نکرده...
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div id="medalContent">
        <div class="col-md-12">
            <div class="rowTitle">
                مدال های کسب شده
                <a href="#" class="link">چگونه کسب درآمد کنیم؟</a>
            </div>
            <div id="takenMedal" class="medals"></div>
        </div>
        @if($myPage)
            <div class="col-md-12">
                <div class="rowTitle">با کمی تلاش کسب می شود</div>
                <div id="inProgressMedal" class="medals"></div>
            </div>
            <div class="col-md-12">
                <div class="rowTitle">همه مدال ها</div>
                <div id="allMedals" class="medals"></div>
            </div>
        @endif
    </div>
</div>

<script>
    let notDataMedal = $('#notDataMedal').html();
    $('#notDataMedal').removeClass();

    let animLoad = '';
    for(let i = 0; i < 4; i++)
        animLoad += '<div class="medalCard">\n' +
                    '<div class="frontCard">\n' +
                    '<div class="pic placeHolderAnime"  style="border-radius: 50%"></div>\n' +
                    '<div class="name animLine placeHolderAnime"></div>\n' +
                    '<div class="summery animLine placeHolderAnime"></div>\n' +
                    '</div>\n' +
                    '</div>';

    $('#allMedals').html(animLoad);
    $('#inProgressMedal').html(animLoad);
    $('#takenMedal').html(animLoad);

    function getMedals(){
        $.ajax({
            type: 'post',
            url: '{{route('profile.getUserMedals')}}',
            data: {
                _token: '{{csrf_token()}}',
                userId: userPageId
            },
            success: function(response){
                response = JSON.parse(response);
                @if($myPage)
                    createCard(response.allMedals, 'allMedals');
                    createCard(response.inProgressMedal, 'inProgressMedal');
                @endif
                if(response.takenMedal.length == 0)
                    $('#takenMedal').html(notDataMedal);
                else
                    createCard(response.takenMedal, 'takenMedal');
            }
        })
    }

    function createCard(_result, _id){
        let text = '';
        _result.map(item => {
            text += '<div class="medalCard" onclick="showBackCard(this)">\n' +
                    '                    <div class="frontCard">\n' +
                    '                        <div class="pic">\n' +
                    '                            <div class="onPic blinking" style="width: ' + item.percent + '%; background-image: url(' + item.onPic + ')"></div>\n' +
                    '                            <div class="offPic" style="background-image: url(' + item.offPic + ')"></div>\n' +
                    '                        </div>\n' +
                    '                        <div class="name">' + item.name + '</div>\n' +
                    '                        <div class="summery">' + item.sumText + '</div>\n' +
                    '                    </div>\n' +
                    '                    <div class="backCard hidden">\n' +
                    '                        <div class="pic">\n' +
                    '                            <img src="' + item.onPic + '" style="width: 100%;">\n' +
                    '                        </div>\n' +
                    '                        <div class="name">' + item.name + '</div>\n' +
                    '                        <div class="text">' + item.text + '</div>\n' +
                    '                        <div class="rate">\n' +
                    '                            <span style="color: var(--koochita-red);">' + item.take + '</span>\n' +
                    ' از                             ' + item.floor +
                    '                        </div>'+
                    '                    </div>\n' +
                    '                </div>';
        });

        $('#'+_id).html(text);
    }

    function filterMedals(_kind, _element){
        $(_element).parent().find('.active').removeClass('active');
        $(_element).addClass('active');
    }

    function showBackCard(_element){
        $(_element).toggleClass('showBack');
        setTimeout(function () {
            $(_element).find('.frontCard').toggleClass('hidden');
            $(_element).find('.backCard').toggleClass('hidden');
        }, 300)
    }
</script>
