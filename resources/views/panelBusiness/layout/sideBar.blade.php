<div id="mainSideBar" class="mainSidebar ">
    <div class="logoBox">
        <img style="width: 100%" src="{{ URL::asset('images/icons/mainLogo.png') }}" alt="koochita">
        <div class="typeLogo">
            Business
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
            <div class="sideNavRow ">
                <div class="userInfoSec">
                    <div class="userPic">
                        <img src="{{ $userInfo->pic }}" class="resizeImgClass" alt="عکس کاربر"
                            onload="fitThisImg(this)">
                    </div>
                    <div class="userName">{{ $userInfo->username }}</div>

                </div>
            </div>
        @endif
        <div class="sideNavRow able">
            <a href="{{ route('businessPanel.mainPage') }}" class="sideNavHeader">
                <i class="fa fa-home"></i> <span class="paddingRight10">خانه</span>
            </a>
        </div>
        @if (\auth()->user()->level === 2)
            <div class="sideNavRow able">
                <div class="sideNavHeader hasBody">
                    <span>مدیریت</span>
                    <i style="margin-right: 5px" class="fas fa-angle-down"></i>
                </div>
                <div class="sideNavBody" style="padding: 10px 20px;">
                    <a href="{{ route('businessPanel.contracts') }}" class="sideNavItem">متن قرارداد ها</a>
                    <a href="{{ route('businessPanel.getUnChecked') }}" class="sideNavItem">درخواست های تعیین تکلیف
                        نشده</a>
                    <a href="{{ route('asset.index') }}" class="sideNavItem">دارایی ها</a>
                    <a href="{{ route('report.index') }}" class="sideNavItem">گزارش ها</a>
                </div>
            </div>

            <div class="sideNavRow able">
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
                    <div class="sideNavRow able">
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
                <div id="lastItemOfSideMenu" class="sideNavRow able showInBottom">
                    <a href="{{ route('businessPanel.panel') }}" class="sideNavHeader hasBody">
                        <span>بازگشت به مدیریت کسب و کار</span>
                    </a>
                </div>
            @else
                <div class="sideNavRow able">
                    <div class="sideNavHeader hasBody">
                        <svg width="15" height="14" viewBox="0 0 15 14" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.00001 9.74999V9H0.757508L0.750008 12C0.749347 12.1972 0.787695 12.3925 0.862843 12.5748C0.937991 12.7571 1.04846 12.9227 1.18787 13.0621C1.32729 13.2015 1.49292 13.312 1.6752 13.3872C1.85749 13.4623 2.05284 13.5007 2.25001 13.5H12.75C12.9472 13.5007 13.1425 13.4623 13.3248 13.3872C13.5071 13.312 13.6727 13.2015 13.8121 13.0621C13.9516 12.9227 14.062 12.7571 14.1372 12.5748C14.2123 12.3925 14.2507 12.1972 14.25 12V9H9V9.74999H6.00001ZM13.5 3H10.4925V1.5L8.9925 0H5.9925L4.49251 1.5V3H1.50001C1.10255 3.00119 0.721707 3.1596 0.440659 3.44065C0.159612 3.7217 0.00119543 4.10254 8.39006e-06 4.5V6.75C-0.000652144 6.94716 0.0376956 7.14252 0.112844 7.3248C0.187992 7.50709 0.298456 7.67271 0.437875 7.81213C0.577295 7.95155 0.742916 8.06201 0.925202 8.13716C1.10749 8.21231 1.30284 8.25066 1.50001 8.25H6.00001V6.75H9V8.25H13.5C13.8975 8.24881 14.2783 8.09039 14.5593 7.80934C14.8404 7.5283 14.9988 7.14746 15 6.75V4.5C14.9988 4.10254 14.8404 3.7217 14.5593 3.44065C14.2783 3.1596 13.8975 3.00119 13.5 3ZM9 3H6.00001V1.5H9V3Z"
                                fill="#5a5a5a" />
                        </svg>
                        <span class="paddingRight10">کسب و کار</span>
                        {{-- <i class="fas fa-angle-down"></i> --}}
                    </div>
                    <div class="sideNavBody">
                        <ul class="">
                            <li>
                                <a class="sideNavItem aligenCenter" href="{{ route('createForm') }}">
                                    ایجاد کسب وکارجدید</a>
                                <a class="sideNavItem aligenCenter" href="{{ route('businessPanel.create') }}">
                                    ایجاد کسب وکارجدید</a>
                            </li>
                            <li>
                                <a class="sideNavItem aligenCenter" href="{{ route('businessPanel.panel') }} ">کسب و
                                    کارهای
                                    من</a>
                            </li>
                            <li>
                                <a class="sideNavItem aligenCenter"
                                    href="{{ route('businessPanel.completeUserInfo') }}">تغییر
                                    اطلاعات
                                    فردی</a>
                            </li>

                        </ul>
                    </div>
                </div>
            @endif
        @endif
        @if (auth()->check())
            <div class="sideNavRow">
                <a href="#" class="item aligenCenter sideNavHeader">
                    <svg width="15" height="16" viewBox="0 0 15 16"xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13.7617 7.5C13.7619 7.10989 13.8804 6.72901 14.1015 6.40758C14.3225 6.08615 14.6358 5.83925 15 5.69944C14.8115 4.91162 14.4991 4.15872 14.0744 3.46889C13.8271 3.5781 13.5598 3.63485 13.2894 3.63556C12.968 3.63602 12.6516 3.55605 12.3691 3.40293C12.0865 3.24982 11.8467 3.02842 11.6716 2.75892C11.4965 2.48942 11.3916 2.18038 11.3664 1.85997C11.3413 1.53955 11.3968 1.21794 11.5278 0.924444C10.8391 0.500151 10.0873 0.188104 9.30056 0C9.161 0.364463 8.91415 0.678005 8.59261 0.899189C8.27107 1.12037 7.88999 1.23879 7.49972 1.23879C7.10946 1.23879 6.72837 1.12037 6.40684 0.899189C6.0853 0.678005 5.83844 0.364463 5.69889 0C4.91106 0.188493 4.15817 0.500902 3.46833 0.925556C3.59932 1.21905 3.65479 1.54066 3.62967 1.86108C3.60455 2.18149 3.49966 2.49053 3.32454 2.76003C3.14942 3.02953 2.90964 3.25093 2.62706 3.40405C2.34447 3.55716 2.02807 3.63713 1.70667 3.63667C1.43609 3.63788 1.16841 3.58104 0.921667 3.47C0.500605 4.1622 0.189672 4.91564 0 5.70333C0.364154 5.84294 0.677451 6.08963 0.89859 6.41087C1.11973 6.73212 1.23833 7.11283 1.23875 7.50283C1.23917 7.89283 1.12139 8.2738 0.900949 8.59552C0.680505 8.91724 0.367741 9.1646 0.00388887 9.305C0.192382 10.0928 0.504791 10.8457 0.929444 11.5356C1.28527 11.3776 1.68062 11.3311 2.06339 11.4022C2.44617 11.4733 2.79841 11.6588 3.07371 11.9341C3.34901 12.2094 3.53444 12.5616 3.60558 12.9444C3.67672 13.3272 3.63023 13.7225 3.47222 14.0783C4.1624 14.5023 4.91518 14.8147 5.70278 15.0039C5.84237 14.6406 6.08882 14.3281 6.40962 14.1077C6.73042 13.8873 7.1105 13.7693 7.49972 13.7693C7.88895 13.7693 8.26903 13.8873 8.58983 14.1077C8.91063 14.3281 9.15708 14.6406 9.29667 15.0039C10.0845 14.8154 10.8374 14.503 11.5272 14.0783C11.3705 13.7225 11.325 13.3277 11.3966 12.9455C11.4682 12.5634 11.6536 12.2118 11.9285 11.9369C12.2034 11.6619 12.555 11.4765 12.9372 11.4049C13.3193 11.3333 13.7142 11.3788 14.07 11.5356C14.494 10.8454 14.8064 10.0926 14.9956 9.305C14.6322 9.1631 14.3201 8.91495 14.1 8.59295C13.8799 8.27094 13.762 7.89005 13.7617 7.5ZM7.535 10.6211C6.91693 10.6211 6.31275 10.4378 5.79884 10.0945C5.28494 9.75107 4.8844 9.26302 4.64788 8.692C4.41135 8.12098 4.34947 7.49264 4.47005 6.88645C4.59062 6.28026 4.88825 5.72344 5.32529 5.2864C5.76233 4.84936 6.31915 4.55174 6.92534 4.43116C7.53153 4.31058 8.15987 4.37246 8.73089 4.60899C9.30191 4.84551 9.78996 5.24605 10.1333 5.75995C10.4767 6.27386 10.66 6.87805 10.66 7.49611C10.6601 7.90653 10.5794 8.31296 10.4224 8.69217C10.2654 9.07138 10.0352 9.41593 9.74503 9.70615C9.45482 9.99636 9.11027 10.2265 8.73106 10.3835C8.35185 10.5405 7.94542 10.6213 7.535 10.6211Z"
                            fill="#5a5a5a" />
                    </svg>
                    <div class="paddingRight10"> تنظیمات</div>
                </a>

            </div>
            <div class="sideNavRow able">
                <a href="#"
                    class="aligenCenter sideNavHeader headerButton notificationHeader {{ $newNotificationCount > 0 ? 'on' : 'off' }}"
                    title="اعلانات">
                    <i class="fa-regular fa-bell icOff"></i>
                    <i class="fa-regular fa-bell-on icOn"></i>
                    <div class="newNum">{{ $newNotificationCount }}</div>
                    <div class="paddingRight10"> اعلانات</div>
                </a>
            </div>
            @if (auth()->user()->level == 0)

                <div class="sideNavRow able">
                    <a href="{{ route('ticket.page') }}" class="aligenCenter sideNavHeader headerButton"
                        title="پشتیبانی">
                        <i class="fa-solid fa-headset"></i>
                        @if ($newTicketCount != 0)
                            <div class="newNum">{{ $newTicketCount }}</div>
                        @endif
                        <div class="paddingRight10"> پشتیبانی</div>
                    </a>
                </div>
            @endif
            <div class="sideNavRow able logOut" onclick="clearLocalStorage()">
                <a href="{{ route('businessPanel.doLogOut') }}" class="item aligenCenter sideNavHeader">
                    <svg width="15" height="16" viewBox="0 0 15 16" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 10V8H7V6.00208H12V4L15 7L12 10ZM11 9V13H6V16L0 13V0H11V5H10V1H2L6 3V12H10V9H11Z"
                            fill="#5a5a5a" />
                    </svg>
                    <div class="paddingRight10">خروج</div>
                </a>
            </div>
        @endif

    </div>
</div>

<script>
    function clearLocalStorage() {
        localStorage.clear();
    }
    // function createNewMenuSideBar(_data) {
    //     var subHtml = '';
    //     _data.sub.map(item => subHtml += `<a href="${item.url}" class="sideNavItem ${item.selected == 1 ? 'selected' : ''}">
    //                                         <span>${item.icon}</span>
    //                                         <span>${item.title}</span>
    //                                     </a>`);

    //     var html = `<div class="sideNavRow open backOrang">
    //                 <div class="sideNavHeader hasBody">
    //                     <span>${_data.title}</span>
    //                     <i class="fas fa-angle-down"></i>
    //                 </div>
    //                 <div class="sideNavBody">${subHtml}</div>
    //             </div>`;

    //     document.getElementById('lastItemOfSideMenu').insertAdjacentHTML('beforebegin', html);
    // }
</script>
