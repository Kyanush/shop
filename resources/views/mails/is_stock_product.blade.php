@extends('layouts.mail')
@section('content')

    <p>Вы просили Вам информацию о налиции товара <a href="{{ env('APP_URL') . $product->detailUrlProduct() }}">{{ $product->name }}</a>.</p>
    <p>Товар <a href="{{ env('APP_URL') . $product->detailUrlProduct() }}">{{ $product->name }}</a> поступил на склад и Вы можете его приобрести на сайте</p>

@endsection