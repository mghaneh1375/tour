<!doctype html>
<html class="no-js" lang="en">

<head>

    @section('header')
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Koochita</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- favicon
                        ============================================ -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('img/favicon.png') }}">
        <!-- Google Fonts
                        ============================================ -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i,800" rel="stylesheet">
        <!-- Bootstrap CSS
                        ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
        <!-- Bootstrap CSS
                        ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}">

        <!-- adminpro icon CSS
                        ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/adminpro-custon-icon.css') }}">

        <!-- meanmenu icon CSS
                        ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/meanmenu.min.css') }}">

        <!-- mCustomScrollbar CSS
                        ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/jquery.mCustomScrollbar.min.css') }}">

        <!-- animate CSS
                        ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/animate.css') }}">

        <!-- jvectormap CSS
                        ============================================ -->
        {{--        <link rel="stylesheet" href="{{URL::asset('css/jvectormap/jquery-jvectormap-2.0.3.css')}}"> --}}

        <!-- normalize CSS
                        ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/data-table/bootstrap-table.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/data-table/bootstrap-editable.css') }}">

        <!-- normalize CSS
                        ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/normalize.css') }}">
        <!-- charts CSS
                        ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/c3.min.css') }}">
        <!-- style CSS
                        ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
        <!-- responsive CSS
                        ============================================ -->
        <link rel="stylesheet" href="{{ URL::asset('css/responsive.css') }}">

        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- modernizr JS
                        ============================================ -->
        <script src="{{ URL::asset('js/vendor/modernizr-2.8.3.min.js') }}"></script>
        <script src="{{ URL::asset('js/jquery.min.js') }}"></script>

        <style>
            .dropdown-item {
                text-align: right;
            }

            .main-sparkline8-hd {
                direction: rtl;
            }

            .hidden {
                display: none !important;
            }

            .calendar>table {
                width: 100%;
            }

            .clickable {
                cursor: pointer;
                color: #d1b676;
            }

            .btn-success,
            .btn-primary {
                color: white !important;
            }

            .modal-header {
                direction: rtl !important;
            }

            table {
                margin-top: 20px;
            }

            td {
                padding: 7px;
                text-align: center;
                border: 1px solid;
            }

            tr:nth-child(even) {
                background-color: #d1d1d1;
            }

            .modal-body p {
                margin-top: 10px;
            }

            #myModal {
                width: 40%;
                padding: 20px;
                left: 30%;
                top: 200px;
                direction: rtl;
            }

            #myModal .modal-content {
                padding: 30px;
            }

            .green {
                background-color: #31a033 !important;
                color: white !important;
            }

            .red {
                background-color: #ca0e0e !important;
                color: white !important;
            }

            .back {
                float: left;
                color: #ca0e0e;
                cursor: pointer;
            }
        </style>

        <script>
            var selectedFormRemoveId;

            function validateNumber(evt) {
                var theEvent = evt || window.event;

                // Handle paste
                if (theEvent.type === 'paste') {
                    key = event.clipboardData.getData('text/plain');
                } else {
                    // Handle key press
                    var key = theEvent.keyCode || theEvent.which;
                    key = String.fromCharCode(key);
                }
                var regex = /[0-9]|\./;
                if (!regex.test(key)) {
                    theEvent.returnValue = false;
                    if (theEvent.preventDefault) theEvent.preventDefault();
                }
            }
        </script>

    @show

</head>

<body class="materialdesign" style="direction: rtl !important;">

    <!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
    <!-- Header top area start-->
    <div class="wrapper-pro">
        <div class="left-sidebar-pro">
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3>خوش آمدید</h3>
                </div>
                <div class="left-custom-menu-adp-wrap">

                    <?php $unSeenMsgs = \App\models\FormCreator\Notification::whereSeen(false)->count(); ?>

                    @if ($unSeenMsgs > 0)
                        <a href="{{ route('notifications') }}" target="_blank"
                            style="color: red; font-size: 18px; font-weight: bolder; margin-right: 20px; margin-top: 20px; cursor: pointer">{{ $unSeenMsgs }}
                            پیام جدید</a>
                    @endif

                    <ul class="nav navbar-nav left-sidebar-menu-pro">
                        @if (\Illuminate\Support\Facades\Auth::check())
                            <li>
                                <a href="{{ route('home') }}" aria-expanded="false"><i class="fa big-icon fa-home"></i>
                                    <span class="mini-dn">خانه</span> <span class="indicator-right-menu mini-dn"><i
                                            class="fa indicator-mn fa-angle-left"></i></span></a>
                            </li>

                            <li class="nav-item"><a href="#" data-toggle="dropdown" role="button"
                                    aria-expanded="false" class="nav-link dropdown-toggle"><i
                                        class="fa big-icon fa-envelope"></i> <span
                                        onclick="document.location.href = '{{ url('asset') }}'" class="mini-dn">مدیریت
                                        محتوا</span> <span class="indicator-right-menu mini-dn"><i
                                            class="fa indicator-mn fa-angle-left"></i></span></a></li>
                            {{--                        <li class="nav-item"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-envelope"></i> <span onclick="document.location.href = '{{url('messages')}}'" class="mini-dn">مدیریت پیام ها</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a></li> --}}
                            {{--                        <li class="nav-item"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-envelope"></i> <span onclick="document.location.href = '{{url('complaints')}}'" class="mini-dn">شکایات</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a></li> --}}

                            <li class="nav-item"><a href="#" data-toggle="dropdown" role="button"
                                    aria-expanded="false" class="nav-link dropdown-toggle"><i
                                        class="fa big-icon fa-table"></i> <span class="mini-dn">گزارش گیری</span> <span
                                        class="indicator-right-menu mini-dn"><i
                                            class="fa indicator-mn fa-angle-left"></i></span></a>
                                <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                                    <a href="{{ url('report') }}" class="dropdown-item">گزارش گیری</a>
                                    <a href="{{ url('notifications') }}" class="dropdown-item">نوتیفیکیشن ها</a>
                                </div>
                            </li>

                            <li class="nav-item"><a href="#" data-toggle="dropdown" role="button"
                                    aria-expanded="false" class="nav-link dropdown-toggle"><i
                                        class="fa big-icon fa-table"></i> <span class="mini-dn">پروفایل کاربری</span>
                                    <span class="indicator-right-menu mini-dn"><i
                                            class="fa indicator-mn fa-angle-left"></i></span></a>
                                <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                                    <a href="{{ route('logout') }}" class="dropdown-item">خروج</a>
                                </div>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('businessPanel.loginPage') }}" aria-expanded="false"><i
                                        class="fa big-icon fa-login"></i> <span class="mini-dn">ورود</span> <span
                                        class="indicator-right-menu mini-dn"><i
                                            class="fa indicator-mn fa-angle-left"></i></span></a>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>
        </div>

        <div class="content-inner-all">
            @yield('content')
        </div>

        <div id="removeModal" class="modal fade" role="dialog">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title">آیا از حذف این آیتم اطمینان دارید؟</h4>
                    </div>

                    <div class="modal-footer">
                        <button id="closeRemoveModalBtn" type="button" class="btn btn-default"
                            data-dismiss="modal">انصراف</button>
                        <input onclick="doRemove()" type="submit" class="btn btn-success" value="تایید">
                    </div>

                </div>

            </div>
        </div>

        @section('reminder')
            <!-- jquery
                    ============================================ -->
            <script src="{{ URL::asset('js/vendor/jquery-1.11.3.min.js') }}"></script>
            <!-- bootstrap JS
                        ============================================ -->
            <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
            <!-- meanmenu JS
                        ============================================ -->
            <script src="{{ URL::asset('js/jquery.meanmenu.js') }}"></script>
            <!-- mCustomScrollbar JS
                        ============================================ -->
            <script src="{{ URL::asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
            <!-- sticky JS
                        ============================================ -->
            <script src="{{ URL::asset('js/jquery.sticky.js') }}"></script>
            <!-- scrollUp JS
                        ============================================ -->
            <script src="{{ URL::asset('js/jquery.scrollUp.min.js') }}"></script>
            <!-- scrollUp JS
                        ============================================ -->
            <script src="{{ URL::asset('js/wow/wow.min.js') }}"></script>
            <!-- counterup JS
                        ============================================ -->
            <script src="{{ URL::asset('js/counterup/jquery.counterup.min.js') }}"></script>
            <script src="{{ URL::asset('js/counterup/waypoints.min.js') }}"></script>
            <script src="{{ URL::asset('js/counterup/counterup-active.js') }}"></script>
            <!-- jvectormap JS
                        ============================================ -->
            {{-- <script src="{{URL::asset('js/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script> --}}
            {{-- <script src="{{URL::asset('js/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script> --}}
            {{-- <script src="{{URL::asset('js/jvectormap/jvectormap-active.js')}}"></script> --}}
            <!-- peity JS
                            ============================================ -->
            <script src="{{ URL::asset('js/peity/jquery.peity.min.js') }}"></script>
            <script src="{{ URL::asset('js/peity/peity-active.js') }}"></script>
            <!-- sparkline JS
                        ============================================ -->
            <script src="{{ URL::asset('js/sparkline/jquery.sparkline.min.js') }}"></script>
            <script src="{{ URL::asset('js/sparkline/sparkline-active.js') }}"></script>

            <!-- data table JS
                        ============================================ -->
            <script src="{{ URL::asset('js/data-table/bootstrap-table.js') }}"></script>
            <script src="{{ URL::asset('js/data-table/tableExport.js') }}"></script>
            <script src="{{ URL::asset('js/data-table/data-table-active.js') }}"></script>
            <script src="{{ URL::asset('js/data-table/bootstrap-table-editable.js') }}"></script>
            <script src="{{ URL::asset('js/data-table/bootstrap-editable.js') }}"></script>
            <script src="{{ URL::asset('js/data-table/bootstrap-table-resizable.js') }}"></script>
            <script src="{{ URL::asset('js/data-table/colResizable-1.5.source.js') }}"></script>
            <script src="{{ URL::asset('js/data-table/bootstrap-table-export.js') }}"></script>
            <!-- main JS
                        ============================================ -->
            <script src="{{ URL::asset('js/main.js') }}"></script>

            <script type="text/javascript">
                function remove(id) {
                    selectedFormRemoveId = id;
                }

                function doRemove() {
                    $.ajax({
                        type: 'delete',
                        url: delUrl + selectedFormRemoveId,
                        success: function(res) {
                            if (res.status === "0") {
                                $("#tr_" + selectedFormRemoveId).remove();
                                $("#closeRemoveModalBtn").click();
                            }
                        }
                    });
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            </script>
        @show
    </div>
</body>
