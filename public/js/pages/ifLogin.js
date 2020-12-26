async function getMyTripsPromiseFunc(){
    var getMyTripsPromise = new Promise((myResolve, myReject) => {
        $.ajax({
            type: 'GET',
            url: window.GetMyTripsUrl,
            success: response => {
                if(response.status == 'ok')
                    myResolve(response.result);
                else
                    myReject(response.result);
            },
            error: err => myReject(err)
        })
    });

    return await getMyTripsPromise;
}

async function getMyBookMarkPromiseFunc(){
    var getMyPromise = new Promise((myResolve, myReject) => {
        $.ajax({
            type: 'GET',
            url: window.GetBookMarkUrl,
            success: response => {
                if(response.status == 'ok')
                    myResolve(response.result);
                else
                    myReject(response.result);
            },
            error: err => myReject(err)
        })
    });

    return await getMyPromise;
}

var searchInUserAjax;
async function searchForUserCommon(_value){
    var findUserPromise = new Promise((myResolve, myReject) => {
        if(searchInUserAjax != null)
            searchInUserAjax.abort();

        searchInUserAjax = $.ajax({
            type: 'GET',
            url: window.searchInUserUrl+'?username='+_value.trim(),
            success: response => {
                if(response.status == 'ok')
                    myResolve(response.result);
                else
                    myReject(response.status);
            },
        })
    });

    return await findUserPromise;
}

