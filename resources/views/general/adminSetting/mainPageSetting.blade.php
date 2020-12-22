<style>
    .settingImg{
        max-width: 100%;
    }
    .addButtonRowAdminSetting{
        display: flex;
        justify-content: center;
        margin-bottom: 15px;
    }
    .addButtonAdminSetting{
        width: 60px;
        height: 60px;
        border-radius: 50%;
        box-shadow: 0 0 20px 0px green;
    }
</style>

<div class="row">
    <div class="settingTabs" onclick="toggleSettingSection(this)">
        تغییر اسلایدرها
    </div>
    <div class="row" style="display: none">
        <div class="settingSection container">

            <div class="row">
                <div style="width: 100%; cursor: pointer" onclick="toggleSettingSection(this)">
                    <h3 style="display: inline-block">تغییر اسلاید اصلی:</h3>
                </div>

                <div class="container settingSubSection" style="display: none;">
                    <div class="row addButtonRowAdminSetting">
                        <button class="btn btn-success addButtonAdminSetting" onclick="addNewMainSliderSetting()">
                            افزودن
                        </button>
                    </div>
                    <div id="sliderPicSection0">
                        <div id="rowSlide0##number##" class="row">
                            <div class="col-md-2">
                                <button class="btn btn-danger" style="position: relative; width: auto" onclick="deleteMainSLiderSetting(##number##)">حذف</button>
                                <button class="btn btn-primary" style="position: relative; width: auto" onclick="storeMainSliderSetting(##number##)">ویرایش</button>
                                <input type="hidden" id="idForImgSlider0##number##" value="##id##">
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-6">
                                         <img id="showUploadImgSlider0##number##" class="settingImg" src="##pic##" style="height: 100px;">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="file" id="uploadImgSlider0##number##" accept="image/*" onchange="showPicInput(this, 'showUploadImgSlider0##number##')">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                         <img id="showUploadBackImgSlider0##number##" class="settingImg" src="##backgroundPic##" style="height: 100px;">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="file" id="uploadBackImgSlider0##number##" accept="image/*" onchange="showPicInput(this, 'showUploadBackImgSlider0##number##')">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="colorForSlider0##number##">رنگ پس زمینه:</label>
                                        <input type="text" id="colorForSlider0##number##" class="form-control" value="##textBackground##">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="colorTextForSlider0##number##">رنگ متن:</label>
                                        <input type="text" id="colorTextForSlider0##number##" class="form-control" value="##textColor##">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="textForSlider0##number##">متن:</label>
                                        <textarea id="textForSlider0##number##" class="form-control">##text##</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
            <hr>

            <div class="row">
                <div style="width: 100%; cursor: pointer" onclick="toggleSettingSection(this)">
                    <h3 style="display: inline-block">تغییر اسلایدر1:</h3>
                </div>

                <div class="container settingSubSection" style="display: none;">
                    <div class="row addButtonRowAdminSetting">
                        <button class="btn btn-success addButtonAdminSetting" style="width: auto; position: relative" onclick="addSliderPicTo(1)">
                            افزودن
                        </button>
                    </div>
                    <div id="sliderPicSection1"></div>
                </div>
            </div>
            <hr>

            <div class="row">
                <div style="width: 100%; cursor: pointer" onclick="toggleSettingSection(this)">
                    <h3 style="display: inline-block">تغییر اسلایدر2:</h3>
                </div>
                <div class="container settingSubSection" style="display: none;">
                    <div id="sliderPicSection2">
                        <div id="rowSlideId2" class="row">
                            <div class="col-md-2">
                                <input type="hidden" id="slideId20" value="{{isset($middleBan['2']['id']) ? $middleBan['2']['id'] : 0}}">
                                @if(isset($middleBan['2']['id']))
                                    <button class="btn btn-primary" onclick="submitSlide({{$middleBan['2']['id']}}, 0, 2)" style="position: relative; width: auto">
                                        ویرایش
                                    </button>
                                    <button class="btn btn-danger" onclick="deleteSlideCommon(0, 2)">
                                        حذف
                                    </button>
                                @else
                                    <button class="btn btn-primary" onclick="submitSlide(0, 0, 2)"style="position: relative; width: auto">
                                        تایید
                                    </button>
                                @endif
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="{{isset($middleBan['2']['pic']) ? $middleBan['2']['pic'] : ''}}"
                                             id="showMiddleBannerInput20" class="settingImg" style="height: 100px; ">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="file" id="uploadImgBanner20" accept="image/*" onchange="showPicInput(this, 'showMiddleBannerInput20')">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6" style="float: right">
                                        <label for="linkForBannerId60">لینک:</label>
                                        <input type="text" id="linkForBanner20" class="form-control" value="{{isset($middleBan['2']['link']) ? $middleBan['2']['link'] : ''}}">
                                    </div>
                                    <div class="col-md-6 hidden">
                                        <label for="textForBannerId20">متن:</label>
                                        <input type="hidden" id="textForBanner20" class="form-control" value="{{isset($middleBan['2']['text'])? $middleBan['2']['text'] : ''}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
            <hr>

            <div class="row">
                <div style="width: 100%; cursor: pointer" onclick="toggleSettingSection(this)">
                    <h3 style="display: inline-block">تغییر اسلایدر4:</h3>
                </div>

                <div class="container settingSubSection" style="display: none;">
                    <div class="row addButtonRowAdminSetting">
                        <button class="btn btn-success addButtonAdminSetting" style="width: auto; position: relative" onclick="addSliderPicTo(4)">
                            افزودن
                        </button>
                    </div>
                    <div id="sliderPicSection4"></div>
                </div>
            </div>
            <hr>

            <div class="row">
                <div style="width: 100%; cursor: pointer" onclick="toggleSettingSection(this)">
                    <h3 style="display: inline-block">تغییر اسلایدر5:</h3>
                </div>

                <div class="container settingSubSection" style="display: none;">
                    <div class="row addButtonRowAdminSetting">
                        <button class="btn btn-success addButtonAdminSetting" onclick="addSliderPicTo(5)">
                            افزودن
                        </button>
                    </div>
                    <div id="sliderPicSection5">

{{--                        @for($i = 0; $i < 3; $i++)--}}
{{--                            <div id="rowSlideId5{{$i}}" class="row">--}}
{{--                                <div class="col-md-2">--}}
{{--                                    <input type="hidden" id="slideId5{{$i}}"--}}
{{--                                           value="{{isset($middleBan['5'][$i]['id']) ? $middleBan['5'][$i]['id'] : 0}}">--}}
{{--                                    @if(isset($middleBan['5']) && isset($middleBan['5'][$i]))--}}
{{--                                        <button class="btn btn-primary"--}}
{{--                                                onclick="submitSlide({{$middleBan['5'][$i]['id']}}, {{$i}}, 5)"--}}
{{--                                                style="position: relative; width: auto">ویرایش--}}
{{--                                        </button>--}}
{{--                                    @else--}}
{{--                                        <button class="btn btn-primary" onclick="submitSlide(0, {{$i}}, 5)"--}}
{{--                                                style="position: relative; width: auto">تایید--}}
{{--                                        </button>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                                <div class="col-md-10">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <img src="{{isset($middleBan['5']) && isset($middleBan['5'][$i]) ? $middleBan['5'][$i]['pic'] : ''}}"--}}
{{--                                                 id="showMiddleBannerInput5{{$i}}" class="settingImg" style="height: 100px; ">--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <input type="file" id="uploadImgBanner5{{$i}}" accept="image/*"--}}
{{--                                                   onchange="showPicInput(this, 'showMiddleBannerInput5{{$i}}')">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <label for="linkForBannerId5{{$i}}">لینک:</label>--}}
{{--                                            <input type="text" id="linkForBanner5{{$i}}" class="form-control"--}}
{{--                                                   value="{{isset($middleBan['5']) && isset($middleBan['5'][$i]) ? $middleBan['5'][$i]['link'] : ''}}">--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <label for="textForBannerId5{{$i}}">متن:</label>--}}
{{--                                            <input type="text" id="textForBanner5{{$i}}" class="form-control"--}}
{{--                                                   value="{{isset($middleBan['5']) && isset($middleBan['5'][$i]) ? $middleBan['5'][$i]['text'] : ''}}">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endfor--}}

{{--                        <hr>--}}
                    </div>
                </div>
            </div>
            <hr>

            <div class="row">
                <div style="width: 100%; cursor: pointer" onclick="toggleSettingSection(this)">
                    <h3 style="display: inline-block">تغییر اسلایدر6:</h3>
                </div>

                <div class="container settingSubSection" style="display: none;">
                    <div id="sliderPicSection6">
                        <div id="rowSlideId6" class="row">
                            <div class="col-md-2">
                                <input type="hidden" id="slideId60"
                                       value="{{isset($middleBan['6']['id']) ? $middleBan['6']['id'] : 0}}">
                                @if(isset($middleBan['6']))
                                    <button class="btn btn-primary" onclick="submitSlide({{$middleBan['6']['id']}}, 0, 6)">
                                        ویرایش
                                    </button>
                                @else
                                    <button class="btn btn-primary" onclick="submitSlide(0, 0, 6)"
                                            style="position: relative; width: auto">تایید
                                    </button>
                                @endif
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="{{isset($middleBan['6']) ? $middleBan['6']['pic'] : ''}}"
                                             id="showMiddleBannerInput60" class="settingImg" style="height: 100px; ">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="file" id="uploadImgBanner60" accept="image/*"
                                               onchange="showPicInput(this, 'showMiddleBannerInput60')">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="linkForBannerId60">لینک:</label>
                                        <input type="text" id="linkForBanner60" class="form-control"
                                               value="{{isset($middleBan['6']) ? $middleBan['6']['link'] : ''}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="textForBannerId60">متن:</label>
                                        <input type="hidden" id="textForBanner60" class="form-control"
                                               value="{{isset($middleBan['6'])? $middleBan['6']['text'] : ''}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<hr>


<script>
    var mainSliderSettingSample = 0;
    var sild0 = 0;
    var slider1Setting = {!! $sliderPic !!};

    function showMainSliderSetting(){
        if(mainSliderSettingSample == 0){
            mainSliderSettingSample = $('#sliderPicSection0').html();
            $('#sliderPicSection0').html('');
        }
        for(var i = 0; i < slider1Setting.length; i++){
            var text = mainSliderSettingSample;
            var fk = Object.keys(slider1Setting[i]);

            for (var x of fk) {
                var t = '##' + x + '##';
                var re = new RegExp(t, "g");
                text = text.replace(re, slider1Setting[i][x]);
            }

            var t = '##number##';
            var re = new RegExp(t, "g");
            text = text.replace(re, sild0);

            $('#sliderPicSection0').append(text);
            sild0++;
        }
    }
    showMainSliderSetting();

    function addNewMainSliderSetting(){
        if(mainSliderSettingSample == 0){
            mainSliderSettingSample = $('#sliderPicSection0').html();
            $('#sliderPicSection0').html('');
        }
        var text = mainSliderSettingSample;
        var fk = {
            'number' : sild0,
            'id' : 0,
            'pic' : '',
            'backgroundPic': '',
            'textBackground' : '',
            'textColor' : '',
            'text' : ''
        };

        for (var x in fk) {

            var t = '##' + x + '##';
            var re = new RegExp(t, "g");
            text = text.replace(re, fk[x]);
        }

        $('#sliderPicSection0').append(text);
        sild0++;
    }

    function storeMainSliderSetting(_number){
        var color = $('#colorForSlider0' + _number).val();
        var textColor = $('#colorTextForSlider0' + _number).val();
        var text = $('#textForSlider0' + _number).val();
        var inputPic = $('#uploadImgSlider0' + _number)[0];
        var inputBackPic = $('#uploadBackImgSlider0' + _number)[0];
        var id = $('#idForImgSlider0' + _number).val();

        var data = new FormData();
        if (inputPic)
            data.append('pic', inputPic.files[0]);
        if (inputBackPic)
            data.append('backPic', inputBackPic.files[0]);

        data.append('color', color);
        data.append('text', text);
        data.append('textColor', textColor);
        data.append('id', id);

        $.ajax({
            type: 'post',
            url: '{{route("mainSlider.image.store")}}',
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                response = JSON.parse(response);
                if (response[0] == 'ok') {
                    alert('ثبت شد.');
                    inputPic.files[0] = '';
                    $('#idForImgSlider0' + _number).val(response[1]);
                }
            }
        });
    }

    function deleteMainSLiderSetting(_number){
        var id = $('#idForImgSlider0' + _number).val();

        if(id != 0){
            $.ajax({
                type: 'post',
                url: '{{route("mainSlider.image.delete")}}',
                data: {
                    _token: '{{csrf_token()}}',
                    id: id
                },
                success: function (response) {
                    if (response == 'ok')
                        $('#rowSlide0' + _number).remove();
                }
            });
        }
    }
</script>
<script>
    var silde5 = 0;
    var silde4 = 0;
    var silde1 = 0;
    var middleBan = {!! json_encode($middleBan) !!};

    function createRowSlid(kind, sil) {
        for (var i = 0; i < sil.length; i++) {
            var text = '                        <div id="rowSlide' + kind + '' + sil[i].number + '" class="row">\n' +
                '                            <div class="col-md-2">\n' +
                '                                <button class="btn btn-danger" onclick="deleteSlideCommon(' + sil[i].number + ', ' + kind + ')" style="position: relative; width: auto">حذف</button>\n' +
                '                                <button class="btn btn-primary" onclick="submitSlideCommon(' + sil[i].number + ', ' + kind + ')" style="position: relative; width: auto">ویرایش</button>\n' +
                '                                <input type="hidden" id="slideId' + kind + '' + sil[i].number + '" value="' + sil[i]["id"] + '">' +
                '                            </div>\n' +
                '                            <div class="col-md-10">\n' +
                '                            <div class="row">\n' +
                '                                <div class="col-md-6">\n' +
                '                                    <img src="' + sil[i]["pic"] + '" class="settingImg" id="showMiddleBannerInput' + kind + '' + sil[i].number + '" style="height: 100px; ">\n' +
                '                                </div>\n' +
                '                                <div class="col-md-6">\n' +
                '                                    <input type="file" id="uploadImgBanner' + kind + '' + sil[i].number + '" accept="image/*" onchange="showPicInput(this, \'showMiddleBannerInput' + kind + '' + sil[i].number + '\')">\n' +
                '                                </div>\n' +
                '                            </div>\n' +
                '                            <div class="row">\n' +
                '                                <div class="col-md-6">\n' +
                '                                    <label for="linkForBanner' + kind + '' + sil[i].number + '">لینک:</label>\n' +
                '                                    <input type="text" id="linkForBanner' + kind + '' + sil[i].number + '" class="form-control" value="' + sil[i]["link"] + '">\n' +
                '                                </div>\n' +
                '                                <div class="col-md-6">\n' +
                '                                    <label for="textForBanner' + kind + '' + sil[i].number + '">متن:</label>\n' +
                '                                    <input type="text" id="textForBanner' + kind + '' + sil[i].number + '" class="form-control" value="' + sil[i]["text"] + '">\n' +
                '                                </div>\n' +
                '                            </div>\n' +
                '                        </div>\n' +
                '                        </div>\n' +
                '                        <hr>';

            $('#sliderPicSection' + kind).append(text);

            if (kind == 4 && sil[i].number >= silde4)
                silde4 = parseInt(sil[i].number) + 1;
            else if (kind == 5 && sil[i].number >= silde5)
                silde5 = parseInt(sil[i].number) + 1;
            else if(kind == 1  && sil[i].number >= silde1)
                silde1 = parseInt(sil[i].number) + 1;
        }
    }

    if (middleBan['1'])
        createRowSlid(1, middleBan['1']);
    if (middleBan['4'])
        createRowSlid(4, middleBan['4']);
    if (middleBan['5'])
        createRowSlid(5, middleBan['5']);

    function addSliderPicTo(kind) {
        if (kind == 4)
            ss = silde4;
        else if (kind == 5)
            ss = silde5;
        else
            ss = silde1;

        var text = '                        <div id="rowSlide' + kind + '' + ss + '" class="row">\n' +
            '                            <div class="col-md-2">\n' +
            '                                <input type="hidden" id="slideId' + kind + '' + ss + '" value="0">\n' +
            '                                <button class="btn btn-success" onclick="submitSlideCommon(' + ss + ', ' + kind + ')" style="position: relative; width: auto">تایید</button>\n' +
            '                            </div>\n' +
            '                            <div class="col-md-10">\n' +
            '                            <div class="row">\n' +
            '                                <div class="col-md-6">\n' +
            '                                    <img  class="settingImg" id="showMiddleBannerInput' + kind + '' + ss + '" style="height: 100px;">\n' +
            '                                </div>\n' +
            '                                <div class="col-md-6">\n' +
            '                                    <input type="file" id="uploadImgBanner' + kind + '' + ss + '" accept="image/*" onchange="showPicInput(this, \'showMiddleBannerInput' + kind + '' + ss + '\')">\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                            <div class="row">\n' +
            '                                <div class="col-md-6">\n' +
            '                                    <label for="linkForBanner' + kind + '' + ss + '">لینک:</label>\n' +
            '                                    <input type="text" id="linkForBanner' + kind + '' + ss + '" class="form-control">\n' +
            '                                </div>\n' +
            '                                <div class="col-md-6">\n' +
            '                                    <label for="textForBanner' + kind + '' + ss + '">متن:</label>\n' +
            '                                    <input type="text" id="textForBanner' + kind + '' + ss + '" class="form-control">\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                        </div>\n' +
            '                        <hr>';

        $('#sliderPicSection' + kind).append(text);

        if (kind == 4)
            silde4++;
        else if(kind == 5)
            silde5++;
        else
            silde1++;
    }

    function showPicInput(input, output) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                newImageReplace = e.target.result;
                $('#' + output).attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function submitSlideCommon(num, numKind) {
        var link = $('#linkForBanner' + numKind + '' + num).val();
        var text = $('#textForBanner' + numKind + '' + num).val();
        var inputPic = $('#uploadImgBanner' + numKind + '' + num)[0];
        var id = $('#slideId' + numKind + '' + num).val();

        var data = new FormData();
        if (inputPic)
            data.append('pic', inputPic.files[0]);

        data.append('section', numKind);
        data.append('page', 'mainPage');
        data.append('number', num);
        data.append('link', link);
        data.append('text', text);
        data.append('id', id);

        $.ajax({
            type: 'post',
            url: '{{route("middleBanner.image.store")}}',
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                response = JSON.parse(response);
                if (response[0] == 'ok') {
                    alert('ثبت شد.');
                    inputPic.files[0] = '';
                    $('#slideId' + numKind + '' + num).val(response[1]);
                }
            }
        });
    }

    function deleteSlideCommon(num, kind) {
        let id = $('#slideId' + kind + '' + num).val();
        $.ajax({
            type: 'post',
            url: '{{route("middleBanner.image.delete")}}',
            data: {
                _token: '{{csrf_token()}}',
                id: id
            },
            success: function (response) {
                if (response == 'ok'){
                    if(kind == 2){
                        $('#showMiddleBannerInput20').attr('src', '');
                        $('#linkForBanner20').text('');
                    }
                    else {
                        $('#rowSlide' + kind + '' + num).remove();
                    }
                }
            }
        })
    }

    function submitSlide(_id, section, kind) {
        var link = $('#linkForBanner' + kind + '' + section).val();
        var text = $('#textForBanner' + kind + '' + section).val();
        var inputPic = $('#uploadImgBanner' + kind + '' + section)[0];
        var id = $('#slideId' + kind + '' + section).val();

        var data = new FormData();
        if (inputPic)
            data.append('pic', inputPic.files[0]);

        data.append('section', kind);
        data.append('page', 'mainPage');
        data.append('number', section);
        data.append('link', link);
        data.append('text', text);
        data.append('id', id);

        $.ajax({
            type: 'post',
            url: '{{route("middleBanner.image.store")}}',
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                response = JSON.parse(response);
                if (response[0] == 'ok') {
                    alert('ثبت شد.');
                    inputPic.files[0] = '';
                    $('#slideId' + kind + '' + section).val(response[1]);
                }
            }
        });
    }

</script>