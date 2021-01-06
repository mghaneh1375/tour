<div class="ppr_rup ppr_priv_hr_atf_north_star_nostalgic">

    <div class="atf_header_wrapper">
        <div class="atf_header ui_container is-mobile full_width">
            <div class="ppr_rup ppr_priv_location_detail_header relative-position">
                <h1 id="HEADING" property="name">
                    <b class="tourCreationMainTitle">شما در حال ایجاد یک تور جدید هستید</b>
                </h1>
                <div class="tourAgencyLogo circleBase type2"></div>
                <b class="tourAgencyName">آژانس ستاره طلایی</b>
            </div>
        </div>
    </div>

    <div class="atf_meta_and_photos_wrapper">
        <div class="atf_meta_and_photos ui_container is-mobile easyClear">
            <div class="prw_rup darkGreyBox tourDetailsMainFormHeading">
                <b class="formName">{{$createTourHeader ?? 'ایجاد تور'}}</b>
                <div class="tourCreationStepInfo">
                        <span>
                            گام
                            <span>{{$createTourStep ?? ''}}</span>
                            از
                            <span>7</span>
                        </span>
                    <span>
                            آخرین ویرایش
                            <span>{{$tour->lastUpdate ?? ''}}</span>
                            <span>{{$tour->lastUpdateTime ?? ''}}</span>
                        </span>
                </div>
            </div>
        </div>
    </div>
</div>
