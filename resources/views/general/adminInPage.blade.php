@if(auth()->check() && auth()->user()->level == 1)
    <style>
        .adminSetting{
            background-color: red;
            width: 50px;
            height: 100px;
            position: fixed;
            right: 0px;
            top: 20px;
            z-index: 9;
            border-radius: 30px 0px 0px 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            top: 0;
            right: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
            text-align:center;
            z-index: 999;
            color: white;
        }
        .sidenav a:hover{
            color: #f1f1f1;
        }
        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }
        .settingSection{
            background: white;
            padding: 24px;
            text-align: right;
            color: black;
            direction: rtl;
            text-align: right;
        }
        .settingTabs{
            cursor: pointer;
        }
        .settingSubSection{
            width: 100%;
            background-color: #bbbbbb;
            padding: 15px;
            border-radius: 10px;
        }
        @media screen and (max-height: 450px) {
            .sidenav {padding-top: 15px;}
            .sidenav a {font-size: 18px;}
        }
    </style>
    <div class="adminSetting"  onclick="openNav()">
        <span style="transform: rotate(-90deg);">ویرایش صفحه</span>
    </div>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        @if(Request::is('main/*') || Request::is('main') || Request::is('/'))
            @include('general.adminSetting.mainPageSetting')
        @endif
    </div>

    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "100%";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }

        function toggleSettingSection(_element){
            $(_element).next().toggle();
        }
    </script>
@endif
