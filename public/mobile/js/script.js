
$(document).ready(function() {

    $('.icon_menu').click(function(e){
            $('.wrapper').addClass('g-ttl-move')
            $('.kaspi-menu').addClass('_opened')
    });

    $('.wrapper').click(function(e){
        if($(e.target).hasClass('g-ttl-move')){
            $('.wrapper').removeClass('g-ttl-move')
            $('.kaspi-menu').removeClass('_opened')
        }
    });

    $('.catalog-sub-item.catalog-main').click(function(e) {
        e.preventDefault();

        if($(this).parent('.catalog-sub-items__el').hasClass('_active')){
            $(this).parent('.catalog-sub-items__el').removeClass('_active');
        }else{
            $(this).parent('.catalog-sub-items__el').addClass('_active');
        }

    });

    $('#go-back').click(function(e){
        parent.history.back();
    });

    $('.filters__view-button').click(function(e) {
        if(!$(this).hasClass('_active')){
            $('.filters__view-button').removeClass('_active');
            $(this).addClass('_active');

            if($(this).hasClass('_grid')){
                $('.catalog-grid').addClass('_grid');
                $('.catalog-grid').removeClass('_list');

                localStorage.setItem('catalog-grid', '_grid');
            }else if($(this).hasClass('_list')){
                $('.catalog-grid').addClass('_list');
                $('.catalog-grid').removeClass('_grid');

                localStorage.setItem('catalog-grid', '_list');
            }
        }
    });

    if(localStorage.getItem('catalog-grid'))
        $('.filters__view-button.' + localStorage.getItem('catalog-grid')).trigger('click');




    var main_slider = new Swiper ('#main-slider', {
        direction: "horizontal",
        loop: !0,
        autoplay: 6e3,
        iOSEdgeSwipeDetection: !0,
        spaceBetween: 10,
        centeredSlides: !0,
        slidesPerView: "auto",
        autoplay: {
            delay: 10000,
        },
    });

    var product_slider = new Swiper ('#product-slider', {
        direction: "horizontal",
        loop: !1,
        pagination: { el: '.swiper-pagination' },
        paginationClickable: true,
        iOSEdgeSwipeDetection: !0
    });


    $('.mount-search-bar').click(function(e) {
        app.componentDialog = 'search-dialog';
    });

    $('#write-review').click(function(e) {
        app.componentDialog = 'write-review';
    });

});

function reviewLikeRating(review_id, like){
    productReviewSetLike(review_id, like, function (data) {
        if(data)
            location.reload();
    });
}

Vue.config.productionTip = false;




Vue.component('write-review', {
    data: function() {
        return{
            rating: 5,
            plus: '',
            minus: '',
            name: '',
            email: '',
            comment: '',

            focus:{
                rating: 0,
                plus:    0,
                minus:   0,
                name:    0,
                email:   0,
                comment: 0,
            }
        }
    },
    template: `
        <div class="dialog">
            <div class="dialog__content _topbar-off">

                <div class="topbar container _filter-dialog">
                   <h1 class="topbar__heading">Написать отзыв</h1>
                   <div class="button _only-red-text" @click="close">Отмена</div>
                </div>
                                
                <div>
                    <div class="input" :class="{ '_has-value': rating, '_focused': focus.rating == 1, '_invalid': focus.rating == 2 && !rating }">
                        <label class="input__label">Оценка</label>
                        <select class="input__input" v-model="rating">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="input__has-error">Пожалуйста, заполните это поле</div>
                </div>
                
                
                <div>
                    <div class="input" :class="{ '_has-value': plus, '_focused': focus.plus == 1, '_invalid': focus.plus == 2 && !plus }">
                        <label class="input__label">Достоинства</label>
                        <textarea class="input__input" v-model="plus" @focus="focus.plus = 1" @blur="focus.plus = 2"></textarea>
                    </div>
                    <div class="input__has-error" v-if="focus.plus == 2">Пожалуйста, заполните это поле</div>
                </div>
                
                
                <div>
                    <div class="input" :class="{ '_has-value': minus, '_focused': focus.minus == 1, '_invalid': focus.minus == 2 && !minus }">
                        <label class="input__label">Недостатки</label>
                        <textarea class="input__input" v-model="minus" @focus="focus.minus = 1" @blur="focus.minus = 2"></textarea>
                    </div>
                    <div class="input__has-error" v-if="focus.minus == 2">Пожалуйста, заполните это поле</div>
                </div>
                
                
                <div>
                    <div class="input" :class="{ '_has-value': name, '_focused': focus.name == 1, '_invalid': focus.name == 2 && !name }">
                        <label class="input__label">Ваше имя</label>
                        <textarea class="input__input" v-model="name" @focus="focus.name = 1" @blur="focus.name = 2"></textarea>
                    </div>
                    <div class="input__has-error" v-if="focus.name == 2">Пожалуйста, заполните это поле</div>
                </div>
                
                
                <div>
                    <div class="input" :class="{ '_has-value': email, '_focused': focus.email == 1, '_invalid': focus.email == 2 && !email }">
                        <label class="input__label">Ваш e-mail</label>
                        <input type="email" class="input__input" v-model="email" @focus="focus.email = 1" @blur="focus.email = 2"/>
                    </div>
                    <div class="input__has-error" v-if="focus.email == 2">Пожалуйста, заполните это поле</div>
                </div>
                
                
                <div>
                    <div class="input" :class="{ '_has-value': comment, '_focused': focus.comment == 1, '_invalid': focus.comment == 2 && !comment }">
                        <label class="input__label">Комментарий</label>
                        <textarea class="input__input" v-model="comment" @focus="focus.comment = 1" @blur="focus.comment = 2"></textarea>
                    </div>
                    <div class="input__has-error" v-if="focus.comment == 2">Пожалуйста, заполните это поле</div>
                </div>
              
              
            </div>
        </div>        
    `,
    methods:{
        close(){
            app.componentDialog = '';
        },
    }
});

Vue.component('search-dialog', {
    data: function() {
        return  {
            search: '',
            result: []
        }
    },
    template: `<div class="dialog">
                <div class="dialog__content _topbar-off ">

                    <div class="search">
                        <div class="search__wrapper">
                            <form action="" class="search__input-wrapper">
                                <input v-model="search" type="search" class="search__input active" autofocus="" placeholder="Поиск товара">
                            </form>
                            <a @click="close" class="search__button button _only-red-text">Отмена</a>
                        </div>
                        <div class="search__suggestion-list">
                        
                            <a v-for="item in result" :href="item.url" class="catalog-item container _product-img">
                                <img :src="item.photo" width="35">&nbsp;
                                <span class="catalog-item__title">{{ item.name }}</span>
                                <i class="catalog-item__icon icon icon_chevron"></i>
                            </a>
                        
                        </div>
                    </div>

                </div>
            </div>`,
    methods:{
        close(){
            app.componentDialog = '';
        },
        querySearch(){
            var self = this;

            console.log(self.search);

            axios.get('/product-search',{
                params: {
                    searchText: self.search,
                    maxResults: 10,
                }
            })
            .then(function (response) {
                console.log(response.data);
                self.result = response.data;
            });
        }
    },
    watch: {
        search: {
            handler: function (val, oldVal) {
                if(val)
                    this.querySearch();
                else
                    this.result = [];
            },
            deep: true
        }
    }
});




Vue.component('filters', {
    data: function() {
        return  {
            filters: JSON.parse($('#filters').val()),
            productsAttributesFilters: JSON.parse($('#productsAttributesFilters').val()),
            subMenu: 0,
            start_page: true
        }
    },
    template: `<div class="dialog">
                    <form id="filterpro">
                       <div class="dialog__content _topbar-off ">
                          <div class="filter-dialog">
                             <div class="filter-dialog__wrapper g-mb-gtn">
                                <div class="topbar container _filter-dialog">
                                   <div class="button _only-red-text" @click="close">Отмена</div>
                                   <h1 class="topbar__heading">Фильтр</h1>
                                   <div class="button _only-red-text" @click="filtersClear">Сбросить</div>
                                </div>
                                <ul class="filter-dialog__ul">

                                    <li class="filter-dialog__el" v-for="attribute in productsAttributesFilters">
                                          <div class="filter-dialog__item container g-bb-thin" @click="subMenu = attribute.id" :class="{'g-hide': subMenu}">
                                             <a class="filter-dialog__description">
                                                <div class="filter-dialog__title">
                                                    {{ attribute.name }}
                                                </div>
                                                <div class="filter-dialog__check" v-html="selectedText(attribute)"></div>
                                             </a>
                                             <div class="filter-dialog__checkbox">
                                                <label>
                                                   <input type="checkbox" :checked="selectedText(attribute) ? true : false">
                                                   <div class="filter-dialog__checkbox-mask"><i class="icon icon_check"></i></div>
                                                </label>
                                             </div>
                                          </div>
                                          <ul class="filter-dialog__submenu" :class="{'_show': subMenu == attribute.id, 'g-hide': subMenu != attribute.id}">

                                                 <li class="filter-dialog__item container" v-for="(value, index) in attribute.values">
                                                    <label :for="'filter' + value.id" class="label-block">
                                                        <a class="filter-dialog__description">
                                                           <div class="filter-dialog__title">
                                                                 {{ value.value }}
                                                                <span class="filter-dialog__couter" v-if="false"> (94) </span>
                                                           </div>
                                                        </a>
                                                        <div class="filter-dialog__checkbox">
                                                           <label :for="'filter' + value.id">
                                                           
                                                              <input type="checkbox"
                                                                     :id="'filter' + value.id"
                                                                     :value="value.code"
                                                                     :name="attribute.code" 
                                                                     :checked="checked(attribute.code, value)"/>
                                                              
                                                              <div class="filter-dialog__checkbox-mask"> <i class="icon icon_check"></i> </div>
                                                           </label>
                                                        </div>
                                                    </label>    
                                                 </li>

                                          </ul>
                                    </li>

                                </ul>
                             </div>
                             
                             <div class="filter-dialog__button-space">
                                <a class="button _big" @click="urlParamsGenerate">Применить</a>
                             </div>
                             
                          </div>
                       </div>
                    </form>
              </div>`,
    methods:{
        close(){
            if(this.subMenu)
                this.subMenu = 0;
            else
                app.showFilters = false;
        },
        filtersClear(){
            filtersClear();
        },
        selectedText(attribute){
            var text = '';

            var arrayFilters = gerArrayFilters();
            if(!arrayFilters.length && this.start_page)
                arrayFilters = this.filters;

            this.start_page = false;

            if(arrayFilters[ attribute.code ])
            {
                arrayFilters = arrayFilters[ attribute.code ];
                Object.keys(arrayFilters).forEach(function (key1){

                    Object.keys(attribute.values).forEach(function (key2){
                        if(attribute.values[key2].code == arrayFilters[key1]){
                            text += attribute.values[key2].value + ', ';
                        }
                    });

                });
            }
            if(text)
                return text.slice(0, -2);
        },
        checked(code, value){

            var filters = this.filters[code] ? this.filters[code] : false;
            var result  = false;

            if(filters)
            {
                if($.isArray(filters) || typeof filters === 'object'){

                    Object.keys(filters).forEach(function (key){
                        if(filters[key] == value.code){
                            result = true;
                            return;
                        }
                    });

                }else {
                    if(filters == value.code)
                        result = true;
                }
            }

            return result;
        },
        urlParamsGenerate(){
            urlParamsGenerate(true);
        }
    },
    created(){
    },
    computed:{
        filtersfilters(){
            console.log(this.filters);
        }
    }
});



const app = new Vue({
    el: '#app',
    data: {
        componentDialog: '',
        open_sort_catalog: false,
        showFilters: false
    },
    methods:{
        catalogSort(sort){
            console.log(sort);
            $('.sort_select option[value=' + sort + ']').prop('selected', true).attr('selected', 'true');
            $('.sort_select').change();
        }
    }
});