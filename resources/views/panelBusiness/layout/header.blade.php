<div class="blackLayer">

</div>
<div class="mainHeader">
    <div>
        <button class="menuBtn" onclick="openNav()">
            mozzzz
        </button>
        <div class="logoBoxheader">
            <img style="width: 100%" src="{{ URL::asset('images/icons/mainLogo.png') }}" alt="koochita">
            <div class="typeLogo">
                Business
            </div>

        </div>
    </div>

    {{-- @if (isset($businessName))
        <div class="businessName">
            <select onchange="changeBusinessPanelManagementHeader(this.value)">
                @foreach ($allOtherYourBusinessForHeader as $item)
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

    @if (auth()->check())
        <a href="#" class="headerButton notificationHeader {{$newNotificationCount > 0 ? 'on' : 'off'}}" title="اعلانات">
            <i class="fa-regular fa-bell icOff"></i>
            <i class="fa-regular fa-bell-on icOn"></i>
            <div class="newNum">{{$newNotificationCount}}</div>
        </a>

        @if (auth()->user()->level == 0)
            <a href="{{route('ticket.page')}}" class="headerButton" title="پشتیبانی">
                <i class="fa-solid fa-headset"></i>
                @if ($newTicketCount != 0)
                    <div class="newNum">{{$newTicketCount}}</div>
                @endif
            </a>
        @endif

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
    @endif --}}
</div>
<script>
    function openNav() {
        $('#mainSideBar').css("width", "250px");
        $('.blackLayer').css("display", "block");
        // $('#mainSideBar').addClass('sideNav');
    }
    $(document).mouseup(function(e) {
        if ($(e.target).closest("#mainSideBar").length ===
            0) {
            $("#mainSideBar").css("width", "0px");
            $('.blackLayer').css("display", "none");
        }
    });
</script>
