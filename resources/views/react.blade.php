@extends('layout')

@section('head')

@viteReactRefresh
@vite(['resources/js/react-app.jsx'])

@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            <div id="react-app"></div>
        </div>
    </div>
</div>

@endsection
