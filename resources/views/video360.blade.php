 <!DOCTYPE html>
<html>
<head>
    <style>
        a-scene {
            height: 300px;
            width: 600px;
        }
    </style>
    <style>
        .progress-containerVideo {
            width: 100%;
            height: 8px;
            background: #ccc;
        }

        .progress-bar {
            height: 8px;
            background: #4caf50;
            width: 0%;
        }
    </style>
</head>
<body>
<!-- As if this Glitch were a typical HTML CodePen... -->
<script src="https://aframe.io/releases/0.7.1/aframe.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<!-- Use components defined in separate files. -->
<script src="jsAfram/arrow-key-rotation.js"></script>
<script src="jsAfram/toggle-play-on-window-click.js"></script>
<script src="jsAfram/play-on-vrdisplayactivate-or-enter-vr.js"></script>
<script src="jsAfram/hide-once-playing.js"></script>

<!-- Specify our scene. -->
<div id="myEmbeddedScene" style="height: 98%; width: 99%; position: absolute;">
<a-scene embedded>
    <a-videosphere rotation="0 180 0" src="#video"
                   toggle-play-on-window-click
                   play-on-vrdisplayactivate-or-enter-vr>
    </a-videosphere>

    <!-- Define camera with zero user height, movement disabled and arrow key rotation added. -->
    <a-camera user-height="0" wasd-controls-enabled="false" arrow-key-rotation>
        <!-- Text element for display messaging.  Hide once video is playing. -->
        <a-entity id="msg" position="0 -0.3 -1.5" text="align:center;
                width:3;
                wrapCount:100;
                color:red;
                value:Click window to make the video play, if needed."
                  hide-once-playing="#video">
        </a-entity>
    </a-camera>

    <!-- Wait for the video to load. -->
    <a-assets>
        <!-- Single source video. -->
        <video id="video" style="display:none"
               autoplay loop crossorigin="anonymous" playsinline webkit-playsinline>
            <!-- MP4 video source. -->
            <source type="video/mp4"
                    src="movie.mp4"/>
        </video>
    </a-assets>
</a-scene>
    <div style="width:90%; height: 8%; z-index:2; position: absolute; bottom: 0;">
        <div style="z-index: 2; display: inline-block; margin-top: 0px;">
            <div style="background-color: red; height: 50px; width: 50px; display: inline-block" onclick="pause()">
                pause
            </div>
            <div style="background-color: blue; height: 50px; width: 50px; display: inline-block;" onclick="play()">
                play
            </div>
            <div style="background-color: red; height: 50px; width: 50px; display: inline-block;" onclick="forwards()">
                forward
            </div>
            <div style="background-color: blue; height: 50px; width: 50px; display: inline-block;" onclick="backward()">
                backward
            </div>
            <div style="background-color: greenyellow; height: 50px; width: 50px; display: inline-block;"
                 onclick="muteVideo()">
                mute
            </div>
        </div>
        <div id="UpperBar" class="progress-containerVideo" onclick="showCords(event)">
            <div class="progress-bar" id="myBar"></div>
        </div>
    </div>
</div>
</body>

<script>
    var WidthBar = $("#UpperBar").width();
    video.addEventListener("timeupdate", function () {
        document.getElementById("myBar").style.width = video.currentTime / endTime * 100 + "%";
    });

    function forwards() {
        video.currentTime = video.currentTime + 10;
    }
    function backward() {
        video.currentTime = video.currentTime - 10;
    }
    function pause() {
        video.pause();
    }
    function play() {
        video.play();
    }
    function muteVideo() {
        if (video.muted) {
            video.muted = false;
        }
        else {
            video.muted = true;
        }
    }
    function showCords(event) {
        var positionClickOnTimeLine = event.clientX / WidthBar ;
        video.currentTime = endTime * positionClickOnTimeLine;
    }
    video.oncanplay = function () {
        endTime = video.duration;
    };
</script>
</html>