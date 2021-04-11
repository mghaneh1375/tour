<div class="bottomLightBorder headerFilter">
    <div class="filterHeaderWithClose">
        <div class="filterGroupTitle">ساعات کاری کسب و کارها</div>
    </div>

    <div class="filterContent ui_label_group inline">
{{--        <div class="filterItem lhrFilter filter selected squerRadioInputSec">--}}
{{--            <input id="p_feat_nowOpen" class="featurePlaceListInput_nowOpen" onclick="doKindFilter('nowOpen', 1, 'زمان')" type="checkbox" value="1"/>--}}
{{--            <label for="p_feat_nowOpen" class="inputRadionSquer">--}}
{{--                <span class="labelBox"></span>--}}
{{--                <span class="name">هم اکنون باز</span>--}}
{{--            </label>--}}
{{--        </div>--}}
        <div class="filterItem lhrFilter filter selected squerRadioInputSec">
            <input id="p_feat_isBoarding" class="featurePlaceListInput_isBoarding" onclick="doKindFilter('isBoarding', 1, 'زمان')" type="checkbox" value="1"/>
            <label for="p_feat_isBoarding" class="inputRadionSquer">
                <span class="labelBox"></span>
                <span class="name">شبانه روزی</span>
            </label>
        </div>
        <div class="filterItem lhrFilter filter selected squerRadioInputSec">
            <input id="p_feat_closedDayIsOpen" class="featurePlaceListInput_closedDayIsOpen" onclick="doKindFilter('closedDayIsOpen', 1, 'زمان')" type="checkbox" value="1"/>
            <label for="p_feat_closedDayIsOpen" class="inputRadionSquer">
                <span class="labelBox"></span>
                <span class="name">باز در روزهای تعطیل</span>
            </label>
        </div>


        @if(count($sideLocalShopCategories) > 0)
            <div class="bottomLightBorder headerFilter">
                <div class="filterHeaderWithClose">
                    <div class="filterGroupTitle">دسته بندی ها</div>
                    @if(count($sideLocalShopCategories) > 5)
                        <span onclick="showMoreItems('LocalShopCategory')" class="moreItemsLocalShopCategory moreItems">
                            <span>{{__('نمایش کامل فیلترها')}}</span>
                            <span class="downArrowIcon"></span>
                        </span>
                        <span onclick="showLessItems('LocalShopCategory')" class="lessItems hidden extraItemLocalShopCategory moreItems">
                            <span>{{__('پنهان سازی فیلتر‌ها')}}</span>
                            <span class="upArrowIcon"></span>
                        </span>
                    @endif
                </div>

                <div class="filterContent ui_label_group inline">
                    @foreach($sideLocalShopCategories as $index => $sub)
                        <div class="filterItem lhrFilter filter squerRadioInputSec {{$index > 4 ? "hidden extraItemLocalShopCategory" : 'selected'}}">
                            <input id="localShopCategory_{{$sub->id}}_{{$type ?? ''}}" name="localShopCategory_{{$type ?? ''}}" class="localShopCategoryId_{{$sub->id}}" onclick="localShopCategoryFilter({{$sub->id}})" type="radio" data-name="{{$sub->name}}" value="{{$sub->id}}"/>
                            <label for="localShopCategory_{{$sub->id}}_{{$type ?? ''}}" class="inputRadionSquer">
                                <span class="labelBox"></span>
                                <span class="name">{{$sub->name}}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
