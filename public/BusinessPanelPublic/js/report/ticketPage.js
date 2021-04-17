
let ticketFiles = [];
let ticketFileIndex = 0;
let getTicketsAjax = null;

function openNewTicketModal(_business = 'free'){
    $('#createTicketModal').modal('show');
    document.getElementById('ticketBusiness').value = _business;
}

function addNewFileToTicket(_input){
    if(_input.files && _input.files[0]){
        let fileRow = `<div class="file">
                                <i class="closeI fa-regular fa-trash-can" data-name="${ticketFileIndex}" onclick="deleteThisTicketFile(this)"></i>
                                <span class="name">${_input.files[0].name}</span>
                            </div>`;

        $('#ticketFilesSection').append(fileRow);
        ticketFiles.push({
            send: false,
            name: _input.files[0].name,
            file: _input.files[0]
        });
        ticketFileIndex++;
    }
}

function deleteThisTicketFile(_element){
    var ticketNumber = _element.getAttribute('data-name');
    ticketFiles[ticketNumber] = null;
    _element.parentElement.remove();
}

function submitNewTicket(){
    let subject = document.getElementById('ticketTitle').value;
    let businessId = document.getElementById('ticketBusiness').value;
    let description = document.getElementById('ticketDescription').value;
    let errors = [];

    if(subject.trim().length == 0)
        errors.push('عنوان درخواست خود را مشخص کنید');

    if(description.trim().length == 0)
        errors.push('برای پشتیبانی بهتر، توضیح بنویسید');

    if(errors.length == 0){
        openLoading();
        $.ajax({
            type: 'POST',
            url: ticketStoreUrl,
            data: {
                _token: csrfTok,
                subject,
                description,
                ticketId: 0,
                businessId,
            },
            success: response =>{
                if(response.status === 'ok'){
                    if(ticketFiles.length > 0)
                        doUploadFiles(response.result);
                    else {
                        closeLoading();
                        showSuccessNotifiBP('درخواست شما با موفقیت ثبت شد.', 'left', 'var(--koochita-blue)');
                        location.reload();
                    }
                }
                else{
                    closeLoading();
                    alert('در ثبت درخواست مشکلی پیش امده، دوباره تلاش کنید');
                    console.log(err);
                }
            },
            error: err =>{
                closeLoading();
                alert('در ثبت درخواست مشکلی پیش امده، دوباره تلاش کنید');
                console.log(err);
            }
        })
    }
    else{
        let errorText = '';
        errors.map(err => errorText += `<li>${err}</li>`);
        errorText = `<ul>${errorText}</ul>`;
        openErrorAlertBP(errorText);
    }
}

function doUploadFiles(_parentId){
    openLoading();
    var errorFiles = [];
    var sendFileIndex = null;

    for(let i = 0; i < ticketFiles.length; i++){
        if(ticketFiles[i] != null && ticketFiles[i].send === false){
            sendFileIndex = i;
            break;
        }
        if(ticketFiles[i] != null && ticketFiles[i].send === 'error')
            errorFiles.push(ticketFiles[i].name);
    }

    if(sendFileIndex != null){
        var data = new FormData();
        data.append('_token', csrfTok);
        data.append('ticketId', _parentId);
        data.append('file', ticketFiles[sendFileIndex].file);

        $.ajax({
            type: 'POST',
            url: ticketStoreUrl,
            data,
            processData: false,
            contentType: false,
            complete: () => {
                setTimeout(() => {
                    if(ticketFiles.length > 0)
                        doUploadFiles(_parentId);
                }, 200);
            },
            success: response => ticketFiles[sendFileIndex].send = response.status === 'ok' ? true : 'error',
            error: err => ticketFiles[sendFileIndex].send = 'error'
        })
    }
    else {
        closeLoading();
        if(errorFiles.length === 0) {
            showSuccessNotifiBP('درخواست شما با موفقیت ثبت شد.', 'left', 'var(--koochita-blue)');
            location.reload();
        }
        else{
            let errorText = '';
            errorFiles.map(err => errorText += `<li>${err}</li>`);
            errorText = `<div>درخواست با موفقیت ثبت شد، اما در بارگذاری فایل های زیر مشکلی پیش امده.</div><ul>${errorText}</ul>`;
            openWarningBP(errorText, () => {
                location.reload();
            });
        }
    }
}

function showThisTicket(_id){
    if(nowTicketId != 0)
        document.querySelector('.selectedTicket').classList.remove('selectedTicket');

    if(document.getElementById(`newTicketCount_${_id}`))
        document.getElementById(`newTicketCount_${_id}`).remove();

    document.querySelector('.mainTicketBody').classList.add('less');
    document.querySelector('.ticketTextBody').classList.add('show');
    document.getElementById('tickHeader').innerText = document.getElementById(`subjectTicket_${_id}`).innerText;

    document.getElementById(`ticketRow_${_id}`).classList.add('selectedTicket');
    nowTicketId = _id;
    getTicketsMsg();
}

function closeTicketMsg(){
    document.querySelector('.mainTicketBody').classList.remove('less');
    document.querySelector('.ticketTextBody').classList.remove('show');
    document.querySelector('.selectedTicket').classList.remove('selectedTicket');
    nowTicketId = 0;
}

function getTicketsMsg(){

    document.getElementById('placeHolderTikcetBody').classList.remove('hidden');
    document.getElementById('mainTicketsBody').classList.add('hidden');

    if(getTicketsAjax != null)
        getTicketsAjax.abort();

    getTicketsAjax = $.ajax({
        type: 'GET',
        url: `${getTicketUrl}/${nowTicketId}`,
        success: response =>{
            if(response.status == 'ok'){
                createMsgCards(response.result);

                if(response.isClose == 1) {
                    $('#writeTicketSection').addClass('notAccess').removeClass('access');
                    if(document.getElementById('closeTicketButton'))
                        document.getElementById('closeTicketButton').classList.add('hidden');
                }
                else {
                    $('#writeTicketSection').addClass('access').removeClass('notAccess');
                    if(document.getElementById('closeTicketButton'))
                        document.getElementById('closeTicketButton').classList.remove('hidden');
                }

            }
        },
        error: err => {
            // closeTicketMsg();
        }
    });
}

function createMsgCards(_msg){
    let html = '';
    _msg.map(item => {
        html += `<div class="msgBody ${item.whoSend == 'user' ? 'userBody' : 'adminBody'}">
                            ${item.hasFile == 1 ?
            `<a href="${item.fileUrl}" download="${item.fileName}" class="file">
                                    <i class="fa-solid fa-file"></i>
                                    <div class="fileName" style="font-size: 15px; margin-right: 10px;">${item.fileName}</div>
                                </a>` :
            `<div class="text">${item.msg}</div>`
        }
                            ${
            (item.whoSend === 'user' && item.canDelete == 1 && item.close == 0) ?
                `<div class="deleteThisTicket" onclick="deleteThisTicket(${item.id})">
                                        <i class="fa-regular fa-xmark"></i>
                                    </div>` : ''
        }
                        </div>`;

        html += `<div class="time ${item.whoSend == 'user' ? 'userTime' : 'adminTime'}">${item.time}</div>`
    });

    document.getElementById('placeHolderTikcetBody').classList.add('hidden');
    document.getElementById('mainTicketsBody').classList.remove('hidden');
    document.getElementById('mainTicketsBody').innerHTML = html;

    var myDiv = document.getElementById("ticketsBody");
    myDiv.scrollTop = myDiv.scrollHeight;
}

function uploadFileForAnswer(_input){
    if(_input.files && _input.files[0]){
        var data = new FormData();
        data.append('_token', csrfTok);
        data.append('ticketId', nowTicketId);
        data.append('file', _input.files[0]);

        openLoading(true, () => {
            $.ajax({
                type: 'POST',
                url: ticketStoreUrl,
                data,
                processData: false,
                contentType: false,
                xhr: function () {
                    var xhr = new XMLHttpRequest();
                    xhr.upload.onprogress = e => {
                        if (e.lengthComputable) {
                            var percent = Math.round((e.loaded / e.total) * 100);
                            updatePercentLoadingBar(percent)
                        }
                    };
                    return xhr;
                },
                complete: closeLoading,
                success: response => {
                    if(response.status === 'ok'){
                        showSuccessNotifiBP('فایل شما با موفقیت بارگذاری شد.', 'left', 'var(--koochita-blue)');
                        getTicketsMsg();
                    }
                    else
                        showSuccessNotifiBP('در بارگذاری فایل مشکلی پیش امده دوباره تلاش کنید.', 'left', 'red');
                },
                error: err => {
                    console.error(err);
                    showSuccessNotifiBP('در بارگذاری فایل مشکلی پیش امده دوباره تلاش کنید.', 'left', 'red');
                }
            })
        });
    }
}

function submitNewAnswerToTicket(){
    let description = document.getElementById('newAnswerText').value;
    if(description.trim().length == 0)
        return;

    openLoading();
    $.ajax({
        type: 'POST',
        url: ticketStoreUrl,
        data: {
            _token: csrfTok,
            ticketId: nowTicketId,
            description: description,
        },
        complete: closeLoading,
        success: response => {
            if(response.status === 'ok'){
                document.getElementById('newAnswerText').value = '';
                showSuccessNotifiBP('پاسخ شما با موفقیت ثبت شد.', 'left', 'var(--koochita-blue)');
                getTicketsMsg();
            }
            else if(response.status === 'closed')
                showSuccessNotifiBP('این درخواست بسته شده است و امکان ارسال پاسخ وجود ندارد.', 'left', 'red');
            else
                showSuccessNotifiBP('در ثبت پاسخ مشکلی پیش امده دوباره تلاش کنید.', 'left', 'red');
        },
        error: err => {
            console.error(err);
            showSuccessNotifiBP('در ثبت پاسخ مشکلی پیش امده دوباره تلاش کنید.', 'left', 'red');
        }
    })
}

function deleteThisTicket(_id){
    openWarningBP('آیا می خواهید این پیام را پاک کنید؟', function() {
        openLoading();
        $.ajax({
            type: 'DELETE',
            url: deleteTicketUrl,
            data: {
                _token: csrfTok,
                id: _id
            },
            complete: closeLoading,
            success: response => {
                if(response.status === 'ok'){
                    showSuccessNotifiBP('پیام مورد نظر با موفقیت حذف شد.', 'left', 'var(--koochita-blue)');
                    getTicketsMsg();
                }
                else
                    showSuccessNotifiBP('در حذف پیام مشکلی پیش امده دوباره تلاش کنید.', 'left', 'red');
            },
            error: err => {
                console.error(err);
                showSuccessNotifiBP('در حذف پیام مشکلی پیش امده دوباره تلاش کنید.', 'left', 'red');
            }
        })
    }, 'بله، پاک شود');
}
