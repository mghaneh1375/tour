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
    </div>
</div>
