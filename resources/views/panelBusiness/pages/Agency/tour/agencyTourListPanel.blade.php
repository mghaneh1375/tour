@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>لیست تورها</title>

    <link rel="stylesheet" href="{{ URL::asset('BusinessPanelPublic/css/tour/commonTour.css') }}">

    <style>
        table {
            font-size: 13px;
        }

        table thead th {
            font-weight: normal;
        }

        .editButton {
            color: black;
            background: white;
            font-size: 11px;
            display: flex;
            align-items: center;
            border-color: var(--koochita-blue);
        }
    </style>
@endsection


@section('body')
    <div class="mainBackWhiteBody" style="height: 100%;">
        <div class="head">لیست تور ها</div>
        <div>
            <table class="table table-striped">
                <thead style="background: var(--koochita-blue); color: white;">
                    <tr>
                        <th>#</th>
                        <th>کد تور</th>
                        <th>عنوان</th>
                        <th>نوع تور</th>
                        <th>وضعیت</th>
                        <th>تعداد تاریخ های تعریف شده</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="toursListTBody"></tbody>
            </table>
        </div>
    </div>
@endsection


@section('modals')
    <div id="editTourModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" style="direction: rtl">
                    <div class="fullwidthDiv" style="display: flex; justify-content: space-between;">
                        <div class="addPlaceGeneralInfoTitleTourCreation">قصد ویرایش کدام مرحله را دارید</div>
                        <button type="button" class="closee" data-dismiss="modal"
                            style="border: none; background: none; float: left">&times;</button>
                    </div>
                    <div id="editModalSelectBody" class="selectEditCardSection"></div>
                </div>
                <div class="modal-footer fullyCenterContent">
                    <button class="btn " data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var getFullDataUrl = '{{ url("businessManagement/{$businessIdForUrl}/tour/getFullyData") }}';
        var getListUrl = '{{ route('businessManagement.tour.getLists', ['business' => $businessIdForUrl]) }}';
        var editTourUrl = '{{ url("businessManagement/{$businessIdForUrl}/tour/create") }}';
        var deleteTourUrl = '{{ route('businessManagement.tour.delete') }}';

        var cityTourismEdit = [{
                stage: 1,
                topTitle: 'مرحله اول',
                title: 'اطلاعات اصلی',
                icon: '<i class="fa-duotone fa-info"></i>',
            },
            {
                stage: 2,
                topTitle: 'مرحله دوم',
                title: 'اطلاعات برگزاری',
                icon: '<i class="fa-duotone fa-info"></i>',
            },
            {
                stage: 3,
                topTitle: 'مرحله سوم',
                title: 'برنامه سفر',
                icon: '<i class="fa-duotone fa-calendar-pen"></i>',
            },
            {
                stage: 4,
                topTitle: 'مرحله چهارم',
                title: 'اطلاعات تکمیلی',
                icon: '<i class="fa-duotone fa-clipboard-list-check"></i>',
            },
        ]
    </script>

    {{-- <script src="{{URL::asset('BusinessPanelPublic/js/tour/tourList.js?v='.$fileVersions)}}"></script> --}}
    <script src="{{ URL::asset('BusinessPanelPublic/js/tour/tourList.js?v=300') }}"></script>
@endsection
