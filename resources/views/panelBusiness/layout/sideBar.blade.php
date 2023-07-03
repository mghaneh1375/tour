<div id="mainSideBar" class="mainSidebar">
    <div class="logoBox">
        <img style="width: 100%" src="{{ URL::asset('images/icons/mainLogo.png') }}" alt="koochita">
        <div class="typeLogo">
            Business
        </div>
    </div>
    <div class="progressBarSection">
        <div class="text">
            <span id="sideProgressBarNumber">0%</span> کامل شده
        </div>
        <div class="progressBarDiv">
            <div id="sideProgressBarFull" class="full"></div>
        </div>
    </div>

    <div class="sideMenuSection">
        @if (isset($businessName))
            <div class="businessName">
                <select onchange="changeBusinessPanelManagementHeader(this.value)">
                    @foreach ($allOtherYourBusinessForHeader as $item)
                        <option value="{{ $item->id }}" {{ $item->name === $businessName ? 'selected' : '' }}>
                            {{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <script>
                function changeBusinessPanelManagementHeader(_value) {
                    openLoading(false, () => location.href = `{{ url('businessManagement') }}/${_value}/main`);
                }
            </script>
        @endif

        @if (auth()->check())
            <div class="sideNavRow">
                <div class="userInfoSec">
                    <div class="userPic">
                        <img src="{{ $userInfo->pic }}" class="resizeImgClass" alt="عکس کاربر"
                            onload="fitThisImg(this)">
                    </div>
                    <span>{{ $userInfo->username }}</span>
                </div>
            </div>
        @endif
        <div class="sideNavRow">
            <a href="{{ route('businessPanel.mainPage') }}" class="sideNavHeader">
                <span>خانه</span>
            </a>
        </div>
        @if (\auth()->user()->level === 2)
            <div class="sideNavRow">
                <div class="sideNavHeader hasBody">
                    <span>مدیریت</span>
                    <i class="fas fa-angle-down"></i>
                </div>
                <div class="sideNavBody">
                    <a href="{{ route('businessPanel.contracts') }}" class="sideNavItem">متن قرارداد ها</a>
                    <a href="{{ route('businessPanel.getUnChecked') }}" class="sideNavItem">درخواست های تعیین تکلیف
                        نشده</a>
                </div>
            </div>

            <div class="sideNavRow">
                <a href="{{ route('ticket.admin.page') }}" class="sideNavHeader">
                    <span>پشتیبانی</span>
                    @if ($newTicketCount > 0)
                        <span class="newTicketCount">{{ $newTicketCount }}</span>
                    @endif
                </a>
            </div>
        @else
            @if (isset($businessType))
                @if ($businessType === 'agency')
                    <div class="sideNavRow">
                        <div class="sideNavHeader hasBody">
                            <span>مدیریت تورها</span>
                            <i class="fas fa-angle-down"></i>
                        </div>
                        <div class="sideNavBody">
                            <a href="{{ route('businessManagement.tour.list', ['business' => $businessIdForUrl]) }}"
                                class="sideNavItem">لیست تورها</a>
                            <a href="{{ route('businessManagement.tour.create', ['business' => $businessIdForUrl]) }}"
                                class="sideNavItem">ایجاد تور جدید</a>
                        </div>
                    </div>
                @endif
                <div id="lastItemOfSideMenu" class="sideNavRow showInBottom">
                    <a href="{{ route('businessPanel.myBusinesses') }}" class="sideNavHeader hasBody">
                        <span>بازگشت به مدیریت کسب و کار</span>
                    </a>
                </div>
            @else
                <div class="sideNavRow">
                    <div class="sideNavHeader hasBody">
                        <span>کسب و کار</span>
                        <i class="fas fa-angle-down"></i>
                    </div>
                    <div class="sideNavBody">
                        <a href="{{ route('businessPanel.create') }}" class="sideNavItem">ایجاد کسب و کار جدید</a>
                        <a href="{{ route('businessPanel.myBusinesses') }}" class="sideNavItem">کسب و کارهای من</a>
                        <a href="{{ route('businessPanel.completeUserInfo') }}" class="sideNavItem">تغییر اطلاعات
                            فردی</a>
                    </div>
                </div>
            @endif
        @endif
        @if (auth()->check())
            <div class="sideNavRow">
                <a href="#" class="item">تنظیمات</a>
            </div>
            <div class="sideNavRow">
                <a href="#"
                    class="headerButton notificationHeader {{ $newNotificationCount > 0 ? 'on' : 'off' }}"
                    title="اعلانات">
                    <i class="fa-regular fa-bell icOff"></i>
                    <i class="fa-regular fa-bell-on icOn"></i>
                    <div class="newNum">{{ $newNotificationCount }}</div>
                    اعلانات
                </a>
            </div>
            @if (auth()->user()->level == 0)

                <div class="sideNavRow">
                    <a href="{{ route('ticket.page') }}" class="headerButton" title="پشتیبانی">
                        <i class="fa-solid fa-headset"></i>
                        @if ($newTicketCount != 0)
                            <div class="newNum">{{ $newTicketCount }}</div>
                        @endif
                        پشتیبانی
                    </a>
                </div>
            @endif
            <div class="sideNavRow">
                <a href="{{ route('businessPanel.doLogOut') }}" class="item">خروج</a>
            </div>
        @endif

    </div>
</div>

<script>
    function createNewMenuSideBar(_data) {
        var subHtml = '';
        _data.sub.map(item => subHtml += `<a href="${item.url}" class="sideNavItem ${item.selected == 1 ? 'selected' : ''}">
                                            <span>${item.icon}</span>
                                            <span>${item.title}</span>
                                        </a>`);

        var html = `<div class="sideNavRow open">
                    <div class="sideNavHeader hasBody">
                        <span>${_data.title}</span>
                        <i class="fas fa-angle-down"></i>
                    </div>
                    <div class="sideNavBody">${subHtml}</div>
                </div>`;

        document.getElementById('lastItemOfSideMenu').insertAdjacentHTML('beforebegin', html);
    }
</script>
