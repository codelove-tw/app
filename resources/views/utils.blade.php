@extends('layout')

@section('head')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="my-5 h1 text-center px-3"><b>Utils</b></h1>
                <hr>
                <div class="text-center">
                    <button class="btn btn-secondary" onclick="$('#loading').show();">global loading</button>
                </div>
                <hr>
                <div class="text-center">
                    <form>
                        <input type="text" placeholder="Enter something..." required>
                        <button type="submit" class="btn btn-primary">prevent double click</button>
                    </form>
                </div>
                <hr>
                <div class="text-center">
                    <form>
                        <button type="submit" class="btn btn-primary" @confirm>confirm before submit</button>
                    </form>
                </div>
                <hr>
                <div class="text-center">
                    <button class="btn btn-default">default button</button>
                </div>
                <hr>
                <div class="text-center">
                    <form method="post" action="/utils/upload-image" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="image">
                        <button type="submit" class="btn btn-primary">upload image</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
