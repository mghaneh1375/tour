<div class="blackLayer">

</div>
<div style="display:flex;justify-content:space-between;">
    <div class="mainHeader">
        <div class="logoBoxheader">
            <img style="width: 100%" src="{{ URL::asset('images/icons/mainLogo.png') }}" alt="koochita">
            <div class="typeLogo">
                Business
            </div>
        </div>
    </div>
    <div class="menuBtn" style="margin-right: 5px;" onclick="openNav()">
        <svg width="45" height="35" viewBox="0 0 69 46" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M41.3996 7.63596C41.3996 9.00065 40.9949 10.3347 40.2368 11.4694C39.4786 12.6041 38.4009 13.4885 37.1401 14.0107C35.8793 14.533 34.492 14.6696 33.1535 14.4034C31.815 14.1371 30.5856 13.48 29.6206 12.515C28.6556 11.55 27.9984 10.3206 27.7322 8.98209C27.466 7.64362 27.6026 6.25626 28.1248 4.99545C28.6471 3.73464 29.5315 2.657 30.6662 1.89882C31.8009 1.14064 33.1349 0.735962 34.4996 0.735962C36.3296 0.735962 38.0846 1.46292 39.3786 2.75693C40.6727 4.05093 41.3996 5.80597 41.3996 7.63596ZM34.4996 16.008C33.1349 16.008 31.8009 16.4126 30.6662 17.1708C29.5315 17.929 28.6471 19.0066 28.1248 20.2674C27.6026 21.5283 27.466 22.9156 27.7322 24.2541C27.9984 25.5926 28.6556 26.822 29.6206 27.787C30.5856 28.752 31.815 29.4091 33.1535 29.6754C34.492 29.9416 35.8793 29.805 37.1401 29.2827C38.4009 28.7605 39.4786 27.8761 40.2368 26.7414C40.9949 25.6067 41.3996 24.2727 41.3996 22.908C41.3996 21.078 40.6727 19.3229 39.3786 18.0289C38.0846 16.7349 36.3296 16.008 34.4996 16.008ZM34.4996 31.28C33.1349 31.28 31.8009 31.6846 30.6662 32.4428C29.5315 33.201 28.6471 34.2786 28.1248 35.5394C27.6026 36.8003 27.466 38.1876 27.7322 39.5261C27.9984 40.8646 28.6556 42.094 29.6206 43.059C30.5856 44.024 31.815 44.6811 33.1535 44.9474C34.492 45.2136 35.8793 45.077 37.1401 44.5547C38.4009 44.0325 39.4786 43.1481 40.2368 42.0134C40.9949 40.8787 41.3996 39.5447 41.3996 38.18C41.3996 37.2738 41.2211 36.3766 40.8744 35.5394C40.5276 34.7023 40.0194 33.9416 39.3786 33.3009C38.7379 32.6602 37.9773 32.152 37.1401 31.8052C36.303 31.4584 35.4057 31.28 34.4996 31.28Z"
                fill="white" />
        </svg>
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
        if ($('#mainSideBar').css('width') == '250px') {
            $("#mainSideBar").css("width", "0px");
            $('.blackLayer').css("display", "none");
            $('.userName').css("display", "none");
        } else {

            $('#mainSideBar').css("width", "250px");
            $('.blackLayer').css("display", "block");
            $('.userName').css("display", "block");
            // $('#mainSideBar').addClass('sideNav');
        }
    }
    $(document).mouseup(function(e) {
        if ($(e.target).closest("#mainSideBar").length ===
            0) {
            $("#mainSideBar").css("width", "0px");
            $('.blackLayer').css("display", "none");
            $('.userName').css("display", "none");
        }
    });
</script>
