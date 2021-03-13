@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>لیست تورها</title>

    <style>

        .selectEditCardSection{
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: center;
        }
        .selectEditCardSection .editCard{
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            border-radius: 15px;
            height: 170px;
            width: 165px;
            margin: 11px 10px;
            text-align: center;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            color: white;
            box-shadow: 1px 2px 3px 2px #00000073;
        }
        .selectEditCardSection .editCard.card1{
            background: linear-gradient(45deg, #0014ff, #0014ff75);
        }
        .selectEditCardSection .editCard.card2{
            background: linear-gradient(45deg, #ff00c8, #0014ff75);
        }
        .selectEditCardSection .editCard.card3{
            background: linear-gradient(45deg, #ff0000, #ff00c88a);
        }
        .selectEditCardSection .editCard.card4{
            background: linear-gradient(45deg, #ffb000, #ff0000d6);
        }
        .selectEditCardSection .editCard.card5{
            background: linear-gradient(45deg, #00ff4e, #0049ff);
        }
        .selectEditCardSection .editCard .icon{
            font-size: 3em;
            transition: .3s;
        }
        .selectEditCardSection .editCard .name{

        }
        .selectEditCardSection .editCard .name .stage{
            font-size: .6em;
        }
        .selectEditCardSection .editCard .name .text{
            font-weight: bold;
            font-size: .8em;
            margin-top: 8px;
        }

        .selectEditCardSection .editCard:hover .icon{
            transform: scale(1.1);
        }
    </style>
@endsection


@section('body')
    <div class="mainBackWhiteBody">
        <div class="head">لیست تور ها</div>
        <div>
            <table class="table table-striped">
                <thead style="background: var(--koochita-blue); color: white;">
                    <tr>
                        <th>#</th>
                        <th>عنوان</th>
                        <th>مبدا</th>
                        <th>مقصد</th>
                        <th>روز / شب</th>
                        <th>وضعیت</th>
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
                        <button type="button" class="closee" data-dismiss="modal" style="border: none; background: none; float: left">&times;</button>
                    </div>
                    <div class="selectEditCardSection">
                        <div class="editCard card1" onclick="goToEditPage(1)">
                            <div class="icon">
                                <i class="fa-duotone fa-info"></i>
                            </div>
                            <div class="name">
                                <div class="stage">قدم اول</div>
                                <div class="text">اطلاعات اولیه</div>
                            </div>
                        </div>
                        <div class="editCard card2" onclick="goToEditPage(2)">
                            <div class="icon">
                                <i class="fa-duotone fa-calendar-pen"></i>
                            </div>
                            <div class="name">
                                <div class="stage">قدم دوم</div>
                                <div class="text">برنامه سفر</div>
                            </div>
                        </div>
                        <div class="editCard card3" onclick="goToEditPage(3)">
                            <div class="icon">
                                <i class="fa-duotone fa-plane-tail"></i>
                            </div>
                            <div class="name">
                                <div class="stage">قدم سوم</div>
                                <div class="text">اطلاعات حمل و نقل</div>
                            </div>
                        </div>
                        <div class="editCard card4" onclick="goToEditPage(4)">
                            <div class="icon">
                                <i class="fa-duotone fa-sack-dollar"></i>
                            </div>
                            <div class="name">
                                <div class="stage">قدم چهارم</div>
                                <div class="text">اطلاعات مالی</div>
                            </div>
                        </div>
                        <div class="editCard card5" onclick="goToEditPage(5)">
                            <div class="icon">
                                <i class="fa-duotone fa-clipboard-list-check"></i>
                            </div>
                            <div class="name">
                                <div class="stage">قدم پنجم</div>
                                <div class="text">اطلاعات اضافی</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer fullyCenterContent">
                    <button class="btn " data-dismiss="modal">بستن</button>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        var tours = [];
        var openEditIndex = null;

        function getTourList(){
            openLoading();
            $.ajax({
                type: 'GET',
                url: '{{route("businessManagement.tour.getLists", ['business' => $businessIdForUrl])}}',
                complete: closeLoading,
                success: response => {
                    if(response.status == 'ok'){
                        tours = response.result;
                        createTourList();
                    }
                    else
                        showSuccessNotifiBP('Server Error', 'left', 'red');
                },
                error: err => {
                    showSuccessNotifiBP('Connection Error', 'left', 'red');
                }
            })
        }

        function createTourList(){
            var html = '';
            tours.map((item, index) => {
                html += `<tr>
                            <td>${index+1}</td>
                            <td>
                                ${item.name}
                                ${item.isLocal == 1 ? '(شهرگردی)' : ''}
                            </td>
                            <td>${item.srcName}</td>
                            <td>${item.destName}</td>
                            <td>${item.day} روز / ${item.night} شب</td>
                            <td>${item.status}</td>
                            <td>
                                <div class="circleButton yellowBut" title="اطلاعات کامل تور">
                                    <i class="fa-regular fa-info"></i>
                                </div>
                                <button class="circleButton editBut" title="ویرایش" onclick="editTour(${index})">
                                    <i class="fa-light fa-pen-to-square"></i>
                                </button>
                                <button class="circleButton deleteBut" title="حذف" onclick="deleteTour(${index})">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </td>
                        </tr>`
            });

            document.getElementById('toursListTBody').innerHTML = html;
        }

        function editTour(_index){
            openEditIndex = _index;
            $('#editTourModal').modal('show');
        }

        function goToEditPage(_stage){
            openLoading(false, () => location.href = `{{url("businessManagement/{$businessIdForUrl}/tour/create")}}/stage_${_stage}/${tours[openEditIndex].id}`)
        }

        function deleteTour(_index){

        }

        $(window).ready(() => {
           getTourList();
        });
    </script>
@endsection

