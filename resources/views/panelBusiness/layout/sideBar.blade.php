<div id="mainSideBar" class="mainSidebar">

    <div class="progressBarSection">
        <div class="text">
            <span id="sideProgressBarNumber">0%</span> کامل شده
        </div>
        <div class="progressBarDiv">
            <div id="sideProgressBarFull" class="full"></div>
        </div>
    </div>

    <div class="sideMenuSection">
        @if(\Illuminate\Support\Facades\Auth::user()->level != 0)
            <div class="sideNavRow">
                <div class="sideNavHeader hasBody">
                    <span>مدیریت</span>
                    <i class="fas fa-angle-down"></i>
                </div>
                <div class="sideNavBody">
                    <a href="{{route('businessPanel.contracts')}}" class="sideNavItem">متن قرارداد ها</a>
                    <a href="{{route('businessPanel.getUnChecked')}}" class="sideNavItem">درخواست های تعیین تکلیف نشده</a>
                </div>
            </div>

            <div class="sideNavRow">
                <a href="{{route("ticket.admin.page")}}" class="sideNavHeader">
                    <span>پشتیبانی</span>
                    @if($newTicketCount > 0)
                        <span class="newTicketCount">{{$newTicketCount}}</span>
                    @endif
                </a>
            </div>
        @else
            @if(isset($businessType))
                @if($businessType === 'agency')
                    <div class="sideNavRow">
                        <div class="sideNavHeader hasBody">
                            <span>مدیریت تورها</span>
                            <i class="fas fa-angle-down"></i>
                        </div>
                        <div class="sideNavBody">
                            <a href="{{route('businessManagement.tour.list', ['business' => $businessIdForUrl])}}" class="sideNavItem">لیست تورها</a>
                            <a href="{{route('businessManagement.tour.create', ['business' => $businessIdForUrl])}}" class="sideNavItem">ایجاد تور جدید</a>
                        </div>
                    </div>
                @endif
                <div id="lastItemOfSideMenu" class="sideNavRow showInBottom">
                    <a href="{{route("businessPanel.myBusinesses")}}" class="sideNavHeader hasBody">
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
                        <a href="{{route('businessPanel.create')}}" class="sideNavItem">ایجاد کسب و کار جدید</a>
                        <a href="{{route('businessPanel.myBusinesses')}}" class="sideNavItem">کسب و کارهای من</a>
                        <a href="{{route('businessPanel.completeUserInfo')}}" class="sideNavItem">تغییر اطلاعات فردی</a>
                    </div>
                </div>
            @endif
        @endif


    </div>
</div>

<script>
    function createNewMenuSideBar(_data){
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
