@extends('Safarnameh.safarnamehLayout')

@section('head')
    <link rel="stylesheet" href="{{URL::asset('css/easyimage.css?v='.$fileVersions)}}">

    <title> {{$safarnameh->seoTitle == null ? $safarnameh->title : $safarnameh->seoTitle}} </title>
    <meta content="article" property="og:type"/>

    <meta name="keywords" content="{{$safarnameh->keyword}}">
    <meta property="og:title" content=" {{$safarnameh->seoTitle}} " />
    <meta property="og:description" content=" {{$safarnameh->meta}}" />
    <meta name="twitter:title" content=" {{$safarnameh->seoTitle}} " />
    <meta name="twitter:description" content=" {{$safarnameh->meta}}" />
    <meta name="description" content=" {{$safarnameh->meta}}"/>
    <meta property="article:author " content="{{$safarnameh->user->username}}" />
    <meta property="article:section" content="article" />
    {{--<meta property="article:published_time" content="2019-05-28T13:32:55+00:00" /> زمان انتشار--}}
    {{--<meta property="article:modified_time" content="2020-01-14T10:43:11+00:00" />زمان آخریت تغییر--}}
    {{--<meta property="og:updated_time" content="2020-01-14T10:43:11+00:00" /> زمان آخرین آپدیت--}}

    @if(isset($safarnameh->pic))
        <meta property="og:image" content="{{URL::asset($safarnameh->pic)}}"/>
        <meta property="og:image:secure_url" content="{{URL::asset($safarnameh->pic)}}"/>
        <meta property="og:image:width" content="550"/>
        <meta property="og:image:height" content="367"/>
        <meta name="twitter:image" content="{{URL::asset($safarnameh->pic)}}"/>
    @endif

    @if(isset($safarnameh->tag))
        @foreach($safarnameh->tag as $item)
            <meta property="article:tag" content="{{$item}}"/>
        @endforeach
    @endif

    <style>
        p {
            font-size: 20px;
        }
        ol, ul{
            padding: 15px;
        }
        .safarnamehDescription{
            margin-top: 65px;
        }
        .safarnamehDescription span, .safarnamehDescription p {
            font-size: 14px !important;
            line-height: 30px !important;
            font-weight: 400 !important;
            text-align: justify;
        }
        .safarnamehDescription figure{
            margin: 20px auto;
            display: flex;
            max-width: 100%;
        }
        .safarnamehDescription h1 span, .safarnamehDescription h1{
            font-size: 28px !important;
            line-height: 44px !important;
            font-weight: bold !important;
        }
        .safarnamehDescription h2, .safarnamehDescription h2 span {
            font-size: 22px !important;
            line-height: 29px !important;
            font-weight: bold !important;
        }
        .safarnamehDescription h3 span, .safarnamehDescription h4 span, .safarnamehDescription h5 span, .safarnamehDescription h6 span,
        .safarnamehDescription h3, .safarnamehDescription h4, .safarnamehDescription h5, .safarnamehDescription h6{
            font-size: 16px !important;
            line-height: 25px !important;
            font-weight: bold !important;
        }
        .safarnamehDescription img{
            margin: 0px auto;
            max-width: 100% !important;
        }
        .content-2col, .content-column, .content-featured{
            margin-bottom: 0px;
        }
        @media (max-width: 768px){
            .gnWhiteBox {
                margin: 0 -15px;
            }

            .safarnamehDescription h1 span, .safarnamehDescription h1{
                font-size: 20px !important;
                line-height: 30px !important;
            }
            .safarnamehDescription h2, .safarnamehDescription h2 span {
                font-size: 18px !important;
                line-height: 25px !important;
            }
            .safarnamehDescription h3 span, .safarnamehDescription h4 span, .safarnamehDescription h5 span, .safarnamehDescription h6 span,
            .safarnamehDescription h3, .safarnamehDescription h4, .safarnamehDescription h5, .safarnamehDescription h6{
                font-size: 14px;
                line-height: 23px !important;
            }
        }

        .mainUserPicSafarnameh{
            position: absolute;
            width: 90px;
            height: 90px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            border: solid 3px #ffffffd9;
            left: calc(50% - 45px);
            top: -70px;
        }
        .gnMainPicOfArticleText .im-meta-item{
            font-size: 18px !important;
        }
        .gnMainPicOfArticleText .iranomag-meta .fa{
            font-size: 18px !important;
        }

        @media (max-width: 767px) {

            .gnMainPicOfArticleText .im-meta-item{
                font-size: 13px !important;
            }
            .gnMainPicOfArticleText .iranomag-meta .fa{
                font-size: 13px !important;
            }
        }
    </style>

@endsection

@section('body')
    <div class="gnWhiteBox">
        <div class="gnMainPicOfArticle">
            <div class="mainImg">
                <img class="gnAdvertiseImage" src="{{$safarnameh->pic}}" alt="{{$safarnameh->keyword}}">
            </div>
            <div class="gnMainPicOfArticleText">
                <a href="{{route('profile', ['username' => $safarnameh->user->username])}}" target="_blank" class="mainUserPicSafarnameh">
                    <img src="{{$safarnameh->user->pic}}"  style="height: 100%;">
                </a>
                <div>
                    <div class="im-entry-category" style="margin: 0 0 0 20px;">
                        <div class="iranomag-meta">
                            <a class="im-catlink-color-2079" href="{{route('safarnameh.list', ['type' => 'category', 'search' => $safarnameh->mainCategory])}}">{{$safarnameh->mainCategory}}</a>
                        </div>
                    </div>
                    <div class="iranomag-meta" style="display: inline-block">
                        <div class="posted-on im-meta-item">
                            <span class="entry-date published updated">{{$safarnameh->date}}</span>
                        </div>
                        <div class="comments-link im-meta-item">
                            <i class="fas fa-comments"></i>
{{--                            <i class="fa fa-comment-o"></i>--}}
                            {{$safarnameh->msgs}}
                        </div>
                        <div class="author vcard im-meta-item">
                            <i class="fa fa-user"></i>
                            {{$safarnameh->user->username}}
                        </div>
{{--                        <div class="post-views im-meta-item">--}}
{{--                            <i class="fa fa-eye"></i>{{$safarnameh->seen}}--}}
{{--                        </div>--}}
                    </div>
                </div>
                <h1 class="im-entry-title">
                    {{$safarnameh->title}}
                </h1>
            </div>
        </div>

        <div>
            <div>
                <div class="safarnamehDescription">
                    {!! $safarnameh->description !!}
                </div>
                <div class="safarnamehTags">
                    @foreach($safarnameh->tag as $tag)
                        <a href="{{url('safarnameh/list/content/'.$tag)}}" class="tag">#{{$tag}}</a>
                    @endforeach
                </div>

                <div class="commentFeedbackChoices">
                    <div class="right">
                        <div class="like" onclick="likePost(1, {{$safarnameh->id}}, this)">
                            <span class="likeSafarnamehCount">{{$safarnameh->like}}</span>
                            <span class="icon LikeIconEmpty {{$safarnameh->youLike == 1 ? 'full': ''}}"></span>
                        </div>
                        <div class="like" onclick="likePost(-1, {{$safarnameh->id}}, this)">
                            <span class="disLikeSafarnamehCount">{{$safarnameh->disLike}}</span>
                            <span class="icon DisLikeIconEmpty {{$safarnameh->youLike == -1 ? 'full': ''}}"></span>
                        </div>
                        <div class="like">
                            <span>{{$safarnameh->msgs}}</span>
                            <span class="icon EmptyCommentIcon" onclick="$('#safarnamehCommentDiv').toggleClass('hidden');"></span>
                        </div>
                    </div>
                    <div class="left">
                        <div id="share_pic" class="postsActionsChoices postShareChoice col-xs-6 col-md-3">
                            <span class="icon commentsShareIconFeedback"></span>
                            @include('layouts.shareBox')
                        </div>
                        <div class="postsActionsChoices col-xs-6 col-md-3 {{$safarnameh->bookMark ? 'BookMarkIcon' : 'BookMarkIconEmpty'}}"
                             onclick="bookMarkSafarnameh({{$safarnameh->id}}, this)" style="cursor: pointer; font-size: 1.3em;"></div>
                    </div>
                </div>
            </div>
            <div>
                <div class="col-md-12 col-sm-12 gnUserDescription">
                    <div>
                        <div class="circleBase type2 newCommentWriterProfilePic" style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden">
                            <img src="{{$safarnameh->user->pic}}" style="height: 100%;">
                        </div>
                        <a href="{{route('profile', ['username' => $safarnameh->user->username])}}" target="_blank" class="gnLabels">{{$safarnameh->user->username}}</a>
                    </div>
                    <div>{{$safarnameh->user->introduction}}</div>
                </div>
            </div>
            <div>

                <div class="newCommentPlaceMainDiv">
                    <div class="circleBase type2 newCommentWriterProfilePic hideOnPhone" style="width: 50px; height: 50px;">
                        <img src="{{$uPic}}">
                    </div>
                    <div class="inputBox">
                        <div class="replyCommentTitle" style="font-weight: bold">نظر خود را در مورد سفرنامه با ما در میان بگذارید</div>
                        <textarea id="textareaForAns" class="inputBoxInput inputBoxInputComment"
                                  rows="1" placeholder="شما چه نظری دارید؟" onclick="checkLogin()"
                                  onchange="checkNotEmptyTextArea(this)// answerPack"
                                  onkeydown="checkNotEmptyTextArea(this)// answerPack"></textarea>
                        <button id="mainBtnAnswer" class="btn submitAnsInReview"
                                onclick="sendCommentText(0, $('#textareaForAns').val()); $(this).hide(); $(this).next().show()"
                                style="height: fit-content" disabled>
                            {{__("ارسال")}}
                        </button>
                        <div class="sendQuestionBtn sendingQuestionLoading" style="display: none;" disabled>
                            <img src="{{URL::asset("images/icons/mGear.svg")}}" style="width: 30px; height: 30px;">
                            {{__("در حال ثبت")}}
                        </div>
                    </div>
                </div>

                <div class="usersCommentHeaderText"> نظرات کاربران </div>
                <div id="safarnamehCommentDiv" class="commentsMainBox"></div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{URL::asset('js/article/articlePage.js')}}"></script>

    <script>
        var safarnamehId = {{$safarnameh->id}};
        var safarnameh = {!! $safarnameh !!};
        var _token= '{{csrf_token()}}';
        var userPic = '{{$uPic}}';

        function likePost(_like, _id, _element){
            if(!checkLogin())
                return;

            $.ajax({
                type: 'post',
                url: '{{route("safarnameh.like")}}',
                data:{
                    _token: '{{csrf_token()}}',
                    like: _like,
                    id: _id
                },
                success: function(response){
                    if(response.status == 'ok'){
                        $(_element).parent().find('.full').removeClass('full');
                        if(response.type === "add")
                            $(_element).find('.icon').addClass('full');


                        $('.likeSafarnamehCount').text(response.like);
                        $('.disLikeSafarnamehCount').text(response.disLike);
                    }
                },
            })
        }

        function getComments(){
            $.ajax({
                type: 'get',
                url: `{{route("safarnameh.comment.get")}}?id=${safarnamehId}`,
                success: response => {
                    if(response.status === "ok")
                        createComment(response.result);
                },
            });
        }

        function createComment(comments){
            let text = '';
            for(let item of comments){
                item.likeFunction = 'likeComments';
                item.sendAnswerFunction = 'sendCommentText';
                text += createMainAnswer(item); // in answerPack.blade.php
            }
            $('#safarnamehCommentDiv').html(text);

            autosize($(".inputBoxInputComment"));
            autosize($(".inputBoxInputAnswer"));
        }

        function likeComments(_id, _kind, _elems){
            $.ajax({
                type: 'POST',
                url: '{{route("safarnameh.comment.like")}}',
                data: {
                    _token: '{{csrf_token()}}',
                    id: _id,
                    like: _kind
                },
                success: function(response){
                    if(response.status === 'ok'){
                        _elems.like.text(response.result[0].likeCount);
                        _elems.disLike.text(response.result[0].disLikeCount);
                    }
                },
                error: err => console.log(err)
            });
        }

        function sendCommentText(_ansTo, _value){
            openLoading();

            $.ajax({
                type: 'post',
                url: '{{route("safarnameh.comment.store")}}',
                data:{
                    _token: '{{csrf_token()}}',
                    id: safarnameh.id,
                    ansTo: _ansTo,
                    txt: _value
                },
                success: function(response){
                    closeLoading();
                    $('#mainBtnAnswer').show().next().hide();
                    $('#textareaForAns').val('');
                    if(response == 'ok'){
                        showSuccessNotifi('پاسخ شما با موفقیت ثبت شد.', 'left', 'var(--koochita-blue)');
                        getComments();
                    }
                    else
                        showSuccessNotifi('مشکلی در ثبت پیام پیش امده', 'left', 'red');
                },
                error: (err) => {
                    console.log(err);

                    $('#mainBtnAnswer').show();
                    $('#mainBtnAnswer').next().hide();
                    $('#textareaForAns').val('');

                    showSuccessNotifi('مشکلی در ثبت پیام پیش امده', 'left', 'red');
                    closeLoading();
                }
            })
        }

        getComments();

        $(window).ready(function(){
            autosize($(".inputBoxInputComment"));
            autosize($(".inputBoxInputAnswer"));
        });
    </script>
@endsection

