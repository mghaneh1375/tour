@if(Auth::check())
    <div class="discountSelectSec">
        <div class="header">تخفیف</div>
        <div class="description">برای خرید تور شما می توانید از کد تحفیف و یا امتیاز خود در سامانه کوچیتا استفاده کنید.</div>
        <div class="butG">
            <div data-type="code" class="discountType butO" onclick="selectDiscountType(this)">کد تخفیف</div>
            <div data-type="koochitaScore" class="discountType butO selected" onclick="selectDiscountType(this)">امتیاز کوچیتا</div>
        </div>
    </div>
    <div id="codeDiscountSection" class="discountSec hidden">
        <div>
            <div class="textTitle display-inline-block"> کد تخفیف </div>
            <div class="display-inline-block"> اگر کد تخفیف دارید در اینجا وارد کنید تا در قیمت نهایی اعمال شود </div>
        </div>
        <div class="width-55per">
            <div class="inputBox width-45per">
                <div class="inputBoxText width-40per">
                    <div class="display-inline-block position-relative"> کد تخفیف را وارد کنید </div>
                </div>
                <input id="discountCodeInput" name="discountCodeInput" class="inputBoxInput width-60per" type="text" placeholder="xxxxxxxxx">
            </div>
            <div class="display-inline-block mg-10-15 float-left">
                <button class="btn afterBuyBtn applyDiscountBtn" type="button" onclick="checkTourDiscountCode()"> اعمال کد تخفیف </button>
                <div id="dicountCodeError" class="applyDiscountErrText hidden"> متأسفانه کد تخفیف معتبر نمی باشد </div>
            </div>
        </div>
        <div> در صورت استفاده از کد تخفیف برای این خرید دیگر امکان خرج کردن امتیاز میسر نمی باشد </div>
    </div>
    <div id="koochitaScoreDiscountSection" class="discountSec usersPointsMainDiv inlineBorder">
        <div class="textTitle payPointsText"> خرج کردن امتیاز </div>
        <div> امتیاز خود را به تخفیف تبدیل کنید. توجه داشته باشید در صورت خرج کردن امتیاز رتبه و نشان های افتخار شما از بین نخواهد رفت </div>
        <div class="font-size-08em">
            برای اطلاعات بیشتر به صفحه
            <a href="" class="color-5-12-147"> راهنمای امتیازات  </a>
            مراجعه کنید
        </div>
        <div class="inputBox">
            <div class="inputBoxText" style="width: 120px;"> امتیاز موجود </div>
            <div class="inputBoxInput" style="width: 120px;"> 0 </div>
        </div>
        <div>
            برای این بلیط هر امتیاز شما معادل
            <span class="color-146-50-27">0</span>
            تومان تخفیف می باشد. توجه حداکثر مبلغ قابل تخفیف
            <span class="color-146-50-27">0</span>
            تومان می باشد
        </div>
        <div>
            <div class="inputBox">
                <div class="inputBoxText" style="width: 120px;">
                    <div class="display-inline-block position-relative"> چقدر امتیاز خرج می کنید </div>
                </div>
                <input class="inputBoxInput" type="text" placeholder="xxxxxxxxx" style="width: 120px;">
            </div>
            <div class="btn crossOneThousand"> ضرب در 0 تومان </div>
            <div class="inputBox discountVerifiedAmountMainBox">
                <div class="inputBoxText width-60per"> مبلغ تخفیف </div>
                <div class="inputBoxInput width-40per"> 0 </div>
            </div>
        </div>
        <div> در صورت انصراف از خرید در آخرین مرحله یا ایجاد هرگونه مشکل امتیاز خرج شده شما به حساب کاربری شما باز می گردد </div>
        <div>
            <button class="btn afterBuyBtn payBtnFinalVerification" type="button"> خرجش کن </button>
            <div class="amountOfPointsToPay"> لطفا امتیاز موردنظر برای خرج کردن را وارد نمایید </div>
        </div>
        <div> در صورت خرج امتیاز برای این خرید دیگر امکان استفاده از کد تخفیف نمی باشد </div>
    </div>
@endif
