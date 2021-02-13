<footer>
    @include('layouts.footer.PcFooter')

    @include('layouts.footer.MobileFooter')

    <script>

        var userSettingPageUrl = "{{route('profile.accountInfo')}}";
        var addPlaceByUserUrl = "{{route('addPlaceByUser.index')}}";
        var getReviewExploreUrl = "{{route('review.explore')}}";
        var cookFestivalUrl = '{{route("festival.cook")}}';
        var touchRigthForFooterMobile = 0;
    @if(Auth::check())
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

    @else
        if (typeof(Storage) !== "undefined") {
            seeLoginHelperFunction = localStorage.getItem('loginButtonHelperNotif1');
            if(seeLoginHelperFunction == null || seeLoginHelperFunction == false){
                setTimeout(() => {
                    setTimeout( openLoginHelperSection, 1000);
                    localStorage.setItem('loginButtonHelperNotif1', true);
                }, 5000);
            }
        }
        else
            console.log('your browser not support localStorage');
    @endif
    </script>

    <script src="{{URL::asset('js/pages/placeFooter.js?v='.$fileVersions)}}"></script>
</footer>

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
