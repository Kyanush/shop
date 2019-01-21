    $('.items').slick({
        adaptiveHeight: true,
        dots: false,
        arrows: true,
        TouchMove: false,
        draggable: true,
        infinite: true,
        autoplay: false,
        variableWidth: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1,
        swipeToSlide: true,
        nextArrow: '<a href="javascript:void(0);" class="slick-next"></a>',
        prevArrow: '<a href="javascript:void(0);" class="slick-prev"></a>',
        responsive: [
            {
                breakpoint: 1300,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4,
                }
            },
            {
                breakpoint: 990,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    arrows: false,
                    centerMode: true
                }
            },
            {
                breakpoint: 400,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    centerMode: true
                }
            },
        ]
    });
