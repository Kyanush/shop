<div id="header_menu">
    <div class="container">
        <div id="menu_categories">
            <div id="menu_categories_selector">
                <span>Каталог товаров</span>
            </div>
            <div id="menu" style="display: none;" class="">
                <ul>

                    <?php
                        $categories = \App\Models\Category::orderBy('sort')->isActive()->where('parent_id', 0)->get();
                    ?>

                    @foreach($categories as $category)
                        <li>
                            <a href="{{ $category->catalogUrl($currentCity->code) }}" class="{{ $category->class }} main_menu">
                                <span>{{ $category->name }}</span>
                            </a>

                            <?php
                            $categories = [];

                            foreach($category->children()->isActive()->orderBy('sort')->get() as $category_children){
                                $categories[] = $category_children;
                                $serviceCategory = new \App\Services\ServiceCategory();

                                $childrens_all = \App\Models\Category::orderBy('sort')->isActive()->whereIn('id', $serviceCategory->categoryChildIds($category_children->id, false, true))->get();
                                foreach ($childrens_all as $item)
                                    $categories[] = $item;
                            }

                            $row_br = 18;
                            ?>

                            <div class="children" style="width: <?=ceil(count($categories) / $row_br) * 300;?>px;">
                                <?php $row = 0; ?>
                                @foreach($categories as $key => $item)
                                    <?php $row++; ?>
                                    @if($row == 1)
                                        <ul class="children-list">
                                            @endif
                                            <li>
                                                @if($category->id == $item->parent_id)
                                                    <a class="link main_menu_sub" href="{{ $item->catalogUrl($currentCity->code) }}">
                                                                <span class="text">
                                                                    {{ $item->name }}
                                                                    @if($item->type)
                                                                        <div class="icon_{{ $item->type }}">
                                                                            {{ $item->typeValueDescription() }}
                                                                        </div>
                                                                    @endif
                                                                </span>
                                                    </a>
                                                @else
                                                    <div class="subchildren">
                                                        <ul>
                                                            <li>
                                                                <a href="{{ $item->catalogUrl($currentCity->code) }}">
                                                                            <span>
                                                                                  {{ $item->name }}
                                                                            </span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            </li>
                                            @if($row == $row_br or count($categories) == $key + 1)
                                        </ul>
                                        <?php $row = 0; ?>
                                    @endif
                                @endforeach
                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
        <div id="header_middle_menu">
            <a href="{{ route('delivery_payment') }}">Доставка, оплата</a>
            <a href="{{ route('guaranty') }}">Гарантия</a>
            <a href="{{ route('contact') }}">Контакты</a>
        </div>

        <?php
        $servicePFC  = new \App\Services\ServiceProductFeaturesCompare();
        $servicePFW  = new \App\Services\ServiceProductFeaturesWishlist();
        $serviceCart = new \App\Services\ServiceCart();

        $servicePFCCount  = $servicePFC->count();
        $servicePFWCount  = $servicePFW->count();
        $serviceCartTotal = $serviceCart->cartTotal();
        ?>
        <a title="Мои закладки" class="header_wishlist <?=$servicePFWCount == 0 ? 'non_active' : ''?>" href="/wishlist">
            <span>{{ $servicePFWCount }}</span>
        </a>
        <a title="Сравнение товаров" class="header_compare <?=$servicePFCCount == 0 ? 'non_active' : ''?>" href="/compare-products">
            <span>{{ $servicePFCCount }}</span>
        </a>
        <div id="cart">
            <div class="heading {{ $serviceCartTotal['quantity'] > 0 ? 'heading_active' : '' }}">
                <a title="Корзина покупок">
                        <span id="cart-total">
                            <span class="cart_counter">
                                {{ $serviceCartTotal['quantity'] }}
                            </span>
                            на сумму:
                            <span class="cart_sum">{{ \App\Tools\Helpers::priceFormat($serviceCartTotal['sum']) }}</span>
                        </span>
                </a>
            </div>
            <div class="content">

            </div>
        </div>
    </div>
</div>