{{--banner_5--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.9.7/TweenMax.min.js"></script>
<style>

    .cube {
        position: relative;
        margin: 0em auto 0;
        padding: 0px;
        width: 100%;
        height: 3.0em;
        list-style: none;
        transform-style: preserve-3d;
        /*animation: ani 8s infinite linear;*/
    }
    .face {
        box-sizing: border-box;
        position: absolute;
        padding: 1.6em;
        width: 100%;
        height:2em;
        /*opacity: .85;*/
        background: lightblue;
    }

    .faceImg1{
        transform: translateZ(16em);
        background:url({{URL::asset('images/test.jpg')}});
        background-repeat: no-repeat;
        backface-visibility: hidden;
        background-size: 100% 67em;
    }
    .faceImg2{
        transform: rotateY(180deg) translateZ(16em);
        background:url({{URL::asset('images/Chromite.jpg')}});
        background-repeat: no-repeat;
        backface-visibility: hidden;
        background-size: 100% 67em;
    }
    .faceImg3{
        transform: rotateY(90deg) translateZ(16em);
        background:url({{URL::asset('images/test.jpg')}});
        background-repeat: no-repeat;
        backface-visibility: hidden;
        background-size: 100% 67em;
    }
    .faceImg4{
        transform: rotateY(-90deg) translateZ(16em);
        background:url({{URL::asset('images/Chromite.jpg')}});
        background-repeat: no-repeat;
        backface-visibility: hidden;
        background-size: 100% 67em;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="adv3D">
            <ul id="level0" class='cube'>
                <li class='face faceImg1'></li>
                <li class='face faceImg2'></li>
                <li class='face faceImg3'></li>
                <li class='face faceImg4'></li>
            </ul>
            <ul id="level1" class='cube'>
                <li class='face faceImg1'></li>
                <li class='face faceImg2'></li>
                <li class='face faceImg3'></li>
                <li class='face faceImg4'></li>
            </ul>
            <ul id="level2" class='cube'>
                <li class='face faceImg1'></li>
                <li class='face faceImg2'></li>
                <li class='face faceImg3'></li>
                <li class='face faceImg4'></li>
            </ul>
            <ul id="level3" class='cube'>
                <li class='face faceImg1'></li>
                <li class='face faceImg2'></li>
                <li class='face faceImg3'></li>
                <li class='face faceImg4'></li>
            </ul>
            <ul id="level4" class='cube'>
                <li class='face faceImg1'></li>
                <li class='face faceImg2'></li>
                <li class='face faceImg3'></li>
                <li class='face faceImg4'></li>
            </ul>
            <ul id="level5" class='cube'>
                <li class='face faceImg1'></li>
                <li class='face faceImg2'></li>
                <li class='face faceImg3'></li>
                <li class='face faceImg4'></li>
            </ul>
            <ul id="level6" class='cube'>
                <li class='face faceImg1'></li>
                <li class='face faceImg2'></li>
                <li class='face faceImg3'></li>
                <li class='face faceImg4'></li>
            </ul>
            <ul id="level7" class='cube'>
                <li class='face faceImg1'></li>
                <li class='face faceImg2'></li>
                <li class='face faceImg3'></li>
                <li class='face faceImg4'></li>
            </ul>
            <ul id="level8" class='cube'>
                <li class='face faceImg1'></li>
                <li class='face faceImg2'></li>
                <li class='face faceImg3'></li>
                <li class='face faceImg4'></li>
            </ul>
            <ul id="level9" class='cube'>
                <li class='face faceImg1'></li>
                <li class='face faceImg2'></li>
                <li class='face faceImg3'></li>
                <li class='face faceImg4'></li>
            </ul>
            <ul id="level10" class='cube'>
                <li class='face faceImg1'></li>
                <li class='face faceImg2'></li>
                <li class='face faceImg3'></li>
                <li class='face faceImg4'></li>
            </ul>
            <ul id="level11" class='cube'>
                <li class='face faceImg1'></li>
                <li class='face faceImg2'></li>
                <li class='face faceImg3'></li>
                <li class='face faceImg4'></li>
            </ul>
            <ul id="level12" class='cube'>
                <li class='face faceImg1'></li>
                <li class='face faceImg2'></li>
                <li class='face faceImg3'></li>
                <li class='face faceImg4'></li>
            </ul>
        </div>
    </div>
</div>

<script>
    // vars
    var gap=0;
    var slow=7;
    var md = false;
    var oldMouseX=0;
    var mouseX=0;
    var mouseY=0;
    var numLevels=13;
    var gaps=[];
    var gapscnt=0;
    var currentLevel=0;
    var px=[0,0,0,0,0,0,0,0,0,0,0,0,0];
    var vx=[0,0,0,0,0,0,0,0,0,0,0,0,0];
    var	windowHalfX = window.innerWidth / 2;
    var	windowHalfY = window.innerHeight / 2;
    init();

    var width3d = $('.adv3D').width();
    width3d /= 2;

    function tickHandler() {
        //run your logic here...
        if(md){
            gap=averageGaps(mouseX-oldMouseX);
        }

        gap*=.9;
        vx[currentLevel]+=gap;
        oldMouseX = mouseX;
        var i;
        for ( i = currentLevel; i < numLevels; i++) {
            vx[i+1]+=((vx[i]-vx[i+1])/slow);
        }
        for ( i = currentLevel; i > 0; i--) {
            vx[i-1]+=(vx[i]-vx[i-1])/slow;
        }
        for ( i = 0; i <numLevels; i++) {
            px[i]+=(vx[i]-px[i]);
            // trying tweenmax duration 0 method of setting rotationY
            // if(i == 0)
            //     console.log(px[i])
            TweenMax.to($('#level'+i), 0, {rotationY:px[i]});
        }
    }
    // functions
    function init(){
        // code for cube
        var d=0.12;var p=3;
        for(var i=0;i<numLevels;i++){
            var posString="0px "+(-48*i)+ "px";
            TweenMax.to($('#level'+i+' li'), 1, {css:{backgroundPosition: posString}, delay:(d*i)});
            // $('#level'+i).children()[0].style.backgroundPosition = posString + ' !important';
            // $('#level'+i).children()[1].style.backgroundPosition = posString + ' !important';
            // $('#level'+i).children()[2].style.backgroundPosition = posString + ' !important';
            // $('#level'+i).children()[3].style.backgroundPosition = posString + ' !important';
        }
        TweenLite.ticker.addEventListener("tick", tickHandler);
        $('.cube').mouseover(function(){
            // TweenMax.to($('.face'),1,{opacity:1});
        });
        $('.cube').mouseout(function(){
            // TweenMax.to($('.face'),1,{opacity:.85});
        });
        $(document).on('mousedown', function(event) {
            event.preventDefault();
            oldMouseX = mouseX;
            gaps.length = 0;
            md=true;
        }).on('mouseup', function(event) {
            md=false;
        }).on('mousemove', function(event) {
            mouseX = event.clientX - windowHalfX;
            mouseY = event.clientY - windowHalfY;
        });



        $('#level0').mousedown(function(){currentLevel=0; });
        $('#level1').mousedown(function(){currentLevel=1; });
        $('#level2').mousedown(function(){currentLevel=2; });
        $('#level3').mousedown(function(){currentLevel=3; });
        $('#level4').mousedown(function(){currentLevel=4; });
        $('#level5').mousedown(function(){currentLevel=5; });
        $('#level6').mousedown(function(){currentLevel=6; });
        $('#level7').mousedown(function(){currentLevel=7; });
        $('#level8').mousedown(function(){currentLevel=8; });
        $('#level9').mousedown(function(){currentLevel=9; });
        $('#level10').mousedown(function(){currentLevel=10; });
        $('#level11').mousedown(function(){currentLevel=11; });
        $('#level12').mousedown(function(){currentLevel=12; });


        var touchEnabled = 'ontouchstart' in window || navigator.msMaxTouchPoints;
        if (touchEnabled == true) {
            console.log("touchEnabled");
            document.addEventListener('touchmove', onTouchMove, false);
            document.addEventListener('touchstart', onTouchStart, false);
            document.addEventListener('touchend', onTouchEnd, false);
        }

    }
    function onTouchMove(event) {
        event.preventDefault();
        var touch = event.touches[0];
        mouseX = touch.pageX - windowHalfX;
        mouseY = touch.pageY - windowHalfY;
    }
    function onTouchStart(event) {
        event.preventDefault();
        oldMouseX = mouseX;
        gaps.length = 0;
        md=true;
    }
    function onTouchEnd(event) {
        event.preventDefault();
        md = false;
    }
    function averageGaps(n){
        if(isNaN(n)){	return 0;	}
        var gl=gaps.length;
        gaps[gapscnt]=n;
        var ave =0;
        for (var i = 0; i < gl; i++) {
            ave+=gaps[i];
        };
        gapscnt=(gapscnt+1)%10;
        var tmp=ave/gl;
        if(isNaN(tmp)){tmp=0;	}
        return tmp;
    }

    setInterval(function (){
        pxf = Math.floor(px[i]/90);
        gap = 9 - pxf;
        console.log(gap);
        console.log(pxf);
    }, 3000);
</script>