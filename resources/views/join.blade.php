<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</head>
<style>
    html, body {
        height: 100%;
        margin: 0;
        overflow: hidden; /* 스크롤이 생기지 않도록 설정 */
    }

    .container {
        height: 100vh; /* 전체 화면 높이를 차지 */
        display: flex;
        align-items: center; /* 수직으로 중앙 정렬 */
    }

    .card {
        width: 400px;
    }


    </style>
<body>
@extends('layouts.loginHeader')

@section('title', '회원가입')

@section('content')
<div class="container ml-5">
    <div class="card p-4">
        <div class="text-center mb-4">
            <h4>회원가입</h4>
        </div>
        <form>
            <div class="mb-3">
                <label for="id" class="form-label">아이디</label>
                <input type="text" class="form-control" id="id"  placeholder="아이디">
            </div>
            <div class="mb-3">
                <label for="Password" class="form-label">비밀번호</label>
                <input type="password" class="form-control" id="password"  placeholder="비밀번호">
            </div>
            <div class="mb-3">
                <label for="PasswordCheck" class="form-label">비밀번호 확인</label>
                <input type="password" class="form-control" id="passwordCheck" placeholder="비밀번호 확인">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">이름</label>
                <input type="email" class="form-control" id="name" placeholder="이름">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">전화번호</label>
                <input type="email" class="form-control" id="phone" placeholder="전화번호">
            </div>
            <button type="submit" class="btn btn-primary btn-block">회원가입</button>
        </form>
    </div>
</div>
@endsection
</body>
</html>
