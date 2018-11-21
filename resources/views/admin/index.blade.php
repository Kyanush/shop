@extends('layouts.admin')
@section('content')

    <? $user = \App\User::with('role')->find(Auth::user()->id); ?>
    <div id="admin">
        <layout :user="{{ $user }}"></layout>
    </div>

@endsection