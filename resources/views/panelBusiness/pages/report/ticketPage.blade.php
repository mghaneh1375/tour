@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>لیست درخواست ها</title>

    <style>
        .ticketBody .addNewTicket {
            background: var(--koochita-light-green);
            color: white;
            border: none;
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 25px;
            cursor: pointer;
        }

        .ticketBody .openTickerRow {
            background: var(--koochita-blue);
            border-radius: 10px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0px 15px;
            color: white;
        }

        .ticketBody .closeTickerRow {
            background: #cecece;
            border-radius: 10px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0px 9px;
            color: #00000080;
        }

        .ticketBody {
            display: flex;
            flex-direction: column;
        }

        .ticketBody.mainTicketBody {
            width: 100%;
            transition: .3s;
        }

        .ticketBody.ticketTextBody {
            width: 0px;
            padding: 0px;
            overflow: hidden;
            transition: .3s;
        }

        .ticketBody.mainTicketBody.less {
            width: 50%;
        }

        .ticketBody.mainTicketBody.less .closeWhenLess {
            display: none;
        }

        .ticketBody.mainTicketBody .newTicketCount {
            width: 20px;
            height: 20px;
            background: var(--koochita-blue);
            color: white;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
        }

        .ticketBody.ticketTextBody.show {
            width: calc(50% - 10px);
            padding: 10px;
            margin-right: 10px;
        }

        .ticketBody .ticketRow {
            cursor: pointer;
        }

        .ticketBody .ticketRow.selectedTicket {
            background: #4dc7bc3d;
        }

        .ticketBody.ticketTextBody .backBut {
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

        .ticketBody.ticketTextBody .writeTicket {
            width: 100%;
            display: flex;
            align-items: center;
            border-top: solid 1px lightgray;
            padding-top: 10px;
        }

        .ticketBody.ticketTextBody .ticketsBody {
            overflow: auto;
            padding-bottom: 15px;
            height: 100%;
        }

        .ticketBody.ticketTextBody .ticketMsgSec {
            display: flex;
            flex-direction: column;
            height: calc(100% - 40px);
        }

        .ticketBody.ticketTextBody .ticketsBody .mainTicketsBody {
            display: flex;
            flex-direction: column;
        }

        .ticketBody.ticketTextBody .ticketsBody .mainTicketsBody .msgBody {
            margin-bottom: 5px;
            background: #4dc7bc69;
            padding: 10px;
            border-radius: 15px;
            max-width: 90%;
            float: left;
            line-height: 20px;
            font-size: 14px;
            margin-right: auto;
            position: relative;
        }

        .ticketBody.ticketTextBody .ticketsBody .mainTicketsBody .msgBody.userBody {
            margin-left: auto;
            margin-right: 0;
            background: #e9e9e9;
        }

        .ticketBody.ticketTextBody .ticketsBody .mainTicketsBody .msgBody .text {}

        .ticketBody.ticketTextBody .ticketsBody .mainTicketsBody .msgBody .file {
            font-size: 45px;
            cursor: pointer;
            color: #404040;
            display: flex;
            align-items: center;
        }

        .ticketBody.ticketTextBody .ticketsBody .mainTicketsBody .msgBody .deleteThisTicket {
            position: absolute;
            left: -25px;
            top: calc(50% - 10px);
            background: red;
            color: white;
            width: 20px;
            height: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            cursor: pointer;
        }

        .ticketBody.ticketTextBody .ticketsBody .mainTicketsBody .time {
            margin-bottom: 15px;
            direction: ltr;
            font-weight: bold;
            color: #808080bf;
            font-size: 10px;
        }

        .ticketBody.ticketTextBody .ticketsBody .mainTicketsBody .userTime {
            margin-right: auto;
        }

        .ticketBody.ticketTextBody .ticketsBody .mainTicketsBody .adminTime {
            margin-left: auto;
        }


        .ticketBody.ticketTextBody .writeTicket .notAccessToSend {
            display: none;
            text-align: center;
            background: #fcc1568a;
            border-radius: 10px;
            padding: 3px 15px;
            margin: 0px auto;
            font-weight: bold;
            font-size: 23px;
        }

        .ticketBody.ticketTextBody .writeTicket.notAccess .notAccessToSend {
            display: flex;
        }

        .ticketBody.ticketTextBody .writeTicket .accessToSend {
            display: none;
        }

        .ticketBody.ticketTextBody .writeTicket.access .accessToSend {
            display: flex;
        }

        .ticketBody .writeTicket .accessToSend {
            width: 100%;
            background: #add8e645;
            padding: 5px;
            flex-direction: column;
            border-radius: 10px;
            position: relative;
        }

        .ticketBody .writeTicket .accessToSend .textInput {
            border: none;
            background: none;
            padding: 5px;
            height: 120px;
        }

        .ticketBody .writeTicket .accessToSend .bottom {
            display: flex;
            position: absolute;
            left: 5px;
            bottom: 5px;
        }

        .ticketBody .writeTicket .accessToSend .bottom .attachIcon {
            background: white;
            width: 40px;
            height: 40px;
            color: var(--koochita-blue);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transform: rotate(45deg);
            font-size: 20px;
            margin-left: 10px;
        }

        .ticketBody .writeTicket .accessToSend .bottom .sendBut {
            background: var(--koochita-blue);
            width: 40px;
            height: 40px;
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            font-size: 11px;
        }

        .ticketBody .ticketMsgSec .placeHoldersTicket .plTicket {
            width: 80%;
            height: 100px;
            margin-bottom: 13px;
            border-radius: 12px;
        }

        .ticketBody .ticketMsgSec .placeHoldersTicket .plTicket.left {
            margin-right: auto;
        }

        .ticketBody table td {
            font-size: 12px;
        }

        .ticketBody .closeThisTicketButton {
            margin-right: auto;
            font-size: 9px;
            color: white;
            background: red;
            padding: 3px 5px;
            border-radius: 10px;
            cursor: pointer;
            border: none;
        }
    </style>
@endsection


@section('body')
    <div style="display: flex; height: 100%;">
        <div class="mainBackWhiteBody ticketBody mainTicketBody">
            <div class="head" style="display: flex; align-items: center; justify-content: space-between;">
                <span>لیست درخواست ها</span>
                @if ($isAdmin == 0)
                    <button class="addNewTicket" onclick="openNewTicketModal()">
                        <i class="fa-regular fa-plus"></i>
                        <span>ایجاد درخواست جدید</span>
                    </button>
                @endif
            </div>
            <div style="overflow: auto;height: 100%;">
                <table class="table table-striped">
                    <thead style="background: var(--koochita-blue); color: white;">
                        <tr>
                            <td>#</td>
                            <td style="width: 50%">عنوان</td>
                            @if ($isAdmin === 1)
                                <td>نام درخواست دهنده</td>
                            @endif
                            <td>کسب و کار</td>
                            <td class="closeWhenLess">تاریخ</td>
                            <td>وضعیت</td>
                        </tr>
                    </thead>
                    <tbody id="ticketListTBody">
                        @foreach ($tickets as $ticket)
                            <tr id="ticketRow_{{ $ticket->id }}" class="ticketRow"
                                onclick="showThisTicket({{ $ticket->id }})">
                                <td>{{ $ticket->id }}</td>
                                <td id="subjectTicket_{{ $ticket->id }}">
                                    {{ $ticket->subject }}
                                    @if ($ticket->hasNew > 0)
                                        <span id="newTicketCount_{{ $ticket->id }}"
                                            class="newTicketCount">{{ $ticket->hasNew }}</span>
                                    @endif
                                </td>
                                @if ($isAdmin === 1)
                                    <td>{{ $ticket->user }}</td>
                                @endif
                                <td>{{ $ticket->businessName }}</td>
                                <td class="closeWhenLess" style="direction: ltr;">{{ $ticket->time }}</td>
                                <td style="display: flex;">
                                    @if ($ticket->close == 1)
                                        <div class="closeTickerRow"> بسته شده </div>
                                    @endif
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

                @if ($isAdmin === 1)
                    <button id="closeTicketButton" class="closeThisTicketButton" onclick="closeThisTicket()">اتمام
                        درخواست</button>
                @endif
            </div>

            <div class="ticketMsgSec">
                <div id="ticketsBody" class="ticketsBody">
                    <div id="placeHolderTikcetBody" class="placeHoldersTicket">
                        <div class="placeHolderAnime plTicket right"></div>
                        <div class="placeHolderAnime plTicket right"></div>
                        <div class="placeHolderAnime plTicket left"></div>
                        <div class="placeHolderAnime plTicket right"></div>
                    </div>
                    <div id="mainTicketsBody" class="mainTicketsBody"></div>
                </div>

                <div id="writeTicketSection" class="writeTicket">
                    <div class="notAccessToSend">این درخواست خاتمه یافته است.</div>
                    <div class="accessToSend">
                        <textarea id="newAnswerText" class="textInput" placeholder="پاسخ خود را اینجا بنویسید..."></textarea>
                        <div class="bottom">
                            <label for="fileToSend" class="attachIcon">
                                <i class="fa-light fa-paperclip"></i>
                            </label>
                            <input id="fileToSend" type="file" style="display: none;"
                                onchange="uploadFileForAnswer(this)">
                            <div class="sendBut" onclick="submitNewAnswerToTicket()">ارسال</div>
                        </div>
                    </div>
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
                    <h4 class="modal-title">ایجاد درخواست جدید</h4>
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group specGroup">
                                <label for="ticketTitle" class="specLabel">عنوان</label>
                                <input type="text" id="ticketTitle" class="form-control specInput"
                                    placeholder="عنوان درخواست را اینجا بنویسید...">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group specGroup">
                                <label for="ticketBusiness" class="specLabel">کسب و کار</label>
                                <select id="ticketBusiness" class="form-control specInput">
                                    <option value="free">آزاد</option>
                                    @foreach ($allOtherYourBusinessForHeader as $bs)
                                        <option value="{{ $bs->id }}">{{ $bs->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group specGroup">
                                <label for="ticketDescription" class="specLabel">توضیح</label>
                                <textarea id="ticketDescription" class="form-control specInput" rows="10"
                                    placeholder="توضیحات تکمیلی درخواست خود را اینجا بنویسید..."></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group specGroup">
                                <label class="specLabel">پیوست</label>
                                <label for="ticketFiles" class="addFile">
                                    <i class="fa-regular fa-plus"></i>
                                    <span>افزودن فایل</span>
                                </label>
                                <input type="file" id="ticketFiles"
                                    accept="application/zip,image/jpg,image/jpeg,image/png,application/rar,application/tar.zip"
                                    style="display: none" onchange="addNewFileToTicket(this)">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="ticketFilesSection" class="filesSection"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="submitNewTicket()">ثبت</button>
                    <button type="button" class="btn" data-dismiss="modal"
                        style="background: #80808017;">بستن</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        var nowTicketId = 0;
        let csrfTok = '{{ csrf_token() }}';
        @if ($isAdmin === 0)
            let getTicketUrl = '{{ url('ticket/user/get/') }}';
            let ticketStoreUrl = '{{ route('ticket.user.store') }}';
            let deleteTicketUrl = '{{ route('ticket.user.delete') }}';
        @else
            let getTicketUrl = '{{ url('ticket/admin/get/') }}';
            let ticketStoreUrl = '{{ route('ticket.admin.store') }}';
            let closeTicketUrl = '{{ route('ticket.admin.close') }}';
            let deleteTicketUrl = '#';

            function closeThisTicket() {
                if (confirm('ایا می خواهید این درخواست را خاتمه بدهید؟ توجه کنید پس از خاتمه امکان بازگشت وجود ندارد')) {
                    openLoading();
                    $.ajax({
                        type: 'POST',
                        url: closeTicketUrl,
                        data: {
                            _token: csrfTok,
                            id: nowTicketId
                        },
                        success: response => {
                            if (response.status === 'ok')
                                location.reload();
                            else
                                showSuccessNotifiBP('در اتمام به درخواست مشکلی پیش امد', 'left',
                                    'var(--koochita-blue)');
                        },
                        error: err => {
                            showSuccessNotifiBP('در اتمام به درخواست مشکلی پیش امد', 'left',
                                'var(--koochita-blue)');
                            console.error(err);
                        }
                    })
                }
            }
        @endif
    </script>
    <script src="{{ URL::asset('BusinessPanelPublic/js/report/ticketPage.js') }}"></script>
@endsection
