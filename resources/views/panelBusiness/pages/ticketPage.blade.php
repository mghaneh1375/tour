@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>لیست درخواست ها</title>

    <style>
        .ticketBody .addNewTicket{
            background: var(--koochita-light-green);
            color: white;
            border: none;
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 25px;
            cursor: pointer;
        }

        .ticketBody .openTickerRow{
            background: var(--koochita-blue);
            border-radius: 10px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0px 15px;
            color: white;
        }
        .ticketBody .closeTickerRow{
            background: #cecece;
            border-radius: 10px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0px 9px;
            color: #00000080;
        }

        .ticketBody{
            display: flex;
            flex-direction: column;
        }
        .ticketBody.mainTicketBody{
            width: 100%;
            transition: .3s;
        }
        .ticketBody.ticketTextBody{
            width: 0px;
            padding: 0px;
            overflow: hidden;
            transition: .3s;
        }
        .ticketBody.mainTicketBody.less{
            width: 50%;
        }
        .ticketBody.mainTicketBody.less .closeWhenLess{
            display: none;
        }
        .ticketBody.ticketTextBody.show{
            width: calc(50% - 10px);
            padding: 10px;
            margin-right: 10px;
        }

        .ticketBody .ticketRow{
            cursor: pointer;
        }
        .ticketBody .ticketRow.selectedTicket{
            background: #4dc7bc3d;
        }

        .ticketBody.ticketTextBody .backBut{
            display: flex;
            justify-content: center;
            align-items: center;
            width: 30px;
            background: var(--koochita-blue);
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            color: white;
            margin-left: 10px;
            box-shadow: -1px 1px 2px 1px #00000094;
        }
        .ticketBody.ticketTextBody .writeTicket{
            width: 100%;
            height: 50px;
            display: flex;
            align-items: center;
            border-top: solid 1px lightgray;
            padding-top: 10px;
        }
        .ticketBody.ticketTextBody .ticketsBody{
            overflow: auto;
            padding-bottom: 15px;
            height: 100%;
        }
        .ticketBody.ticketTextBody .ticketMsgSec{
            display: flex;
            flex-direction: column;
            height: calc(100% - 40px);
        }

        .ticketBody.ticketTextBody .ticketsBody .mainTicketsBody{
            display: flex;
            flex-direction: column;
        }
        .ticketBody.ticketTextBody .ticketsBody .mainTicketsBody .msgBody{
            margin-bottom: 5px;
            background: #4dc7bc69;
            padding: 15px;
            border-radius: 15px;
            max-width: 90%;
            float: left;
            line-height: 20px;
            font-size: 14px;
            margin-right: auto;
        }
        .ticketBody.ticketTextBody .ticketsBody .mainTicketsBody .msgBody.userBody{
            margin-left: auto;
            margin-right: 0;
            background: #e9e9e9;
        }
        .ticketBody.ticketTextBody .ticketsBody .mainTicketsBody .msgBody .text{

        }
        .ticketBody.ticketTextBody .ticketsBody .mainTicketsBody .msgBody .file{
            font-size: 80px;
            cursor: pointer;
            color: #404040;
        }
        .ticketBody.ticketTextBody .ticketsBody .mainTicketsBody .time{
            margin-bottom: 15px;
            direction: ltr;
            font-weight: bold;
            color: #808080bf;
        }
        .ticketBody.ticketTextBody .ticketsBody .mainTicketsBody .userTime{
            margin-right: auto;
        }
        .ticketBody.ticketTextBody .ticketsBody .mainTicketsBody .adminTime{
            margin-left: auto;
        }
    </style>
@endsection


@section('body')
    <div style="display: flex; height: 100%;">
        <div class="mainBackWhiteBody ticketBody mainTicketBody">
            <div class="head" style="display: flex; align-items: center; justify-content: space-between;">
                <span>لیست درخواست ها</span>
                <button class="addNewTicket" onclick="openNewTicketModal()">
                    <i class="fa-regular fa-plus"></i>
                    <span>ایجاد درخواست جدید</span>
                </button>
            </div>
            <div style="overflow: auto;height: 100%;">
                <table class="table table-striped">
                    <thead style="background: var(--koochita-blue); color: white;">
                    <tr>
                        <td>#</td>
                        <td style="width: 50%">عنوان</td>
                        <td>کسب و کار</td>
                        <td class="closeWhenLess">تاریخ</td>
                        <td>وضعیت</td>
                    </tr>
                    </thead>
                    <tbody id="ticketListTBody">
                    @foreach($tickets as $ticket)
                        <tr id="ticketRow_{{$ticket->id}}" class="ticketRow" onclick="showThisTicket({{$ticket->id}})">
                            <td>{{$ticket->id}}</td>
                            <td id="subjectTicket_{{$ticket->id}}">{{$ticket->subject}}</td>
                            <td>{{$ticket->businessName}}</td>
                            <td class="closeWhenLess" style="direction: ltr;">{{$ticket->time}}</td>
                            <td style="display: flex;">
                                <div class="{{$ticket->close == 1 ? 'closeTickerRow' : 'openTickerRow'}}">
                                    {{$ticket->closeType}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mainBackWhiteBody ticketBody ticketTextBody">
            <div class="head" style="display: flex; align-items: center; width: 100%;">
                <span class="backBut" onclick="closeTicketMsg()">
                    <i class="fa-solid fa-arrow-right"></i>
                </span>
                <span id="tickHeader">عنوان درخواست</span>
            </div>

            <div class="ticketMsgSec">
                <div class="ticketsBody">
                    <div class="placeHoldersTicket">

                    </div>

                    <div id="mainTicketsBody" class="mainTicketsBody"></div>
                </div>

                <style>
                    .ticketBody.ticketTextBody .writeTicket .notAccessToSend{
                        display: none;
                        text-align: center;
                        background: #fcc1568a;
                        border-radius: 10px;
                        padding: 3px 15px;
                        margin: 0px auto;
                        font-weight: bold;
                        font-size: 23px;
                    }
                    .ticketBody.ticketTextBody .writeTicket.notAccess .notAccessToSend{
                        display: flex;
                    }
                    .ticketBody.ticketTextBody .writeTicket .accessToSend{
                        display: none;
                    }
                    .ticketBody.ticketTextBody .writeTicket.access .accessToSend{
                        display: flex;
                    }
                </style>

                <div id="writeTicketSection" class="writeTicket">
                    <div class="notAccessToSend">این تیکت خاتمه یافته است.</div>
                    <div class="accessToSend">بفرست</div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modals')

    <div id="createTicketModal" class="modal createTicketModal">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">ایجاد تیکت جدید</h4>
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group specGroup">
                                <label for="ticketTitle" class="specLabel">عنوان</label>
                                <input type="text" id="ticketTitle" class="form-control specInput" placeholder="عنوان تیکت را اینجا بنویسید...">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group specGroup">
                                <label for="ticketBusiness" class="specLabel">کسب و کار</label>
                                <select id="ticketBusiness" class="form-control specInput">
                                    <option value="free">آزاد</option>
                                    @foreach($allOtherYourBusinessForHeader as $bs)
                                        <option value="{{$bs->id}}">{{$bs->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group specGroup">
                                <label for="ticketDescription" class="specLabel">توضیح</label>
                                <textarea id="ticketDescription" class="form-control specInput" rows="10" placeholder="توضیحات تکمیلی تیکت خود را اینجا بنویسید..."></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group specGroup">
                                <label class="specLabel">پیوست</label>
                                <label for="ticketFiles" class="addFile">
                                    <i class="fa-regular fa-plus"></i>
                                    <span>افزودن فایل</span>
                                </label>
                                <input type="file" id="ticketFiles" accept="application/zip,image/jpg,image/jpeg,image/png,application/rar,application/tar.zip" style="display: none" onchange="addNewFileToTicket(this)">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="ticketFilesSection" class="filesSection"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="submitNewTicket()">ثبت</button>
                    <button type="button" class="btn" data-dismiss="modal" style="background: #80808017;">بستن</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let ticketFiles = [];
        let ticketFileIndex = 0;

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
                errors.push('عنوان تیکت خود را مشخص کنید');

            if(description.trim().length == 0)
                errors.push('برای پشتیبانی بهتر، توضیح بنویسید');

            if(errors.length == 0){
                openLoading();
                $.ajax({
                    type: 'POST',
                    url: '{{route("ticket.store")}}',
                    data: {
                        _token: '{{csrf_token()}}',
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
                                showSuccessNotifiBP('تیکت شما با موفقیت ثبت شد.', 'left', 'var(--koochita-blue)');
                                location.reload();
                            }
                        }
                        else{
                            closeLoading();
                            alert('در ثبت تیکت مشکلی پیش امده، دوباره تلاش کنید');
                            console.log(err);
                        }
                    },
                    error: err =>{
                        closeLoading();
                        alert('در ثبت تیکت مشکلی پیش امده، دوباره تلاش کنید');
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
                data.append('_token', '{{csrf_token()}}');
                data.append('ticketId', _parentId);
                data.append('file', ticketFiles[sendFileIndex].file);

                $.ajax({
                    type: 'POST',
                    url: '{{route("ticket.store")}}',
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
                    showSuccessNotifiBP('تیکت شما با موفقیت ثبت شد.', 'left', 'var(--koochita-blue)');
                    location.reload();
                }
                else{
                    let errorText = '';
                    errorFiles.map(err => errorText += `<li>${err}</li>`);
                    errorText = `<div>تیکت با موفقیت ثبت شد، اما در بارگزاری فایل های زیر مشکلی پیش امده.</div><ul>${errorText}</ul>`;
                    openWarningBP(errorText, () => {
                        location.reload();
                    });
                }
            }
        }
    </script>
@endsection


@section('script')
    <script>
        let lastTicketId = 0;
        function showThisTicket(_id){
            if(lastTicketId != 0)
                document.querySelector('.selectedTicket').classList.remove('selectedTicket');



            document.querySelector('.mainTicketBody').classList.add('less');
            document.querySelector('.ticketTextBody').classList.add('show');
            document.getElementById('tickHeader').innerText = document.getElementById(`subjectTicket_${_id}`).innerText;

            document.getElementById(`ticketRow_${_id}`).classList.add('selectedTicket');
            lastTicketId = _id;
            getTicketsMsg(_id);
        }

        function closeTicketMsg(){
            document.querySelector('.mainTicketBody').classList.remove('less');
            document.querySelector('.ticketTextBody').classList.remove('show');
            document.querySelector('.selectedTicket').classList.remove('selectedTicket');
            lastTicketId = 0;
        }


        function getTicketsMsg(_id){
            openLoading();
            $.ajax({
                type: 'GET',
                url: `{{url("ticket/user/get/")}}/${_id}`,
                complete: closeLoading,
                success: response =>{
                    if(response.status == 'ok'){
                        if(response.isClose == 1) $('#writeTicketSection').addClass('notAccess').removeClass('access');
                        else $('#writeTicketSection').addClass('access').removeClass('notAccess');

                        createMsgCards(response.result);
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
                                    <div class="fileName" style="font-size: 15px;">${item.fileName}</div>
                                </a>` :
                                `<div class="text">${item.msg}</div>`
                            }
                        </div>`;

                html += `<div class="time ${item.whoSend == 'user' ? 'userTime' : 'adminTime'}">${item.time}</div>`
            });

            document.getElementById('mainTicketsBody').innerHTML = html;
        }
    </script>
@endsection


