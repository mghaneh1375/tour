
<div class="bottomLightBorder headerFilter">
    <div class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
        <div style="display: flex; justify-content: space-between;">
            <div class="filterGroupTitle">{{__('نوع غذا')}}</div>
        </div>
        <div class="filterContent ui_label_group inline specialFiltersSection">
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input class="kind1" onclick="doKindFilter('kind', 1)" type="checkbox" id="kind1" value="چلوخورش"/>
                <label for="kind1" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">چلوخورش</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input  class="kind2" onclick="doKindFilter('kind', 2)" type="checkbox" id="kind2" value="خوراک"/>
                <label for="kind2" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">خوراک</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input  class="kind8" onclick="doKindFilter('kind', 8)" type="checkbox" id="kind8" value="سوپ و آش"/>
                <label for="kind8" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">سوپ و آش</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input  class="kind3" onclick="doKindFilter('kind', 3)" type="checkbox" id="kind3" value="سالاد و پیش غذا"/>
                <label for="kind3" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">سالاد و پیش غذا</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input  class="kind4" onclick="doKindFilter('kind', 4)" type="checkbox" id="kind4" value="ساندویچ"/>
                <label for="kind4" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">ساندویچ</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input  class="kind5" onclick="doKindFilter('kind', 5)" type="checkbox" id="kind5" value="کباب"/>
                <label for="kind5" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">کباب</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input  class="kind6" onclick="doKindFilter('kind', 6)" type="checkbox" id="kind6" value="دسر"/>
                <label for="kind6" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">دسر</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input  class="kind7" onclick="doKindFilter('kind', 7)" type="checkbox" id="kind7" value="نوشیدنی"/>
                <label for="kind7" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">نوشیدنی</span>
                </label>
            </div>
        </div>

    </div>
</div>

<div class="bottomLightBorder headerFilter">
    <div class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
        <div class="filterContent ui_label_group inline specialFiltersSection">
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input  class="hotOrCold1" name="hotOrCold" onclick="doKindFilter('hotOrCold', 1)" type="radio" id="hotOrCold1" value="گرم"/>
                <label for="hotOrCold1" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">گرم</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input  class="hotOrCold2" name="hotOrCold" onclick="doKindFilter('hotOrCold', 2)" type="radio" id="hotOrCold2" value="سرد"/>
                <label for="hotOrCold2" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">سرد</span>
                </label>
            </div>
        </div>

    </div>
</div>

<div class="bottomLightBorder headerFilter">
    <div class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
        <div style="display: flex; justify-content: space-between;">
            <div class="filterGroupTitle">{{__('مناسب برای')}}</div>
        </div>
        <div class="filterContent ui_label_group inline specialFiltersSection">
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input  class="vegetarian1" onclick="doKindFilter('vegetarian', 1)" type="checkbox" id="vegetarian1" value="افراد گیاه‌خوار"/>
                <label for="vegetarian1" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">افراد گیاه‌خوار</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input class="vegan1" onclick="doKindFilter('vegan', 1)" type="checkbox" id="vegan1" value="وگان"/>
                <label for="vegan1" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">وگان</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input  class="diabet1" onclick="doKindFilter('diabet', 1)" type="checkbox" id="diabet1" value="افراد مبتلا به دیابت"/>
                <label for="diabet1" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">افراد مبتلا به دیابت</span>
                </label>
            </div>
        </div>

    </div>
</div>

<script>
    //this function for change ids of specialFilters in phone type
    function changePhoneIds(){
        var getIds = [];

        var elems = $('.specialFiltersSection').children();
        for(i = 0; i < elems.length; i++){
            var childs = $(elems[i]).children();
            var inputId = $(childs[0]).attr('id');

            if(getIds.indexOf(inputId) > -1){
                $(childs[0]).attr('id', 'phone_' + inputId);
                $(childs[1]).attr('for', 'phone_' + inputId);
            }
            else
                getIds[getIds.length] = inputId;
        }
    }
    changePhoneIds();
</script>
