
function checkAll(val) {

    if($(val).attr('data-val') == 'select') {
        $(":checkbox[name='checkedLogs[]']").prop('checked', true);
        $(val).attr('data-val', 'unSelect');
    }
    else {
        $("input[name='checkedLogs[]']").prop('checked', false);
        $(val).attr('data-val', 'select');
    }

}

function submitLogs() {

    var checkedValues = $("input:checkbox[name='checkedLogs[]']:checked").map(function() {
        return this.value;
    }).get();

    if(checkedValues.length == 0)
        return;
    
    $.ajax({
        type: 'post',
        url: submitLogsDir,
        data: {
            'logs': checkedValues
        },
        success: function (response) {
            if(response == "ok") {
                document.location.href = selfUrl;
            }
        }
    });
}

function deleteLogs() {

    var checkedValues = $("input:checkbox[name='checkedLogs[]']:checked").map(function() {
        return this.value;
    }).get();

    if(checkedValues.length == 0)
        return;

    $.ajax({
        type: 'post',
        url: deleteLogsDir,
        data: {
            'logs': checkedValues
        },
        success: function (response) {
            if(response == "ok") {
                document.location.href = selfUrl;
            }
        }
    });
}