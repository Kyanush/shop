<div class="topbar container {{ $class }}">

    <a class="topbar__icon icon icon_menu">
        <span></span>
    </a>

    @if($title)
        <h1 class="topbar__heading">
            {!! $title !!}
        </h1>
    @endif

    @if($search_show)
        <a class="topbar__icon icon icon_loop mount-search-bar"></a>
    @endif

</div>