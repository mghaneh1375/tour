
<div class="bottomLightBorder headerFilter">
    <div class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
        <div class="filterContent ui_label_group inline specialFiltersSection">
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input class="eatable0" onchange="doKindFilter('eatable', 0)" type="radio" name="eatableFilter" id="eatable0" value="صنایع دستی"/>
                {{--غیر خوراکی--}}
                <label for="eatable0" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">صنایع‌دستی</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                {{--خوراکی--}}
                <input class="eatable1" onchange="doKindFilter('eatable', 1)" type="radio" name="eatableFilter" id="eatable1" value="سوغات"/>
                <label for="eatable1" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">سوغات</span>
                </label>
            </div>
        </div>
    </div>
</div>


<div class="filterForEatable0 " style="display: none">
    <div class="bottomLightBorder headerFilter">
        <div class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
            <div class="filterContent ui_label_group inline specialFiltersSection">
                <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                    <input class="fragile1" name="fragile" onclick="doKindFilter('fragile', 1)" type="radio" id="fragile1" value="شکستنی"/>
                    <label for="fragile1" class="inputRadionSquer">
                        <span class="labelBox"></span>
                        <span class="name">شکستنی</span>
                    </label>
                </div>
                <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                    <input class="fragile0" name="fragile" onclick="doKindFilter('fragile', 0)" type="radio" id="fragile0" value="غیرشکستنی"/>
                    <label for="fragile0" class="inputRadionSquer">
                        <span class="labelBox"></span>
                        <span class="name">غیرشکستنی</span>
                    </label>
                </div>
            </div>

        </div>
    </div>

    <div class="bottomLightBorder headerFilter">
        <div class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
            <div style="display: flex; justify-content: space-between;">
                <div class="filterGroupTitle">{{__('نوع')}}</div>
            </div>
            <div class="filterContent ui_label_group inline specialFiltersSection">
                <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                    <input class="jewelry1" onclick="doKindFilter('jewelry', 1)" type="checkbox" id="jewelry1" value="زیورآلات"/>
                    <label for="jewelry1" class="inputRadionSquer">
                        <span class="labelBox"></span>
                        <span class="name">زیورآلات</span>
                    </label>
                </div>
                <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                    <input class="cloth1" onclick="doKindFilter('cloth', 1)" type="checkbox" id="cloth1" value="پارچه و پوشیدنی"/>
                    <label for="cloth1" class="inputRadionSquer">
                        <span class="labelBox"></span>
                        <span class="name">پارچه و پوشیدنی</span>
                    </label>
                </div>
                <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                    <input class="decorative1" onclick="doKindFilter('decorative', 1)" type="checkbox" id="decorative1" value="لوازم تزئینی"/>
                    <label for="decorative1" class="inputRadionSquer">
                        <span class="labelBox"></span>
                        <span class="name">لوازم تزئینی</span>
                    </label>
                </div>
                <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                    <input class="applied1" onclick="doKindFilter('applied', 1)" type="checkbox" id="applied1" value="لوازم کاربردی منزل"/>
                    <label for="applied1" class="inputRadionSquer">
                        <span class="labelBox"></span>
                        <span class="name">لوازم کاربردی منزل</span>
                    </label>
                </div>
            </div>

        </div>
    </div>

    <div class="bottomLightBorder headerFilter">
        <div class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
            <div style="display: flex; justify-content: space-between;">
                <div class="filterGroupTitle">{{__('سبک')}}</div>
            </div>
            <div class="filterContent ui_label_group inline specialFiltersSection">
                <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                    <input class="style1" onclick="doKindFilter('style', 1)" type="checkbox" id="style1" value="سنتی"/>
                    <label for="style1" class="inputRadionSquer">
                        <span class="labelBox"></span>
                        <span class="name">سنتی</span>
                    </label>
                </div>
                <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                    <input class="style2" onclick="doKindFilter('style', 2)" type="checkbox" id="style2" value="مدرن"/>
                    <label for="style2" class="inputRadionSquer">
                        <span class="labelBox"></span>
                        <span class="name">مدرن</span>
                    </label>
                </div>
                <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                    <input class="style3" onclick="doKindFilter('style', 3)" type="checkbox" id="style3" value="تلفیقی"/>
                    <label for="style3" class="inputRadionSquer">
                        <span class="labelBox"></span>
                        <span class="name">تلفیقی</span>
                    </label>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="filterForEatable1" style="display: none">
    <div class="bottomLightBorder headerFilter">
    <div class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
        <div style="display: flex; justify-content: space-between;">
            <div class="filterGroupTitle">{{__('مزه')}}</div>
        </div>
        <div class="filterContent ui_label_group inline specialFiltersSection">
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input class="torsh1" onclick="doKindFilter('torsh', 1)" type="checkbox" id="torsh1" value="ترش"/>
                <label for="torsh1" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">ترش</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input class="shirin1" onclick="doKindFilter('shirin', 1)" type="checkbox" id="shirin1" value="شیرین"/>
                <label for="shirin1" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">شیرین</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input class="talkh1" onclick="doKindFilter('talkh', 1)" type="checkbox" id="talkh1" value="تلخ"/>
                <label for="talkh1" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">تلخ</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input class="malas1" onclick="doKindFilter('malas', 1)" type="checkbox" id="malas1" value="ملس"/>
                <label for="malas1" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">ملس</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input class="shor1" onclick="doKindFilter('shor', 1)" type="checkbox" id="shor1" value="شور"/>
                <label for="shor1" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">شور</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input class="tond1" onclick="doKindFilter('tond', 1)" type="checkbox" id="tond1" value="تند"/>
                <label for="tond1" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">تند</span>
                </label>
            </div>
        </div>

    </div>
</div>
</div>


{{--common in sogatSanaie--}}
<div class="bottomLightBorder headerFilter">
    <div class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
        <div style="display: flex; justify-content: space-between;">
            <div class="filterGroupTitle">{{__('ابعاد')}}</div>
        </div>
        <div class="filterContent ui_label_group inline specialFiltersSection">
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input class="size1" onclick="doKindFilter('size', 1)" type="checkbox" id="size1" value="کوچک"/>
                <label for="size1" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">کوچک</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input class="size2" onclick="doKindFilter('size', 2)" type="checkbox" id="size2" value="متوسط"/>
                <label for="size2" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">متوسط</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input class="size3" onclick="doKindFilter('size', 3)" type="checkbox" id="size3" value="بزرگ"/>
                <label for="size3" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">بزرگ</span>
                </label>
            </div>
        </div>

    </div>
</div>

<div class="bottomLightBorder headerFilter">
    <div class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
        <div style="display: flex; justify-content: space-between;">
            <div class="filterGroupTitle">{{__('وزن')}}</div>
        </div>
        <div class="filterContent ui_label_group inline specialFiltersSection">
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input class="weight1" onclick="doKindFilter('weight', 1)" type="checkbox" id="weight1" value="سبک"/>
                <label for="weight1" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">سبک</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input class="weight2" onclick="doKindFilter('weight', 2)" type="checkbox" id="weight2" value="متوسط"/>
                <label for="weight2" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">متوسط</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input class="weight3" onclick="doKindFilter('weight', 3)" type="checkbox" id="weight3" value="سنگین"/>
                <label for="weight3" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">سنگین</span>
                </label>
            </div>
        </div>

    </div>
</div>

<div class="bottomLightBorder headerFilter">
    <div class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
        <div style="display: flex; justify-content: space-between;">
            <div class="filterGroupTitle">{{__('کلاس قیمتی')}}</div>
        </div>
        <div class="filterContent ui_label_group inline specialFiltersSection">
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input class="price1" onclick="doKindFilter('price', 1)" type="checkbox" id="price1" value="ارزان"/>
                <label for="price1" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">ارزان</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input class="price2" onclick="doKindFilter('price', 2)" type="checkbox" id="price2" value="متوسط"/>
                <label for="price2" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">متوسط</span>
                </label>
            </div>
            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                <input class="price3" onclick="doKindFilter('price', 3)" type="checkbox" id="price3" value="گران"/>
                <label for="price3" class="inputRadionSquer">
                    <span class="labelBox"></span>
                    <span class="name">گران</span>
                </label>
            </div>
        </div>

    </div>
</div>

<script>

    function onlyForSogatSanaie(){

        $('.filterForEatable0').css('display', 'none');
        $('.filterForEatable1').css('display', 'none');

        for(var i = 0; i < specialFilters.length; i++){
            if(specialFilters[i]['kind'] == 'eatable') {
                $('.filterForEatable' + specialFilters[i]['value']).css('display', 'block');

                var deleteKind;
                if(specialFilters[i]['value'] == 0)
                    deleteKind = ['torsh', 'shirin', 'talkh', 'malas', 'shor', 'tond'];
                else
                    deleteKind = ['jewelry', 'cloth', 'decorative', 'applied', 'style', 'fragile'];

                for(var i = 0 ; i < specialFilters.length; i++){
                    if(deleteKind.indexOf(specialFilters[i]['kind']) > -1) {
                        $('.' + specialFilters[i]['kind'] + specialFilters[i]['value']).prop("checked", false);
                        specialFilters[i] = 0;
                    }
                }

            }
        }

        newSearch();
    }

    function specialCancelSogataSanaiesFilters(){
        $('.filterForEatable0').css('display', 'none');
        $('.filterForEatable1').css('display', 'none');

        var deleteKind = ['torsh', 'shirin', 'talkh', 'malas', 'shor', 'tond', 'jewelry', 'cloth', 'decorative', 'applied', 'style', 'fragile'];
        for(var i = 0 ; i < specialFilters.length; i++){
            if(deleteKind.indexOf(specialFilters[i]['kind']) > -1) {
                $('.' + specialFilters[i]['kind'] + specialFilters[i]['value']).prop("checked", false);
                specialFilters[i] = 0;
            }
        }

        newSearch();
    }


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
