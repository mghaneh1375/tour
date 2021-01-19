@if(Auth::check())
    <div>
        <div>
            <div class="textTitle display-inline-block"> کد تخفیف </div>
            <div class="display-inline-block"> اگر کد تخفیف دارید در اینجا وارد کنید تا در قیمت نهایی اعمال شود </div>
        </div>
        <div class="width-55per">
            <div class="inputBox width-45per">
                <div class="inputBoxText width-40per">
                    <div class="display-inline-block position-relative"> کد تخفیف را وارد کنید </div>
                </div>
                <input class="inputBoxInput width-60per" type="text" placeholder="xxxxxxxxx">
            </div>
            <div class="display-inline-block mg-10-15 float-left">
                <button class="btn afterBuyBtn applyDiscountBtn" type="button"> اعمال کد تخفیف </button>
                <div class="applyDiscountErrText"> متأسفانه کد تخفیف معتبر نمی باشد <br>  کد تخفیف وارد شده قبلا استفاده شده است </div>
            </div>
        </div>
        <div> در صورت استفاده از کد تخفیف برای این خرید دیگر امکان خرج کردن امتیاز میسر نمی باشد </div>
    </div>
    <div class="inlineBorder"></div>
    <div class="usersPointsMainDiv">
        <div class="textTitle payPointsText"> خرج کردن امتیاز </div>
        <div> امتیاز خود را به تخفیف تبدیل کنید. توجه داشته باشید در صورت خرج کردن امتیاز رتبه و نشان های افتخار شما از بین نخواهد رفت </div>
        <div class="font-size-08em">
            برای اطلاعات بیشتر به صفحه
            <a href="" class="color-5-12-147"> راهنمای امتیازات  </a>
            مراجعه کنید
        </div>
        <div class="inputBox width-18per">
            <div class="inputBoxText width-40per"> امتیاز موجود </div>
            <div class="inputBoxInput width-60per"> 1005000 </div>
        </div>
        <div>
            برای این بلیط هر امتیاز شما معادل
            <span class="color-146-50-27"> 1000 </span>
            تومان تخفیف می باشد. توجه حداکثر مبلغ قابل تخفیف
            <span class="color-146-50-27"> 50000 </span>
            تومان می باشد
        </div>
        <div>
            <div class="inputBox width-18per">
                <div class="inputBoxText width-60per">
                    <div class="display-inline-block position-relative"> چقدر امتیاز خرج می کنید </div>
                </div>
                <input class="inputBoxInput width-40per" type="text" placeholder="xxxxxxxxx">
            </div>
            <div class="btn crossOneThousand"> ضرب در 1000 تومان </div>
            <div class="inputBox discountVerifiedAmountMainBox">
                <div class="inputBoxText width-60per"> مبلغ تخفیف </div>
                <div class="inputBoxInput width-40per"> 50000 </div>
            </div>
        </div>
        <div> در صورت انصراف از خرید در آخرین مرحله یا ایجاد هرگونه مشکل امتیاز خرج شده شما به حساب کاربری شما باز می گردد </div>
        <div>
            <button class="btn afterBuyBtn payBtnFinalVerification" type="button"> خرجش کن </button>
            <div class="amountOfPointsToPay"> لطفا امتیاز موردنظر برای خرج کردن را وارد نمایید </div>
        </div>
        <div> در صورت خرج امتیاز برای این خرید دیگر امکان استفاده از کد تخفیف نمی باشد </div>
    </div>
@elseif($mode == 2)
    <div>
        <div class="textTitle"> نام کاربری و رمزعبور </div>
        <div> در آخرین گام برای خود یک نام کاربری و رمزعبور انتخاب کنید تا بتوانید از تمامی امکانات شازده استفاده نمایید </div>
        <div class="inputBox width-25per">
            <div class="inputBoxText">
                <div class="display-inline-block position-relative">
                    <div class="afterBuyIcon redStar"></div> نام کاربری
                </div>
            </div>
            <input id="usernameForRegistration" class="inputBoxInput" type="text">
        </div>
        <div class="font-size-08em"> دوستان شما، شما را با این نام خواهند شناخت </div>
        <div>
            <div class="inputBox width-25per">
                <div class="inputBoxText">
                    <div class="display-inline-block position-relative">
                        <div class="afterBuyIcon redStar"></div>
                        رمزعبور
                    </div>
                </div>
                <input id="passwordForRegistration" class="inputBoxInput" type="password">
            </div>
            <div class="inputBox width-25per mg-rt-5per">
                <div class="inputBoxText">
                    <div class="display-inline-block position-relative">
                        <div class="afterBuyIcon redStar"></div>
                        تکرار رمزعبور
                    </div>
                </div>
                <input id="rPasswordForRegistration" class="inputBoxInput" type="password">
            </div>
        </div>
        <div class="font-size-08em"> رمزعبور شما برای حفظ امنیت می بایست شامل حروف بزرگ و کوچک به همراه عدد باشد. فراموش نکنید زیر شش کاراکتر مورد قبول نمی باشد. </div>
    </div>
@endif
