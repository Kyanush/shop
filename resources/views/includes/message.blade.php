@if(isset($errors))
    @if (count($errors) > 0)
       <div class="warning">
            <ul>
                @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                @endforeach
            </ul>
       </div>
    @endif
@endif

@if(session()->has('attention'))
    <div class="attention">
        {{ session()->get('attention') }}
    </div>
@endif

@if(session()->has('success'))
    <div class="success">
        {{ session()->get('success') }}
    </div>
@endif