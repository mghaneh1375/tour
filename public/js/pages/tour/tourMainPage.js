
function updatePageElementsSizes(){
    var mainPic = document.getElementById('mainBackgroundPicWithBlur');
    var sidePic = document.getElementById('sideBackgroundPicWithBlur');

    sidePic.style.width = mainPic.offsetWidth + 'px';
    sidePic.style.height = mainPic.offsetHeight + 'px';


    setTimeout(() => {
        var searchSectionHeight = document.getElementById('listSearchTopSection').offsetHeight;
        document.getElementById('listSection').style.height = `calc(100% - ${searchSectionHeight}px)`;
    }, 400);
}

function showTourTypeShow(_show){
    for(var i = 0; i < tourTypeMenu.length; i++) {
        if(tourTypeMenu[i].id === _show){
            nowTourTypeShow = tourTypeMenu[i];
            break;
        }
    }

    var backgroundColor = nowTourTypeShow.color;

    getTourSuggestions();
    hideBackgroundPic(nowTourTypeShow.backPic);

    [...document.querySelectorAll('.searchPanelBodies')].map(item => item.classList.remove("show"));

    [...document.querySelectorAll('.sideItem')].map(item => {
        item.classList.remove('select');
        item.style.color = 'white';

        if(item.classList.contains(`${nowTourTypeShow.id}_sideItem`)){
            item.classList.add('select');
            item.style.color = backgroundColor;
        }
    });

    [...document.querySelectorAll('.backgroundColorChanges')].map(item => item.style.background = backgroundColor);
    [...document.querySelectorAll('.changeableIconColor')].map(item => {
        item.style.background = backgroundColor + '33';
        item.style.color = backgroundColor;
    });

    setTimeout(() => {

        document.getElementById('topTourKindText').innerText = nowTourTypeShow.picText['top'];
        document.getElementById('mainTourKindText').innerText = nowTourTypeShow.picText['main'];
        document.getElementById('bottomTourKindText').innerText = nowTourTypeShow.picText['bottom'];

        document.getElementById(`${nowTourTypeShow.id}_searchPanel`).classList.add('show');

        updatePageElementsSizes();
    }, 500);
}

function hideBackgroundPic(_pic){
    [...document.querySelectorAll('.backgroundPicTour')].map(item => {
        item.classList.add('addOpacity0ToPic');
        setTimeout(() => item.src = _pic, 500);
    });
}

function showBackgroundPic(){
    [...document.querySelectorAll('.backgroundPicTour')].map(item => {
        item.classList.remove('addOpacity0ToPic');
    });
}

function showSearchPanel(){
    document.getElementById(`${nowTourTypeShow.id}_searchPanel`).classList.add('show');
    setTimeout(() => isShowFullSearchPanel = true, 400);
    updatePageElementsSizes();
}

function hideSearchPanel(){
    [...document.querySelectorAll('.searchPanelBodies')].map(item => item.classList.remove("show"));
    setTimeout(() => isShowFullSearchPanel = false, 400);
    updatePageElementsSizes();
}

function createTourSuggestionPlaceHolderCard(_count){
    var html = '';
    for(var i = 0; i < _count; i++)
        html += `<div class="tourSmallCard">
                            <div class="imgSec placeHolderAnime"></div>
                            <div class="contentSec">
                                <div class="smallText placeHolderAnime resultLineAnim"></div>
                                <div class="bigBoldText placeHolderAnime resultLineAnim"></div>
                                <div class="smallText placeHolderAnime resultLineAnim"></div>
                                <div class="smallText placeHolderAnime resultLineAnim"></div>
                            </div>
                        </div>`;

    document.getElementById('listResult').innerHTML = html;
}

function createTourSuggestionCards(_result){
    var htmlCard = '';
    _result.map(item => {
        htmlCard += `<a href="${item.url}" class="tourSmallCard">
                            <div class="imgSec">
                                <img src="${item.pic}" class="resizeImgClass" alt="tourName" onload="fitThisImg(this)">
                            </div>
                            <div class="contentSec">
                                <div class="smallText">${item.categoryName}</div>
                                <div class="bigBoldText">${item.name}</div>
                                <div class="smallText">
                                    ${item.type === 'cityTourism' ?
                                        `` :
                                        `<span>
                                            ${item.day} روز
                                            ${ item.night > 0 ? `/ ${item.night} شب` : '' }
                                        </span>`
                                    }
                                    <span style="margin-right: 20px;"> ${item.sDate} </span>
                                </div>
                                <div class="smallText">شروع قیمت از ${numberWithCommas(item.cost)} تومان</div>
                            </div>
                            <div class="agencyPic">
                                <img src="${item.agencyPic}" alt="${item.agencyName}" style="max-height: 100%; max-width: 100%;">
                            </div>
                        </a>`;
    });

    document.getElementById('listResult').innerHTML = htmlCard;
}

function createDestinationCardsPlaceHolder(_count){
    var html = '';
    for(var i = 0; i < _count; i++){
        html += `<div class="destinationCard">
                    <div class="destImg placeHolderAnime"></div>
                </div>`;
    }
    document.getElementById('destinationResult').innerHTML = html;
}

function createDestinationCards(_result){
    var html = '';
    _result.map(item => {
        html += `<a href="${item.url}" class="destinationCard">
                    <div class="destImg">
                        <img src="${item.pic}" class="resizeImgClass" alt="cityName" onload="fitThisImg(this)">
                    </div>
                </a>`;
    });

    document.getElementById('destinationResult').innerHTML = html;
}

function getTourSuggestions(){
    createTourSuggestionPlaceHolderCard(2);
    createDestinationCardsPlaceHolder(4);

    if(!nowTourTypeShow['isGet']) {
        $.ajax({
            type: 'GET',
            url: `${getMainPageToursUrl}?type=${nowTourTypeShow['id']}`,
            success: response => {
                if (response.status === 'ok') {
                    nowTourTypeShow['isGet'] = true;
                    nowTourTypeShow['tours'] = response.result.tour;
                    nowTourTypeShow['destinations'] = response.result.destinations;

                    createTourSuggestionCards(nowTourTypeShow['tours']);
                    createDestinationCards(nowTourTypeShow['destinations']);
                }
            },
        })
    }
    else{
        createTourSuggestionCards(nowTourTypeShow['tours']);
        createDestinationCards(nowTourTypeShow['destinations']);
    }
}

document.getElementById('listResult').onscroll = e => {
    if(e.target.scrollTop > 0 && isShowFullSearchPanel)
        hideSearchPanel();
    else if(!isShowFullSearchPanel)
        showSearchPanel();
};

