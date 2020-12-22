<!doctype html>
<html lang="fa" dir="rtl">
<head>
    @include('layouts.topHeader')
    <title>
        فستیوال
    </title>

    <link rel="stylesheet" href="{{URL::asset('css/pages/festival.css?v='.$fileVersions)}}">
</head>
<body>
    @include('general.forAllPages')
    <header>
        <div class="container">
            <div class="logos">
                <a href="{{route('main')}}">
                    <img src="{{URL::asset('images/camping/undp.svg')}}" style="height: 100%">
                    <img src="{{URL::asset('images/icons/mainLogo.png')}}" style="height: 100%">
                </a>
            </div>
            <div class="buttons">
                <a href="{{route('festival.main')}}" class="votedButton" >رای می دهم</a>
                <div class="registerButton" onclick="iParticipate()">شرکت می کنم</div>
            </div>
        </div>
    </header>

    <section>
        <div class="container headerWhite">
            <span class="bigFont">#جشنواره ایران ما</span>
            <span class="smallFont">فیلم، عکس و عکس‌های موبایلی</span>
        </div>
        <div class="container mainPic">
            <img src="{{URL::asset('images/festival/BANNER.jpg')}}" style="width: 100%">
        </div>
        <div class="flowColor">
            <img src="{{URL::asset('images/festival/2Color.svg')}}" class="bakPic topPic">
            <img src="{{URL::asset('images/festival/2Color2.svg')}}" class="bakPic botPic">

            <div class="container axesMatch">
                <div class="rightText">
                    <div class="bigFont" style="color: var(--yellow)">محورهای مسابقه</div>
                    <ul class="smallFont">
                        <li class="yellowDotBefore">طبیعت، ویژگی‌های اقلیمی و جاذبه‌های گردشگری ایران</li>
                        <li class="yellowDotBefore"> مردم‌نگاری اقوام و خانواده‌ی ایرانی</li>
                        <li class="yellowDotBefore">میراث فرهنگی و بناهای تاریخی و مذهبی ایران</li>
                        <li class="yellowDotBefore"> آیین‌های، مراسم و رویدادهای ملی و مذهبی ایران</li>
                    </ul>
                </div>
                <div class="leftPics">
                    <img src="{{URL::asset('images/festival/cameraWithFoot.png')}}" class="commonPic pic1">
                    <img src="{{URL::asset('images/festival/cameraWithFoot.png')}}" class="commonPic pic2">
                    <img src="{{URL::asset('images/festival/cameraWithFoot.png')}}" class="commonPic pic3">
                </div>
            </div>
        </div>

        <div class="container conditionFestival">
            <div class="row">
                <div class="bigFont">
                    شرایط مسابقه
                </div>
                <div class="smallFont buttonss">
                    <div class="selected" onclick="changeConditionMatch('pic', this)">#عکس</div>
                    <div onclick="changeConditionMatch('mobile', this)">#عکس موبایلی</div>
                    <div onclick="changeConditionMatch('video', this)">#فیلم</div>
                </div>
            </div>
            <div class="row" style="margin-top: 25px">
                <div id="conditionTexts" class="rightSec" style="position: relative;">
                    <div class="smallFont rowss conditionRows pic show">
                        <div>تعداد آثار ارسالی برای هر شخص محدودیتی ندارد.</div>
                        <div>ارایه آثار این بخش نیز می‌بایست همراه با ثبت‌نام متقاضی، به‌صورت آپلود در
                            سایت حجمی معادل حداکثر 100 کیلوبایت و نیز ارسال سی‌دی در
                            اندازه 30 در 45 سانتی‌متر با 300 دی پی آی صورت گیرد.</div>
                        <div>تمام آثار ارسالی بایستی دارای زمان و مکان عکاسی باشند.</div>
                        <div>ارسال عکس در ابعاد اعلام شده روی سی دی الزامی است.</div>
                        <div>شرکت در این بخش برای عموم آزاد است و شرط سنی ندارد.</div>
                    </div>
                    <div class="smallFont rowss conditionRows mobile down hidden">
                        <div>تعداد آثار ارسالی برای هر شخص محدودیتی ندارد.2</div>
                        <div>ارایه آثار این بخش نیز می‌بایست همراه با ثبت‌نام متقاضی، به‌صورت آپلود در
                            سایت حجمی معادل حداکثر 100 کیلوبایت و نیز ارسال سی‌دی در
                            اندازه 30 در 45 سانتی‌متر با 300 دی پی آی صورت گیرد.</div>
                        <div>تمام آثار ارسالی بایستی دارای زمان و مکان عکاسی باشند.</div>
                        <div>ارسال عکس در ابعاد اعلام شده روی سی دی الزامی است.</div>
                        <div>شرکت در این بخش برای عموم آزاد است و شرط سنی ندارد.</div>
                        <div>شرکت در این بخش برای عموم آزاد است و شرط سنی ندارد.</div>
                        <div>شرکت در این بخش برای عموم آزاد است و شرط سنی ندارد.</div>
                    </div>
                    <div class="smallFont rowss conditionRows video down hidden">
                        <div>تعداد آثار ارسالی برای هر شخص محدودیتی ندارد.3</div>
                        <div>ارایه آثار این بخش نیز می‌بایست همراه با ثبت‌نام متقاضی، به‌صورت آپلود در
                            سایت حجمی معادل حداکثر 100 کیلوبایت و نیز ارسال سی‌دی در
                            اندازه 30 در 45 سانتی‌متر با 300 دی پی آی صورت گیرد.</div>
                    </div>
                </div>
                <div class="leftSec">
                    <img id="matchConditionPic" src="{{URL::asset('images/festival/oneHandCamera.png')}}" >
                </div>
            </div>
        </div>

        <div class="yellowSecBack withGear">
            <div class="container">
                <div class="bigFont">جوایز</div>
                <div class="smallFont">در هر بخش سه اثر برگزیده توسط رای مخاطبان و سه اثر برگزیده توسط هیات داوران انتخاب می‌گردد.</div>
                <div class="centerContent" style="margin-top: 13px;">
                    <img src="{{URL::asset('images/festival/cup.svg')}}" style="width: 75px">
                    <div class="smallFont">در هر بخش به سه اثر برگزیده هیئت داوران تندیس جشنواره و به سه اثر برگزیده آرای مردمی لوح تقدیر جشنواره تعلق می‌گیرد</div>
                </div>
                <div class="centerContent" style="margin-top: 13px;">
                    <div class="smallFont">
                        آثار برگزیده در بخش عکاسی و فیلم ، در نمایشگاهی با همکاری سازمان برنامه توسعه سازمان ملل؛UNDP،  در ایران و خارج
                        از ایران به نمایش در می‌آید. اطلاعات کاملتر در این مورد از همین وب سایت اعلام می شود.
                    </div>
                    <img src="{{URL::asset('images/festival/redCarpet.svg')}}" style="height: 100px;">
                </div>
            </div>
        </div>

        <div class="blackSecBack withGear">
            <div class="container">
                <div class="bigFont">
                    هیئت داوران
                </div>
                <div class="smallFont buttonss">
                    <div>#عکس</div>
                    <div class="selected">#عکس موبایلی</div>
                    <div>#فیلم</div>
                </div>
                <div class="judgesSec">
                    <div class="jug">
                        <div class="pic">
                            <img src="https://static.koochita.com/defaultPic/da45ed5ff457e3a6f1cf01c708ceabe3.jpg" alt="">
                        </div>
                        <div class="info">
                            <div class="name">افشین شاهرودی</div>
                            <div class="role">نویسنده، عکاس</div>
                            <div class="role">afshin.akkas@gmail.com</div>
                        </div>
                    </div>
                    <div class="jug">
                        <div class="pic">
                            <img src="https://static.koochita.com/defaultPic/da45ed5ff457e3a6f1cf01c708ceabe3.jpg" alt="">
                        </div>
                        <div class="info">
                            <div class="name">افشین شاهرودی</div>
                            <div class="role">نویسنده، عکاس</div>
                            <div class="role">afshin.akkas@gmail.com</div>
                        </div>
                    </div>
                    <div class="jug">
                        <div class="pic">
                            <img src="https://static.koochita.com/defaultPic/da45ed5ff457e3a6f1cf01c708ceabe3.jpg" alt="">
                        </div>
                        <div class="info">
                            <div class="name">افشین شاهرودی</div>
                            <div class="role">نویسنده، عکاس</div>
                            <div class="role">afshin.akkas@gmail.com</div>
                        </div>
                    </div>
                    <div class="jug">
                        <div class="pic">
                            <img src="https://static.koochita.com/defaultPic/da45ed5ff457e3a6f1cf01c708ceabe3.jpg" alt="">
                        </div>
                        <div class="info">
                            <div class="name">افشین شاهرودی</div>
                            <div class="role">نویسنده، عکاس</div>
                            <div class="role">afshin.akkas@gmail.com</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="yellowSecBack withGear">
            <div class="container">
                <div class="bigFont">تقویم جشنواره</div>
                <div class="calendar right">
                    <div class="topText">آغاز ثبت نام و دریافت تصویر آثار</div>
                    <div class="line"></div>
                    <div class="botText">10 مهر تا 10 آبان</div>
                </div>
                <div class="calendar left">
                    <div class="topText">آغاز ثبت نام و دریافت تصویر آثار</div>
                    <div class="line"></div>
                    <div class="botText">10 مهر تا 10 آبان</div>
                </div>
                <div class="calendar right">
                    <div class="topText">آغاز ثبت نام و دریافت تصویر آثار</div>
                    <div class="line"></div>
                    <div class="botText">10 مهر تا 10 آبان</div>
                </div>
                <div class="calendar left">
                    <div class="topText">آغاز ثبت نام و دریافت تصویر آثار</div>
                    <div class="line"></div>
                    <div class="botText">10 مهر تا 10 آبان</div>
                </div>
            </div>
        </div>

        <div class="blackSecBack withGear">
            <div class="container">
                <div class="bigFont">روند برگزاری</div>
                <div class="smallFont" style="margin-top: 20px">
                    هنرمندان، آثاری را در زمینه های عکاسی و فیلم و با توجه به
                    موضوعات مشخص شده، به  صورت دیجیتال آنلاین برای وب
                    سایت جشنواره ارسال می کنند، برای ارسال آثار زمانی در
                    حدود یک ماه در نظر گرفته شده است، سپس این آثار
                    توسط مردم داوری می شوند و با توجه به تعداد رای های
                    هر اثر نفرات برگزیده مردمی انتخاب می شوند، سپس
                    سایت بر روی هنرمندان جهت ارسال آثار بسته خواهد شد
                    و تیم های داوری به صورت مستقل از پنل های خود آثار
                    برگزیده را انتخاب می کنند، آثاری که بالاترین امتیاز را
                    از مجموع امتیاز های داده شده توسط داوران کسب
                    کنند، به عنوان برگزیدگان داوری معرفی خواهند شد.
                </div>
            </div>
        </div>

        <div class="yellowSecBack withGear">
            <div class="container">
                <div class="bigFont">اعلان نتایج</div>
                <div class="smallFont" style="margin-top: 20px">
                    اعلام نتایج برگزیدگان از طریق ایمیلی که در فرم ثبت نام نوشته‌اند، به ایشان اعلام می‌گردد. به
                    همین سبب لازم است تا شرکت کنندگان یک ایمیل معتبر در فرم ثبت نام ارائه نمایند.
                    ضمنا اخبار و اطلاعیه ها از طریق وب سایت و یا کانال رسمی جشنواره در وب سایت کوچیتا قابل دسترسی خواهند بود.
                </div>
            </div>
        </div>

        <div class="blackSecBack" style="padding: 20px 0px;">
            <div class="container">
                <div class="bigFont">تماس با  دبیرخانه</div>
                <div class="footerRow">
                    <div>
                        <span>آدرس:</span>
                        <span style="color: white">تهران، میدان ونک، بزرگراه حقانی، نرس یده به چهارراه جهان کودک، پلاک 40 ، مرکز رشد و نوآوری دانشگاه علامه، طبقه سوم، واحد سمت چپ</span>
                    </div>
                    <div>
                        <span>تلقن:</span>
                        <span style="color: white">021-88195360</span>
                    </div>
                    <div>
                        <span>کدپستی:</span>
                        <span style="color: white"></span>
                    </div>
                    <div>
                        <span>پشتیبانی فنی:</span>
                        <span style="color: white">09120239315</span>
                    </div>
                    <div>
                        <span>ساعات تماس:</span>
                        <span style="color: white">از شنبه تا چهارشنبه از ساعت 12 الی 17</span>
                    </div>
                    <div>
                        <span>ایمیل:</span>
                        <span style="color: white">festival@koochita.com</span>
                    </div>
                    <div>
                        <span>نشانی وبسایت رسمی:</span>
                        <span style="color: white">koochita.com/festival</span>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <script>
        let matchConditionPics = {
            'pic' : '{{URL::asset('images/festival/oneHandCamera.png')}}',
            'mobile': '{{URL::asset('images/festival/handMobile.png')}}',
            'video': '{{URL::asset('images/festival/twoHandCamera.png')}}'
        }
        function changeConditionMatch(_kind, _elem){
            $(_elem).parent().find('.selected').removeClass('selected');
            $(_elem).addClass('selected');
            $('#matchConditionPic').attr('src', matchConditionPics[_kind]);

            let showText = $('#conditionTexts').find('.show');
            let needToShowText = $('#conditionTexts').find('.'+_kind);
            if(showText[0] != needToShowText[0]) {
                showText.removeClass('show').addClass('down');
                needToShowText.removeClass('hidden');
                needToShowText.removeClass('down');

                setTimeout(() => needToShowText.addClass('show'), 10);
                setTimeout(() => showText.addClass('hidden'), 500);
            }
        }

        function iParticipate(){
            if(!checkLogin('{{route('festival.uploadWorks')}}'))
                return;

            window.location.href = '{{route('festival.uploadWorks')}}';
        }

    </script>
</body>
</html>