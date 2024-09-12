<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>아이디 찾기 완료</title>

</head>
<style>
    html, body {
        height: 100%;
        margin: 0;
        overflow: hidden;
    }

    .container {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card {
        width: 400px;
        text-align: center;
    }
</style>
<body>
@extends('layouts.loginHeader')

@section('title', '아이디 찾기 완료')

@section('content')
<div class="container">
    <div class="card p-4">
        <div class="text-center mb-4">
            <h4>아이디 찾기 완료</h4>
        </div>
        <div class="mb-3">
            @if (session('user_id'))
                <p>회원님의 아이디는 <strong>{{ session('user_id') }}</strong> 입니다.</p>
            @endif

            @if (session('error'))
                <p class="text-danger">{{ session('error') }}</p>
            @endif
        </div>
        <a href="/" class="btn btn-primary btn-block">로그인 하러 가기</a>
        <a href="/findPassword" class="btn btn-secondary btn-block mt-2">비밀번호 찾기</a>
    </div>
</div>
@endsection
</body>
</html>
