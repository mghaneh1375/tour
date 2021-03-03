var searchInCityAccountInfoAjax = null;
var reminderTime;


function openSearchFindCityFormAccountInfo(){
    createSearchInput(searchCityForAccountInfo, 'نام شهر را وارد کنید.');
}

function searchCityForAccountInfo(_element) {
    var value = _element.value;
    if(value.trim().length > 1){
        if(searchInCityAccountInfoAjax != null)
            searchInCityAccountInfoAjax.abort();

        searchInCityAccountInfoAjax = $.ajax({
            type: 'POST',
            url: searchForCityAccountInfoUrl,
            data: {
                _token: csrfTokenGlobal,
                key:  value,
                village: 1
            },
            success: function (response) {
                var html = "";
                response = JSON.parse(response);
                response.map(item =>{
                    html += `<div onclick="chooseThisCityForAccountInfo('${item.cityName}', ${item.id})" class="articleCityResultRow">
                                            <div class="icons location spIcons" style="display: inline"></div>
                                            <p class="suggest cursor-pointer font-weight-700" style="margin: 0px; display: inline;">${item.isVillage == 0 ? 'شهر' : 'روستا'} ${item.cityName}</p>
                                            <p class="suggest cursor-pointer stateName">${item.stateName}</p>
                                        </div>`;
                });
                setResultToGlobalSearch(html);
            }
        });
    }
    else
        clearGlobalResult();
}

function chooseThisCityForAccountInfo(_cityName, _id){
    closeSearchInput();
    $("#cityName").val(_cityName);
    $("#cityId").val(_id);
}

function changeUserName(){
    var username = $('#userNameFieldInput').val();

    if(username.trim().length > 3){
        $('#usernameError').empty();

        openLoading(false, () => {
            $.ajax({
                type: 'POST',
                url: editUsernameAccountInfoUrl,
                data: {
                    _token: csrfTokenGlobal,
                    username: username
                },
                complete: closeLoading,
                success: response =>{
                    if(response.status == 'ok')
                        showSuccessNotifi('نام کاربری با موفقیت تغییر یافت', 'left', 'var(--koochita-blue)');
                    else if(response.status == 'duplicate') {
                        showSuccessNotifi('خطا', 'left', 'red');
                        $('#usernameError').html('<div style="color: red">نام کاربری تکراری می باشد</div>');
                    }
                    else
                        showSuccessNotifi('خطا', 'left', 'red');
                },
                error: err =>{
                    showSuccessNotifi('خطا', 'left', 'red');
                }
            });
        });
    }
    else{
        $('#usernameError').html('<div style="color: red">نام کاربری باید بیش از 3 حرف داشته باشد</div>');
    }
}

function changeUserPhoneNumber() {
    var phoneErrorElement = $('#phoneError');
    var phone = $('#phoneAccountInfoInput').val();

    if(phone.length === 11 && phone[0] == '0' && phone[1] == '9') {
        openLoading(false, () => {

            phoneErrorElement.empty();
            $.ajax({
                type: 'POST',
                url: checkPhoneAccountInfoUrl,
                data: {
                    _token: csrfTokenGlobal,
                    phoneNum: phone,
                    sendCode: 1
                },
                complete: closeLoading,
                success: response => {
                    if(response == 'nok'){
                        showSuccessNotifi('خطا', 'left', 'red');
                        phoneErrorElement.html('<div style="color: red">شماره تماس وارد شده تکراری می باشد</div>');
                    }
                    else{
                        try{
                            response = JSON.parse(response);
                            if(response.status == 'ok'){
                                $('#sendPhoneNumber').text(phone);
                                $('#phoneEnterRow').addClass('hidden');
                                $('#phoneVerificationCode').removeClass('hidden');
                                $("#resendPhoneCodeButton").prop('disabled', true);

                                decreaseTime(response.reminder);
                            }
                            else if(response.status == 'nok3')
                                showSuccessNotifi('خطا در ارسال پیامک', 'left', 'red');
                        }
                        catch (e) {
                            showSuccessNotifi('خطا', 'left', 'red');
                        }
                    }
                }
            });
        })
    }
    else
        phoneErrorElement.html('<div style="color: red">شماره تماس خود را به درستی وارد نمایید</div>');
}

function checkPhoneVerifyCode(){
    var code = $('#activationCode').val();
    var phone = $('#phoneAccountInfoInput').val();

    if(code.trim().length > 1 && phone.length === 11 && phone[0] == '0' && phone[1] == '9'){
        $('#phoneError').empty();

        openLoading(false, () => {
            $.ajax({
                type: 'POST',
                url: editPhoneNumberAccountInfoUrl,
                data: {
                    _token: csrfTokenGlobal,
                    phoneNum: phone,
                    code: code
                },
                complete: closeLoading,
                success: response => {
                    if(response.status == 'ok'){
                        showSuccessNotifi('شماره تماس شما با موفقیت تغییر یافت', 'left', 'var(--koochita-blue)');

                        $('#phoneEnterRow').removeClass('hidden');
                        $('#phoneVerificationCode').addClass('hidden');
                        $("#resendPhoneCodeButton").prop('disabled', true);
                    }
                    else if(response.status == 'duplicate'){
                        $('#phoneError').html('<div style="color: red">شماره وارد شده تکراری می باشد</div>');
                        showSuccessNotifi('شماره وارد شده تکراری می باشد', 'left', 'red');
                    }
                    else if(response.status == 'wrong'){
                        $('#phoneError').html('<div style="color: red">کد وارد شده اشتباه می باشد</div>');
                        showSuccessNotifi('کد وارد شده اشتباه می باشد', 'left', 'red');
                    }
                    else if(response.status == 'expire'){
                        changeUserPhoneNumber();
                        showSuccessNotifi('کد تایید مجددا برای شما ارسال شد', 'left', 'red');
                    }
                },
                error: err => {
                    showSuccessNotifi('خطا', 'left', 'red');
                }
            })
        });
    }
}

function decreaseTime(_time) {
    var min = _time % 60;
    var second = Math.floor(_time / 60);
    second = (second < 10 ? '0' : '') + second;

    $("#remainderTimeForPhoneVerify").text(`${second}:${min}`);

    if(_time > 0) {
        _time -= 1;
        setTimeout(() => decreaseTime(_time), 1000);
    }
    else
        $("#resendPhoneCodeButton").removeAttr('disabled');
}

function updateGeneralInfo(){
    var firstName = $('#firstName').val();
    var lastName = $('#lastName').val();
    var cityId = $('#cityId').val();
    var gender = $('#genderAccountInfoInput').val();
    var age = $('#ageAccountInfoInput').val();
    var introduction = $('#introduceYourSelfTextBox').val();

    openLoading(false, () => {
        $.ajax({
            type: 'POST',
            url: editGeneralInfoAccountInfoUrl,
            data: {
                _token: csrfTokenGlobal,
                firstName,
                lastName,
                cityId,
                gender,
                age,
                introduction,
            },
            complete: closeLoading,
            success: response => {
                if(response.status == 'ok')
                    showSuccessNotifi('اطلاعات شما با موفقیت ثبت شدند', 'left', 'var(--koochita-blue)');
                else
                    showSuccessNotifi('خطا', 'left', 'red');
            },
            error: err => {
                showSuccessNotifi('خطا', 'left', 'red');
            }
        })
    });
}

function doEditSocialInfo(){
    var email = $('#emailAccountInfoInput').val();
    var instagram = $('#instagramAccountInfoInput').val();

    openLoading(false, () => {
        $('#socialError').empty();
        $.ajax({
            type: 'POST',
            url: editSocialInfoAccountInfoUrl,
            data: {
                _token: csrfTokenGlobal,
                email,
                instagram
            },
            complete: closeLoading,
            success: response =>{
                if(response.status === 'ok'){
                    showSuccessNotifi('اطلاعات شما با موفقیت ثبت شدند', 'left', 'var(--koochita-blue)');
                }
                else {
                    var error = '';
                    showSuccessNotifi('خطا', 'left', 'red');
                    if(response['result'].indexOf('emailDuplicate') > -1){
                        error += '<div style="color: red; margin-bottom: 3px">ایمیل وارد شده تکراری می باشد</div>';
                    }
                    if(response['result'].indexOf('instagramDuplicate') > -1){
                        error += '<div style="color: red; margin-bottom: 3px">اکانت اینستاگرام وارد شده تکراری می باشد</div>';
                    }

                    $('#socialError').html(error);
                }
            },
            error: err =>{
                showSuccessNotifi('خطا', 'left', 'red');
            }
        });
    })
}
