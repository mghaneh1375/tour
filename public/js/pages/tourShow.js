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

function fillTourShowPage(_response){
    var newFeature = '';
    var equipments;

    console.log(_response);

    $('.mainCost').text(_response.cost);

    if(_response.importantNotes.length != 0){
        var notes = '';
        _response.importantNotes.map(item => notes += `<p>${item}</p>`);
        $('#noticTourContent').find('.content').html(notes);
    }
    else
        $('#noticTourContent').remove();

    if(_response.childDisCount != null)
        $('#tourExpDiscountAlerts').html(`<span>${_response.childDisCount.discount} درصد تخفیف ویژه کودکان</span>`);

    $('.mainDescription').text(_response.description);

    $('.srcName').text(_response.src.name);
    $('.destinationName').text(_response.dest.name);
    $('.sDateTour').text(_response.sDate);
    $('.eDateTour').text(_response.eDate);

    $('.tourDay').text(_response.day);
    $('.tourNight').text(_response.night);

    $('.tourStyleOneRow').text(_response.style.join(' , '));
    $('.tourKindOneRow').text(_response.kinds.join(' , '));
    $('.tourSideTransportOneRow').text(_response.sideTransport.join(' , '));
    $('.tourLanguageOneRow').text(_response.language.join(' , '));
    $('.tourInsurance').text(_response.isInsurance == 1 ? 'دارد' : 'ندارد');

    $('.tourIsPrivate').text(_response.private == 1 ? 'خصوصی' : 'عمومی');

    $('.tourExceptionText').text(_response.textExpectation);
    $('.tourSpecialInformationText').text(_response.specialInformation);
    $('.tourOpinionText').text(_response.opinion);
    $('.tourLimitText').text(_response.tourLimit);


    if(_response.isTransport == 1){
        $('.sTransportName').text(_response.mainTransport.sTransportName);
        $('.sTransportDate').text(_response.mainTransport.sTime);
        $('.sTransportAddress').text(_response.mainTransport.sAddress);
        $('.sTransportDescription').text(_response.mainTransport.sDescription);

        $('.eTransportName').text(_response.mainTransport.eTransportName);
        $('.eTransportDate').text(_response.mainTransport.eTime);
        $('.eTransportAddress').text(_response.mainTransport.eAddress);
        $('.eTransportDescription').text(_response.mainTransport.eDescription);
    }
    else
        $('.mainTransportDetails').addClass('hidden');


    _response.features.map((item, index) => {
        newFeature += ` <tr>
                            <td>
                                <div class="ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem ">
                                    <input type="checkbox" id="feature_${item.id}" value="${item.id}" class="ng-pristine ng-untouched ng-valid ng-not-empty">
                                    <label for="feature_${item.id}"><span></span></label>
                                </div>
                            </td>
                            <td>${item.name}</td>
                            <td>${item.description}</td>
                            <td>+${item.cost}</td>
                        </tr>`;

    });
    $('.additionalFeatures').append(newFeature);


    equipments = '';
    _response.mustEquip.map(item => equipments += `<div class="inline-block essentialEquipments">${item}</div>`);
    $('#mustEquipments').html(equipments);

    equipments = '';
    _response.suggestEquip.map(item => equipments += `<div class="inline-block suggestedEquipments">${item}</div>`);
    $('#suggestEquipments').html(equipments);

}

getInformation();
