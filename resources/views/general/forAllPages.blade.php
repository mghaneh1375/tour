<link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/shazdeDesigns/abbreviations.css?v='.$fileVersions)}}'/>
<link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/shazdeDesigns/proSearch.css?v='.$fileVersions)}}'/>

<div id="darkModal" class="display-none" role="dialog"></div>

{{--this dark modal with blur--}}
<div id="darkModeMainPage" class="ui_backdrop dark" ></div>

<script>
    function resizeFitImg(_class) {
        let imgs = $('.' + _class);
        for(let i = 0; i < imgs.length; i++)
            fitThisImg(imgs[i]);
    }

    function fitThisImg(_element){
        var img = $(_element);
        var imgW = img.width();
        var imgH = img.height();

        var secW = img.parent().width();
        var secH = img.parent().height();

        if(imgH < secH){
            img.css('height', '100%');
            img.css('width', 'auto');
        }
        else if(imgW < secW){
            img.css('width', '100%');
            img.css('height', 'auto');
        }
    }
</script>
{{--@include('general.searches.proSearch')--}}

@include('general.loading')

@include('general.photoAlbumModal')

@include('general.searches.mainSearch')

@include('general.searches.globalInput')

@include('general.alerts')

@include('component.suggestionPack')

@include('component.questionPack')

@include('component.answerPack')

@include('general.reportModal')

@include('general.followerPopUp')

@include('general.searches.userKoochitaSearch')

@if(Auth::check())
    @include('general.adminInPage')

    @include('general.addToTripModal')

    @include('general.uploadPhoto')

    @include('general.addSafarnameh')

    @include('general.writeReview')
@endif

<script defer src="{{URL::asset('js/component/load-image.all.min.js')}}"></script>

<script>
    var openHeadersTab = false;
    var seenToZero = false;
    var csrfTokenGlobal = '{{csrf_token()}}';
    var hasLogin = {{auth()->check() ? 1 : 0}};
    window.userPic = '{{getUserPic(auth()->check() ? auth()->user()->id : 0)}}';
    window.gearIcon = '{{URL::asset("images/icons/mGear.svg")}}';
    window.getPages = [];
    window.getLoginPageUrl = '{{route("getPage.login")}}';
    window.languageUrl = '{{url('language/')}}/';
    window.InUrl = '{{Request::url()}}';
    window.getAlertUrl = '{{route('getAlerts')}}';
    window.alertSeenUrl = '{{route("alert.seen")}}';
    window.deleteBookMarkUrl = '{{route("profile.bookMark.delete")}}';
    window.storeSeenLogUrl = '{{route('log.storeSeen')}}';
    window.searchInUserUrl = '{{route("findUser")}}';


    window.seenRelatedId = sessionStorage.getItem("lastPageLogId") == null ? 0 : sessionStorage.getItem("lastPageLogId");
    window.seenPageLogId = 0;
    window.userScrollPageLog = [];
    var userWindowInScrolling = null;
    var seenLogStartTime = new Date().getTime();
    var lastSeenLogScroll = 0;

    $(document, window).ready(() => {
        window.isMobile = window.mobileAndTabletCheck() ? 1 : 0;

        resizeFitImg('resizeImgClass');
        showLastPages();

        @if(Auth::check())
            getAlertItems();
            getBookMarkForHeaderAndFooter();
        @endif

        $(".login-button").click(() => checkLogin());
        sendSeenPageLog();
    });
</script>

<script src="{{URL::asset('js/pages/forAllPages.js?v='.$fileVersions)}}"></script>

