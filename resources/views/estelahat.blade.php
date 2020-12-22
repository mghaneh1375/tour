<?php $placeMode = 'estelahat'; $state = "تهران"; ?>
@extends('layouts.bodyPlace')

@section('header')
    @parent

    <link rel="stylesheet" href="{{URL::asset('css/shazdeDesigns/estelahat.css?v=1')}}">
    <link rel="stylesheet" href="{{URL::asset('css/shazdeDesigns/abbreviations.css?v=1')}}">

    <script>

        var searchEstelah = '{{route('searchEstelah')}}';
        var mode = 1;

         $(document).ready(function() {

             $('.menu').addClass('original').clone().insertAfter('.menu').addClass('cloned').css('position','fixed').css('top','0').css('margin-top','0').css('z-index','500').removeClass('original').hide();

             scrollIntervalID = setInterval(stickIt, 10);


             function stickIt() {

                 var orgElementPos = $('.original').offset();
                 orgElementTop = orgElementPos.top;

                 if ($(window).scrollTop() >= (orgElementTop)) {
                 // scrolled past the original position; now only show the cloned, sticky element.

                 // Cloned element should always have same left position and width as original element.
                     orgElement = $('.original');
                     coordsOrgElement = orgElement.offset();
                     leftOrgElement = coordsOrgElement.left;
                     widthOrgElement = orgElement.css('width');
                     $('.cloned').addClass('my_moblie_hidden');
                     $('.cloned').css('left','0%').css('box-shadow','0 0 10px 0 rgba(0, 0, 0, 0.45)').css('top',0).css('font-size', '13px').css('right', '0%').css('width','auto').show();
                     $('.original').css('visibility','hidden');
                 } else {
                     // not scrolled past the menu; only show the original menu.
                     $('.cloned').hide();
                     $('.original').css('visibility','visible');
                 }
             }
         });

        function changeSrcAndDest() {
            $("#result").empty();
            $("#mean").val("");
            $("#word").val("");
            mode = (mode == 1) ? 2 : 1;
            src = $("#srcContainer").find("select");
            dest = $("#destContainer").find("select");
            $("#srcContainer").remove('select').prepend(dest);
            $("#destContainer").remove('select').prepend(src);
        }

        function search() {

            if($("#word").val().length < 2 || $("#goyeshCities").val() == "none") {
                $("#result").empty();
                return;
            }

            $.ajax({
                type: 'post',
                url: searchEstelah,
                data: {
                    'key': $("#word").val(),
                    'goyesh': $("#goyeshCities").val(),
                    'mode' : mode
                },
                success: function (response) {

                    if(response.length < 0) {
                        $("#result").empty();
                        return;
                    }

                    response = JSON.parse(response);

                    newElement = "";
                    if(mode == 1) {
                        for (i = 0; i < response.length; i++) {
                            newElement += "<p class='cursor-pointer' onclick='fillTranslate(\"" + response[i].estelah + "\", \"" + response[i].talafoz + "\", \"" + response[i].maani + "\")'>" + response[i].estelah + "</p>";
                        }
                    }
                    else {
                        for (i = 0; i < response.length; i++) {
                            newElement += "<p class='cursor-pointer' onclick='fillTranslate(\"" + response[i].estelah + "\", \"" + response[i].talafoz + "\", \"" + response[i].maani + "\")'>" + response[i].maani + "</p>";
                        }
                    }

                    $("#result").empty().append(newElement);

                }
            });

        }

        function fillTranslate(a, b, c) {
            $("#mean").val(a + " - " + b + " - " + c);
        }

    </script>
@stop

@section('main')

    <div class="ui_container">
        <div class="ppr_rup ppr_priv_hr_btf_similar_hotels">
            <div class="ui_columns is-mobile">
                <div class="ui_column is-12">
                    <center class="col-xs-12 menu addWordMainDiv">
                        <div class="col-xs-1">&nbsp;</div>
                        <div class="col-xs-4" id="destContainer">
                            <select class="field dropdown" id="justFarsi">
                                <option value="0" class="dropdownItem">فارسی</option>
                            </select>
                            <br><br>
                            <input class="word_mean" type="text" id="mean" disabled placeholder="ترجمه">
                        </div>
                        <div class="col-xs-2">
                            <div onclick="changeSrcAndDest()" class="translateImage"></div>
                        </div>
                        <div class="col-xs-4" id="srcContainer">

                            <select onchange="search()" class="field dropdown" id="goyeshCities">
                                <option class="dropdownItem" selected value="none">انتخاب</option>

                                @foreach($goyeshCities as $itr)
                                    <option class="dropdownItem" value="{{$itr->id}}">{{$itr->name}}</option>
                                @endforeach
                                <option class="dropdownItem" value="-1">همه</option>
                            </select>
                            <br><br>
                            <input onkeyup="search()" class="word_mean" type="text" id="word" placeholder="کلمه">
                            <div class="clear-both"></div>
                            <div id="result" class="data_holder"></div>

                        </div>
                        <div class="col-xs-1">&nbsp;</div>

                    </center>
                </div>
            </div>


            <div class="ui_column is-12">
                <div class="recommendedCard" id="estelah">
                    <div >
                        <div class="row">

                            @foreach($tags as $tag)
                                <div class="col-xs-3" id="tagMainBox">
                                    <div class="col-xs-12" id="tagNameDiv">{{$tag->name}}</div>
                                    <div class="col-xs-12 pd-10Imp" >
                                        @foreach($tag->words as $word)
                                            <div class="col-xs-12 estelahatrow">
                                                <div class="col-xs-4">{{$word->estelah}}</div>
                                                <div class="col-xs-4">{{$word->talafoz}}</div>
                                                <div class="col-xs-4">{{$word->maani}}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <script>
        $('.login-button').click(function() {

            var url = '{{route('estelahat', ['goyesh' => $goyesh])}}';

            $(".dark").show();
            showLoginPrompt(url);
        });

        function hideElement(val) {
            $("#" + val).addClass('hidden');
            $(".dark").hide();
        }

        function showElement(val) {
            $(".dark").show();
            $("#" + val).removeClass('hidden');
        }
    </script>

    <div class="ui_backdrop dark opacityMode"></div>
@stop