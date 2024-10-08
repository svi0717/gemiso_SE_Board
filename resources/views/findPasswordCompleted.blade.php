<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>비밀번호 변경 완료</title>
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

@section('title', '비밀번호 변경 완료')

@section('content')
<div class="container">
    <div class="card p-4">
        <div class="text-center mb-4">
            <h4>비밀번호 변경 완료</h4>
        </div>
        <div class="mb-3">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
        <a href="/" class="btn btn-primary btn-block">로그인 하러 가기</a>
    </div>
</div>
@endsection
</body>
</html>
