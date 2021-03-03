
<script src="{{asset('js/ckeditor5/ckeditor5.js')}}"></script>
<script src="{{asset('js/ckeditor5/ckeditorUpload.js')}}"></script>

<div id="newSafarnameh" class="modalBlackBack" style="z-index: 9999;">
    <div class="newSafarnamehSection">
        <input type="hidden" id="newSafarnamehId" value="0">
        <div class="nsHeader">
            <h3 id="newSafarnamehModalHeader" class="text">نوشتن سفرنامه</h3>
            <div class="iconClose" onclick="closeNewSafarnameh()"></div>
        </div>
        <div class="nsContenet">
            <div class="row">
                <div class="form-group">
                    <label for="safarnamehTitle">برای سفرنامت یک عنوان بنویسید</label>
                    <input id="newSafarnamehTitle" type="text" class="form-control" placeholder="عنوان سفرنامه">
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="safarnamehSummery">می تونی یه خلاصه از سفرنامت تو 100 کاراکتر بنویسی (اختیاری)</label>
                    <textarea id="safarnamehSummery" class="form-control" rows="1" placeholder="خلاصه سفرنامه"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="safarnamehText" class="inputLabel">متن سفرنامت رو اینجا بنویس</label>
                    <div class="toolbar-container"></div>
                    <div id="safarnamehText" class="textEditor"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="safarnamehTags">برای سفرنامه خود برچسب بگذارید</label>
                    <input type="text" id="safarnamehTag1" class="form-control" placeholder="برچسب اول" style="margin-bottom: 10px">
                    <input type="text" id="safarnamehTag2" class="form-control" placeholder="برچسب دوم" style="margin-bottom: 10px">
                    <input type="text" id="safarnamehTag3" class="form-control" placeholder="برچسب سوم">
                </div>
                <div class="col-md-6 form-group" style="display: flex; flex-direction: column;">
                    <label>خب یه عکس خوب هم از سفرنامت
                        {{--                        <button class="addPlaceButton" onclick="$('#safarnamehPicInput').click()">--}}
                        {{--                            انتخاب عکس--}}
                        {{--                        </button>--}}
                    </label>
                    <input type="file" id="safarnamehPicInput" accept="image/*" style="display: none" onchange="changeNewPicSafarnameh(this)">
                    <label for="safarnamehPicInput" class="newSafarnamehImgSection">
                        <div class="notPicSafarnameh">
                            <span class="plus2" style="font-size: 40px; line-height: 20px;"></span>
                            <span>افزودن عکس </span>
                        </div>
                        <img alt="addSafarnameh" id="newSafarnamehPic"  style=" height: 120px; display: none">
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="form-group" style="display: flex; flex-direction: column;">
                    <label>
                        محل های مرتبط به سفرنامه خود را انتخاب کنید.
                        <button class="addPlaceButton" onclick="openSuggestion()">
                            افزودن محل جدید
                        </button>
                    </label>
                </div>
                <div class="pickPlaces ourSuggestionMainPage" style="max-height: 1000vh"></div>
            </div>

            <div class="row newSafarnamehFooter">
                <div style="width: 100%; padding: 0px 30px;">
                    <ul id="newSafarnamehError" style="color: red"></ul>
                </div>
                <div>
                    <button class="backSafarnameh" onclick="closeNewSafarnameh()">{{__('بستن')}}</button>
                    <button class="btn btn-success submitSafarnameh" style="background: var(--koochita-green)" onclick="storeSafarnameh()">ثبت</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="placeSuggestionModal" class="modalBlackBack" style="z-index: 10000;">
    <div class="placeSuggestionBody">
        <div class="iconClose closeSuggestionModal" onclick="closeSuggestion()"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 form-group placeSuggKind">
                    <label for="kindPlace">نوع محل را مشخص کنید.</label>
                    <select id="kindPlace" class="form-control" onchange="$('#searchResultPlacess').hide(); $('#placeName').val('')">
                        <option value="state">استان</option>
                        <option value="city">شهر</option>
                        <option value="village">روستا</option>
                        <option value="boomgardies">بوم گردی</option>
                        <option value="amaken">اماکن</option>
                        <option value="restaurant">رستوران</option>
                        <option value="hotels">هتل</option>
                        <option value="majara">طبیعت گردی</option>
                        <option value="sogatSanaies">صنایع دستی و سوغات</option>
                        <option value="mahaliFood">غذا</option>
                    </select>
                </div>
                <div class="col-md-8 form-group">
                    <label> نام محل</label>
                    <input type="text" id="placeName" class="form-control" onkeyup="searchForPlaces(this.value)">
                    <div id="searchResultPlacess" class="searchResultPlacess"></div>
                </div>
            </div>

            <div class="row" style="padding: 10px">
                <div id="pickPlacesTitle" style="font-size: 20px; font-weight: bold">انتخاب شده ها</div>
                <div class="pickPlaces ourSuggestion"></div>
            </div>

            <div class="row" style="margin: 10px; border-top: solid 1px #cccccc; padding-top: 5px;">
                <div class="ourSuggestionShow" style="font-size: 20px; font-weight: bold">پیشنهادهای ما</div>
                <div id="ourSuggestion" class="ourSuggestion ourSuggestionShow" style="max-height: 20vh"></div>
                {{--                    <div class="showAllSuggestion ourSuggestionShow" onclick="showAllSuggestionFunc()">مشاهده تمام پیشنهادها</div>--}}
            </div>
            <div class="row" style="text-align: center">
                <button class="submitSarnamehButton" onclick="closeSuggestion()">{{__('ثبت')}}</button>
            </div>
        </div>
    </div>
</div>

<script>
    var applicationLanguage_addSafarnameh = "{{app()->getLocale()}}";
    var userId_addSafarnameh = "{{auth()->user()->id}}";
    var storePicUrl_addSafarnameh = "{{route("safarnameh.storePic")}}";
    var storeSafarnamehUrl_addSafarnameh = "{{route('safarnameh.store')}}";
    var getSafarnamehUrl_addSafarnameh = "{{route("safarnameh.get")}}";
    var placeSuggestionSafarnamehUrl_addSafarnameh = "{{route("profile.safarnameh.placeSuggestion")}}";
    var searchSuggSafarnamehUrl_addSafarnameh = "{{route("searchSuggestion")}}";
</script>

<script src="{{URL::asset('js/component/addSafarnameh.js?v='.$fileVersions)}}"></script>
