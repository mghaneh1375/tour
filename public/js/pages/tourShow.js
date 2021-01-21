var propertySample = `<div class="tourProperty" style="color: ##color##">
                            <div class="propTop">
                                <div class="propHeader">
                                    <div class="propIcon" style="background: ##background##">
                                        <div class="##icon##"></div>
                                    </div>
                                    <div class="propName">##name##</div>
                                </div>
                            </div>
                            <div class="propBottom">##content##</div>
                        </div>`;

var tourSideFeatureList = {
    tourDifficult: {
        name: 'درجه سختی',
        icon: 'fad fa-gauge-simple-max',
        color: '#d80000',
        background: '#ff000026',
        content: ''
    },
    tourKind: {
        name: 'نوع تور',
        icon: 'fad fa-campground',
        color: '#003b75',
        background: '#ecf3fa',
        content: ''
    },
    tourFitFor: {
        name: 'مناسب برای',
        icon: 'fad fa-yin-yang',
        color: '#00aba3',
        background: '#00aba31f',
        content: ''
    },
    tourLanguage: {
        name: 'زبان تور',
        icon: 'fad fa-globe',
        color: '#70005d',
        background: '#fcebf9',
        content: ''
    },
    tourStyle: {
        name: 'تیپ تور',
        icon: 'fad fa-vest-patches',
        color: '#0d5e2f',
        background: '#0d5e2f2b',
        content: ''
    },
    tourSideTransport: {
        name: 'حمل و نقل فرعی',
        icon: 'fad fa-car-bus',
        color: '#9c1a00',
        background: 'rgba(156,26,0,.2)',
        content: ''
    },
};

var mainCost;

function getInformation(){
    $.ajax({
        type: 'GET',
        url: tourInformationUrl,
        success: response => {
            if(response.status == 'ok')
                fillTourShowPage(response.result);
        }
    })
}

function openDayDetails(_day){
    $('#dayEventIdicator').html(dayEvents[(_day-1)].indicatorHtml);
    $('#detailInfSec').html(dayEvents[(_day-1)].detailHtml);
    $('#fullDayDetailSection').addClass('showMinDetail');
    $('#showBigDays').addClass('hidden');
}

function selectDay(_element){

    $('html, body').animate({ scrollTop: $('#dayInfoSection').offset().top }, 500);
    $('#fullDayDetailSection').removeClass('showMinDetail');
    $('#showBigDays').removeClass('hidden');

    var day = $(_element).attr('data-day');

    $(_element).parent().find('.selected').removeClass('selected');
    $(_element).addClass('selected');

    $('#showBigDays').find('.selected').removeClass('selected');
    $('#mainDayShow_'+day).addClass('selected');


    $('#showBigDays').animate({
        scrollTop: $('#showBigDays').scrollTop() + $('#mainDayShow_' + day).position().top
    }, 1000);
    $('#showBigDays').scrollTop();
}

function selectBuyButton(){
    openMyModal('buyModal');
}

function fillTourShowPage(_response){
    console.log(_response);

    var propertySection = '';
    var newFeature = '';
    var newFeatureForBuy = '';
    var equipments;

    tourPrices = _response.prices;
    mainCost = _response.minCost;


    $('.tourName').text(_response.name);
    $('.sDateName').text(_response.sDateName);
    $('.eDateName').text(_response.eDateName);

    $('.mainCost').text(_response.cost);

    $('.mainDescription').text(_response.description);
    $('.tourExceptionText').text(_response.textExpectation);
    $('.tourSpecialInformationText').text(_response.specialInformation);
    $('.tourLimitText').text(_response.tourLimit);

    $('.srcName').text(_response.src.name);
    $('.destinationName').text(_response.dest.name);

    $('.tourDay').text(_response.day);
    $('.tourNight').text(_response.night);

    $('.tourStyleOneRow').text(_response.style.join(' , '));
    $('.tourKindOneRow').text(_response.kinds.join(' , '));
    $('.tourSideTransportOneRow').text(_response.sideTransport.join(' , '));
    $('.tourInsurance').text(_response.isInsurance == 1 ? 'دارد' : 'ندارد');

    $('.tourIsPrivate').text(_response.private == 1 ? 'خصوصی' : 'عمومی');

    var timeHtml = '';
    tourTimes = _response.times;
    if(tourTimes.length > 1) {
        tourTimes.map((item, index) => {
            timeHtml += `<tr class="otherDateChoose ${item.hasCapacity ? 'can' : 'cant'} ${tourTimeCode == item.code ? 'selectdd' : ''}" onclick="chooseOtherDates(this, ${index})">
                            <td>${item.sDateName}</td>
                            <td>${item.eDateName}</td>
                            <td>${ item.hasCapacity ? (item.anyCapacity == 1 ? 'دارد' : item.capacityRemaining + ' نفر') : 'تکمیل' }</td>
                        </tr>`;
        });

        $('#tourTimesTable').html(timeHtml);
    }
    else
        $('.rowChooseDate').hide();

    if(_response.isTransport == 1){
        $('.sMainTransportKind').text(_response.mainTransport.sTransportName);
        $('.sMainTransportAddress').text(_response.mainTransport.sAddress);
        $('.sMainTransportDescription').text(_response.mainTransport.sDescription);
        $('.sMainTransportTime').text(_response.mainTransport.sTime);

        $('.eMainTransportKind').text(_response.mainTransport.eTransportName);
        $('.eMainTransportAddress').text(_response.mainTransport.eAddress);
        $('.eMainTransportDescription').text(_response.mainTransport.eDescription);
        $('.eMainTransportTime').text(_response.mainTransport.eTime);
    }
    else
        $('.mainTransportDetails').addClass('hidden');

    $('.tourGuidName').text(_response.tourGuidName);
    if(_response.tourGuidKoochitaId != 0){
        $('.tourGuidInKoochita').removeClass('hidden');
    }
    else
        $('.tourGuidInKoochita').addClass('hidden');

    features = _response.features;
    features.map((item, index) => {
        newFeature += ` <tr>
                            <td>${item.name}</td>
                            <td>${item.cost}</td>
                            <td>${item.description}</td>
                        </tr>`;

        newFeatureForBuy += `<div class="full-width inline-block buyFeatureRow">
                                <span>${item.name}</span>
                                <span>${item.cost}</span>
                                <input type="number" class="form-control featuresInputCount" data-index="${index}" placeholder="تعداد" style="margin-right: auto; margin-left: 10px; width: 100px;" onchange="calculateFullCost()">
                            </div>`;
    });

    $('.additionalFeatures').html(newFeature);
    $('.additionalFeaturesForBuy').html(newFeatureForBuy);

    var diffEquip = _response.mustEquip.length - _response.suggestEquip.length;

    equipments = '';
    _response.mustEquip.map(item => {
        equipments += `<div class="checkRow">
                            <div class="tichSquer" style="color: #b41b17">
                                <i class="far fa-check"></i>
                            </div>
                            <div class="text">${item}</div>
                        </div>`;
    });
    $('#mustEquipments').html(equipments);

    equipments = '';
    _response.suggestEquip.map(item => {
        equipments += `<div class="checkRow">
                            <div class="tichSquer" style="color: #131457">
                                <i class="far fa-check"></i>
                            </div>
                            <div class="text">${item}</div>
                        </div>`;
    });
    $('#suggestEquipments').html(equipments);

    equipments = '';
    for(var diff = 0; diff < Math.abs(diffEquip); diff++)
        equipments += `<div class="checkRow">
                            <div class="tichSquer"></div>
                            <div class="text"></div>
                        </div>`;
    if(diffEquip != 0)
        $(`#${diffEquip > 0 ? 'suggestEquipments' : 'mustEquipments'}`).append(equipments);


    _response.difficult.map(item => tourSideFeatureList.tourDifficult.content += `<div class="propItem" style="background: ${tourSideFeatureList.tourDifficult.background}">${item}</div>`);
    _response.kinds.map(item => tourSideFeatureList.tourKind.content += `<div class="propItem" style="background: ${tourSideFeatureList.tourKind.background}">${item}</div>`);
    _response.language.map(item => tourSideFeatureList.tourLanguage.content += `<div class="propItem" style="background: ${tourSideFeatureList.tourLanguage.background}">${item}</div>`);
    _response.fitFor.map(item => tourSideFeatureList.tourFitFor.content += `<div class="propItem" style="background: ${tourSideFeatureList.tourFitFor.background}">${item}</div>`);
    _response.style.map(item => tourSideFeatureList.tourStyle.content += `<div class="propItem" style="background: ${tourSideFeatureList.tourStyle.background}">${item}</div>`);
    _response.sideTransport.map(item => tourSideFeatureList.tourSideTransport.content += `<div class="propItem" style="background: ${tourSideFeatureList.tourSideTransport.background}">${item}</div>`);

    for(var item of Object.keys(tourSideFeatureList)){
        var newProp = propertySample;
        for (var x of Object.keys(tourSideFeatureList[item]))
            newProp = newProp.replace(new RegExp(`##${x}##`, "g"), tourSideFeatureList[item][x]);

        propertySection += newProp;
    }
    $('.propertySection').append(propertySection);

    var dayListHtml = '';
    var dayBigInfoHtml = '';
    var allDay = 24 * 60;

    _response.schedule.map((item, index) => {
        dayListHtml += `<div class="dayRow ${index+1 == 1 ? 'selected' : ''}" data-day="${index+1}" onclick="selectDay(this)">
                            <div class="dayCircle"></div>
                            <div class="dayName">روز ${index+1} :</div>
                            <div class="dayTitle">برنامه روز ${index+1}</div>
                        </div>`;

        dayBigInfoHtml += `<div id="mainDayShow_${index+1}" class="bigDetailRow borderBotDashed">
                                <div class="title">
                                    <div class="dayCount">روز ${index+1}</div>
                                    <div class="name">برنامه روز ${index+1}</div>
                                </div>
                                <div class="text">${item.description}</div>
                                ${
                                    item.hotel == null ? '' :
                                        `<div class="sideInfos">
                                            <div class="title">
                                                <div class="iconSec hotelIcon"></div>
                                                <div class="name">محل اقامت :</div>
                                            </div>
                                            <div class="content">
                                                <a href="${item.hotel.url}">${item.hotel.name}</a>
                                            </div>
                                        </div>`
                                }
                                <div class="sideInfos">
                                    <div class="title">
                                        <div class="iconSec restaurantIcon"></div>
                                        <div class="name">وعده غذایی تور :</div>
                                    </div>
                                    <div class="content">${item.meals.join(" - ")}</div>
                                </div>
                                <div class="showAllDetail leftArrowIconAfter" onclick="openDayDetails(${index+1})">مشاهده جزئیات روز</div>
                            </div>`;

        dayEvents.push({
            indicatorHtml: '',
            detailHtml: ''
        });

        item.events.map(event => {
            var sTime = event.sTime.split(':');
            var eTime = event.eTime.split(':');
            var sMinutes = parseInt(sTime[0])*60 + parseInt(sTime[1]);
            var eMinutes = parseInt(eTime[0])*60 + parseInt(eTime[1]);
            var height = ((eMinutes - sMinutes)/allDay) * 100;
            var startPos = (sMinutes/allDay) * 100;

            dayEvents[index].indicatorHtml += `<div class="dayEvent" style="background: ${event.color}; top: ${startPos}%; height: ${height}%;">
                                                   <div class="dayEventName">${event.kindName}</div>
                                               </div>`;

            dayEvents[index].detailHtml += `<div class="dayInfoRow">
                                                <div class="title">
                                                    <div class="iconSec" style="background: ${event.color}">
                                                        <div class="${event.icon}"></div>
                                                    </div>
                                                    ${event.text == null ? event.kindName : event.text}
                                                    <div class="time">${event.sTime} - ${event.eTime}</div>
                                                </div>
                                                <div class="text">${event.description}</div>
                                            </div>`;
        });
    });

    $('#listOfDays').html(dayListHtml);
    $('#showBigDays').html(dayBigInfoHtml);

    createTourPricesHtml();
}

function calculateFeatureCost(){
    var totalCost = 0;
    var elements = $('.featuresInputCount');
    for(var i = 0; i < elements.length; i++){
        index = $(elements[i]).attr('data-index');
        count = $(elements[i]).val();

        if(count != '') {
            cost = features[index].cost;
            cost = cost.toString().replace(new RegExp(',', 'g'), '');
            totalCost += (parseInt(count) * parseFloat(cost));
        }
    }

    $('.featureTotalCost').text(numberWithCommas(totalCost));

    return totalCost;
}

async function calculateFullCost(){
    var featureCost = await calculateFeatureCost();
    var totalValue = parseInt(featureCost);
    pricesArr.map(item => {
        if(item.isFree == 0) {
            totalValue += (item.count * item.prices)
        }
    });
    $('.passengerTotalCost').text(numberWithCommas(totalValue));
}

function addPassenger(_index, _add){
    pricesArr[_index].count += _add;
    if(pricesArr[_index].count < 0)
        pricesArr[_index].count = 0;

    $('.passengerCount_'+_index).text(pricesArr[_index].count);

    calculateFullCost();
}

function chooseOtherDates(_element, _index){
    if(tourTimes[_index].hasCapacity) {
        $(_element).parent().find('.selectdd').removeClass('selectdd');
        $(_element).addClass('selectdd');

        $('.sDateName').text(tourTimes[_index].sDateName);
        $('.eDateName').text(tourTimes[_index].eDateName);

        tourTimeCode = tourTimes[_index].code;
    }
}

function createTourPricesHtml(){
    var pricesHtml = '';

    pricesArr.push({
        id: 0,
        text: 'بزرگسال',
        prices: mainCost,
        isFree: 0,
        inCapacity: 0,
        count: 0
    });

    tourPrices.map(item =>{
        pricesArr.push({
            id: item.id,
            text: `کودک از سن ${item.ageFrom} تا ${item.ageTo}`,
            prices: item.cost,
            isFree: item.isFree,
            inCapacity: item.inCapacity,
            count: 0
        })
    });

    pricesArr.map((item, index) => {
        pricesHtml += `<div class="full-width inline-block priceRow">
                            <span>${item.text}</span>
                            <span style="display: flex; align-items: center; direction: ltr">
                                <span style="margin-right: 10px; width: 80px;">${item.isFree ? 'رایگان' : numberWithCommas(item.prices)}</span>
                                X
                                <span class="passCount">
                                    <span class="addButton" onclick="addPassenger(${index}, -1)">-</span>
                                    <span class="passengerCount_${index}" style="margin: 0px 10px; width: 15px; text-align: center;">${item.count}</span>
                                    <span class="addButton" onclick="addPassenger(${index}, 1)">+</span>
                                </span>
                            </span>
                        </div>`;
    });

    $('#pricesInBuyButton').html(pricesHtml);
}

getInformation();
