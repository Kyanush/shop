@php
    $cities = \App\Services\ServiceCity::groupingFirstLetters();
@endphp

<div id="select-city" style="display:none;">
    <div class="town_popup">
        <div class="town_popup_header">Выбор города
            <div class="town_popup_close callback_popup_close"></div>
        </div>
        <!--
        <div class="town_popup_enter">
            <input type="text" id="main_city" placeholder="Поиск города" autocomplete="off" class="suggestions-input" style="box-sizing: border-box;"><div class="suggestions-wrapper"><span class="suggestions-addon" data-addon-type="spinner" style="left: -43px; top: 1px; height: 42px; width: 42px;"></span><ul class="suggestions-constraints" style="left: -607px; top: 22px;"></ul><div class="suggestions-suggestions" style="position: absolute; display: none; left: -620px; top: 43px; width: 618px;"></div></div>
            <div class="town_popup_enter_search"></div>
            <div class="town_popup_enter_close"></div>
        </div>
        -->
        <div class="town_popup_list">
            <ul>
                @foreach($cities as $key => $item_cities)
                    @if(count($item_cities) == 1)
                        <li>
                            <ul>
                                <li class="first_char">{{ $key }}</li>
                                @foreach($item_cities as $city)
                                    <li>
                                        <a onclick="setCity('{{$city->code}}')" @if(in_array($city->id, [4,20])) class="special_town_a" @endif>
                                            {{ $city->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li>
                            <ul>
                                <li class="first_char">{{ $key }}</li>
                                @foreach($item_cities as $city)
                                    <li>
                                        <a onclick="setCity('{{$city->code}}')" @if(in_array($city->id, [4,20])) class="special_town_a" @endif>
                                            {{ $city->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="town_popup_list_bottom">
            Не нашли свой город? У нас есть доставка по <a href="/delivery-payment">Казахстан</a>.
        </div>
    </div>
</div>
