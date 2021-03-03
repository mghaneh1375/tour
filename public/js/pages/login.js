var pas = "";
var back = "";
var email = "";
var username = "";
var phoneNum = "";
var selectedUrl = "";
var reminderTime = 0;
var reminderTime2 = 0;
var phoneCodeRegister = null;

var callBackAfterLogin = null;

function showLoginEmail() {
    $('#loginPopUp').addClass('hidden');
    $('#EnterEmail-loginPopUp').removeClass('hidden');
}

function firstRegisterStep() {
    let name = $('#username_register').val();
    let emailPhone = $('#emailPhone_register').val();
    let password = $('#password_register').val();
    $('.registerErr').html('');

    if (name.trim().length > 0 && emailPhone.trim().length > 0 && password.trim().length > 0) {

        let kind = 'email';
        if (!emailPhone.includes('@')) {
            let phone = convertNumberToEn(emailPhone);
            if (!(phone.trim().length == 11 && phone[0] == 0 && phone[1] == 9)) {
                $('.registerErr').html('شماره تماس خود را به درستی وارد نمایید.');
                return;
            }
            kind = 'phone';
        }

        openLoading();
        $.ajax({
            type: 'post',
            url: checkRegisterDataUrl,
            data: {
                _token: csrfToken,
                name: name,
                emailPhone: emailPhone,
            },
            success: function (response) {
                try {
                    response = JSON.parse(response);
                    if (response.status == 'ok') {
                        if (response.nameErr || response.phoneErr || response.emailErr) {
                            closeLoading();

                            if (response.nameErr)
                                $('.registerErr').append('<div>نام وارد شده تکراری می باشد.</div>');
                            if (response.phoneErr)
                                $('.registerErr').append('<div>شماره تماس وارد شده تکراری می باشد.</div>');
                            if (response.emailErr)
                                $('.registerErr').append('<div>ایمیل وارد شده تکراری می باشد.</div>');
                        } else {
                            if (kind == 'phone')
                                checkInputPhoneRegister();
                            else
                                openUserRegisterationPage();
                        }
                    }
                } catch (e) {
                    closeLoading();
                    showSuccessNotifi('در فرایند ثبت نام مشکلی پیش امده لطفا دوباره تلاش نمایید.', 'left', 'red');
                }
            },
            error: function (err) {
                closeLoading();
                showSuccessNotifi('در فرایند ثبت نام مشکلی پیش امده لطفا دوباره تلاش نمایید.', 'left', 'red');
            }
        })

    } else
        $('.registerErr').html('پر کردن تمامی فیلد ها الزامی است.');

}

function openRegisterSection(_kind) {
    $('#registerDiv').removeClass('hidden');
    $('#loginPopUp').addClass('hidden');

    if (_kind == 'email')
        $('#EnterEmail-loginPopUp').removeClass('hidden');
    else if (_kind == 'ForgetPassword')
        $('#ForgetPassword').removeClass('hidden');
    else
        $('#EnterPhone-loginPopUp').removeClass('hidden');
}

function Return(_id) {
    $('#' + _id).addClass('hidden');
    switch (_id) {
        case 'EnterEmail-loginPopUp':
        case 'EnterPhone-loginPopUp':
        case 'ForgetPassword':
            $('#registerDiv').addClass('hidden');
            $('#loginPopUp').removeClass('hidden');
            break;
        case 'sendVerifiedPhoneCodeSection':
            $('#loginPopUp').removeClass('hidden');
            $('#registerDiv').addClass('hidden');
            $('#sendVerifiedPhoneCodeSection').addClass('hidden');
            break;
        case 'Email_ForgetPass':
        case 'Phone_ForgetPass':
            $('#ForgetPassword').removeClass('hidden');
            break;
        case 'PhoneCodePasswordForget':
            $('#Phone_ForgetPass').removeClass('hidden');
            break;
    }
}

function closeLoginPopup() {
    $('#mainLoginPopUp').addClass('hidden');
}

function closeRegister() {
    $('#registerDiv').addClass('hidden');
    $('#loginPopUp').removeClass('hidden');
}

function emailRegister() {
    var loginErrEmailElement = $('#loginErrEmail');
    let email = $('#emailRegisterInput').val();
    if (email.trim().length > 0 && validateEmail(email)) {
        openLoading();
        $.ajax({
            type: 'post',
            url: checkEmailDir,
            data: {
                _token: csrfToken,
                email: email
            },
            complete: closeLoading,
            success: function (response) {
                if (response == 'ok')
                    openUserRegisterationPage();
                else if (response == 'nok')
                    loginErrEmailElement.empty().append('ایمیل وارد شده در سامانه موجود است');
            else
                loginErrEmailElement.empty().append('در فرایند ثبت نام مشکلی پیش امده لطفا دوباره تلاش کنید');
            },
            error: function (err) {
                loginErrEmailElement.empty().append('در فرایند ثبت نام مشکلی پیش امده لطفا دوباره تلاش کنید');
            }
        })
    }
    else
        loginErrEmailElement.empty().append('ایمیل خود را به درستی وارد کنید.');
}

function checkInputPhoneRegister() {
    let phone = $('#emailPhone_register').val();
    phone = convertNumberToEn(phone);
    $.ajax({
        type: 'post',
        url: checkPhoneLoginUrl,
        data: {
            phoneNum: phone
        },
        success: function (response) {
            closeLoading();
            if (phoneCodeRegister != null)
                clearTimeout(phoneCodeRegister);

            response = JSON.parse(response);

            if (response.status == "ok") {
                phoneNum = phone;
                reminderTime = response.reminder;

                if (reminderTime > 0) {
                    $(".reminderTimeDiv").removeClass('hidden');
                    $(".resendActivationCode").addClass('hidden');
                    phoneCodeRegister = setInterval("decreaseTime()", 1000);
                } else {
                    $(".reminderTimeDiv").addClass('hidden');
                    $(".resendActivationCode").removeClass('hidden');
                }

                $("#activationCode").val("");
                $('#loginPopUp').addClass('hidden');
                $('#registerDiv').removeClass('hidden');
                $('#sendVerifiedPhoneCodeSection').removeClass('hidden');
            } else if (response.status == "nok")
                $("#loginErrPhonePass1").empty().append('شماره شما پیش از این در سامانه ثبت گردیده است.');
        else if (response.status == "nok3")
                $("#loginErrPhonePass1").empty().append('اشکالی در ارسال پیام رخ داده است');
        else
            $("#loginErrPhonePass1").empty().append('کد اعتبار سنجی برای شما ارسال شده است. برای ارسال مجدد کد منتظر بمانید');
        },
        error: function (err) {
            closeLoading();
            console.log(err);
        }
    });
}

function resendActivationCode(_kind) {
    let phoneNum;
    if (_kind == 'forget')
        phoneNum = $('#phoneForgetPass').val();
    else
        phoneNum = $('#emailPhone_register').val();

    phoneNum = convertNumberToEn(phoneNum);

    $.ajax({
        type: 'post',
        url: resendActivationCode,
        data: { phoneNum: phoneNum },
        success: function (response) {
            response = JSON.parse(response);
            if (phoneCodeRegister != null)
                clearTimeout(phoneCodeRegister);

            reminderTime = response.reminder;

            if (response.status == "ok") {
                if (reminderTime > 0) {
                    $(".reminderTimeDiv").removeClass('hidden');
                    $(".resendActivationCode").addClass('hidden');
                    phoneCodeRegister = setInterval("decreaseTime()", 1000);
                } else {
                    $(".reminderTimeDiv").addClass('hidden');
                    $(".resendActivationCode").removeClass('hidden');
                }
            } else {
                $(".reminderTimeDiv").addClass('hidden');
                $(".resendActivationCode").removeClass('hidden');
                phoneCodeRegister = setInterval("decreaseTime()", 1000);
            }
        }
    })

}

function registerWithPhone() {
    let username = $('#username_register').val();
    let phone = $('#emailPhone_register').val();
    let password = $('#password_register').val();
    let actCode = $('#activationCode').val();
    let inviteCode = $('#invitationCode').val();

    phone = convertNumberToEn(phone);
    actCode = convertNumberToEn(actCode);
    inviteCode = convertNumberToEn(inviteCode);
    $(".phoneRegisterErr").html('');

    if (actCode.trim().length > 2) {
        openLoading();
        $.ajax({
            type: 'post',
            url: registerAndLogin,
            data: {
                username: username,
                password: password,
                phone: phone,
                actCode: actCode,
                // invitationCode: inviteCode
            },
            success: function (response) {
                if (response == "ok")
                    login(username, password);
                else if (response == "nok1") {
                    closeLoading();
                    $('.phoneRegisterErr').append('<span>نام کاربری وارد شده در سامانه موجود است</span>');
                } else if (response == 'nok5') {
                    closeLoading();
                    $('.phoneRegisterErr').append('<span>کد وارد شده نامعتبر می باشد.</span>');
                } else {
                    closeLoading();
                    $('.phoneRegisterErr').append("<span>{{__('کد معرف وارد شده نامعتبر است')}}</span>");
                }
            },
            error: function (err) {
                console.log(err);
                closeLoading();
                showSuccessNotifi('در فرایند ثبت نام مشکلی پیش امده لطفا دوباره تلاش کنید.', 'left', 'red');
            }
        });
    }
}

function checkValidationPhoneCode(_phoneId, _codeId, _callback = '') {
    let phoneNum = $('#' + _phoneId).val();
    let code = $('#' + _codeId).val();

    phoneNum = convertNumberToEn(phoneNum);
    code = convertNumberToEn(code);

    if (code.trim().length > 0) {
        openLoading();
        $.ajax({
            type: 'post',
            url: registercheckActivationCode,
            data: {
                phoneNum: phoneNum,
                activationCode: code
            },
            success: function (response) {
                closeLoading();
                if (response.status == "ok") {
                    if (typeof _callback === 'function')
                        _callback();
                }
                else
                    $(".loginErrActivationCode").empty().append('کد وارد شده معتبر نمی باشد');
            },
            error: function (err) {
                closeLoading();
                console.log(err);
                showSuccessNotifi('در فرایند ثبت نام مشکلی پیش امده لطفا دوباره تلاش کنید.', 'left', 'red');
            }
        });
    }
}

function decreaseTime() {
    $(".reminderTime").text((reminderTime % 60) + " : " + Math.floor(reminderTime / 60));

    if (reminderTime > 0)
        reminderTime--;
    else {
        clearTimeout(phoneCodeRegister);
        $(".reminderTimeDiv").addClass('hidden');
        $(".resendActivationCode").removeClass('hidden');
    }
}

function checkRecaptcha() {
    let username = $('#username_register').val();
    let password = $('#password_register').val();

    if (username.trim().length > 0 && password.trim().length > 0) {
        openLoading();
        $.ajax({
            type: 'post',
            url: checkReCaptcha,
            data: { captcha: grecaptcha.getResponse() },
            success: function (response) {
                if (response == "ok")
                    registerWithEmail();
                else {
                    closeLoading();
                    $("#loginErrUserName").empty().append('لطفا ربات نبودن خود را ثابت کنید');
                }
            }
        });
    } else {
        closeLoading();
        $("#loginErrUserName").empty().append('لطفا نام کاربری و رمز عبور خود را مشخص کنید');
    }
}

function registerWithEmail() {
    let username = $('#username_register').val();
    let password = $('#password_register').val();
    let email = $('#emailPhone_register').val();
    let inviteCode = $("#invitationCode").val();

    $.ajax({
        type: 'post',
        url: registerAndLogin,
        data: {
            username: username,
            password: password,
            email: email,
            // invitationCode: inviteCode
        },
        success: function (response) {
            if (response == "ok")
                login(username, password);
            else if (response == "nok1") {
                closeLoading();
                $("#loginErrUserName").empty().append('نام کاربری وارد شده در سامانه موجود است');
            } else {
                closeLoading();
                $("#loginErrUserName").empty().append('کد معرف وارد شده نامعتبر است');
            }
        },
        error: function (err) {
            console.log(err);
            closeLoading();
            showSuccessNotifi('در فرایند ثبت نام مشکلی پیش امده لطفا دوباره تلاش کنید.', 'left', 'red');
        }
    });
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function checkedCheckBox(_element) {

    if ($(_element).is(":checked")) {
        $(".submitAndFinishBtn").removeAttr('disabled');
    } else {
        $(".submitAndFinishBtn").attr('disabled', 'disabled');
    }
}

function openUserRegisterationPage() {
    $('#loginPopUp').addClass('hidden');
    $('#registerDiv').removeClass('hidden');
    $('#EnterUsername-loginPopUp').removeClass('hidden');
    closeLoading();
}

function showForgatenPassInput(_id) {
    $('#' + _id).removeClass('hidden');
    $('#ForgetPassword').addClass('hidden');
}

function login(username, password) {
    if (username.trim().length > 0 && password.trim().length > 0) {
        openLoading();
        $.ajax({
            type: 'post',
            url: login2URl,
            data: {
                username: username,
                password: password
            },
            success: function (response) {
                if (response.status == "ok") {
                    $('#form_userName').val(username);
                    $('#form_pass').val(password);
                    $('#redirectUrl').val(selectedUrl);
                    hasLogin = true;
                    if(typeof callBackAfterLogin === 'function')
                        callBackAfterLogin();
                    else
                        $('#second_login').submit();
                } else if (response.status == "nok2") {
                    closeLoading();
                    $(".loginErr").empty().append('حساب کاربری شما غیر فعال شده است');
                } else {
                    closeLoading();
                    $(".loginErr").empty().append('نام کاربری و یا رمز عبور اشتباه وارد شده است');
                }
            },
            error: function (xhr, status, error) {
                closeLoading();
                if (xhr.responseText == "Too Many Attempts.")
                    $(".loginErr").empty().append('تعداد درخواست های شما بیش از حد مجاز است. لطفا تا 5 دقیقه دیگر تلاش نفرمایید');
            }
        });
    }
}

function sendForgetPassPhone() {
    let phoneNum = $('#phoneForgetPass').val();
    phoneNum = convertNumberToEn(phoneNum);

    if (phoneNum.trim().length == 11 && phoneNum[0] == 0 && phoneNum[1] == 9) {
        openLoading();
        $.ajax({
            type: 'post',
            url: retrievePasByPhoneUrl,
            data: { phone: phoneNum },
            success: function (response) {
                closeLoading();

                if (phoneCodeRegister != null)
                    clearTimeout(phoneCodeRegister);

                if (response.status == "ok") {
                    reminderTime = response.reminder;
                    if (reminderTime > 0) {
                        $(".reminderTimeDiv").removeClass('hidden');
                        $(".resendActivationCode").addClass('hidden');
                        phoneCodeRegister = setInterval("decreaseTime()", 1000);
                    }
                    else {
                        $(".reminderTimeDiv").addClass('hidden');
                        $(".resendActivationCode").removeClass('hidden');
                    }
                    $("#activationCodeForgetPass").val("");
                    $('#Phone_ForgetPass').addClass('hidden');
                    $('#PhoneCodePasswordForget').removeClass('hidden');
                }
                else if (response.status == "nok")
                    $("#loginErrResetPasByPhone").empty().append('Server error');
                else if (response.status == "nok1")
                    $("#loginErrResetPasByPhone").empty().append('کاربری با این شماره یافت نشد');
                else if (response.status == "nok2")
                    $("#loginErrResetPasByPhone").empty().append('مشکلی در ارسال پیامک پیش امده');
                else if (response.status == "nok3")
                    $("#loginErrResetPasByPhone").empty().append('اشکالی در ارسال پیام رخ داده است');
            else
                $("#loginErrResetPasByPhone").empty().append('کد اعتبار سنجی برای شما ارسال شده است. برای ارسال مجدد کد باید 5 دقیقه منتظر بمانید');
            },
            error: function (err) {
                closeLoading();
                console.log(err);
                showSuccessNotifi('در فرایند بازبابی رمز عبور مشکلی پیش امده لطفا دوباره تلاش کنید.', 'left', 'red');
            }
        });
    }
    else
        $("#loginErrResetPasByPhone").empty().append('شماره موبایل خود را به درستی وارد نمایید.');
}

function checkValidateForgetPass() {
    checkValidationPhoneCode('phoneForgetPass', 'activationCodeForgetPass', function () {
        $('#setNewPassword').removeClass('hidden');
        $('#PhoneCodePasswordForget').addClass('hidden');
    })
}

function submitNewPassword() {
    let newPass = $('#newPassword').val();
    let phone = $('#phoneForgetPass').val();
    let code = $('#activationCodeForgetPass').val();
    phone = convertNumberToEn(phone);
    if (newPass.trim().length > 0) {
        openLoading();
        $.ajax({
            type: 'post',
            url: userSetNewPasswordUrl,
            data: {
                _token: csrfToken,
                pass: newPass,
                phone: phone,
                code: code
            },
            success: function (response) {
                closeLoading();
                if (response == 'ok') {
                    showSuccessNotifi('رمز شما با موفقیت تغییر یافت', 'left', 'var(--koochita-blue)');

                    $("#setNewPassword").addClass('hidden');
                    closeRegister();
                } else if (response == 'nok5') {
                    $('#setNewPassword').addClass('hidden');
                    $('#Phone_ForgetPass').removeClass('hidden');
                    showSuccessNotifi('لطفا دوباره شماره تماس خود را تایید کنید', 'left', 'red');
                    closeLoading();
                }
            },
            error: function (err) {
                closeLoading();
                console.log(err);
                showSuccessNotifi('در هنگام تغییر رمز مشکلی پیش امده لظفا دوباره تلاش نمایید', 'left', 'red');
            }
        })
    }
}

function showLoginPrompt(url, _callBackAfterLogin = '') {
    selectedUrl = url;
    callBackAfterLogin = _callBackAfterLogin;
    $("#username_main").val("");
    $("#password_main").val("");
    $('#mainLoginPopUp').removeClass('hidden');

    var googleUrl = $('#googleUrlRedirector').attr('href');
    var indexOfState = googleUrl.search('state=');
    var urlState = googleUrl.slice(indexOfState);
    var indexOfEndState = urlState.search('&');
    var findedUrl = googleUrl.slice(indexOfState, indexOfState+indexOfEndState);
    googleUrl = googleUrl.replace(findedUrl, 'state='+url);
    $('#googleUrlRedirector').attr('href', googleUrl);
}

function retrievePasByEmail() {
    let email = $('#forget_email').val();
    if (email.trim().length > 0) {
        openLoading();
        $.ajax({
            type: 'POST',
            url: retrievePasByEmailUrl,
            data: {
                _token: csrfToken,
                email: email
            },
            success: function (response) {
                closeLoading();
                try {
                    response = JSON.parse(response);
                    if (response.status == 'ok') {
                        showSuccessNotifi('لینک بازیابی به لینک شما ارسال شد', 'left', 'red');
                        $('#reminderTimeEmailForgetPassDiv').removeClass('hidden');
                        $('#resendForgetPassEmailButton').addClass('hidden');
                        reminderTime = response.remainder;
                        phoneCodeRegister = setInterval("decreaseTime()", 1000);
                    } else if (response.status == 'nok')
                        showSuccessNotifi('در بازیبای رمز عبور مشکلی پیش امده لطفا دوباره تلاش نمایید', 'left', 'red');
                else if (response.status == 'nok1')
                        $('#loginErrResetPasByEmail').text('کاربری با این ایمیل در سامانه ثبت نشده است');
                else if (response.status == 'nok2')
                        showSuccessNotifi('در بازیبای رمز عبور مشکلی پیش امده لطفا دوباره تلاش نمایید', 'left', 'red');
                else if (response.status == 'nok3') {
                        reminderTime = response.remainder;
                        phoneCodeRegister = setInterval("decreaseTime()", 1000);
                        $('#reminderTimeEmailForgetPassDiv').removeClass('hidden');
                        $('#resendForgetPassEmailButton').addClass('hidden');
                    }

                } catch (e) {
                    console.log(e)
                    showSuccessNotifi('در بازیبای رمز عبور مشکلی پیش امده لطفا دوباره تلاش نمایید', 'left', 'red');
                }
            },
            error: function (err) {
                console.log(err);
                closeLoading();
                showSuccessNotifi('در بازیبای رمز عبور مشکلی پیش امده لطفا دوباره تلاش نمایید', 'left', 'red');
            }
        })
    }
}
