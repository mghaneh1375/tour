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
        <div class="sideNavRow">
            <div class="sideNavHeader hasBody">داشبورد</div>
            <div class="sideNavBody">
                @if(\Illuminate\Support\Facades\Auth::user()->level != 0)
                    <a href="{{route('businessPanel.contracts')}}" class="sideNavItem">متن قرارداد ها</a>
                    <a href="{{route('businessPanel.getUnChecked')}}" class="sideNavItem">درخواست های تعیین تکلیف نشده</a>
                @endif
                <a href="{{route('businessPanel.create')}}" class="sideNavItem">ایجاد کسب و کار جدید</a>
                <a href="{{route('businessPanel.myBusinesses')}}" class="sideNavItem">کسب و کارهای من</a>
                <a href="{{route('businessPanel.completeUserInfo')}}" class="sideNavItem">تغییر اطلاعات فردی</a>
            </div>
        </div>
    </div>
</div>
