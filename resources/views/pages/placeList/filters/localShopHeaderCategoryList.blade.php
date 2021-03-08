<style>
    .placeListHeader{
        height: auto;
    }
</style>


<div class="localShopCategoryFilterSection">
    <div id="mainLocalShopCategoryRow" class="mainLocalShopCategoryList">
        <div class="header">دسته بندی های کسب و کار</div>
        <div class="swiper-container localCategSwiper">
            <div class="swiper-wrapper categorySections">
                @foreach($localShopCategories as $category)
                    <div class="swiper-slide locCategory" data-id="{{$category->id}}" data-name="{{$category->name}}" onclick="showSubCategoryOfLocalShop(this, 'main')">
                        <i class="icon {{$category->icon}}"></i>
                        <div class="name">{{$category->name}}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @foreach($localShopCategories as $category)
        <div id="subsOfLocalShopCategory_{{$category->id}}" class="mainLocalShopCategoryList hideOnBottom">
            <div class="header">
                <span class="emptyRightArrowLine" onclick="showMainLocalShopCategoryList('refresh')"></span>
                دسته بندی {{$category->name}}
            </div>
            <div class="swiper-container localCategSwiper">
                <div class="swiper-wrapper categorySections">
                    @foreach($category->subs as $sub)
                        <div class="swiper-slide locCategory" data-id="{{$sub->id}}" data-name="{{$sub->name}}" onclick="showSubCategoryOfLocalShop(this, 'sub')">
                            <i class="icon {{$sub->icon}}"></i>
                            <div class="name">{{$sub->name}}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach


</div>


<script>
    var nowShowLocalShopTopCategory = 0;
    $(window).ready(() => {
        var swiper = new Swiper('.localCategSwiper', {
            slidesPerView: 'auto',
            freeMode: true,
        });
    });


</script>
