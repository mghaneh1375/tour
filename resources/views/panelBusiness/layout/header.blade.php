<div class="mainHeader">
    <div class="mainLogo">
        <img src="{{URL::asset('images/icons/mainLogo.png')}}" alt="koochita">
    </div>

    @if(auth()->check())
        <div class="userInfoSec">
            <div class="userPic">
                <img src="{{$userInfo->pic}}" class="resizeImgClass" alt="عکس کاربر" onload="fitThisImg(this)">
            </div>
            <div class="topDropDown">
                <div class="text topHeaderDropDown">{{$userInfo->username}}</div>
                <div class="dropDownMenu topHeaderDropDown">
                    <a href="#" class="item">پروفایل</a>
                    <a href="#" class="item">تنظیمات</a>
                    <a href="{{route('businessPanel.doLogOut')}}" class="item">خروج</a>
                </div>
            </div>
        </div>
    @endif
</div>
