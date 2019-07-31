@extends('layouts.site')

@section('title',    	 $seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])

@section('content')

@section('add_in_head')
    <link rel="stylesheet" type="text/css" href="/site/css/filterpro.css">
    <!-- Slider -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" type="text/css" media="all">
    <!-- Slider -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" type="text/javascript"></script>
@stop

    <div class="container">

        @include('includes.breadcrumb', ['breadcrumbs' => $breadcrumbs])

        <h1 itemprop="name">
            {{ $title }}
        </h1>

        <div id="column-left">
            <div id="filterpro_box">
                <div class="filterpro">
                    <form id="filterpro">

                        <div class="option_box">
                            <div class="option_name">Цена ₸</div>
                            <div class="price_slider collapsible">
                                <div class="price_slider_min">{{ $priceMinMax['min'] }}</div>
                                <div class="price_slider_middle">{{ round((($priceMinMax['max'] - $priceMinMax['min']) / 2) + $priceMinMax['min']) }}</div>
                                <div class="price_slider_max">{{ $priceMinMax['max'] }}</div>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" id="min_price" value="{{ $filters['price_start'] ?? $priceMinMax['min']}}" name="price_start" class="price_limit">
                                            </td>
                                            <td style="padding: 0 7px;"><label> — </label></td>
                                            <td>
                                                <input type="text" id="max_price" value="{{ $filters['price_end'] ?? $priceMinMax['max'] }}" name="price_end" class="price_limit">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div id="slider-range"></div>

                                <script>
                                    $('#slider-range').slider({
                                        range:true,
                                        min: {{ $priceMinMax['min'] ?? 0 }},
                                        max: {{ $priceMinMax['max'] ?? 0 }},
                                        values:[{{ $filters['price_start'] ?? $priceMinMax['min'] ?? 0 }}, {{ $filters['price_end'] ?? $priceMinMax['max'] ?? 0}}],
                                        slide:function (a, b) {
                                            var min = b.values[0];
                                            var max = b.values[1];
                                            $("#min_price").val(min);
                                            $("#max_price").val(max);
                                        },
                                        stop:function (a, b) {
                                            var min = b.values[0];
                                            var max = b.values[1];
                                            $("#min_price").val(min);
                                            $("#max_price").val(max);
                                            urlParamsGenerate();
                                        }
                                    });
                                </script>

                            </div>
                        </div>

                        @foreach($productsAttributesFilters as $attribute)
                            <div class="attribute_box option_box">
                                <div class="option_name {{ !isset($filters[$attribute->code]) ? 'hided' : '' }}">

                                    {{ $attribute->name }}

                                    <span class="podskazka">
                                        <span style="display: none;">
                                            {{ $attribute->description }}
                                        </span>
                                    </span>
                                </div>
                                <div class="collapsible" style="display:{{ !isset($filters[$attribute->code]) ? 'none' : 'block' }}">
                                    <table>
                                        <tbody>
                                            @foreach($attribute->values as $value)
                                                <tr>
                                                    <td class="checkbox_td">
                                                        <input class="filtered a_name"
                                                               onclick="urlParamsGenerate()"
                                                               id="attribute_value_{{$attribute->id}}{{$value->id}}"
                                                               value="{{ $value->code }}"

                                                               @if(isset($filters[$attribute->code]))
                                                                   @if(is_array($filters[$attribute->code]))
                                                                        @foreach($filters[$attribute->code] as $filter_value)
                                                                               @if($filter_value == $value->code)
                                                                                    checked
                                                                               @endif
                                                                        @endforeach
                                                                   @else
                                                                       @if($filters[$attribute->code] == $value->code)
                                                                            checked
                                                                       @endif
                                                                   @endif
                                                               @endif

                                                               type="checkbox"
                                                               name="{{ $attribute->code }}" >
                                                        <label for="attribute_value_{{$attribute->id}}{{$value->id}}">

                                                            @if($attribute->type == 'color')
                                                                <span class="color" style="background-color: {{ $value->props }};"></span>
                                                                {{ $value->value }}
                                                            @else
                                                                {{ $value->value }}
                                                            @endif

                                                        </label>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach

                        <a class="clear_filter">
                            <span onclick="filtersClear()">Сбросить фильтр</span>
                        </a>

                    </form>
                </div>

            </div>

			<div class="homepage_banner w100">
				@include('includes.product_day')
            </div>
            <div class="team_banners">
                {!! \App\Services\ServiceBanner::getBanner(9) !!}
            </div>
        </div>

        <div id="content" class="category_content">
            <div class="category_content">
                <div class="product-filter">
                    <!-- Mobile lini -->
                    <div class="product-filter-wave"></div>
                    <!-- Вид -->
                    <div class="display">
                        <div onclick="display('list');" class="view_as_list"></div>
                        <div class="view_as_grid active_view"></div>
                    </div>

					@if($category)
                        <?php
                            $orderBy = \App\Tools\Helpers::getSortedToFilter($filters);

                            $column  = $orderBy['sorting_product']['column'];

                            $order = $orderBy['default']
                                     ?  $orderBy['sorting_product']['order']
                                     : ($orderBy['sorting_product']['order'] == 'ASC' ? 'DESC' : 'ASC');
                        ?>
                        <div class="sort">
                            <select class="sort_select">
                                @foreach(\App\Tools\Helpers::listSortingProducts() as $item)
                                    <option
                                         @if($item['column'] == $column)
                                            selected
                                         @endif
                                         value="{{ $item['value'] }}">{{ $item['title'] }}</option>
                                @endforeach
                            </select>

                            <div class="sort_by_rating sort_{{ mb_strtolower($column == 'viewed' ? $order : 'ASC')}}
                                 {{ $column == 'viewed' ? 'sort_active' : ''}}"
                                 sort="viewed"
                                 order="{{ $column == 'viewed' ? $order : 'ASC'}}">По популярности</div>


                            <div class="sort_by_name sort_{{ mb_strtolower($column == 'name' ? $order : 'ASC') }}
                                {{ $column == 'name'   ? 'sort_active' : ''}}"
                                 sort="name"
                                 order="{{ $column == 'name'   ? $order : 'ASC'}}">По алфавиту</div>


                            <div class="sort_by_price sort_{{ mb_strtolower($column == 'price' ? $order : 'ASC') }}
                                {{ $column == 'price'  ? 'sort_active' : ''}}"
                                 sort="price"
                                 order="{{ $column == 'price'  ? $order : 'ASC'}}">По цене</div>

                        </div>
					@endif
                </div>

                <div class="product-grid product-grid_4">
                    @foreach($products as $product)
                        @include('includes.catalog_item', ['product' => $product])
                    @endforeach
					<script>
                        $(document).ready(function() {
                            view = localStorage.getItem('display');
                            if (view) {
                                display(view);
                            } else {
                                display('grid');
                            }
                        });
					</script>

                    <span class="category_banner">
                        {!! \App\Services\ServiceBanner::getBanner(5) !!}
                    </span>
                </div>

   			    {!! $products->links("pagination::default") !!}

				@if(isset($category->description))
					<div class="category-info">
                        <h2>Купить {{ $category->name }} в {{ $currentCity->name }}, Казахстан</h2>
                        <br/>

                        @if($category->description)
                            {!! $category->description  !!}
                            <br/>
                            <br/>
                        @endif

                        <h2>Где купить {{ $category->name }}</h2>
                        <br/>
                        <p>
                            Заказать товар с доставкой на дом в пределах {{ $currentCity->name }}, Казахстан можно круглосуточно, через корзину на сайте.
                            Интернет-магазин официальных товаров {{ env('APP_NO_URL') }} предлагает доставку заказов и в
                            другие города Республики Казахстан. К оплате принимаются банковские карты и наличные средства.
                        </p>

						<div class="category-info_show_all"><span>показать полностью</span></div>
					</div>
				@endif

                <div class="category_bottom_10px"></div>
            </div>

			<br>
			<br>
			@include('includes.product_slider', ['products' => $productsHitViewed, 'title' => 'Хиты'])
            <br>
            <br>
            @include('includes.product_slider', ['products' => $youWatchedProducts, 'title' => 'Вы смотрели'])
        </div>



</div>




@endsection