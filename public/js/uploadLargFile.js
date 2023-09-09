var readerLargeFileUploadedInJsFile = {};
var fileLargeFileUploadedInJsFile = {};
var sliceSizeLargeFileUploadedInJsFile = 500 * 1024;
var ajaxUrlLargeFile = "";
var callBackFunctionLargeFileUploadedInJsFile = null;
var inProcessLargeFileUploadedInJsFile = false;
var errorCountInLargeFileUploadedInJsFile = 5;
var cancelLargeFileUploadedInJsFile = 0;
var dataAddedLargeFileUploadedInJsFile = null;
var jwtToken = null;

function uploadLargeFile(_url, _files, _data, _callBackFunction, jt = null) {
    if (!inProcessLargeFileUploadedInJsFile) {
        ajaxUrlLargeFile = _url;
        fileLargeFileUploadedInJsFile = _files;
        inProcessLargeFileUploadedInJsFile = true;
        errorCountInLargeFileUploadedInJsFile = 5;
        callBackFunctionLargeFileUploadedInJsFile = _callBackFunction;
        readerLargeFileUploadedInJsFile = new FileReader();
        dataAddedLargeFileUploadedInJsFile = JSON.stringify(_data);
        jwtToken = jt;
        if (jt != null) {
            upload_fileLargeFile2();
        } else {
            upload_fileLargeFile(0, 0);
        }
        return true;
    } else _callBackFunction("queue");
}
function upload_fileLargeFile(start, _fileName) {
    console.log("upload_fileLargeFile");
    let isLast = false;
    let next_slice = start + sliceSizeLargeFileUploadedInJsFile + 1;
    let blob = fileLargeFileUploadedInJsFile.slice(start, next_slice);
    if (next_slice >= fileLargeFileUploadedInJsFile.size) isLast = true;

    readerLargeFileUploadedInJsFile.onloadend = function (event) {
        if (event.target.readyState !== FileReader.DONE) return;

        let data = {
            _token: csrfTokenGlobal,
            data: dataAddedLargeFileUploadedInJsFile,
            storeFileName: _fileName,
            file_name: fileLargeFileUploadedInJsFile.name,
            file_type: fileLargeFileUploadedInJsFile.type,
            cancelUpload: cancelLargeFileUploadedInJsFile,
            last: isLast,
            file_data: event.target.result,
        };
        // if (jwtToken !== null) {
        //     data = new FormData();
        //     data.append("pic", fileLargeFileUploadedInJsFile);
        // }

        $.ajax({
            url: ajaxUrlLargeFile,
            type: "POST",
            cache: false,
            dataType: "json",
            data: data,
            processData: false,
            contentType: false,
            headers:
                jwtToken === null
                    ? {}
                    : { Authorization: "Bearer " + jwtToken },
            error: function (jqXHR, textStatus, errorThrown) {
                errorCountInLargeFileUploadedInJsFile--;
                if (errorCountInLargeFileUploadedInJsFile <= 0) {
                    inProcessLargeFileUploadedInJsFile = false;
                    callBackFunctionLargeFileUploadedInJsFile("error");
                } else {
                    upload_fileLargeFile(start, _fileName);
                }
            },
            success: function (response) {
                if (
                    cancelLargeFileUploadedInJsFile == 1 &&
                    response.status == "canceled"
                ) {
                    inProcessLargeFileUploadedInJsFile = false;
                    callBackFunctionLargeFileUploadedInJsFile("cancelUpload");
                    cancelLargeFileUploadedInJsFile = 0;
                } else if (response.status == "ok") {
                    errorCountInLargeFileUploadedInJsFile = 5;
                    var size_done = start + sliceSizeLargeFileUploadedInJsFile;
                    var percent_done = Math.floor(
                        (size_done / fileLargeFileUploadedInJsFile.size) * 100
                    );

                    if (!isLast) {
                        upload_fileLargeFile(next_slice, response.fileName);
                        callBackFunctionLargeFileUploadedInJsFile(
                            percent_done,
                            "",
                            response.result
                        );
                    } else {
                        inProcessLargeFileUploadedInJsFile = false;
                        callBackFunctionLargeFileUploadedInJsFile(
                            "done",
                            response.fileName,
                            response.result
                        );
                    }
                } else {
                    errorCountInLargeFileUploadedInJsFile--;
                    if (errorCountInLargeFileUploadedInJsFile <= 0) {
                        inProcessLargeFileUploadedInJsFile = false;
                        callBackFunctionLargeFileUploadedInJsFile("error");
                    } else upload_fileLargeFile(start, _fileName);
                }
            },
        });
    };
    readerLargeFileUploadedInJsFile.readAsDataURL(blob);
}

function upload_fileLargeFile2() {
    data = new FormData();
    data.append("pic", fileLargeFileUploadedInJsFile);

    $.ajax({
        url: ajaxUrlLargeFile,
        type: "POST",
        cache: false,
        dataType: "json",
        data: data,
        processData: false,
        contentType: false,
        headers: { Authorization: jwtToken },
        error: function (jqXHR, textStatus, errorThrown) {
            errorCountInLargeFileUploadedInJsFile--;
            if (errorCountInLargeFileUploadedInJsFile <= 0) {
                inProcessLargeFileUploadedInJsFile = false;
                callBackFunctionLargeFileUploadedInJsFile("error");
            } else upload_fileLargeFile(0, 0);
        },
        success: function (response) {
            if (response.status == "0") {
                roomNum = response.id;
                errorCountInLargeFileUploadedInJsFile = 5;
                callBackFunctionLargeFileUploadedInJsFile(40, "");
                setTimeout(() => {
                    callBackFunctionLargeFileUploadedInJsFile(60, "");
                    setTimeout(() => {
                        callBackFunctionLargeFileUploadedInJsFile(90, "");
                        setTimeout(() => {
                            let namePic = response.data.split("_");
                            inProcessLargeFileUploadedInJsFile = false;
                            callBackFunctionLargeFileUploadedInJsFile(
                                "done",
                                namePic[namePic.length - 1],
                                roomNum
                            );
                        }, 1000);
                    }, 1000);
                }, 1000);
            }
        },
    });
}

function cancelLargeUploadedFile() {
    cancelLargeFileUploadedInJsFile = 1;
}
