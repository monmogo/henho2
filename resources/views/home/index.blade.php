@extends('layouts.app')

@section('title', 'Trang Chủ')

@section('content')
<div class="container mt-5">
    <div class="jumbotron text-center">
        <h1 class="display-4">Chào mừng đến với Trang Chủ!</h1>
        <p class="lead">Đây là trang chủ của website Laravel.</p>
        <hr class="my-4">
        <p>Hãy đăng nhập hoặc đăng ký để sử dụng dịch vụ của chúng tôi.</p>
        <a class="btn btn-primary btn-lg" href="{{ route('login') }}" role="button">Đăng nhập</a>
        <a class="btn btn-success btn-lg" href="{{ route('register') }}" role="button">Đăng ký</a>
    </div>
</div>
@endsection
