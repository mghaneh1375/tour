<footer>

    @include('layouts.footer.PcFooter')

    @include('layouts.footer.MobileFooter')

    <script>
        window.seenRelatedId = sessionStorage.getItem("lastPageLogId") == null ? 0 : sessionStorage.getItem("lastPageLogId");
        window.seenPageLogId = 0;
        window.userScrollPageLog = [];
        window.isMobile = window.mobileAndTabletCheck() ? 1 : 0;
        var userWindowInScrolling = null;
        var seenLogStartTime = new Date().getTime();
        var lastSeenLogScroll = 0;

        // $(window).on('scroll', () => {
        //     var time = seenLogStartTime;
        //     seenLogStartTime = new Date().getTime();
        //     if(new Date().getTime() - time > 1000){
        //         window.userScrollPageLog.push({
        //             scroll: (lastSeenLogScroll/($(document).height() - $(window).height())) * 100,
        //             time: new Date().getTime() - time
        //         })
        //     }
        //     else if(window.userScrollPageLog[window.userScrollPageLog.length-1] != 'scrolling')
        //         window.userScrollPageLog.push('scrolling');
        //
        //     if(userWindowInScrolling != null)
        //         clearTimeout(userWindowInScrolling);
        //
        //     setTimeout(() => {
        //         seenLogStartTime = new Date().getTime();
        //         lastSeenLogScroll = window.pageYOffset
        //     }, 1000);
        // });
        function sendSeenPageLog(){
            $.ajax({
                type: 'post',
                url: '{{route('log.storeSeen')}}',
                data: {
                    _token: '{{csrf_token()}}',
                    relatedId: window.seenRelatedId,
                    seenPageLogId: window.seenPageLogId,
                    scrollData: window.userScrollPageLog,
                    isMobile: window.isMobile,
                    windowsSize: {width: $(window).width(), height: $(window).height()},
                    url: document.location.pathname
                },
                success: response => {
                    if(response.status == 'ok') {
                        sessionStorage.setItem("lastPageLogId", response.seenPageLogId);
                        window.seenPageLogId = response.seenPageLogId;
                    }
                    // setTimeout(sendSeenPageLog, 5000);
                },
                // error: err => setTimeout(sendSeenPageLog, 5000)
            })
        }
        sendSeenPageLog();

    </script>

    <script async src="{{URL::asset('js/pages/placeFooter.js?v='.$fileVersions)}}"></script>
    @if(Auth::check())
        <script>
            let profileUrl = '{{route("profile")}}';

            function initialProgressFooter() {
                var b = "{{$authUserInfos->userTotalPoint / $authUserInfos->userLevel[1]->floor}}" * 100;
                $("#progressIdPhone").css("width", b + "%");
            }
            initialProgressFooter();

            @if($newRegisterOpen)
            if($(window).width() <= 767) {
                setTimeout(() => {
                    $('#profileFooterModal').modal('show');
                    setTimeout(() => $('.welcomeMsgModalFooter').removeClass('hidden'), 200);
                }, 1000);
            }
            {{\Session::forget('newRegister')}}
            @endif
        </script>
    @elseif(Request::is('show-place-details/*') || Request::is('placeList/*'))
        <script>
            if (typeof(Storage) !== "undefined") {
                seeLoginHelperFunction = localStorage.getItem('loginButtonHelperNotif1');
                if(seeLoginHelperFunction == null || seeLoginHelperFunction == false){
                    setTimeout(() => {
                        setTimeout( openLoginHelperSection, 1000);
                        localStorage.setItem('loginButtonHelperNotif1', true);
                    }, 15000);
                }
            }
            else
                console.log('your browser not support localStorage');
        </script>
    @endif


    <script>
        {{--var serviceWorkerUrl = '{{URL::asset("ServiceWorker.js")}}';--}}
        {{--serviceWorkerUrl = serviceWorkerUrl.replace('http://', 'https://');--}}

        {{--if ('serviceWorker' in navigator) {--}}
        {{--    window.addEventListener('load', function(){--}}
        {{--        navigator.serviceWorker.register(serviceWorkerUrl).then(--}}
        {{--            registration => {--}}
        {{--                console.log('Service Worker is registered', registration);--}}
        {{--            }).catch(--}}
        {{--            err => {--}}
        {{--                console.error('Registration failed:', err);--}}
        {{--            });--}}
        {{--    })--}}
        {{--}--}}
    </script>

</footer>
