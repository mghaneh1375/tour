<div class="bottomLightBorder headerFilter">
    <div class="filterHeaderWithClose">
        <div class="filterGroupTitle">{{__('مراکز اقامتی')}}</div>
    </div>

    <div class="filterContent ui_label_group inline specialFiltersSection">

        <div class="filterItem lhrFilter filter selected squerRadioInputSec">
            <input class="kind_id1" onclick="doKindFilter('kind_id', 1)" type="checkbox" id="kind_id1" value="هتل" checked/>
            <label for="kind_id1" class="inputRadionSquer">
                <span class="labelBox"></span>
                <span class="name">هتل</span>
            </label>
        </div>
        <div class="filterItem lhrFilter filter selected squerRadioInputSec">
            <input class="kind_id2" onclick="doKindFilter('kind_id', 2)" type="checkbox" id="kind_id2" value="هتل آپارتمان"/>
            <label for="kind_id2" class="inputRadionSquer">
                <span class="labelBox"></span>
                <span class="name">هتل آپارتمان</span>
            </label>
        </div>
        <div class="filterItem lhrFilter filter selected squerRadioInputSec">
            <input class="kind_id3" onclick="doKindFilter('kind_id', 3)" type="checkbox" id="kind_id3" value="مهمانسرا"/>
            <label for="kind_id3" class="inputRadionSquer">
                <span class="labelBox"></span>
                <span class="name">مهمانسرا</span>
            </label>
        </div>
        <div class="filterItem lhrFilter filter selected squerRadioInputSec">
            <input class="kind_id4" onclick="doKindFilter('kind_id', 4)" type="checkbox" id="kind_id4" value="ویلا"/>
            <label for="kind_id4" class="inputRadionSquer">
                <span class="labelBox"></span>
                <span class="name">ویلا</span>
            </label>
        </div>
        <div class="filterItem lhrFilter filter selected squerRadioInputSec">
            <input class="kind_id5" onclick="doKindFilter('kind_id', 5)" type="checkbox" id="kind_id5" value="متل"/>
            <label for="kind_id5" class="inputRadionSquer">
                <span class="labelBox"></span>
                <span class="name">متل</span>
            </label>
        </div>
        <div class="filterItem lhrFilter filter selected extraItem0 squerRadioInputSec">
            <input class="kind_id6" onclick="doKindFilter('kind_id', 6)" type="checkbox" id="kind_id6" value="مجتمع تفریحی"/>
            <label for="kind_id6" class="inputRadionSquer">
                <span class="labelBox"></span>
                <span class="name">مجتمع تفریحی</span>
            </label>
        </div>
        <div class="filterItem lhrFilter filter selected extraItem0 squerRadioInputSec">
            <input class="kind_id7" onclick="doKindFilter('kind_id', 7)" type="checkbox" id="kind_id7" value="پانسیون"/>
            <label for="kind_id7" class="inputRadionSquer">
                <span class="labelBox"></span>
                <span class="name">پانسیون</span>
            </label>
        </div>
        <div class="filterItem lhrFilter filter selected extraItem0 squerRadioInputSec">
            <input class="kind_id8" onclick="doKindFilter('kind_id', 8)" type="checkbox" id="kind_id8" value="بوم گردی"/>
            <label for="kind_id8" class="inputRadionSquer">
                <span class="labelBox"></span>
                <span class="name">بوم گردی</span>
            </label>
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
