<ul class="breadcrumb">
    @foreach($breadcrumb as $item)
        <li>
            @if(!empty($item['link'])) <a href="{{ $item['link'] }}"> @endif
                {{ $item['title'] }}
            @if(!empty($item['link'])) </a> @endif
        </li>
    @endforeach
</ul>



@include('includes.message')