
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>videojs-vr Demo</title>

    <link rel="stylesheet" href="/vr2/video-js.css">
    <link rel="stylesheet" href="/vr2/videojs-vr.css">

    <script src="/vr2/video.js"></script>
    <script src="/vr2/videojs-vr.js"></script>
</head>
<body>

<video width="640" height="300" id="my-video" class="video-js vjs-default-skin" autoplay>
    <source src="/vr2/eagle-360.mp4" type="video/mp4">
</video>

</body>

<script>
    (function(window, videojs) {
        var player = window.player = videojs('my-video');
        player.mediainfo = player.mediainfo || {};
        player.mediainfo.projection = '360';

        // AUTO is the default and looks at mediainfo
        var vr = window.vr = player.vr({projection: 'AUTO', debug: true, forceCardboard: false});
    }(window, window.videojs));

</script>
</html>
