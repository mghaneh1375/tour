@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>اطلاعات تور {{ $tour->name }}</title>
    <link rel="stylesheet" href="{{ URL::asset('packages/leaflet/leaflet.css') }}">

    <style>
        .tourInfoPage .infoSections {
            margin-top: 30px;
        }

        .tourInfoPage .infoSections .infoHeader {
            font-size: 22px;
            background: #fcc15682;
            padding: 10px;
            border-radius: 5px 5px 0px 0px;
            color: black;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
        }

        .tourInfoPage .infoSections .infoBody {
            border: solid 1px #fcc15682;
            max-height: 0px;
            overflow: hidden;
            transition: .3s;
        }

        .tourInfoPage .infoSections .infoBody.show {
            max-height: 2000px;
        }


        .tourInfoPage .infoRow {
            border-bottom: solid 1px #fddfa9;
            padding: 10px 0px;
            margin-bottom: 10px;
        }

        .tourInfoPage .infoRow .infoSec {
            display: flex;
            font-size: 19px;
            align-items: center;
        }

        .tourInfoPage .infoRow .infoSec .infoTitle {
            margin-left: 10px;
            font-size: .8em;
            color: #000a46;
        }

        .tourInfoPage .infoRow .infoSec .infoVal {
            font-weight: bold;
        }

        .tourInfoPage .infoRow .infoSec .picSec {
            width: 300px;
            height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 10px;
        }

        .tourInfoPage .infoRow .infoSec .picSec>img {
            max-width: 100%;
            max-height: 100%;
        }

        .tourInfoPage .importantNote {
            font-weight: bold;
            color: var(--koochita-blue) !important;
        }

        .tourInfoPage .timeRow {
            border-bottom: solid 1px #eaeaea;
            padding-bottom: 5px;
            margin-bottom: 5px;
            height: auto;
        }
    </style>
@endsection


@section('body')
    <div class="mainBackWhiteBody tourInfoPage">
        <div class="head">اطلاعات تور {{ $tour->name }}</div>
        <div>
            <div class="infoSections">
                <div>
                    <div class="infoHeader" onclick="openCloseTabs(1)">
                        <div>
                            <i class="fa-duotone fa-info"></i>
                            <span>اطلاعات اولیه</span>
                        </div>
                        <i class="fas fa-angle-down"></i>
                    </div>
                    <div id="infoBody_1" class="infoBody show">
                        <div class="row infoRow">
                            <div class="col-md-3 infoSec">
                                <div class="infoTitle">نام تور:</div>
                                <div class="infoVal">{{ $tour->name }}</div>
                            </div>

                            <div class="col-md-3 infoSec">
                                <div class="infoTitle">وضعیت تور:</div>
                                <div id="tourPublishStatusText" class="infoVal"
                                    style="color: {{ $tour->statusCode == 0 ? '#caca00' : ($tour->statusCode == 1 ? 'red' : 'green') }}">
                                    {{ $tour->statusText }}</div>
                            </div>

                            @if ($tour->confirm == 1)
                                <div class="col-md-3 infoSec">
                                    <div class="infoVal">
                                        <button id="tourPublishButton"
                                            class="btn btn-{{ $tour->statusCode == 1 ? 'success' : 'warning' }}"
                                            onclick="changeTourStatus()">{{ $tour->statusCode == 1 ? 'تغییر به حالت انتشار' : 'تغییر به حالت پیش نویس' }}</button>
                                    </div>
                                </div>
                            @endif

                        </div>

                        <div class="row infoRow">
                            <div class="col-md-3 infoSec">
                                <div class="infoTitle">نوع تور:</div>
                                <div class="infoVal">{{ $tour->isLocal == 1 ? 'شهرگردی' : 'بین شهری' }}</div>
                            </div>
                            <div class="col-md-3 infoSec">
                                <div class="infoTitle">مبدا تور:</div>
                                <div class="infoVal">{{ $tour->srcName ?? '' }}</div>
                            </div>
                            <div class="col-md-3 infoSec">
                                <div class="infoTitle">مقصد تور:</div>
                                <div class="infoVal">{{ $tour->destName ?? '' }}</div>
                            </div>
                        </div>

                        <div class="row infoRow">
                            <div class="col-md-3 infoSec">
                                <div class="infoTitle">تعداد روز تور:</div>
                                <div class="infoVal">{{ $tour->day }}</div>
                            </div>
                            <div class="col-md-3 infoSec">
                                <div class="infoTitle">تعداد شب تور:</div>
                                <div class="infoVal">{{ $tour->night }}</div>
                            </div>
                        </div>

                        <div class="row infoRow">
                            <div class="col-md-3 infoSec">
                                <div class="infoTitle">حداقل ظرفیت تور:</div>
                                <div class="infoVal">{{ $tour->minCapacity }}</div>
                            </div>
                            <div class="col-md-3 infoSec">
                                <div class="infoTitle">حداکثر ظرفیت تور:</div>
                                <div class="infoVal">{{ $tour->maxCapacity }}</div>
                            </div>
                            @if ($tour->anyCapacity == 1)
                                <div class="col-md-3 infoSec">
                                    <div class="infoTitle importantNote">تور من با هر ظرفیتی برگزاری می شود</div>
                                </div>
                            @endif
                            @if ($tour->private == 1)
                                <div class="col-md-3 infoSec">
                                    <div class="infoTitle importantNote">تور به صورت خصوصی</div>
                                </div>
                            @endif
                        </div>

                        <div class="row infoRow">
                            <div class="col-md-9 infoSec">
                                <div class="infoTitle">اطلاعات مسافرین:</div>
                                <div class="infoVal">
                                    @foreach ($tour->userInfoNeed as $item)
                                        {{ $item }} -
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-3 infoSec">
                                <div class="infoTitle importantNote">
                                    {{ $tour->allUserInfoNeed == 1 ? 'اطلاعات تک تک مسافرین مورد نیاز است' : 'فقط اطلاعات یک مسافر نیاز است' }}
                                </div>
                            </div>
                        </div>

                        <div class="row infoRow">
                            <div class="col-md-9 infoSec">
                                <div class="infoTitle">تاریخ های برگزاری:</div>
                            </div>
                            <div class="col-md-12">
                                @foreach ($tour->times as $time)
                                    <div class="row timeRow" style="height: auto">
                                        <div class="col-md-2">{{ $time->sDate }}</div>
                                        <div class="col-md-2">{{ $time->eDate }}</div>
                                        <div class="col-md-2">
                                            کد تور:
                                            {{ $time->code }}
                                        </div>
                                        <div class="col-md-2">
                                            تعداد ثبت نامی:
                                            {{ $time->registered }}
                                        </div>
                                        <div id="timeStatus_{{ $time->id }}" class="col-md-2"
                                            style="color: {{ $time->isPublished == 1 ? 'green' : 'red' }}">
                                            {{ $time->isPublished == 1 ? 'قابل ثبت نام' : 'توقف ثبت نام' }}
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-primary" style="font-size: 10px;"
                                                onclick="changeTimeStatus({{ $time->id }})">تغییر وضعیت ثبت
                                                نام</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row infoRow">
                            <div class="col-md-6 infoSec">
                                <div class="infoTitle">قابلیت کنسلی:</div>
                                <div class="infoVal" style="color: {{ $tour->cancelAble == 1 ? 'green' : 'red' }}">
                                    {{ $tour->cancelAble == 1 ? 'دارد' : 'ندارد' }}</div>
                            </div>

                            @if ($tour->cancelAble == 1)
                                <div class="col-md-12 infoSec">
                                    <div class="infoTitle">توضیج کنسلی:</div>
                                    <div class="infoVal">{{ $tour->cancelDescription ?? '' }}</div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

                <div>
                    <div class="infoHeader" onclick="openCloseTabs(2)">
                        <div>
                            <i class="fa-duotone fa-plane-tail"></i>
                            <span>اطلاعات برگزاری</span>
                        </div>
                        <i class="fas fa-angle-down"></i>
                    </div>
                    <div id="infoBody_2" class="infoBody">
                        <div class="row infoRow">
                            <div class="col-md-3 infoSec">
                                <div class="infoTitle"
                                    style="color: {{ $tour->isTransport == 1 ? 'green' : 'red' }}; font-weight: bold;">
                                    {{ $tour->isTransport == 1 ? 'حمل و نقل با تور است' : 'حمل و نقل با مسافر است' }}</div>
                            </div>
                        </div>

                        @if ($tour->isTransport == 1)
                            <div class="row infoRow">
                                <div class="col-md-12 infoSec">
                                    <div class="infoTitle">رفت</div>
                                </div>
                                <div class="col-md-3 infoSec">
                                    <div class="infoTitle">وسیله رفت:</div>
                                    <div class="infoVal">{{ $tour->transport->sType }}</div>
                                </div>
                                <div class="col-md-3 infoSec">
                                    <div class="infoTitle">ساعت حرکت:</div>
                                    <div class="infoVal">{{ $tour->transport->sTime }}</div>
                                </div>
                                <div class="col-md-9 infoSec">
                                    <div class="infoTitle">آدرس محل حرکت:</div>
                                    <div class="infoVal">{{ $tour->transport->sAddress }}</div>
                                </div>
                                <div class="col-md-2 infoSec">
                                    <div class="infoVal">
                                        <button class="btn btn-primary" onclick="changeCenter('src')">نقشه</button>
                                    </div>
                                </div>
                                <div class="col-md-12 infoSec">
                                    <div class="infoTitle">توضیحات رفت:</div>
                                    <div class="infoVal">{{ $tour->transport->sDescription }}</div>
                                </div>

                            </div>

                            <div class="row infoRow">
                                <div class="col-md-12 infoSec">
                                    <div class="infoTitle">برگشت</div>
                                </div>
                                <div class="col-md-3 infoSec">
                                    <div class="infoTitle">وسیله برگشت:</div>
                                    <div class="infoVal">{{ $tour->transport->eType }}</div>
                                </div>
                                <div class="col-md-3 infoSec">
                                    <div class="infoTitle">ساعت برگشت:</div>
                                    <div class="infoVal">{{ $tour->transport->eTime }}</div>
                                </div>
                                <div class="col-md-9 infoSec">
                                    <div class="infoTitle">آدرس محل برگشت:</div>
                                    <div class="infoVal">{{ $tour->transport->eAddress }}</div>
                                </div>
                                <div class="col-md-2 infoSec">
                                    <div class="infoVal">
                                        <button class="btn btn-primary" onclick="changeCenter('dest')">نقشه</button>
                                    </div>
                                </div>
                                <div class="col-md-12 infoSec">
                                    <div class="infoTitle">توضیحات برگشت:</div>
                                    <div class="infoVal">{{ $tour->transport->eDescription }}</div>
                                </div>
                            </div>
                        @endif


                        <div class="row infoRow">
                            <div class="col-md-12 infoSec">
                                <div class="infoTitle">حمل و نقل فرعی:</div>
                                <div class="infoVal">
                                    @foreach ($tour->sideTransport as $item)
                                        {{ $item }} -
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="row infoRow">
                            <div class="col-md-12 infoSec">
                                <div class="infoTitle">زبان های برگزاری تور:</div>
                                <div class="infoVal">
                                    @foreach ($tour->language as $item)
                                        {{ $item }} -
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="row infoRow">
                            <div class="col-md-12 infoSec">
                                <div class="infoTitle">وعده غذایی: </div>
                                <div class="infoVal" style="color: {{ $tour->isMeal == 1 ? 'green' : 'red' }}">
                                    {{ $tour->isMeal == 1 ? 'بر عهده تور' : 'ندارد' }}</div>
                                @if ($tour->isMeal == 1)
                                    <div class="infoVal importantNote" style="margin-right: 20px;">
                                        {{ $tour->isMealAllDay == 1 ? 'تمام روزهای تور' : 'بعضی روزها' }}</div>
                                @endif
                            </div>

                            @if ($tour->isMeal == 1)
                                <div class="col-md-12 infoSec">
                                    <div class="infoTitle">وعده های غذایی: </div>
                                    @if ($tour->isMealAllDay == 1)
                                        <div class="infoVal">
                                            @foreach ($tour->meals as $item)
                                                {{ $item }} -
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                @if ($tour->isMealAllDay == 0)
                                    <div class="col-md-12">
                                        @foreach ($tour->meals as $index => $meals)
                                            <div class="row timeRow" style="height: auto">
                                                <div class="col-md-2">روز {{ $index + 1 }}:</div>
                                                <div class="col-md-10 ">
                                                    <div class="infoVal">
                                                        @foreach ($meals as $item)
                                                            {{ $item }} -
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endif
                        </div>

                        <div class="row infoRow">
                            <div class="col-md-12 infoSec">
                                <div class="infoTitle">راهنمای تور:</div>
                            </div>
                            <div class="col-md-6 infoSec">
                                <div class="infoTitle">آیا تور شما راهنما دارد؟</div>
                                <div class="infoVal">{{ $tour->isTourGuide == 1 ? 'بله' : 'خیر' }}</div>
                            </div>
                            @if ($tour->isTourGuide == 1)
                                <div class="col-md-6 infoSec">
                                    <div class="infoTitle">آیا راهنمای تور شما از افراد محلی منطقه می باشد؟</div>
                                    <div class="infoVal">{{ $tour->isLocalTourGuide == 1 ? 'بله' : 'خیر' }}</div>
                                </div>
                                <div class="col-md-6 infoSec">
                                    <div class="infoTitle">آیا راهنمای تور شما تجربه‌ی مخصوصی برای افراد فراهم می‌آورد؟
                                    </div>
                                    <div class="infoVal">{{ $tour->isSpecialTourGuid == 1 ? 'بله' : 'خیر' }}</div>
                                </div>
                                <div class="col-md-6 infoSec">
                                    <div class="infoTitle">آیا راهنمای تور شما هم اکنون مشخص است؟</div>
                                    <div class="infoVal">{{ $tour->isTourGuidDefined == 1 ? 'بله' : 'خیر' }}</div>
                                </div>
                                <div class="col-md-6 infoSec">
                                    <div class="infoTitle">آیا راهنمای تور شما دارای حساب کاربری کوچیتا می‌باشد؟</div>
                                    <div class="infoVal">{{ $tour->isTourGuideInKoochita == 1 ? 'بله' : 'خیر' }}</div>
                                </div>
                                <div class="col-md-6 infoSec">
                                    <div class="infoTitle">
                                        {{ $tour->isTourGuideInKoochita == 1 ? 'نام کاربری' : 'نام و نام خانوادگی' }}</div>
                                    <div class="infoVal">{{ $tour->guideName }}</div>
                                </div>
                            @endif
                        </div>

                        <div class="row infoRow">
                            <div class="col-md-6 infoSec">
                                <div class="infoTitle">تفلن پشتیبانی</div>
                                <div class="infoVal">{{ $tour->backupPhone }}</div>
                            </div>
                        </div>

                    </div>
                </div>

                <div>
                    <div class="infoHeader" onclick="openCloseTabs(3)">
                        <div>
                            <i class="fa-duotone fa-sack-dollar"></i>
                            <span>اطلاعات مالی</span>
                        </div>
                        <i class="fas fa-angle-down"></i>
                    </div>
                    <div id="infoBody_3" class="infoBody">

                        <div class="row infoRow">
                            <div class="col-md-3 infoSec">
                                <div class="infoTitle">قیمت بزرگسالان تور:</div>
                                <div class="infoVal">{{ $tour->minCost }} تومان</div>
                            </div>
                            <div class="col-md-3 infoSec">
                                <div class="infoVal importantNote"
                                    style="color: {{ $tour->isInsurance == 1 ? 'green' : 'red' }}">
                                    {{ $tour->isInsurance == 1 ? 'بیمه دارد' : 'بیمه ندارد' }}</div>
                            </div>
                        </div>

                        <div class="row infoRow">
                            <div class="col-md-9 infoSec">
                                <div class="infoTitle">دیگر قیمت ها:</div>
                            </div>
                            <div class="col-md-12">
                                @foreach ($tour->otherCost as $otherCost)
                                    <div class="row timeRow" style="height: auto">
                                        <div class="col-md-3">
                                            از سن
                                            {{ $otherCost->ageFrom }}
                                            تا
                                            {{ $otherCost->ageTo }}
                                        </div>
                                        <div class="col-md-3">
                                            {{ $otherCost->isFree == 1 ? 'رایگان' : $otherCost->cost . 'تومان' }}</div>
                                        <div class="col-md-3">
                                            {{ $otherCost->inCapacity == 0 ? 'جز ظرفیت حساب نمی شود' : '' }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row infoRow">
                            <div class="col-md-9 infoSec">
                                <div class="infoTitle">امکانات اضافی:</div>
                            </div>
                            <div class="col-md-12">
                                @foreach ($tour->features as $feats)
                                    <div class="row timeRow" style="height: auto">
                                        <div class="col-md-3">{{ $feats->name }}</div>
                                        <div class="col-md-3">{{ $otherCost->cost }}تومان</div>
                                        <div class="col-md-6">{{ $feats->description }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row infoRow">
                            <div class="col-md-9 infoSec">
                                <div class="infoTitle">تخفیف خرید گروهی:</div>
                            </div>
                            <div class="col-md-12">
                                @foreach ($tour->groupDiscount as $discount)
                                    <div class="row timeRow" style="height: auto">
                                        <div class="col-md-3">
                                            از
                                            {{ $discount->minCount }}نفر
                                            تا
                                            {{ $discount->maxCount }}نفر
                                        </div>
                                        <div class="col-md-3">{{ $discount->discount }}%</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row infoRow">
                            <div class="col-md-9 infoSec">
                                <div class="infoTitle">تخفیف روزهای پایانی:</div>
                            </div>
                            <div class="col-md-12">
                                @foreach ($tour->remainingDay as $remainingDay)
                                    <div class="row timeRow" style="height: auto">
                                        <div class="col-md-3">
                                            {{ $remainingDay->remainingDay }}
                                            روز مانده
                                        </div>
                                        <div class="col-md-3">{{ $remainingDay->discount }}%</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

                <div>
                    <div class="infoHeader" onclick="openCloseTabs(4)">
                        <div>
                            <i class="fa-duotone fa-clipboard-list-check"></i>
                            <span>اطلاعات اضافی</span>
                        </div>
                        <i class="fas fa-angle-down"></i>
                    </div>
                    <div id="infoBody_4" class="infoBody ">
                        <div class="row infoRow">
                            <div class="col-md-6 infoSec">
                                <div class="infoTitle">نوع تور:</div>
                                <div class="infoVal">
                                    @foreach ($tour->kind as $kind)
                                        {{ $kind }} -
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-6 infoSec">
                                <div class="infoTitle">درجه سختی تور:</div>
                                <div class="infoVal">{{ $tour->defficult ?? '' }}</div>
                            </div>
                        </div>
                        <div class="row infoRow">
                            <div class="col-md-6 infoSec">
                                <div class="infoTitle">مناسب برای:</div>
                                <div class="infoVal">{{ $tour->fitFor ?? '' }}</div>
                            </div>

                            <div class="col-md-6 infoSec">
                                <div class="infoTitle">تیپ تور:</div>
                                <div class="infoVal">{{ $tour->style ?? '' }}</div>
                            </div>
                        </div>

                        <div class="row infoRow">
                            <div class="col-md-12 infoSec">
                                <div class="infoTitle">چه انتظاری داشته باشیم:</div>
                            </div>
                            <div class="col-md-12 infoSec">
                                <div class="infoVal">{{ $tour->textExpectation }}</div>
                            </div>
                        </div>

                        <div class="row infoRow">
                            <div class="col-md-12 infoSec">
                                <div class="infoTitle">اطلاعات اختصاصی:</div>
                            </div>
                            <div class="col-md-12 infoSec">
                                <div class="infoVal">{{ $tour->specialInformation }}</div>
                            </div>
                        </div>

                        <div class="row infoRow">
                            <div class="col-md-12 infoSec">
                                <div class="infoTitle">اطلاعات اختصاصی:</div>
                            </div>
                            <div class="col-md-12 infoSec">
                                <div class="infoVal">{{ $tour->tourLimit }}</div>
                            </div>
                        </div>

                        <div class="row infoRow">
                            <div class="col-md-12 infoSec">
                                <div class="infoTitle">چه همراه داشته باشیم:</div>
                            </div>
                            <div class="col-md-6 infoSec">
                                <div class="infoTitle">ضروری:</div>
                                <div class="infoVal">{{ $tour->neccesseryEquip }}</div>
                            </div>
                            <div class="col-md-6 infoSec">
                                <div class="infoTitle">پیشنهادی:</div>
                                <div class="infoVal">{{ $tour->notNeccesseryEquip }}</div>
                            </div>
                        </div>

                        <div class="row infoRow">
                            <div class="col-md-12 infoSec">
                                <div class="infoTitle">عکس:</div>
                            </div>
                            <div class="col-md-12 infoSec" style="flex-wrap: wrap">
                                @foreach ($tour->pics as $pic)
                                    <div class="picSec">
                                        <img src="{{ $pic }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection


@section('modals')
    <div class="modal fade" id="modalMap">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="mapDiv" style="width: 100%; height: 500px"></div>
                </div>
                <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-success" data-dismiss="modal">تایید</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script defer type="text/javascript" src="{{ URL::asset('packages/leaflet/leaflet-src.js') }}"></script>
    <script defer type="text/javascript" src="{{ URL::asset('packages/leaflet/leaflet-wms-header.js') }}"></script>


    <script>
        var sideMenuAdditional = {
            title: 'ویرایش تور',
            sub: [{
                    title: 'اطلاعات اولیه',
                    icon: '<i class="fa-duotone fa-info"></i>',
                    url: "{{ route('businessManagement.tour.create.stage_1', ['business' => $businessIdForUrl, 'tourId' => $tour->id]) }}",
                },
                {
                    title: 'برنامه سفر',
                    icon: '<i class="fa-duotone fa-calendar-pen"></i>',
                    url: "{{ route('businessManagement.tour.create.stage_2', ['business' => $businessIdForUrl, 'tourId' => $tour->id]) }}",
                },
                {
                    title: 'اطلاعات برگزاری',
                    icon: '<i class="fa-duotone fa-plane-tail"></i>',
                    url: "{{ route('businessManagement.tour.create.stage_3', ['business' => $businessIdForUrl, 'tourId' => $tour->id]) }}",
                },
                {
                    title: 'اطلاعات مالی',
                    icon: '<i class="fa-duotone fa-sack-dollar"></i>',
                    url: "{{ route('businessManagement.tour.create.stage_4', ['business' => $businessIdForUrl, 'tourId' => $tour->id]) }}",
                },
                {
                    title: 'اطلاعات اضافی',
                    icon: '<i class="fa-duotone fa-clipboard-list-check"></i>',
                    url: "{{ route('businessManagement.tour.create.stage_5', ['business' => $businessIdForUrl, 'tourId' => $tour->id]) }}",
                },
            ]
        };

        createNewMenuSideBar(sideMenuAdditional);

        function openCloseTabs(_num) {
            document.getElementById(`infoBody_${_num}`).classList.toggle('show');
        }

        function changeTimeStatus(_id) {
            openLoading(false, () => {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('businessManagement.tour.update.timeStatus') }}',
                    data: {
                        _token: csrfTokenGlobal,
                        timeId: _id,
                    },
                    complete: closeLoading,
                    success: response => {
                        if (response.status == 'ok') {
                            var element = document.getElementById(`timeStatus_${_id}`);
                            element.innerText = response.result == 1 ? 'قابل ثبت نام' : 'توقف ثبت نام';
                            element.style.color = response.result == 1 ? 'green' : 'red';
                        } else {
                            console.error(response.status);
                            showSuccessNotifiBP('Server Error', 'left', 'red');
                        }
                    },
                    error: err => {
                        console.error(err);
                        showSuccessNotifiBP('Connection Error', 'left', 'red');
                    }
                })
            })
        }

        function changeTourStatus() {
            openLoading(false, () => {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('businessManagement.tour.update.published') }}',
                    data: {
                        _token: csrfTokenGlobal,
                        tourId: '{{ $tour->id }}'
                    },
                    complete: closeLoading,
                    success: response => {
                        if (response.status == 'ok') {
                            var button = document.getElementById('tourPublishButton');
                            var text = document.getElementById('tourPublishStatusText');
                            if (response.publish == 1) {
                                button.innerText = 'تغییر به حالت پیش نویس';
                                text.innerText = 'انتشار';

                                button.classList.remove('btn-success');
                                button.classList.add('btn-warning');
                                text.style.color = 'green';
                            } else {
                                button.innerText = 'تغییر به حالت انتشار';
                                text.innerText = 'پیش نویس';

                                button.classList.remove('btn-warning');
                                button.classList.add('btn-success');
                                text.style.color = 'red';
                            }
                        } else {
                            console.error(response.status);
                            showSuccessNotifiBP('Server Error', 'left', 'red');
                        }
                    },
                    error: err => {
                        console.error(err);
                        showSuccessNotifiBP('Connection Error', 'left', 'red');
                    }
                })
            });
        }



        @if ($tour->transport !== false)
            var tourSMap = {!! json_encode($tour->transport->sMap) !!};
            var tourEMap = {!! json_encode($tour->transport->eMap) !!};

            var mainMap = null;

            function initMapIr() {
                if (mainMap == null) {
                    mainMap = L.map("mapDiv", {
                        minZoom: 1,
                        maxZoom: 20,
                        crs: L.CRS.EPSG3857,
                        center: [32.42056639964595, 54.00537109375],
                        zoom: 6
                    });
                    L.TileLayer.wmsHeader(
                        "https://map.ir/shiveh", {
                            layers: "Shiveh:Shiveh",
                            format: "image/png",
                            minZoom: 1,
                            maxZoom: 20
                        },
                        [{
                            header: "x-api-key",
                            value: window.mappIrToken
                        }]
                    ).addTo(mainMap);

                    L.marker(tourSMap).addTo(mainMap);
                    L.marker(tourEMap).addTo(mainMap);
                }
            }

            function changeCenter(_kind) {
                mapIsOpen = _kind;
                $('#modalMap').modal('show');
                setTimeout(() => {
                    initMapIr();
                    var center = _kind == 'src' ? tourSMap : tourEMap;
                    mainMap.setView(center, 6);
                }, 500);
            }
        @endif
    </script>
@endsection
