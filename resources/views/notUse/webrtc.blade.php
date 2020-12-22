<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<video id="localVideo" autoplay playsinline controls="false"/>

<script !src="">
    let _token = '{{csrf_token()}}';
    let url = '{{url("webrtcPost")}}'

</script>

<script src="test/video.js"></script>

</body>
</html>