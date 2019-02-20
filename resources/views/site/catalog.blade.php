@extends('layouts.site')

<?php
$default_title = 'Каталог товаров';
$catalog_url = 'catalog';

if(strpos(url()->current(), '/specials') !== false)
{
    $catalog_url = 'specials';
    $default_title = 'Скидки';
}
?>

@section('title',    	 $category ? $category->name : $default_title)
@section('description', $category ? ($category->seo_description ? $category->seo_description : $category->name) : $default_title)
@section('keywords',    $category ? ($category->seo_keywords    ? $category->seo_keywords    : $category->name) : $default_title)

@section('content')

@section('end_styles')
    <link rel="stylesheet" type="text/css" href="/site/css/filterpro.css">
    <!-- Slider -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" type="text/css" media="all">
@stop

@section('start_scripts')
    <!-- Slider -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" type="text/javascript"></script>
@stop



    <div class="container" style="position:static;">
        <div id="notification"></div>

        <?php $breadcrumb = [
            [
                'title' => 'Главная',
                'link'  => '/'
            ],
            [
                'title' => $default_title,
                'link'  => $category ? '/' . $catalog_url : ''
            ],
        ];

        if($category)
        {
            $breadcrumb[] = [
                    'title' => $category->name ? $category->name : $default_title,
                    'link'  => ''
                ];
        }
        ?>
        @include('includes.breadcrumb', ['breadcrumb' => $breadcrumb])

        <h1 itemprop="name">
            {{ $category ? $category->name : $default_title }}
        </h1>

		@if($listCategoryFilterLinks)
			<div class="box-cat-topper">
				<ul class="box-cat-category">
					@foreach($listCategoryFilterLinks as $key => $CategoryFilterLink)
						<li @if($key + 1 > 12) class="invisible_li_box" @endif>
							<a href="{{ $CategoryFilterLink->link }}">
								{{ $CategoryFilterLink->name }}
							</a>
						</li>
					@endforeach
					@if(count($listCategoryFilterLinks) > 12)
						<li>
							<a href="javascript:void(0)" class="also_category_add_open" onclick="categoryFilterLinks(this)">
								<span>Ещё</span>
							</a>
						</li>
					@endif
				</ul>
			</div>
		@endif


        <div id="column-left">
            <div id="filterpro_box">
                <div class="filterpro">
                    <form id="filterpro">

						@if(!$category)

                            <?php $categories = \App\Models\Category::orderBy('sort')->where('parent_id', 0)->get();?>
							 @foreach($categories as $category_item)
								<div class="attribute_box option_box">
									<div class="option_name">
										{{ $category_item->name }}
									</div>
									<div class="collapsible" style="display:none">
										<table>
											<tbody>
									<?php
									$serviceCategory = new \App\Services\ServiceCategory();
									$category_childrens = \App\Models\Category::orderBy('sort')->whereIn('id', $serviceCategory->categoryChildIds($category_item->id, false))->get();
									?>
											@foreach($category_childrens as $value)
												<tr>
													<td class="checkbox_td">
														<a href="/{{$catalog_url}}/{{ $value->url }}">
															{{ $value->name }}
														</a>
													</td>
												</tr>
											@endforeach
											</tbody>
										</table>
									</div>
								</div>
							 @endforeach

						@else

                        <div class="option_box">
                            <div class="option_name">Цена ₸</div>
                            <div class="price_slider collapsible">
                                <div class="price_slider_min">{{ $priceMinMax['min'] }}</div>
                                <div class="price_slider_middle">{{ (($priceMinMax['max'] - $priceMinMax['min']) / 2) + $priceMinMax['min'] }}</div>
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
                                        min: {{ $priceMinMax['min'] }},
                                        max: {{ $priceMinMax['max'] }},
                                        values:[{{ $filters['price_start'] ?? $priceMinMax['min'] }}, {{ $filters['price_end'] ?? $priceMinMax['max'] }}],
                                        slide:function (a, b) {
                                            var min = b.values[0];
                                            var max = b.values[1];
                                            $("#min_price").html(min);
                                            $("#max_price").html(max);
                                            urlParamsGenerate();
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
                                                        <label for="attribute_value_{{$attribute->id}}{{$value->id}}"  >
                                                            {{ $value->value }}
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
						@endif
                    </form>
                </div>

            </div>

			<div class="homepage_banner w100">
				@include('includes.product_day')
            </div>


            <div class="team_banners">
                <a href="/contact">
                    <img src="https://ru-mi.com/image/data/team_banners/rumi_team_banner_sergey.jpg">
                </a>
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

                    <!-- Mobile -->
                    <div class="mobile_filter">
                        <span>Фильтр</span>
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


                    <!-- sort_active -->

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



						<!--
                    <span class="category_banner">
                        <a href="device/brasleti/">
                            <img src="https://ru-mi.com/image/cache/data/category_banners/xiaomi_smartwatch_1-1070x190.jpg">
                        </a>
                    </span>-->

                </div>

   			    {!! $products->links("pagination::default") !!}

				@if(isset($category->description))
					<div class="category-info">
						{!! $category->description  !!}
						<div class="category-info_show_all"><span>показать полностью</span></div>
					</div>
				@endif

                <div class="category_bottom_10px"></div>
            </div>

			<br>
			<br>
			@include('includes.product_slider', ['products' => $productsHitViewed, 'title' => 'Хиты'])

        </div>



		@include('includes.product_slider', ['products' => $youWatchedProducts, 'title' => 'Вы смотрели'])



</div>


@endsection