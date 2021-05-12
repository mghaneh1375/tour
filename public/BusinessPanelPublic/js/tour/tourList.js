var tours = [];
var openEditIndex = null;
var deleteTourIndex = null;

function getTourList(){
    openLoading();
    $.ajax({
        type: 'GET',
        url: getListUrl,
        complete: closeLoading,
        success: response => {
            if(response.status == 'ok'){
                tours = response.result;
                createTourList();
            }
            else
                showSuccessNotifiBP('Server Error', 'left', 'red');
        },
        error: err => {
            showSuccessNotifiBP('Connection Error', 'left', 'red');
        }
    })
}

function createTourList(){
    var html = '';

    tours.map((item, index) => {
        html += `<tr>
                <td>${index + 1}</td>
                <td>${item.code}</td>
                <td> <a href="${item.url}" target="_blank">${item.name}</a> </td>
                <td>${item.typeName}</td>
                <td>${item.status}</td>
                <td>${item.timeCount}</td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary dropdown-toggle editButton" data-toggle="dropdown"> تنظیمات </button>
                        <div class="dropdown-menu" style="font-size: 12px">
                          <a class="dropdown-item" href="#" style="padding: 0px 5px;">ویرایش تاریخ های برگزاری تور</a>
                          <a class="dropdown-item" onclick="editTour(${index})" href="#" style="padding: 5px; margin: 5px 0;">ویرایش اطلاعات تور</a>
                          ${item.statusCode == -1 ? '' :
                            `<div class="dropdown-divider"></div>
                            <a class="dropdown-item" onclick="deleteTour(${index})" href="#" style="color: red;">حذف تور</a>`
                          }
                        </div>
                    </div>
                </td>
            </tr>`
    });

    // <a href="${getFullDataUrl}/${item.id}" class="circleButton yellowBut" title="اطلاعات کامل تور">
    //     <i class="fa-regular fa-info"></i>
    // </a>
    // <button class="circleButton editBut" title="ویرایش" onclick="editTour(${index})">
    //     <i class="fa-light fa-pen-to-square"></i>
    // </button>
    // <button class="circleButton deleteBut" title="حذف" onclick="deleteTour(${index})">
    //     <i class="fa-regular fa-trash-can"></i>
    // </button>

    document.getElementById('toursListTBody').innerHTML = html;
}

function editTour(_index){
    openEditIndex = _index;
    if(tours[openEditIndex].type === 'cityTourism')
        createEditModalBody(cityTourismEdit);

    $('#editTourModal').modal('show');
}

function createEditModalBody(list){
    let html = '';
    let inTour = tours[openEditIndex];
    list.forEach(item => {
        let minOfStage = 9999;
        let canEdit = undefined;
        if(inTour.remainingStage != null) {
            inTour.remainingStage.map(e => minOfStage = minOfStage > e ? e : minOfStage);
            canEdit = inTour.remainingStage.find(e => e == item.stage);
        }

        canEdit = (canEdit === undefined || canEdit == minOfStage);

        html += `<div class="editCard card${item.stage} ${canEdit ? '' : 'notAllow'}" onclick="goToEditPage(${item.stage})">
                    <div class="icon">${item.icon}</div>
                    <div class="name">
                        <div class="stage">${item.topTitle}</div>
                        <div class="text">${item.title}</div>
                    </div>
                </div>`;
    });

    document.getElementById('editModalSelectBody').innerHTML = html;
}

function goToEditPage(_stage){
    let minOfStage = 9999;
    let inTour = tours[openEditIndex];
    let canEdit = undefined;
    if(inTour.remainingStage != null) {
        inTour.remainingStage.map(e => minOfStage = minOfStage > e ? e : minOfStage);
        canEdit = inTour.remainingStage.find(e => e == _stage);
    }

    canEdit = (canEdit === undefined || canEdit == minOfStage);

    if(canEdit)
        openLoading(false, () => location.href = `${editTourUrl}/stage_${_stage}/${tours[openEditIndex].id}`);
    else{
        openErrorAlertBP('برای ویرایش این بخش ابتدا باید مراحل قبل را تکمیل کنید.');
    }
}

function deleteTour(_index){
    deleteTourIndex = _index;
    openWarningBP('ایا از حذف تور اطمینان دارید؟ در صورت حذف امکان بازگشت تور وجود ندارد', doDeleteTour, 'بله، پاک شود');
}

function doDeleteTour(){
    openLoading(false, () => {
        $.ajax({
            type: 'DELETE',
            url: deleteTourUrl,
            data: {
                _token: csrfTokenGlobal,
                tourId: tours[deleteTourIndex].id
            },
            success: response => {
                if(response.status == 'ok')
                    getTourList();
                else if(response.status == 'registered'){
                    closeLoading();
                    openErrorAlertBP('برای تور شما افرادی ثبت نام کرده اند و شما نمی توانید تور خود را حذف کنید.');
                }
                else if(response.status == 'notAccess'){
                    closeLoading();
                    openErrorAlertBP('شما دسترسی لازم برای حذف تور را ندارید.');
                }
                else{
                    closeLoading();
                    console.error(response.status);
                    showSuccessNotifiBP('Server Error', 'left', 'red')
                }
            },
            error: err => {
                closeLoading();
                console.error(err);
                showSuccessNotifiBP('Connection error', 'left', 'red')
            }
        })
    })
}

$(window).ready(() => {
    getTourList();
});
