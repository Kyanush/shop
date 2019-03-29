<div class="topbar container {{ $class }}">

    <a @if(isset($go_back)) href="{{ $go_back }}" @else id="go-back" @endif
        class="topbar__icon icon icon_back">
    </a>

    @if($title)
        <h1 class="topbar__heading">
            {{ $title }}
        </h1>
    @endif

    <a class="topbar__icon icon icon_loop mount-search-bar"></a>

</div>