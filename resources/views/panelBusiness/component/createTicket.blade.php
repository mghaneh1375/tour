<style>
    .createTicketModal .modal-footer{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .createTicketModal .modal-footer > button{
        margin: 0px 5px;
        border-radius: 24px;
        padding: 5px 25px;
    }
    .createTicketModal .specLabel{
        width: 110px;
        font-size: 14px;
    }
    .createTicketModal .specInput{
        color: black;
        background: #add8e645;
        border: none;
        border-radius: 25px;
        padding: 5px 15px;
    }
    .createTicketModal .specGroup{
        display: flex;
    }
    .createTicketModal .addFile{
        background: var(--koochita-light-green);
        color: white;
        padding: 3px 10px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        cursor: pointer;
    }
    .createTicketModal .filesSection{
        display: flex;
        flex-wrap: wrap;
    }
    .createTicketModal .filesSection .file{
        align-items: center;
        width: 100%;
        justify-content: space-between;
        display: flex;
        margin: 5px 0px;
        background: var(--koochita-yellow);
        padding: 4px 10px;
        border-radius: 20px;
    }
    .createTicketModal .filesSection .file .closeI{
        cursor: pointer;
        color: red;
        background: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        padding: 3px;
    }
    .createTicketModal .filesSection .file .name{

    }
</style>


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
                <button type="button" class="btn btn-success">ثبت</button>
                <button type="button" class="btn" data-dismiss="modal" style="background: #80808017;">بستن</button>
            </div>
        </div>
    </div>
</div>

<script>
    let ticketFiles = {};
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
            ticketFiles[ticketFileIndex] = {
                name: _input.files[0].name,
                file: _input.files[0]
            };
            ticketFileIndex++;
        }
    }

    function deleteThisTicketFile(_element){
        var ticketNumber = _element.getAttribute('data-name');
        ticketFiles[ticketNumber] = null;
        _element.parentElement.remove();
    }

    function submitNewTicket(){
        let title = document.getElementById('ticketTitle').value;
        let business = document.getElementById('ticketBusiness').value;
        let description = document.getElementById('ticketDescription').value;


    }




</script>
