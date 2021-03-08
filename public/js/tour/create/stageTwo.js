var rateStar= [
    '<span class="ui_bubble_rating bubble_10 font-size-16" property="ratingValue" content="1" alt="1 of 5 bubbles"></span>',
    '<span class="ui_bubble_rating bubble_20 font-size-16" property="ratingValue" content="2" alt="2 of 5 bubbles"></span>',
    '<span class="ui_bubble_rating bubble_30 font-size-16" property="ratingValue" content="3" alt="3 of 5 bubbles"></span>',
    '<span class="ui_bubble_rating bubble_40 font-size-16" property="ratingValue" content="4" alt=\'4 of 5 bubbles\'></span>',
    '<span class="ui_bubble_rating bubble_50 font-size-16" property="ratingValue" content="5" alt=\'5 of 5 bubbles\'></span>'
];
var isMeal = 1;

function transportTour(_value){
    document.getElementById('sDiv').style.display = _value == 0 ? 'none' : 'inline-block';
    document.getElementById('eDiv').style.display = _value == 0 ? 'none' : 'inline-block';
    isTransport = _value;
}

function openMultiSelect(){
    if(multiIsOpen){
        $('#multiselect').hide();
        multiIsOpen = false;
    }
    else{
        $('#multiselect').show();
        multiIsOpen = true;
    }
}

function chooseMultiSelect(_id){
    var choose = 0;
    var text = '';

    for(i = 0; i < transports.length; i++){
        if(transports[i].id == _id){
            choose = transports[i];
            break;
        }
    }

    if(choose != 0)
        document.getElementById('multiSelectTransport_' + choose.id).style.display = 'none';


    text = '<div id="selectedMulti_' + choose.id + '" class="transportationKindChosenOnes col-xs-2">\n' + choose.name +
            '<span class="glyphicon glyphicon-remove" onclick="removeMultiSelect(' + choose.id + ')"></span>\n' +
            '</div>';
    $('#multiSelected').append(text);


    if(chooseSideTransport.includes(0)){
        index = chooseSideTransport.indexOf(0);
        chooseSideTransport[index] = choose.id;
    }
    else
        chooseSideTransport[chooseSideTransport.length] = choose.id;

}

function removeMultiSelect(_id){
    $('#selectedMulti_' + _id).remove();
    document.getElementById('multiSelectTransport_' + _id).style.display = 'block';

    if(chooseSideTransport.includes(_id)){
        index = chooseSideTransport.indexOf(_id);
        chooseSideTransport[index] = 0;
    }

    document.getElementById('sideTransport').value = JSON.stringify(chooseSideTransport);
}

$(window).on('click', function (e) {
    var target = $(e.target), article;

    if( multiIsOpen  && !target.is('.optionMultiSelect') && !target.is('#multiSelected')){
        openMultiSelect();
    }
});

