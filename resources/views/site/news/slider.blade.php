<div class="container">
    <div class="box">
        <div class="box-heading">
            <a href="{{ route('news_list') }}">Новости</a>
            <div class="box-arrows">
                <div class="box-arrow-left"></div>
                <div class="box-arrow-right"></div>
            </div>
            <div class="box-right-link">
                <a href="{{ route('news_list') }}">Все новости</a>
            </div>
        </div>
        <div class="box-content">
            <ul class="blog_list">

                @foreach($news as $item)
                    <li class="blog_item">
                        <div class="blog_item_image">
                            <a href="{{ $item->detailUrl() }}">
                                <img src="{{ $item->pathImage(true) }}"
                                     class="lazyload"
                                     title="{{ $item->title }}"
                                     alt="{{ $item->title }}"/>
                            </a>
                        </div>
                        <div class="blog_item_item_description">
                            <div class="blog_item_item_description_bg"></div>
                            <a href="{{ $item->detailUrl() }}">
                                {{ $item->title }}
                            </a>
                            <div class="blog_item_description">
                                {!! $item->preview_text !!}
                            </div>
                        </div>
                    </li>
                @endforeach

            </ul>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.blog_list').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        swipeToSlide: true,
    });

    $(document).ready(function() {
        $('.box-arrow-left').on('click', function () {
            $(".blog_list").slick('slickPrev');
        });
        $('.box-arrow-right').on('click', function () {
            $(".blog_list").slick('slickNext');
        });
    });
</script>