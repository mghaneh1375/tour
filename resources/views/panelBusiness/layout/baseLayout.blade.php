<!doctype html>
<html lang="fa">

<head>
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <meta name="theme-color" content="#30b4a6" />
    <meta name="msapplication-TileColor" content="#30b4a6">
    <meta name="msapplication-TileImage" content="{{ URL::asset('images/icons/mainIcon.png') }}">
    <meta name="twitter:card" content="summary" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:site_name" content="سامانه جامع گردشگری کوچیتا" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="{{ URL::asset('BusinessPanelPublic/css/fonts.css?v=' . $fileVersions) }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/form.css?v=' . $fileVersions) }}" />
    <link rel="icon" href="{{ URL::asset('images/icons/KOFAV0.svg') }}" sizes="any" type="image/svg+xml">
    <link rel="apple-touch-icon-precomposed" href="{{ URL::asset('images/icons/KOFAV0.svg') }}" sizes="any"
        type="image/svg+xml">

    <link rel='stylesheet' type='text/css' href='{{ URL::asset('css/bootstrap/bootstrap-rtl.min.css') }}'
        media="all" />
    <link rel='stylesheet' type='text/css' href='{{ URL::asset('css/shazdeDesigns/icons.css?v=' . $fileVersions) }}'
        media="all" />

    <link rel="stylesheet" href="{{ URL::asset('css/component/generalFolder.css?v=' . $fileVersions) }}">
    <link rel="stylesheet" href="{{ URL::asset('BusinessPanelPublic/css/allBusinessPanel.css?v=' . $fileVersions) }}">

    <script src="{{ URL::asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="{{ URL::asset('js/bootstrap/bootstrap-rtl.min.js') }}"></script>
    <script src="{{ URL::asset('BusinessPanelPublic/js/allBusinessPanel.js?v=' . $fileVersions) }}"></script>

    <script>
        $.ajaxSetup({
            xhrFields: {
                withCredentials: true
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
    </script>

    @yield('head')

    <link rel="stylesheet" href="{{ URL::asset('packages/fontAwesome6/css/all.min.css') }}">
    <script src="{{ URL::asset('packages/fontAwesome6/js/all.min.js') }}"></script>

    <script>
        var csrfTokenGlobal = '{{ csrf_token() }}';
    </script>

</head>

<body>
    @include('panelBusiness.layout.businessPanelGeneral')
    @include('panelBusiness.layout.header')

    @if (auth()->check())
        @include('panelBusiness.layout.sideBar')
    @endif

    <div class="mainBodySection">

        @yield('body')
    </div>

    @yield('modals')
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

    <script>
        const p2e = s => s.replace(/[۰-۹]/g, d => '۰۱۲۳۴۵۶۷۸۹'.indexOf(d));

        function remove(id) {
            selectedFormRemoveId = id;
        }

        function doRemove() {
            console.log('asd');
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
    </script>

    @yield('script')

</body>

</html>
