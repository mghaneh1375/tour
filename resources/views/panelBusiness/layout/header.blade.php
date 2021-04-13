<div class="mainHeader">
    <div class="mainLogo">
        <img src="{{URL::asset('images/icons/mainLogo.png')}}" alt="koochita">
    </div>

    @if(isset($businessName))
        <div class="businessName">
            <select onchange="changeBusinessPanelManagementHeader(this.value)">
                @foreach($allOtherYourBusinessForHeader as $item)
                    <option value="{{$item->id}}" {{$item->name === $businessName ? 'selected' : ''}}>{{$item->name}}</option>
                @endforeach
            </select>
        </div>

        <script>
            function changeBusinessPanelManagementHeader(_value){
                openLoading(false, () => location.href = `{{url("businessManagement")}}/${_value}/main`);
            }
        </script>
    @endif

    @if(auth()->check())
        <a href="{{route('ticket.page')}}" class="ticketButton" title="پشتیبانی">
            <i class="fa-solid fa-headset"></i>
            @if($newTicketCount != 0)
                <div class="newNum">{{$newTicketCount}}</div>
            @endif
        </a>

        <div class="userInfoSec">
            <div class="userPic">
                <img src="{{$userInfo->pic}}" class="resizeImgClass" alt="عکس کاربر" onload="fitThisImg(this)">
            </div>
            <div class="topDropDown">
                <div class="text topHeaderDropDown">
                    <span>{{$userInfo->username}}</span>
                    <i class="fas fa-angle-down"></i>
                </div>
                <div class="dropDownMenu topHeaderDropDown">
                    <a href="#" class="item">پروفایل</a>
                    <a href="#" class="item">تنظیمات</a>
                    <a href="{{route('businessPanel.doLogOut')}}" class="item">خروج</a>
                </div>
            </div>
        </div>
    @endif
</div>
